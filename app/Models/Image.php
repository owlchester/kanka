<?php


namespace App\Models;


use App\Facades\Img;
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
 * @property bool $is_default
 * @property Carbon $created_at
 * @property Carbon $updated_at
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
    public $fillable = [
        'name',
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
}
