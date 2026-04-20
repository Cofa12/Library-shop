<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Books extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'books';
    protected $fillable = [
        'name',
        'author',
        'isbn',
        'price',
        'library_id'
    ];
}
