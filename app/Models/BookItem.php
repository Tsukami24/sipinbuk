<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookItem extends Model
{
    protected $table = 'book_items';
    protected $fillable = [
        'book_id',
        'book_code',
        'status'
    ];

    const STATUS_AVAILABLE = 'available';
    const STATUS_BORROWED  = 'borrowed';
    const STATUS_LOST      = 'lost';

    public static function statuses()
    {
        return [
            self::STATUS_AVAILABLE => 'Available',
            self::STATUS_BORROWED  => 'Borrowed',
            self::STATUS_LOST      => 'Lost',
        ];
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function borrowDetails()
    {
        return $this->hasMany(BorrowDetail::class);
    }
}
