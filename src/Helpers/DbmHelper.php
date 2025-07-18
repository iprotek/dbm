<?php

namespace iProtek\Dbm\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use iProtek\Dbm\Models\DbmBackup;
use iProtek\Dbm\Models\DbmRestore;
use iProtek\Core\Helpers\PayModelHelper;

class DbmHelper
{ 

    public static $excluded = [
        'migrations', 
        'failed_jobs', 
        'user_admins', 
        'user_admin_pay_accounts',
        'sys_sidemenu_items',
        'sys_sidemenu_groups',
        'sys_sidemenu_combos',
        'web_visitors',
        'jobs',
        'sys_notifications',
        'dbm_backups',
        'dbm_restores'
    ];

    public static function backup( Request $request = null, $is_auto=false){

        $tables = DB::select('SHOW TABLES');
        $database = config('database.connections.mysql.database');
        $rows = [];

        $generated = DbmBackup::whereRaw(' created_at > NOW() - INTERVAL 30 MINUTE ')->first();
        if($generated){
            //abort(403, "Already generated please retry after 30 Minutes");
            return response()->json(["message"=>"Already generated please retry after 30 Minutes"], 403);
        }
    
        if($request){
            $file_name = "manual-export_".$database."_".date("YmdHis").".sql";
            $backup = PayModelHelper::create(DbmBackup::class, $request, [
                "is_auto"=>false,
                "file_name"=>$file_name,
                "status_info"=>"Generating backup",
                "is_completed"=>false
            ]);
        }
        else{
            $file_name = $is_auto === false ?  "manual-export_".$database."_".date("YmdHis").".sql" : "auto-export_".$database."_".date("YmdHis").".sql";
            $backup = DbmBackup::create([
                "is_auto"=> $is_auto,
                "file_name"=>$file_name,
                "status_info"=>"Generating backup",
                "is_completed"=>false
            ]);

        }
        foreach ($tables as $tableObj) {
            $table = array_values((array) $tableObj)[0];
            if (in_array($table,  static::$excluded)) continue; // skip

            $data = DB::table($table)->get();
            $data_length = count($data);
            if($data_length > 0){
                $renders = "";
                for($counter = 0; $counter < $data_length; $counter++){
                    $row = $data[$counter];
                    if($counter == 0){
                        $columns = array_map(fn($k) => "`$k`", array_keys((array)$row));
                    }
                    $values = array_map(fn($v) => is_null($v) ? 'NULL' : DB::getPdo()->quote($v), array_values((array)$row));
                    if($data_length == 1)
                        $renders= "INSERT INTO `$table` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $values) . ")";
                    else{
                        if($counter == 0){
                            $renders = "INSERT INTO `$table` (" . implode(', ', $columns) . ") VALUES";
                        }
                        $renders .= ($counter > 0 ? ",":"")."(" . implode(', ', $values) . ")";

                    }
                }

                $rows[] = $renders.";";

            }
        }

        $backup->status_info = "Generating completed";
        $backup->is_completed = true;
        $backup->save();

        $path = "";
        if($is_auto){
            $path = storage_path("app/db-backup/".$file_name);
            file_put_contents($path, implode("\n", $rows));
        }
        else{
            $path = storage_path("app/db-backup/".$file_name);
            file_put_contents($path, implode("\n", $rows));
            return response()->download($path, $file_name)->deleteFileAfterSend(true);
        }
        return ["status"=>1, "message"=>"completed" ];
    }

    public static function restore(Request $request = null, $restore_location=null, $file_name=null){
        
        $tables = DB::select('SHOW TABLES');
        $database = config('database.connections.mysql.database');
        $rows = [];

        
        if($request){
            //$file_name = $file_name ?? "manual-export_".$database."_".date("YmdHis").".sql";
            $restore = PayModelHelper::create(DbmRestore::class, $request, [
                "file_name"=>$file_name,
                "is_restored"=>false,
                "dbm_backup_id"=>0,
                "status_info"=>"Restoring data from backup"
            ]);
        }
        else{
            //$file_name = $is_auto === false ?  "manual-export_".$database."_".date("YmdHis").".sql" : "auto-export_".$database."_".date("YmdHis").".sql";
            $restore = DbmRestore::create([
                "file_name"=>$file_name,
                "is_restored"=>false,
                "dbm_backup_id"=>0,
                "status_info"=>"Restoring data from backup"
            ]);

        }


        foreach ($tables as $tableObj) {
            $table = array_values((array) $tableObj)[0];
            if (in_array($table,  static::$excluded)) continue; // skip

            //TRUNCATE TABLE
            DB::table($table)->truncate();

        }
        //INSERTDATA FROM SQL FILE
        $sql = file_get_contents(storage_path('app/'.$restore_location));
        DB::unprepared($sql);
        //Log::error("Backup restored");

        $restore->is_restored = true;
        $restore->status_info = "Successfully restored.";
        $restore->save();


        return ["status"=>1, "message"=>"Restoring successful"];
    }


}
