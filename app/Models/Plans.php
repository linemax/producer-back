<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Plans extends Model
{
    use HasFactory, Uuids;
    protected $fillable = ['title'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }


    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }
}
