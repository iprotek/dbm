<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDbmRestoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dbm_restores', function (Blueprint $table) {

            $table->iprotekDefaultColumns();

            $table->string('file_name');
            $table->boolean('is_restored')->default(0);
            $table->bigInteger('dbm_backup_id')->nullable();
            $table->string('status_info')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dbm_restores');
    }
}
