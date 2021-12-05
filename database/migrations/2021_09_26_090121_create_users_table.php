<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 30);
            $table->string('last_name', 50);
            $table->string('username', 50)->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('profile_image')->nullable();
            $table->date('birthdate');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('gender_id');
            $table->foreign('role_id')->references("id")->on("roles")->onDelete('cascade');
            $table->foreign('gender_id')->references("id")->on("genders")->onDelete('cascade');
            $table->boolean('is_active')->default(1);
            $table->boolean('is_reported')->default(0);
            $table->boolean('is_blocked')->default(0);
            $table->dateTime('reported_at', $precision = 0)->nullable();
            $table->dateTime('blocked_at', $precision = 0)->nullable();
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
        Schema::dropIfExists('users');
    }
}
