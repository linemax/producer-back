<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory, Uuids;

    protected $fillable = ['url'];
    protected $hidden = ['photoable_type', 'photoable_id'];

    public function videoable(){
        return $this->morphTo();
    }
}
