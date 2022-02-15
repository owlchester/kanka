<?php

namespace App\Services;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class TutorialService
{
    protected $workflows = [
        'dashboard_1' => [
            'highlight' => '.subsection.section-characters a',
        ],
        'character_1' => [
            'highlight' => 'a.btn-new-entity'
        ]
    ];
    /** @var User */
    protected $user;

    /**
     * @param User $user
     * @return $this
     */
    public function user(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return $this
     */
    public function disable(): self
    {
        $this->user
            ->doneTutorial('disabled');
        return $this;
    }

    /**
     * @return $this
     */
    public function reset(): self
    {
        $this->user
            ->resetTutorial();
        return $this;
    }

    /**
     * @param string $key
     * @param string|null $next
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function done(string $key, string $next = null): JsonResponse
    {
        $this->user
            ->doneTutorial($key);

        if (empty($next) || !view()->exists('tutorials.' . $next)) {
            $highlight = Arr::get($this->workflows, $key. '.highlight');
            return response()->json(['success' => true, 'close' => true, 'highlight' => $highlight]);
        }

        $html = view('tutorials.' . $next)->render();
        return response()
            ->json([
                'success' => true,
                'html' => $html
            ]);
    }
}
