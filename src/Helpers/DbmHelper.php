<?php

namespace iProtek\Dbm\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DbmHelper
{ 
    public static function backup($is_auto=false){

        $tables = DB::select('SHOW TABLES');
        $database = config('database.connections.mysql.database');
        $rows = [];
        $excluded = ['migrations', 'failed_jobs', 'user_admins', 'user_admin_pay_accounts'];
        foreach ($tables as $tableObj) {
            $table = array_values((array) $tableObj)[0];
            if (in_array($table,  $excluded)) continue; // skip

            $data = DB::table($table)->get();
            foreach ($data as $row) {
                $columns = array_map(fn($k) => "`$k`", array_keys((array)$row));
                $values = array_map(fn($v) => is_null($v) ? 'NULL' : DB::getPdo()->quote($v), array_values((array)$row));
                $rows[] = "INSERT INTO `$table` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $values) . ");";
            }
        }

        if($is_auto)
            file_put_contents(storage_path("app/db-backup/auto-export".date("YmdHis").".sql"), implode("\n", $rows));
        else
            file_put_contents(storage_path("app/db-backup/manual-export".date("YmdHis").".sql"), implode("\n", $rows));

        return ["status"=>1, "message"=>"completed" ];
    }

    public static function restore(){
        
    }


}
