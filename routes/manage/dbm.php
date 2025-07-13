<?php

use iProtek\Dbm\Http\Controllers\DbmController;


Route::prefix('system/dbm')->name('.system.dbm')->group(function(){

    //GET APP LISTS BASED ON THE LINK
    Route::get('', [DbmController::class, 'index']);
    /**My Details */ 
    
});