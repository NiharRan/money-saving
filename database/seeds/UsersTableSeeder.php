<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
        'name' => 'Nihar Ranjan Das',
        'slug' => Str::slug('Nihar Ranjan Das', '-'),
        'father_name' => 'Niranjan Kumer Das',
        'mother_name' => 'Swapna Rani Das',
        'phone' => '01623021319',
        'email' => 'niharranjandasmu@gmail.com',
        'gender_id' => 1,
        'birth_date' => '1994-08-18',
        'blood_group_id' => 1,
        'religion_id' => 1,
        'role_id' => 1,
        'password' => Hash::make('12345678'),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ]);
      DB::table('users')->insert([
        'name' => 'Akash Das',
        'slug' => Str::slug('Akash Das', '-'),
        'father_name' => 'Niranjan Kumer Das',
        'mother_name' => 'Swapna Rani Das',
        'phone' => '01761152186',
        'email' => 'akashdasmu@gmail.com',
        'gender_id' => 1,
        'birth_date' => '1994-08-18',
        'blood_group_id' => 1,
        'religion_id' => 1,
        'role_id' => 2,
        'password' => Hash::make('12345678'),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ]);

      DB::table('users')->insert([
        'name' => 'Pulok Talukdar',
        'slug' => Str::slug('Pulok Talukdar', '-'),
        'father_name' => '',
        'mother_name' => '',
        'phone' => '01726334422',
        'gender_id' => 1,
        'birth_date' => '1994-10-12',
        'blood_group_id' => 1,
        'religion_id' => 1,
        'role_id' => 2,
        'password' => Hash::make('12345678'),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ]);

      DB::table('users')->insert([
        'name' => 'Prodip Das',
        'slug' => Str::slug('Prodip Das', '-'),
        'father_name' => '',
        'mother_name' => '',
        'phone' => '01911152186',
        'gender_id' => 1,
        'birth_date' => '1993-05-28',
        'blood_group_id' => 1,
        'religion_id' => 1,
        'role_id' => 2,
        'password' => Hash::make('12345678'),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ]);
    }
}
