<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function permission_type()
    {
        return $this->belongsTo(PermissionType::class);
    }
    
    public function roles()
    {
        return $this->hasMany(Role::class);
    }
}
