<?php

namespace iProtek\Dbm\Http\Controllers;

use Illuminate\Http\Request;
use iProtek\Core\Http\Controllers\_Common\_CommonController;
use iProtek\Dbm\Helpers\DbmHelper;
use iProtek\Dbm\Models\DbmRestore;
use Illuminate\Support\Facades\Log;

class DbmRestoreController extends _CommonController
{
    //
    public $guard = 'admin';

    public function restore(Request $request){

        $this->validate($request,[
            'file' => 'required|file|mimes:sql,txt'
        ]);

        
        //$has_restored = DbmRestore::whereRaw(' created_at > NOW() - INTERVAL 30 MINUTE ')->first();
        $has_restored = null;
        if($has_restored){
            return response()->json(["message"=>"Already restored. Please retry after 30 Minutes"], 403);
            //return ["status"]
        }

        $file_name = "upload-restore_".date("YmdHis").".sql";

        $path = $request->file('file')->storeAs('db-backup',  $file_name );
        
        return DbmHelper::restore($request, $path, $file_name);
        
    }

    public function restore_list(Request $request){
        $list = DbmRestore::on();
        return $list->orderBy('id', 'DESC')->paginate(10);

    }


}
