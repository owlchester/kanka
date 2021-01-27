<?php


namespace App\Models;


use App\Facades\Img;
use App\Traits\CampaignTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class Image
 * @package App\Models
 *
 * @property string $id
 * @property int $campaign_id
 * @property string $name
 * @property string $ext
 * @property int $size
 * @property int $created_by
 * @property string $folder_id
 * @property bool $is_default
 * @property bool $is_folder
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property ImageFolder $imageFolder
 *
 * @property User $user
 * @property Campaign $campaign
 *
 * @property string $path
 * @property string $file
 * @property string $folder
 */
class Image extends Model
{
    use CampaignTrait;

    public $fillable = [
        'name',
        'is_folder',
        'folder_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function imageFolder()
    {
        return $this->belongsTo(Image::class, 'folder_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'folder_id', 'id');
    }

    /**
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }

    /**
     * @return string
     */
    public function getPathAttribute(): string
    {
        return $this->folder . '/' . $this->file;
    }

    /**
     * @return string
     */
    public function getFileAttribute(): string
    {
        return $this->id . '.' . $this->ext;
    }

    /**
     * @return string
     */
    public function getFolderAttribute(): string
    {
        return 'campaigns/' . $this->campaign_id;
    }

    /**
     * @return string
     */
    public function niceSize(): string
    {
        if ($this->size > 1000) {
            return round($this->size / 1024, 2) . ' MB';
        }

        return $this->size . ' KB';
    }

    /**
     * @param $query
     * @param $folderUuid
     * @return mixed
     */
    public function scopeImageFolder($query, $folderUuid)
    {
        if (empty($folderUuid)) {
            return $query->whereNull('folder_id');
        }

        return $query->where('folder_id', $folderUuid);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDefaultOrder($query)
    {
        return $query
            ->orderBy('is_folder', 'desc')
            ->orderBy('updated_at', 'desc');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeFolders($query)
    {
        return $query
            ->where('is_folder', true)
            ->orderBy('name', 'asc');
    }

    /**
     * @return bool
     */
    public function hasNoFolders(): bool
    {
        return $this->images()->where('is_folder', '1')->count() == 0;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return \Illuminate\Support\Facades\Storage::url($this->path);
    }
}
