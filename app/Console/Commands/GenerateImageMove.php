<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\Calendar;
use App\Models\Character;
use App\Models\Event;
use App\Models\Family;
use App\Models\Item;
use App\Models\Journal;
use App\Models\Location;
use App\Models\Note;
use App\Models\Organisation;
use App\Models\Quest;
use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateImageMove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:move';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move local images to s3';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $count = 0;
        $imageField = 'image';
        $thumbName = '_thumb';

        foreach (Calendar::whereNotNull($imageField)->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', $thumbName, $model->image);
            $this->move($thumb);
        }
        foreach (Campaign::whereNotNull($imageField)->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', $thumbName, $model->image);
            $this->move($thumb);
        }
        foreach (Character::whereNotNull($imageField)->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', $thumbName, $model->image);
            $this->move($thumb);
        }
        foreach (Event::whereNotNull($imageField)->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', $thumbName, $model->image);
            $this->move($thumb);
        }
        foreach (Family::whereNotNull($imageField)->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', $thumbName, $model->image);
            $this->move($thumb);
        }
        foreach (Item::whereNotNull($imageField)->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', $thumbName, $model->image);
            $this->move($thumb);
        }
        foreach (Journal::whereNotNull($imageField)->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', $thumbName, $model->image);
            $this->move($thumb);
        }
        foreach (Location::whereNotNull($imageField)->get() as $model) {
            $count++;
            $this->move($model->image);
            $this->move($model->map);

            $thumb = str_replace('.', $thumbName, $model->image);
            $this->move($thumb);
        }
        foreach (Note::whereNotNull($imageField)->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', $thumbName, $model->image);
            $this->move($thumb);
        }
        foreach (Organisation::whereNotNull($imageField)->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', $thumbName, $model->image);
            $this->move($thumb);
        }
        foreach (Quest::whereNotNull($imageField)->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', $thumbName, $model->image);
            $this->move($thumb);
        }
        foreach (Tag::whereNotNull($imageField)->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', $thumbName, $model->image);
            $this->move($thumb);
        }

        $this->info("Update $count entities.");

        return true;
    }

    /**
     * @param $file
     */
    protected function move($file)
    {
        $disk = 'public';
        if (Storage::disk($disk)->exists($file)) {
            $content = Storage::disk($disk)->get($file);
            Storage::disk('s3')->put($file, $content, $disk);
            unset($content);
        }
    }
}
