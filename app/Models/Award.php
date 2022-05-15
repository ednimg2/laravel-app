<?php

namespace App\Models;

use App\Models\Traits\CommentableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use CommentableTrait;
    use HasFactory;

    protected $table = 'award';

    public function blog() {
        return $this->belongsTo(Blog::class);
    }
}
