<?php

namespace App\Services\Campaign\Import;

use App\Enums\CampaignImportStatus;
use App\Models\CampaignImport;
use App\Services\Campaign\Import\Mappers\AbilityMapper;
use App\Services\Campaign\Import\Mappers\CalendarMapper;
use App\Services\Campaign\Import\Mappers\CampaignMapper;
use App\Services\Campaign\Import\Mappers\CreatureMapper;
use App\Services\Campaign\Import\Mappers\EventMapper;
use App\Services\Campaign\Import\Mappers\FamilyMapper;
use App\Services\Campaign\Import\Mappers\GalleryMapper;
use App\Services\Campaign\Import\Mappers\ItemMapper;
use App\Services\Campaign\Import\Mappers\JournalMapper;
use App\Services\Campaign\Import\Mappers\NoteMapper;
use App\Services\Campaign\Import\Mappers\OrganisationMapper;
use App\Services\Campaign\Import\Mappers\RaceMapper;
use App\Services\Campaign\Import\Mappers\TagMapper;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;
use Exception;

class ImportService
{
    use CampaignAware;
    use UserAware;

    protected ZipArchive $archive;

    protected CampaignImport $job;

    protected GalleryMapper $gallery;
    protected TagMapper $tags;
    protected CalendarMapper $calendars;

    protected string $dataPath;


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
            ->process()
            ->cleanup();
    }

    protected function init(): self
    {
        $this->job->status_id = CampaignImportStatus::RUNNING;
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
            Log::info('Want to download ' . $file);
            $s3 = Storage::disk('s3')->get($file);
            $local = $path . uniqid() . '.zip';
            Storage::disk('local')->put($local, $s3);

            $this->archive = new ZipArchive();
            $zipPath = storage_path('app/' . $local);
            Log::info('Want to open ' . $zipPath);
            $this->archive->open($zipPath);
            Log::info('Opened ' . $local . ' file');
            $this->extract();
            $this->archive->close();
            unlink($zipPath);
        }

        return $this;
    }

    protected function extract(): void
    {
        $this->dataPath = 'campaigns/' . $this->campaign->id . '/import-data';
        $this->archive->extractTo(storage_path('/app/' . $this->dataPath));
    }

    protected function process()
    {
        try {
            $this->importCampaign()
                ->gallery()
                ->entities()
                //->tags()
                //->calendars()
            ;
            $this->job->status_id = CampaignImportStatus::FINISHED;
        } catch (Exception $e) {
            dump($e->getMessage());
            Log::error('Import', ['error' => $e->getMessage()]);
            $this->job->status_id = CampaignImportStatus::FAILED;
        }

        return $this;
    }

    protected function cleanup(): self
    {
        Storage::deleteDirectory(storage_path('/app/' . $this->dataPath));
        $this->job->save();
        return $this;
    }

    protected function importCampaign(): self
    {
        // Open the campaign zip
        $data = $this->open('campaign.json');

        /** @var CampaignMapper $mapper */
        $mapper = app()->make(CampaignMapper::class);
        $this->campaign = $mapper
            ->path($this->dataPath)
            ->data($data)
            ->campaign($this->campaign)
            ->import();
        return $this;
    }

    protected function gallery(): self
    {
        $this->gallery = app()->make(GalleryMapper::class);
        $this->gallery->campaign($this->campaign)
            ->prepare();

        $path = $this->dataPath . '/gallery';
        if (!Storage::disk('local')->exists($path)) {
            dd('no gallery');
        }

        $files = Storage::disk('local')->files($path);
        foreach ($files as $file) {
            if (!Str::endsWith($file, '.json')) {
                continue;
            }
            $filePath = Str::replace($this->dataPath, null, $file);
            $data = $this->open($filePath);
            $this->gallery
                ->path($path)
                ->data($data)
                ->import()
            ;
            unset($data);
        }
        $this->gallery->tree()->clear();

        return $this;
    }


    protected function entities(): self
    {
        $setup = [
            'tags' => TagMapper::class,
//            'calendars' => CalendarMapper::class,
//            'creatures' => CreatureMapper::class,
//            'notes' => NoteMapper::class,
//            'races' => RaceMapper::class,
//            'events' => EventMapper::class,
//            'items' => ItemMapper::class,
//            'journals' => JournalMapper::class,
//            'abilities' => AbilityMapper::class,
//            'families' => FamilyMapper::class,
            'organisations' => OrganisationMapper::class,
        ];
        foreach ($setup as $model => $mapperClass) {
            dump('Processing ' . $model);
            $this->$model = app()->make($mapperClass);
            $this->$model
                ->campaign($this->campaign)
                ->prepare()
            ;

            $path = $this->dataPath . '/' . $model;
            if (!Storage::disk('local')->exists($path)) {
                dump('No ' . $model);
                return $this;
            }

            $files = Storage::disk('local')->files($path);
            $count = 0;
            foreach ($files as $file) {
                if (!Str::endsWith($file, '.json')) {
                    continue;
                }
                $filePath = Str::replace($this->dataPath, null, $file);
                $data = $this->open($filePath);
                $this->$model
                    ->path($this->dataPath . '/')
                    ->data($data)
                    ->first()
                ;
                $count++;
                unset($data);
            }
            dump('- ' . $count . ' ' . $model);
            $this->$model->tree()->clear();
        }

        return $this;
    }

    protected function open(string $file): array
    {
        $path = $this->dataPath . '/' . $file;
        if (!Storage::disk('local')->exists($path)) {
            dd('file ' . $path . ' doesnt exist');
        }

        $fullpath = Storage::disk('local')->path($path);
        $content = file_get_contents($fullpath);
        $data = json_decode($content, true);
        return $data;
    }

}
