<?php

use Illuminate\Support\Facades\Route; 
use iProtek\Apps\Http\Controllers\AppsController;
use Illuminate\Http\Request;

include(__DIR__.'/api.php');

Route::middleware(['web'])->group(function(){
 
    Route::middleware(['auth:admin','can:super-admin'])->prefix('manage')->name('manage')->group(function(){
        
        
        Route::prefix('system/dbm')->name('.system.dbm')->group(function(){

            //GET APP LISTS BASED ON THE LINK
            Route::get('backup',function(Request $request){
                return \iProtek\Dbm\Helpers\DbmHelper::backup();
            })->name('.backup');
            
        });
        

    });
  
});