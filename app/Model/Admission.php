<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $fillable = [
        'name', 'description', 'status'
    ];

    public function interviews(){
        return $this->hasMany(Interview::class);
    }

}
