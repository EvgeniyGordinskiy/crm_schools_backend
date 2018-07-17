<?php
namespace  App\Http\Controllers;


use App\Http\Resources\PermissionResource;
use App\Http\Resources\RolePermissionsResource;
use App\Models\Permission;
use App\Models\RolePermission;

class PermissionController extends Controller
{
    public function index()
    {
        return PermissionResource::collection(Permission::all());
    }
    
    public function roles_permissions()
    {
        return RolePermissionsResource::collection(RolePermission::whereHas('role', function($q){
            $q->where('name', '!=', 'super_admin');
        })->get());
    }
}