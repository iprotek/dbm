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

      Route::get('create-backup', [DbmBackupController::class, 'backup'])
        ->defaults("_description", "create backup for database")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.backup');

      Route::get('backup-list', [DbmBackupController::class, 'get_list'])
        ->defaults("_description", "Get backup list for database")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.list');

      Route::post('restore-from-file', [DbmRestoreController::class, 'restore'])
        ->defaults("_description", "Restore database from backup file")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.restore');

      Route::get('restore-list', [DbmRestoreController::class, 'restore_list'])
        ->defaults("_description", "Get restore list for database")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.restore-list');

    });
 
}); 
