<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowDetail extends Model
{
    protected $table = 'borrow_details';

    protected $fillable = [
        'borrow_id',
        'book_item_id',
        'returned_at',
        'return_requested',
        'return_condition',
    ];

    public function borrow()
    {
        return $this->belongsTo(Borrow::class);
    }

    public function bookItem()
    {
        return $this->belongsTo(BookItem::class);
    }

    public function damagedBooks()
    {
        return $this->hasMany(DamagedBook::class);
    }

    public function fines()
    {
        return $this->hasMany(Fine::class);
    }
}
