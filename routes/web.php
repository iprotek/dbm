<?php

use Illuminate\Support\Facades\Route; 
use iProtek\Apps\Http\Controllers\AppsController;
use Illuminate\Http\Request;
use iProtek\Dbm\Http\Controllers\DbmController;

include(__DIR__.'/api.php');

Route::middleware(['web'])->group(function(){
 
    Route::middleware(['auth:admin','can:super-admin'])->prefix('manage')->name('manage')->group(function(){
        
        
        include(__DIR__.'/manage/dbm.php'); 
        

    });
  
});