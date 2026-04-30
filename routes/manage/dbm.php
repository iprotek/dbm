<?php

use iProtek\Dbm\Http\Controllers\DbmController;


Route::prefix('system/dbm')->name('.system.dbm')->group(function(){

    //GET APP LISTS BASED ON THE LINK
    Route::get('/', [ 
        "uses"=>[DbmController::class, 'index'],
        "description"=>"Databse Management Index page",
        "is_visible"=>false,
        "is_allow"=>true
    ]);
    /**My Details */ 
    
});