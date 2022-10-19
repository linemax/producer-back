<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Services extends Model
{
    use HasFactory, Uuids;

    protected $fillable = ['name', 'description'];
    protected $with = ['photo', 'photos'];

    
    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }
    
    public function plans()
    {
        return $this->hasMany(Plans::class);
    }
    
    public function photo()
    {
        return $this->morphOne(Photo::class, 'photoable');
    }

}
