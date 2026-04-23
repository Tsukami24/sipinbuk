<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $table = 'borrows';

    protected $fillable = [
        'user_id',
        'borrow_date',
        'due_date',
        'status',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'due_date'    => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(BorrowDetail::class);
    }

    public function fines()
    {
        return $this->hasManyThrough(
            Fine::class,
            BorrowDetail::class
        );
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'active' => 'Sedang Dipinjam',
            'completed' => 'Selesai',
            'overdue' => 'Terlambat',
            'pending' => 'Menunggu Persetujuan',
            'rejected' => 'Ditolak',
            default => ucfirst($this->status),
        };
    }
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'active' => 'bg-warning text-dark',
            'completed' => 'bg-success',
            'overdue' => 'bg-danger',
            'pending' => 'bg-secondary',
            'rejected' => 'bg-dark',
            default => 'bg-secondary',
        };
    }
}
