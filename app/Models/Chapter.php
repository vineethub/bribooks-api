<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = [
        'book_id',
        'title',
        'position'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
