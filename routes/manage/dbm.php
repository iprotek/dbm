<?php

use iProtek\Dbm\Http\Controllers\DbmController;


Route::prefix('system/dbm')->name('.system.dbm')->group(function(){

    //GET APP LISTS BASED ON THE LINK
    Route::get('/', [DbmController::class, 'index'])
        ->defaults("_description", "Database Management Index page")
        ->defaults("_is_visible", false)
        ->defaults("_is_allow", true)
        ->name('.index');
    /**My Details */ 
    
});