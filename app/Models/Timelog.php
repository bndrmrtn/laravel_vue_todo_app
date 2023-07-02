<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timelog extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $fillable = ['current_status_id', 'user_id'];
}
