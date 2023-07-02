<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $fillable = ['current_status_id', 'group_id', 'user_id', 'task', 'priority'];
    protected $with = ['status','group'];

    public function status(){
        return $this->belongsTo(Status::class,'current_status_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function group(){
        return $this->belongsTo(Group::class,'group_id');
    }

    public function hasActiveActivity(){
        $timelog = Timelog::where('todo_id','=',$this->id)->where('finished','=',0)->first();
        if($timelog) return $timelog;
        return false;
    }

    public function timelog(){
        return $this->hasMany(Timelog::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function logStatus($status = NULL){
        if(!$status) $status = $this->current_status_id;
        Statuschange::create([
            'status_id' => $status,
            'todo_id' => $this->id,
        ]);
    }

}
