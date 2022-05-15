<?php

namespace App\Models;

use App\Models\Traits\CommentableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory;
    use CommentableTrait;
    use SoftDeletes;

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

    public function audits()
    {
        return $this->hasMany(Audit::class);
    }
}
