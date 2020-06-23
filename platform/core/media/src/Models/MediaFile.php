<?php

namespace Botble\Media\Models;

use Botble\Media\Services\UploadsManager;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class MediaFile extends BaseModel
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'media_files';

    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'mime_type',
        'type',
        'size',
        'url',
        'options',
        'folder_id',
        'user_id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'options' => 'json',
    ];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function (MediaFile $file) {
            if ($file->isForceDeleting()) {
                $uploadManager = new UploadsManager;
                $uploadManager->deleteFile($file->url);
            }
        });
    }

    /**
     * @return BelongsTo
     */
    public function folder()
    {
        return $this->belongsTo(MediaFolder::class, 'id', 'folder_id');
    }

    /**
     * @return string
     */
    public function getTypeAttribute()
    {
        $type = 'document';
        if ($this->attributes['mime_type'] == 'youtube') {
            return 'video';
        }

        foreach (config('core.media.media.mime_types', []) as $key => $value) {
            if (in_array($this->attributes['mime_type'], $value)) {
                $type = $key;
                break;
            }
        }

        return $type;
    }

    /**
     * @return string
     */
    public function getHumanSizeAttribute()
    {
        return human_file_size($this->attributes['size']);
    }

    /**
     * @return string
     */
    public function getIconAttribute()
    {
        switch ($this->type) {
            case 'image':
                $icon = 'far fa-file-image';
                break;
            case 'video':
                $icon = 'far fa-file-video';
                break;
            case 'pdf':
                $icon = 'far fa-file-pdf';
                break;
            case 'excel':
                $icon = 'far fa-file-excel';
                break;
            case 'youtube':
                $icon = 'fab fa-youtube';
                break;
            default:
                $icon = 'far fa-file-alt';
                break;
        }
        return $icon;
    }

    /**
     * @return bool
     */
    public function canGenerateThumbnails(): bool
    {
        return is_image($this->mime_type) &&
            !in_array($this->mime_type, ['image/svg+xml', 'image/x-icon']) &&
            Storage::exists($this->url);
    }
}
