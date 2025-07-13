<?php

use Illuminate\Support\Facades\Route; 
use iProtek\Core\Http\Controllers\Manage\FileUploadController; 
use iProtek\Core\Http\Controllers\AppVariableController;
use Illuminate\Http\Request;

Route::prefix('api')->middleware('api')->name('api')->group(function(){ 

    Route::prefix('group/{group_id}/system/dbm')->middleware(['pay.api'])->name('.system.dbm')->group(function(){
      
      //FILE UPLOADS
      //include(__DIR__.'/api/file-upload.php');

      //FILE UPLOADS
      //include(__DIR__.'/api/meta-data.php'); 

      Route::get('backup',function(Request $request){
          return \iProtek\Dbm\Helpers\DbmHelper::backup();
      })->name('.backup');

    });
 
}); 
