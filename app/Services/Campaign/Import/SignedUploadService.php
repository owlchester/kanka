<?php

namespace App\Services\Campaign\Import;

use App\Enums\CampaignImportStatus;
use App\Jobs\Campaigns\Import;
use App\Models\CampaignImport;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
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

        return Storage::disk('export')->temporaryUploadUrl($key, now()->addHour());
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

        $isCsv = str_ends_with(strtolower($key), '.csv');
        $maxMb = (int) config($isCsv ? 'imports.max_size_csv_mb' : 'imports.max_size_zip_mb', $isCsv ? 50 : 512);

        if (Storage::disk('export')->size($key) > $maxMb * 1024 * 1024) {
            Storage::disk('export')->delete($key);
            abort(422, "File exceeds {$maxMb} MiB limit.");
        }

        $token->config = array_merge($token->config, ['files' => [$key]]);
        $token->status_id = CampaignImportStatus::QUEUED;
        $token->save();

        Import::dispatch($token)->onQueue('heavy');
    }
}
