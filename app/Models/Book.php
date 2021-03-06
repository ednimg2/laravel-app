<?php

namespace App\Models;

use App\Models\Traits\CommentableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    use CommentableTrait;

    protected $fillable = ['title', 'description'];
}
