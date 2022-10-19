<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Project extends Model
{
    use HasFactory, Uuids;

    protected $fillable = ['title', 'description', 'producer', 'client',];
    protected $with = ['photo', 'video', 'galleries'];

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }


    public function photo()
    {
        return $this->morphOne(Photo::class, 'photoable');
    }

    public function video()
    {
        return $this->morphOne(Video::class, 'videoable');
    }

}
