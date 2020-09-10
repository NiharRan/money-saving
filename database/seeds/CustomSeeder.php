<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $weekDays = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
      foreach ($weekDays as $weekDay) {
        DB::table('week_days')->insert([
          'name' => $weekDay,
          'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
          'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
      }

      $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
      foreach ($bloodGroups as $bloodGroup) {
        DB::table('blood_groups')->insert([
          'name' => $bloodGroup,
          'status' => 1,
          'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
          'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
      }

      $genders = ['Male', 'Female', 'Others'];
      foreach ($genders as $gender) {
        DB::table('genders')->insert([
          'name' => $gender,
          'status' => 1,
          'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
          'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
      }

      $religions = ['Hindu', 'Muslim', 'Cristian', 'Buddha'];
      foreach ($religions as $religion) {
        DB::table('religions')->insert([
          'name' => $religion,
          'status' => 1,
          'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
          'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
      }

      $roles = ['Admin', 'Subscriber',];
      foreach ($roles as $role) {
        DB::table('roles')->insert([
          'name' => $role,
          'status' => 1,
          'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
          'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
      }


      // Address related tables
      $divisions = ['Dhaka', 'Sylhet', 'Chitagong'];
      foreach ($divisions as $division) {
        DB::table('divisions')->insert([
          'name' => $division,
          'status' => 1,
          'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
          'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
      }
      $districts = ['Hobigong', 'Sylhet', 'Sunamgong'];
      foreach ($divisions as $division) {
        DB::table('districts')->insert([
          'division_id' => 2,
          'name' => $division,
          'status' => 1,
          'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
          'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
      }
      $upazillas = ['Tahirpur', 'Jamalgong', 'Sunamgong'];
      foreach ($upazillas as $upazilla) {
        DB::table('upazillas')->insert([
          'division_id' => 2,
          'district_id' => 3,
          'name' => $upazilla,
          'status' => 1,
          'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
          'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
      }

      $accountTypes = ['Single', 'Join'];
      foreach ($accountTypes as $accountType) {
        DB::table('account_types')->insert([
          'name' => $accountType,
          'slug' => Str::slug($accountType),
          'status' => 1,
          'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
          'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
      }

      $transactionTypes = ['Saving', 'Widrow', 'Borrow'];
      foreach ($transactionTypes as $transactionType) {
        DB::table('transaction_types')->insert([
          'name' => $transactionType,
          'slug' => Str::slug($transactionType),
          'status' => 1,
          'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
          'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
      }

      $moneyFormats = ['TK', 'USD', 'RUPY'];
      foreach ($moneyFormats as $moneyFormat) {
        DB::table('money_formats')->insert([
          'name' => $moneyFormat,
          'slug' => Str::slug($moneyFormat),
          'status' => 1,
          'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
          'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
      }
    }
}
