<?php

namespace App\Models;

use App\Models\Traits\CommentableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    use CommentableTrait;
}
