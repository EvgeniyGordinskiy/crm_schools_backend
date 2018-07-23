<?php

namespace App\Http\Resources;

use App\Models\School;
use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
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
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role->name,
            'permissions' => PermissionResource::collection($this->role->permissions),
            'schools' => SchoolResource::collection(School::whereOwner($this->id)->get()),
        ];
    }
}
