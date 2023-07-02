<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $fillable = ['todo_id', 'comment','user_id'];

    protected $with = ['user'];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
