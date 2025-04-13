<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $config = config('roles');
        $mapping = $config['mappings'];
        foreach($config['roles'] as $roleName => $value){
            $role = Role::findOrCreate($roleName);
            
            $perms = [];
            foreach($value as $permKey => $perm){
                if($permKey == 'weight'){
                    $role->weight = $perm;
                    $role->save();
                }else
                if($permKey == 'specific'){
                    foreach($perm as $specificPerm){

                        $perms[] =  Permission::findOrCreate($specificPerm);
                    }
                }else{
                    $crud = explode(',', $perm);
                    foreach($crud as $c){
                        $finalPerm = $permKey . '.' . $mapping[$c];
                        $perms[] = Permission::findOrCreate($finalPerm);
                    }
                  
                }

            }
            $role->syncPermissions($perms);
          
        }
    }
   
    
}
