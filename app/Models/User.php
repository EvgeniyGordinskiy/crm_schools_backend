<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();  // Eloquent model method
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'user' => [
                'id' => $this->id,
            ]
        ];
    }

//    public function scopePermissions()
//    {
//        $rolePermissionTable = (new RolePermission)->getTable();
//        $permissionTable = (new Permission)->getTable();
//        $roleTable = (new Role)->getTable();
//        return $this
//            ->join($roleTable,"users.role_id",'=', "$roleTable.id")
//            ->join($rolePermissionTable,"$roleTable.id",'=',"$rolePermissionTable.role_id")
//            ->join($permissionTable,'permission_id', '=', "$permissionTable.id");
//    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
