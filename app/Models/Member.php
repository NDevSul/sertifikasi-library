<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Member extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email']; 

    public function books()
    {
        return $this->belongsToMany(Book::class)->withPivot('status')->withTimestamps();
    }

    public function borrowedBooks()
    {
        return $this->books()->wherePivot('status', 'borrowed');
    }


}

