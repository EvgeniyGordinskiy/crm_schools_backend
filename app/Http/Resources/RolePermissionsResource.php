<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class RolePermissionsResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'role' => $this->role->name,
            'permission_id' => $this->permission_id,
            'model_name' => $this->permission->model_name
        ];  
    }
}
