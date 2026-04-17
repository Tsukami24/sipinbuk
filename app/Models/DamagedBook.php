<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DamagedBook extends Model
{
    protected $table = 'damaged_books';

    protected $fillable = [
        'borrow_detail_id',
        'book_item_id',
        'damage_level',
        'description',
    ];

    public function bookItem()
    {
        return $this->belongsTo(BookItem::class);
    }

    public function borrowDetail()
    {
        return $this->belongsTo(BorrowDetail::class);
    }
}
