<?php

namespace App\Models;

use App\Contracts\HasTypesInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Message extends Model implements HasTypesInterface
{
    public function types(): HasOne
    {
        return $this->hasOne(GrantType::class);
    }
}
