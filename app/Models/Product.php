<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'stock',
        'type',
        'image',
        'description',
    ];


    public function getImageUrlAttribute()
    {
        $r2Url = config('filesystems.disks.r2.public_url', 'https://pub-ef41dcc750a041ce9bac4f3337e6e4a7.r2.dev');
        return $r2Url . '/' . $this->image;
    }
}
