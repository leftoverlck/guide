<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'latitude',
        'longitude',
        'type',
        'region',
        'category'
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
