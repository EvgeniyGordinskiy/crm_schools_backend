<?php

namespace App\Services\Permission;

use App\Models\Role;
use App\Models\RolePermission;

class PermissionService
{
	public function update($permissions = []) {
		foreach ($permissions as $role => $permissionArray) {
			$roleModel = Role::whereName($role)->first();
			if($roleModel) {
				$roleModel->permissions()->sync($permissionArray);
			}
		}
	}
}