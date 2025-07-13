<?php

namespace iProtek\Dbm\Http\Controllers;

use Illuminate\Http\Request;
use iProtek\Core\Http\Controllers\_Common\_CommonController;
use iProtek\Dbm\Models\DbmBackup;
use iProtek\Dbm\Helpers\DbmHelper;

class DbmBackupController extends _CommonController
{
    //
    public $guard = 'admin';

    public function backup(Request $request){
        return DbmHelper::backup($request);
    }

    public function get_list(Request $request){
        $list = DbmBackup::on();
        return $list->orderBy('id', 'DESC')->paginate(10);
    }
}
