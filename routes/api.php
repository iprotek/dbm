<?php

use Illuminate\Support\Facades\Route; 
use iProtek\Core\Http\Controllers\Manage\FileUploadController; 
use iProtek\Core\Http\Controllers\AppVariableController;
use Illuminate\Http\Request;
use iProtek\Dbm\Http\Controllers\DbmBackupController;
use iProtek\Dbm\Http\Controllers\DbmRestoreController;

Route::prefix('api')->middleware('api')->name('api')->group(function(){ 

    Route::prefix('group/{group_id}/system/dbm')->middleware(['pay.api', 'policy.control'])->name('.system.dbm')->group(function(){
      
      //FILE UPLOADS
      //include(__DIR__.'/api/file-upload.php');

      //FILE UPLOADS
      //include(__DIR__.'/api/meta-data.php'); 

      Route::get('create-backup',[
        "uses"=>[DbmBackupController::class, 'backup'],
        "description"=>"create backup for database",
        "is_visible"=>true,
        "is_allow"=>false
      ])->name('.backup');

      Route::get('backup-list', [
        "uses"=>[DbmBackupController::class, 'get_list'],
        "description"=>"Get backup list for database",
        "is_visible"=>true,
        "is_allow"=>false
      ])->name('.list');

      Route::post('restore-from-file', [
        "uses"=>[DbmRestoreController::class, 'restore'],
        "description"=>"Restore database from backup file",
        "is_visible"=>true,
        "is_allow"=>false
      ])->name('.restore');

      Route::get('restore-list', [
        "uses"=>[DbmRestoreController::class, 'restore_list'],
        "description"=>"Get restore list for database",
        "is_visible"=>true,
        "is_allow"=>false
      ])->name('.restore-list');

    });
 
}); 
