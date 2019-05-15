<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    protected $fillable = [
        'admission_id', 'date', 'user_id', 'time', 'staff_id'
    ];
    public function admission(){
        return $this->belongsTo(Admission::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeNotdeleted($query){
        return $query->where('deleted', 0);
    }

    public function pending($id){
        $pending = Interview::where('admission_id', $id)->where('status', 0)->count();
        return $pending;
    }

    public function rejected($id){
        $rejected = Interview::where('admission_id', $id)->where('status', 2)->count();
        return $rejected;
    }

    public function confirmed($id){
        $confirmed = Interview::where('admission_id', $id)->where('status', 1)->count();
        return $confirmed;
    }
}
