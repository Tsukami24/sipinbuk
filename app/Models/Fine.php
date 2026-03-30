<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $table = 'fines';

    protected $fillable = [
        'borrow_detail_id',
        'fine_type',
        'amount',
        'is_paid',
    ];

    public function borrowDetail()
    {
        return $this->belongsTo(BorrowDetail::class);
    }
}
