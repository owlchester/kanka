<?php

namespace App\Services;

use App\Enums\CampaignImportStatus;
use App\Models\CampaignImport;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use SplFileObject;
use RuntimeException;

class CsvValidatorService
{
    use CampaignAware;
    use UserAware;

    protected int $expectedColumns = 1;
    protected int $requiredFullyFilledColumns = 1;
    protected CampaignImport $job;
    protected string $filePath;

    public function job(CampaignImport $job)
    {
        $this->job = $job;
        $this
            ->campaign($job->campaign)
            ->user($job->user);

        return $this;
    }

    public function run(): void
    {
        $this
            ->init()
            ->download()
            ->validate();
    }

    public function toSelect(): array
    {
       return $this
            ->download()
            ->getHeader();
    }

    public function preview(): array
    {
       return $this
            ->download()
            ->getHeaderAndFirstRows();
    }

    protected function init(): self
    {
        $this->job->status_id = CampaignImportStatus::VALIDATING;
        $this->job->save();

        return $this;
    }

    /**
     * Download the files from s3 onto the local machine and unzip it
     */
    protected function download(): self
    {
        $files = $this->job->config['files'];
        $path = '/campaigns/' . $this->campaign->id . '/imports/';
        foreach ($files as $file) {
            // Log::info('Want to download ' . $file);
            $s3 = Storage::disk('export')->get($file);
            $local = $path . uniqid() . '.csv';
            // Log::info('Will download from the export disk to local ' . $local);
            Storage::disk('local')->put($local, $s3);

            $this->filePath = storage_path('app/' . $local);
        }

        return $this;
    }


    protected function getHeader(): array
    {
        $csv = new SplFileObject($this->filePath);
        $csv->setFlags(
            SplFileObject::READ_CSV |
            SplFileObject::SKIP_EMPTY |
            SplFileObject::DROP_NEW_LINE
        );

        foreach ($csv as $row) {
            // Skip empty lines / EOF
            if ($row === [null]) {
                continue;
            }

            return $row;
        }

        return [];
    }

    /**
     * Return the header row and the first two data rows from a CSV
     */
    protected function getHeaderAndFirstRows(int $rows = 2): array
    {
        $csv = new SplFileObject($this->filePath);
        $csv->setFlags(
            SplFileObject::READ_CSV |
            SplFileObject::SKIP_EMPTY |
            SplFileObject::DROP_NEW_LINE
        );
        $result = [];

        foreach ($csv as $row) {
            // Skip empty lines / EOF
            if ($row === [null]) {
                continue;
            }

            $result[] = $row;

            // Stop after header + N rows
            if (count($result) === $rows + 1) {
                break;
            }
        }

        // Reset pointer for later use
        $csv->rewind();

        return $result;
    }


    /**
     * Return headers for columns that have no empty values in any row
     */
    protected function getFullyFilledColumnHeaders(SplFileObject $csv): array
    {
        $headers = null;
        $hasEmpty = [];

        foreach ($csv as $row) {
            // Skip empty lines / EOF
            if ($row === [null]) {
                continue;
            }

            // First non-empty row = headers
            if ($headers === null) {
                $headers = $row;
                $hasEmpty = array_fill(0, count($headers), false);
                continue;
            }

            foreach ($row as $index => $value) {
                if (trim((string) $value) === '') {
                    $hasEmpty[$index] = true;
                }
            }
        }

        // Reset pointer if needed later
        $csv->rewind();

        if ($headers === null) {
            return [];
        }

        $result = [];

        foreach ($headers as $index => $header) {
            if ($hasEmpty[$index] === false) {
                $result[] = $header;
            }
        }

        return $result;
    }

    public function validate(): void
    {
        $csv = new SplFileObject($this->filePath);
        $csv->setFlags(
            SplFileObject::READ_CSV |
            SplFileObject::SKIP_EMPTY |
            SplFileObject::DROP_NEW_LINE
        );

        $validHeaders = $this->getFullyFilledColumnHeaders($csv);

        if (empty($validHeaders)) {
            throw new RuntimeException(
                "At least 1 columns must be fully populated."
            );
        }

        $config = $this->job->config;
        $config['filled_columns'] = $validHeaders; 

        $this->job->status_id = CampaignImportStatus::READY;
        $this->job->config = $config;
        $this->job->save();

        return;
    }
}
