<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDbmBackupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('dbm_backups', function (Blueprint $table) {
            
            $table->iprotekDefaultColumns();

            $table->boolean('is_auto')->default(1);
            $table->string('file_name');
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
        Schema::dropIfExists('dbm_backups');
    }
}
