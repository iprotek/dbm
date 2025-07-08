<?php

namespace iProtek\Dbm\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DbmHelper
{ 

    public static $excluded = ['migrations', 'failed_jobs', 'user_admins', 'user_admin_pay_accounts'];

    public static function backup($is_auto=false){

        $tables = DB::select('SHOW TABLES');
        $database = config('database.connections.mysql.database');
        $rows = [];
        //$excluded = ['migrations', 'failed_jobs', 'user_admins', 'user_admin_pay_accounts'];
        foreach ($tables as $tableObj) {
            $table = array_values((array) $tableObj)[0];
            if (in_array($table,  static::$excluded)) continue; // skip

            $data = DB::table($table)->get();
            foreach ($data as $row) {
                $columns = array_map(fn($k) => "`$k`", array_keys((array)$row));
                $values = array_map(fn($v) => is_null($v) ? 'NULL' : DB::getPdo()->quote($v), array_values((array)$row));
                $rows[] = "INSERT INTO `$table` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $values) . ");";
            }
        }

        $path = "";
        if($is_auto){
            $path = storage_path("app/db-backup/auto-export_".$database."_".date("YmdHis").".sql");
            file_put_contents($path, implode("\n", $rows));
        }
        else{
            $path = storage_path("app/db-backup/manual-export_".$database."_".date("YmdHis").".sql");
            file_put_contents($path, implode("\n", $rows));
            return response()->download($path, "manual-export_".$database."_".date("YmdHis").".sql")->deleteFileAfterSend(true);
        }
        return ["status"=>1, "message"=>"completed" ];
    }

    public static function restore(){
        
    }


}
