<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'author', 'is_active'
    ];

    protected $attributes = [
        'is_active' => false,
    ];

    public function award()
    {
        return $this->hasOne(Award::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
