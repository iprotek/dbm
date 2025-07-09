<?php

namespace iProek\Dbm\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use iProtek\Core\Models\_CommonModel;

class DbmBackup extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        "is_auto",
        "file_name",
        "status_info"
    ];
}
