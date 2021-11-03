<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        \DB::table('permissions')->delete();

        \DB::table('permissions')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'viewNova',
                'guard_name' => 'web',
                'group' => 'System',
                'created_at' => '2021-10-29 02:44:25',
                'updated_at' => '2021-10-29 02:44:25',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'viewDocuments',
                'guard_name' => 'web',
                'group' => 'System',
                'created_at' => '2021-10-29 02:44:37',
                'updated_at' => '2021-10-29 02:44:37',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'viewMutations',
                'guard_name' => 'web',
                'group' => 'System',
                'created_at' => '2021-10-29 02:44:44',
                'updated_at' => '2021-10-29 02:44:44',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'downloadDocuments',
                'guard_name' => 'web',
                'group' => 'System',
                'created_at' => '2021-10-29 02:45:09',
                'updated_at' => '2021-10-29 02:45:09',
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'downloadMutations',
                'guard_name' => 'web',
                'group' => 'System',
                'created_at' => '2021-10-29 02:45:23',
                'updated_at' => '2021-10-29 02:45:23',
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'uploadDocument',
                'guard_name' => 'web',
                'group' => 'System',
                'created_at' => '2021-10-29 02:45:34',
                'updated_at' => '2021-10-29 02:45:34',
            ),
            6 =>
            array (
                'id' => 7,
                'name' => 'uploadMutation',
                'guard_name' => 'web',
                'group' => 'System',
                'created_at' => '2021-10-29 02:45:45',
                'updated_at' => '2021-10-29 02:45:45',
            ),
            7 =>
            array (
                'id' => 8,
                'name' => 'viewLogs',
                'guard_name' => 'web',
                'group' => 'System',
                'created_at' => '2021-10-29 02:45:57',
                'updated_at' => '2021-10-29 02:45:57',
            ),
        ));

    }
}
