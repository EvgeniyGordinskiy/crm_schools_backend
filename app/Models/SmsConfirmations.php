<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsConfirmations extends Model
{
    protected $table = 'sms_confirmations';
    protected $guarded =[];
    public function users(){
        $this->belongsTo(User::class);
    }
}
