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

    public function getFineTypeLabelAttribute()
    {
        return match ($this->fine_type) {
            'late' => 'Terlambat',
            'damaged' => 'Rusak',
            'lost' => 'Hilang',
            default => ucfirst($this->fine_type),
        };
    }

    public function getFineBadgeAttribute()
    {
        return match ($this->fine_type) {
            'late' => 'bg-warning text-dark',
            'damaged' => 'bg-danger',
            'lost' => 'bg-dark',
            default => 'bg-secondary',
        };
    }
}
