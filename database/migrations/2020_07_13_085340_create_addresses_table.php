<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->text('address')->nullable();
            $table->string('upazilla_id', 30)->nullable();
            $table->string('district_id', 30)->nullable();
            $table->string('division_id', 30)->nullable();
            $table->string('postcode')->nullable();
            $table->boolean('type')->default(1)->comment("1 -> Current\n2 -> Permanent");
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('addresses');
    }
}
