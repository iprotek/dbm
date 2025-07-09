<?php

namespace iProek\Dbm\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use iProtek\Core\Models\_CommonModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class DbmRestore extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        "file_name",
        "is_restored",
        "dbm_backup_id",
        "status_info"
    ];
}
