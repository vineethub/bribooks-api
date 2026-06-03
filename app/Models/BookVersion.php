<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookVersion extends Model
{
    use HasFactory;
    protected $fillable = [
        'book_id',
        'version_number',
        'snapshot_json',
        'created_by'
    ];
}
