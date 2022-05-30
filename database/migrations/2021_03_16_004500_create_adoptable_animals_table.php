<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdoptableAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adoptable_animals', function (Blueprint $table) {
            $table->increments('id');
            $table->char('token', 36)->unique();
            $table->string('type', 20)->default('dog');
            $table->string('name', 100)->default('');
            $table->text('description');
            $table->boolean('is_active')->default(1);
            $table->boolean('is_available')->default(1);
            $table->timestamp('created_at')->nullable(false)->default('1970-01-01 00:00:01');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->default('1970-01-01 00:00:01');
            $table->timestamp('adopted_at')->nullable(false)->default('1970-01-01 00:00:01');
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
        Schema::dropIfExists('adoptable_animals');
    }
}
