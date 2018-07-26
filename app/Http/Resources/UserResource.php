<?php

namespace App\Http\Resources;

use App\Models\School;
use App\Services\Image\ImageService;
use Illuminate\Http\Resources\Json\Resource;
use Intervention\Image\Facades\Image;

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
            'emailVerified' => $this->emailVerified,
            'phoneNumberVerified' => $this->phoneNumberVerified,
            'registerComplete' => $this->registerComplete,
            'avatar' => $this->avatar ? (string) Image::make(ImageService::getImage(ImageService::$AVATARS_FOLDER, $this->avatar))->encode('data-url') : '',
            'role' => $this->role->name,
            'permissions' => PermissionResource::collection($this->role->permissions),
            'schools' => SchoolResource::collection(School::whereOwner($this->id)->get()),
        ];
    }
}
