<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use App\Models\Book;
use MongoDB\Laravel\Eloquent\HybridRelations;


class Library extends Model
{
    use HasFactory, HybridRelations;
    protected $connection = 'mysql';
    protected $table = 'libraries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'user_id',
    ];

    public function books() : Collection {
        return Book::where('library_id', (string) $this->id)->get();
    }

    public function user() : BelongsTo 
    {
        return $this->belongsTo(User::class);
    }
}
