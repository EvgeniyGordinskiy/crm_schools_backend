<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $table = 'permission_role';
    public $timestamps = false;
    
    public function role() {
        return $this->belongsTo(Role::class);
    } 
    
    public function permission() {
        return $this->belongsTo(Permission::class);
    } 
}
