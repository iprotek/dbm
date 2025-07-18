<?php

namespace iProtek\Dbm\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use iProtek\Core\Http\Controllers\_Common\_CommonController;

class DbmController extends _CommonController
{ 
    public $guard = 'admin';

    public function index(Request $request){
        return $this->view('iprotek_dbm::index');
    }

}