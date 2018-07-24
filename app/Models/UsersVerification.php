<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersVerification extends Model
{
    protected $table = 'users_verifications';
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
