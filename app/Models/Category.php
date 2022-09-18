<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image'
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return asset(Storage::disk()->url($this->image));
    }
}
