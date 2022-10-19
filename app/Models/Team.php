<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Team extends Model
{
    use HasFactory, Uuids;
    protected $fillable = ['name','occupation', 'description'];
    protected $with = ['photo'];

    public function photo()
    {
        return $this->morphOne(Photo::class, 'photoable');
    }

}
