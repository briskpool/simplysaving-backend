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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('profile_img');
            $table->string('email')->unique();
            $table->string('security_answer')->nullable();
            $table->bigInteger('security_question_id')->nullable();
            $table->boolean('is_secure')->default(0);
            $table->integer('attempts')->default(0);
            $table->string('status')->default('active');
            $table->timestamp('email_verified_at')->nullable();
            $table->text('password');
            $table->decimal('client_balance')->default(0);
            $table->boolean('is_admin')->nullable();
            $table->rememberToken();
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
