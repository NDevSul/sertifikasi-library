<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author'];

    // Relasi Many-to-Many dengan Category
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function members()
{
    return $this->belongsToMany(Member::class)->withPivot('status')->withTimestamps();
}
}
