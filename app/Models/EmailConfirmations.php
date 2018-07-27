<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailConfirmations extends Model
{
    protected $guarded = [];
    public function users(){
        $this->belongsTo(User::class);
    }
}
