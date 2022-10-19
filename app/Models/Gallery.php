<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory, Uuids;

    protected $fillable = ['title'];
    protected $with = ['photos', 'videos'];

    /**
     * Get the project that owns the Gallery
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }


    public function videos()
    {
        return $this->morphMany(Video::class, 'videoable');
    }
}
