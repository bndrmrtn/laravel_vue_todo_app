<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $fillable = ['todo_id', 'user_id'];
}
