<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'category_id',
        'title',
        'description',
        'image',
        'deleted_at'
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return asset(Storage::disk()->url($this->image));
    }
}
