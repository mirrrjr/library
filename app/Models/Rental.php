<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    /** @use HasFactory<\Database\Factories\RentalFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'rentet_at',
        'due_at',
        'returned_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
