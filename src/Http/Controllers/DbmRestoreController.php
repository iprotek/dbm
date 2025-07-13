<?php

namespace iProtek\Dbm\Http\Controllers;

use Illuminate\Http\Request;
use iProtek\Core\Http\Controllers\_Common\_CommonController;
use iProtek\Dbm\Helpers\DbmHelper;
use iProtek\Dbm\Models\DbmRestore;

class DbmRestoreController extends _CommonController
{
    //
    public $guard = 'admin';

    public function restore(Request $request){

        return DbmHelper::restore($request);

    }

    public function restore_list(Request $request){
        $list = DbmRestore::on();
        return $list->orderBy('id', 'DESC')->paginate(10);

    }


}
