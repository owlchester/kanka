<?php

namespace App\Exceptions;

use App\Facades\ApiLog;
use App\Facades\Domain;
use App\Models\Campaign;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Broadcasting\BroadcastException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Exceptions\DecoderException;
use Laravel\Passport\Exceptions\OAuthServerException;
use Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException;
use PDOException;
use Predis\Connection\ConnectionException as PredisConnectionException;
use RedisException;
use Sentry\Laravel\Integration;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\Console\Exception\NamespaceNotFoundException;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Symfony\Component\HttpKernel\Exception\HttpException as SymHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mailer\Exception\HttpTransportException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        \League\OAuth2\Server\Exception\OAuthServerException::class,
        NamespaceNotFoundException::class,
        CommandNotFoundException::class,
        HttpTransportException::class,
        FatalError::class,
        OAuthServerException::class,
        CannotUpdateLockedPropertyException::class,
        BroadcastException::class,
        NotFoundHttpException::class,
        DecoderException::class,
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            Integration::captureUnhandledException($e);
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @return JsonResponse|RedirectResponse|Response|\Symfony\Component\HttpFoundation\Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($this->isInfrastructureConnectionFailure($exception)) {
            if (! $this->shouldReturnJson($request, $exception) && ! $request->is('api/*') && ! Domain::isApi()) {
                return response()->view('errors.infrastructure', [], 200);
            }
        }

        if ($exception instanceof TokenMismatchException) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withErrors(__('redirects.session_timeout'));
        } elseif ($exception instanceof AuthorizationException && auth()->guest()) {
            // User needs to be logged in, remember the page they visited
            session()->put('login_redirect', $request->getRequestUri());
        } elseif (! $request->is('api/*') && $exception instanceof ModelNotFoundException) {
            // If the guest user tries accessing a private campaign, let's tell them about it
            $campaign = request()->route('campaign');
            if (! empty($campaign) && ! ($campaign instanceof Campaign)) {
                session()->put('login_redirect', $request->getRequestUri());
                /** @var Campaign $campaign */
                $campaign = Campaign::select('id')->slug($campaign)->first();
                if ($campaign && ! $campaign->isPublic()) {
                    return response()->view('errors.private-campaign', [
                        'campaign' => $campaign,
                    ], 200);
                }
            }
        } elseif ($exception instanceof SymHttpException && $exception->getStatusCode() == 503) {
            if (request()->ajax()) {
                return response()->json([
                    'title' => __('errors.503.title'),
                    'message' => __('errors.503.json'),
                ], 503);
            }
            // For stripe, we want them to try again later
            if (request()->is('stripe/*')) {
                return response()->json(['maintenance'], 503);
            }

            return response()->view('errors.maintenance', [
                'message' => $exception->getMessage(),
                // 'retry' => $exception->retryAfter
            ], 200);
        } elseif ($request->is('api/*') || Domain::isApi()) {
            // API error handling
            return $this->handleApiErrors($exception);
        }

        return parent::render($request, $exception);
    }

    private function isInfrastructureConnectionFailure(Throwable $exception): bool
    {
        for ($current = $exception; $current !== null; $current = $current->getPrevious()) {
            if (! $current instanceof QueryException && ! $current instanceof PDOException) {
                if ($current instanceof FatalError && preg_match('/^Uncaught PDOException: (SQLSTATE\\[(?:08001|08003|08004|08S01)\\]|SQLSTATE\\[HY000\\](?:: General error:)?(?: \\[)?(?:2002|2003|2006|2013)(?:\\])?\\b)/i', $current->getMessage())) {
                    return true;
                }

                if ($current instanceof PredisConnectionException || ($current instanceof RedisException && preg_match('/(connection refused|connection timed out|read error on connection|connection lost|went away)/i', $current->getMessage()))) {
                    return true;
                }

                continue;
            }

            $state = $current instanceof PDOException ? ($current->errorInfo[0] ?? null) : null;
            $code = $current instanceof PDOException ? ($current->errorInfo[1] ?? null) : null;
            if ($current instanceof QueryException && $current->getPrevious() instanceof PDOException) {
                $state ??= $current->getPrevious()->errorInfo[0] ?? null;
                $code ??= $current->getPrevious()->errorInfo[1] ?? null;
            }
            if (in_array($state, ['08001', '08003', '08004', '08S01'], true) || ($state === 'HY000' && in_array((int) $code, [2002, 2003, 2006, 2013], true))) {
                return true;
            }
            if (preg_match('/^SQLSTATE\\[(?:08001|08003|08004|08S01)\\]|^SQLSTATE\\[HY000\\](?:: General error:)?(?: \\[)?(?:2002|2003|2006|2013)(?:\\])?\\b/i', $current->getMessage())) {
                return true;
            }
        }

        return false;
    }

    /**
     * Unauthenticated exception handler
     *
     * @param  Request  $request
     * @return JsonResponse|RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->is('api/*') || Domain::isApi()
            ? response()->json([
                'message' => 'Unauthenticated (missing the authorization token in the request headers, or the token is invalid).',
                'documentation' => 'https://app.kanka.io/api-docs/1.0/setup#authentication',
            ], 401)
            : redirect()->guest(route('login'));
    }

    /**
     * Handle all errors that happen in the API
     *
     * @return JsonResponse
     */
    protected function handleApiErrors(Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()
                ->json([
                    'code' => 404,
                    'error' => $exception->getMessage(),
                ], 404);
        } elseif ($exception instanceof MethodNotAllowedHttpException) {
            return response()
                ->json([
                    'code' => 405,
                    'error' => $exception->getMessage(),
                ], 405);
        } elseif ($exception instanceof ValidationException) {
            return response()
                ->json([
                    'code' => $exception->status,
                    'error' => $exception->getMessage(),
                    'fields' => $exception->errors(),
                ], $exception->status);
        } elseif ($exception instanceof AuthorizationException) {
            return response()
                ->json([
                    'code' => 403,
                    'error' => $exception->getMessage(),
                ], 403);
        } elseif ($exception instanceof NotFoundHttpException) {
            return response()
                ->json(['error' => 'Page not found'], 404);
        } elseif ($exception instanceof ThrottleRequestsException) {
            $amount = auth()->user()->rateLimit;
            $message = $amount != 90 ? ' Subscribe to Kanka to unlock higher limits' : null;

            return response()
                ->json(['Your account limit of ' . $amount . ' requests per minute has been reached.'
                    . $message], 429);
        } elseif ($exception instanceof AuthenticationException) {
            return response()
                ->json([
                    'code' => 401,
                    'error' => 'Invalid authentication token. Make sure you copy-pasted it correctly, or try using a new one at https://app.kanka.io/settings/api.',
                ], 401);
        }

        $limit = app()->isProduction() ? 100 : 2000;
        $trace = app()->hasDebugModeEnabled() ? $exception->getTrace() : null;

        ApiLog::exception($exception);

        return response()
            ->json([
                'code' => 500,
                'error' => 'Unhandled API error. Contact us on Discord',
                'hint' => Str::limit($exception->getMessage(), $limit),
                'trace' => $trace,
            ], 500);
    }
}
