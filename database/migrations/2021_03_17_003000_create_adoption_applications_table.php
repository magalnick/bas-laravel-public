<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdoptionApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adoption_applications', function (Blueprint $table) {
            $table->increments('id');
            $table->char('token', 36)->unique();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('adoptable_animal_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('adoptable_animal_id')->references('id')->on('adoptable_animals');
            $table->string('type', 20)->default('');
            $table->string('animal_name', 100)->default('');
            $table->boolean('is_old_enough')->default(0);
            $table->string('government_id', 40)->default('');
            $table->date('government_id_expires_at')->nullable(false)->default('1000-01-01');
            $table->string('address_1', 100)->default('');
            $table->string('address_2', 100)->default('');
            $table->string('city', 50)->default('');
            $table->char('state', 2)->default('');
            $table->char('zip_code', 5)->default('');
            $table->char('phone_1', 12)->default('');
            $table->char('phone_2', 12)->default('');
            $table->text('object_data');
            $table->timestamp('created_at')->nullable(false)->default('1970-01-01 00:00:01');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->default('1970-01-01 00:00:01');
            $table->timestamp('submitted_at')->nullable(false)->default('1970-01-01 00:00:01');
            $table->timestamp('archived_at')->nullable(false)->default('1970-01-01 00:00:01');
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adoption_applications');
    }
}
