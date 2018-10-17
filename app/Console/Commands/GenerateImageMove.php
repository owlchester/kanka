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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $count = 0;

        foreach (Calendar::whereNotNull('image')->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', '_thumb.', $model->image);
            $this->move($thumb);
        }
        foreach (Campaign::whereNotNull('image')->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', '_thumb.', $model->image);
            $this->move($thumb);
        }
        foreach (Character::whereNotNull('image')->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', '_thumb.', $model->image);
            $this->move($thumb);
        }
        foreach (Event::whereNotNull('image')->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', '_thumb.', $model->image);
            $this->move($thumb);
        }
        foreach (Family::whereNotNull('image')->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', '_thumb.', $model->image);
            $this->move($thumb);
        }
        foreach (Item::whereNotNull('image')->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', '_thumb.', $model->image);
            $this->move($thumb);
        }
        foreach (Journal::whereNotNull('image')->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', '_thumb.', $model->image);
            $this->move($thumb);
        }
        foreach (Location::whereNotNull('image')->get() as $model) {
            $count++;
            $this->move($model->image);
            $this->move($model->map);

            $thumb = str_replace('.', '_thumb.', $model->image);
            $this->move($thumb);
        }
        foreach (Note::whereNotNull('image')->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', '_thumb.', $model->image);
            $this->move($thumb);
        }
        foreach (Organisation::whereNotNull('image')->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', '_thumb.', $model->image);
            $this->move($thumb);
        }
        foreach (Quest::whereNotNull('image')->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', '_thumb.', $model->image);
            $this->move($thumb);
        }
        foreach (Tag::whereNotNull('image')->get() as $model) {
            $count++;
            $this->move($model->image);
            $thumb = str_replace('.', '_thumb.', $model->image);
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
        if (Storage::disk('public')->exists($file)) {
            $content = Storage::disk('public')->get($file);
            Storage::disk('s3')->put($file, $content, 'public');
            unset($content);
        }
    }
}
