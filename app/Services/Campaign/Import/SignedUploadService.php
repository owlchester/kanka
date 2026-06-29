<?php

namespace App\Services\Campaign\Import;

use App\Enums\CampaignImportStatus;
use App\Jobs\Campaigns\Import;
use App\Models\CampaignImport;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Aws\S3\S3Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SignedUploadService
{
    use CampaignAware;
    use UserAware;

    /**
     * Generate a presigned S3 upload URL for the given import token.
     *
     * @return array{url: string, headers: array<string, string>}
     */
    public function presign(CampaignImport $token, string $ext): array
    {
        if (! in_array($ext, ['zip', 'csv'], true)) {
            abort(422);
        }

        $key = 'campaigns/' . $this->campaign->id . '/imports/' . Str::uuid() . '.' . $ext;

        $token->config = array_merge($token->config ?? [], ['upload_key' => $key]);
        $token->save();

        $publicUrl = config('filesystems.disks.export.temporary_url');

        if ($publicUrl) {
            return $this->presignWithPublicEndpoint($key, $publicUrl);
        }

        return Storage::disk('export')->temporaryUploadUrl($key, now()->addHour());
    }

    /**
     * Sign a PUT presigned URL using the public-facing endpoint so the browser
     * can reach it directly (needed in Docker where the internal endpoint differs).
     *
     * @return array{url: string, headers: array<string, string>}
     */
    private function presignWithPublicEndpoint(string $key, string $publicUrl): array
    {
        $disk = config('filesystems.disks.export');
        $root = trim($disk['root'] ?? '', '/');
        $fullKey = $root !== '' ? $root . '/' . $key : $key;

        $client = new S3Client([
            'version' => 'latest',
            'region' => $disk['region'],
            'endpoint' => $publicUrl,
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key' => $disk['key'],
                'secret' => $disk['secret'],
            ],
        ]);

        $command = $client->getCommand('PutObject', [
            'Bucket' => $disk['bucket'],
            'Key' => $fullKey,
        ]);

        return [
            'url' => (string) $client->createPresignedRequest($command, '+1 hour')->getUri(),
            'headers' => [],
        ];
    }

    /**
     * Confirm that the file was uploaded to S3 and dispatch the import job.
     */
    public function confirm(CampaignImport $token): void
    {
        $key = $token->config['upload_key'] ?? null;
        if (! $key) {
            abort(422, 'No upload key found.');
        }

        if (! Storage::disk('export')->exists($key)) {
            abort(422, 'File not found on storage.');
        }

        if (Storage::disk('export')->size($key) > 512 * 1024 * 1024) {
            Storage::disk('export')->delete($key);
            abort(422, 'File exceeds 512 MiB limit.');
        }

        $token->config = array_merge($token->config, ['files' => [$key]]);
        $token->status_id = CampaignImportStatus::QUEUED;
        $token->save();

        Import::dispatch($token);
    }
}
