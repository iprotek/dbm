<?php

namespace iProtek\Dbm\Http\Controllers;

use Illuminate\Http\Request;
use iProtek\Core\Http\Controllers\_Common\_CommonController;
use iProtek\Dbm\Models\DbmBackup;

class DbmBackupController extends _CommonController
{
    //
    public $guard = 'admin';

    public function get_list(Request $request){
        $list = DbmBackup::on();
        return $list->paginate(10);
    }
}
