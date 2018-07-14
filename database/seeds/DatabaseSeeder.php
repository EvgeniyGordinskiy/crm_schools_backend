<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    private $roles = [
        'super_admin',
        'admin',
        'student_individual',
        'student_group',
        'teacher'
    ];

    private $events = [
      'read',
      'update',
      'delete',
      'insert'
    ];

    private $permissionTypes = [
      'message' => [
          'to super admin',
          'to owner',
          'to student',
          'to teacher',
      ],
      'payment' => [
          'individual',
          'group',
          'special discount'
      ]
    ];

    private $rolePermissions = [

    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 5)->create();
        factory(App\Models\School::class, 5)->create();
        factory(App\Models\Program::class, 5)->create();
        factory(App\Models\SchoolPrograms::class, 5)->create();
        factory(App\Models\Attendance::class, 5)->create();
        factory(App\Models\Schedule::class, 5)->create();
        factory(App\Models\Membership::class, 5)->create();
        factory(App\Models\ProgramMembership::class, 5)->create();
        foreach ($this->roles as $role) {
            (new \App\Models\Role(['name' => $role]))->save();
        }
        foreach ($this->getModels() as $model) {
            $modelR = 'App\Models\\'.ucfirst($model);
            if(new $modelR() instanceof \App\Contracts\HasTypesInterface) {
                if(isset($this->grantTypes[strtolower($model)])) {
                    foreach ($this->permissionTypes[strtolower($model)] as $grantType) {
                        $tmpModel = new \App\Models\PermissionType(['name' => $grantType]);
                        $tmpModel->save();
                        foreach ($this->events as $event) {
                            (new \App\Models\Permission([
                                'grant_type_id' => $tmpModel->id,
                                'model_name' => $model,
                                'event' => $event
                            ]))->save();
                        }
                    }
                }
            } else {
                foreach ($this->events as $event) {
                    (new \App\Models\Permission([
                        'grant_type_id' => null,
                        'model_name' => $model,
                        'event' => $event
                    ]))->save();
                }
            }
        }
    }

    private function getModels(){
        $path = app_path() . "/Models";
        $out = [];
        $results = scandir($path);
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;
            $filename = $path . '/' . $result;
            if (is_dir($filename)) {
                $out = array_merge($out, $this->getModels($filename));
            }else{
                $out[] = substr($result,0,-4);
            }
        }
        return $out;
    }
}
