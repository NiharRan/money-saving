<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('name');
          $table->string('slug')->unique();
          $table->string('avatar')->nullable()->default('default.jpg');
          $table->string('phone', 11)->unique();
          $table->string('email')->nullable()->unique();

          $table->unsignedBigInteger('account_id');
          $table->foreign('account_id')->references('id')->on('accounts');

          $table->unsignedBigInteger('gender_id')->nullable();
          $table->foreign('gender_id')->references('id')->on('genders');

          $table->unsignedBigInteger('religion_id')->nullable();
          $table->foreign('religion_id')->references('id')->on('religions');

          $table->unsignedBigInteger('division_id');
          $table->foreign('division_id')->references('id')->on('divisions');

          $table->unsignedBigInteger('district_id');
          $table->foreign('district_id')->references('id')->on('districts');

          $table->unsignedBigInteger('upazilla_id');
          $table->foreign('upazilla_id')->references('id')->on('upazillas');

          $table->text('address')->nullable();
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
