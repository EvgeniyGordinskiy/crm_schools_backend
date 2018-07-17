<?php
namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;

class RoleController
{
    public function index()
    {
        return RoleResource::collection(Role::all());
    }
}