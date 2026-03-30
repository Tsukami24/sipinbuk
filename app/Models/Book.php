<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'title',
        'cover',
        'author',
        'publisher',
        'year',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function items()
    {
        return $this->hasMany(BookItem::class);
    }
}
