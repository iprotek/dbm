<?php

namespace iProtek\Dbm\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use iProtek\Core\Models\_CommonModel;

class DbmBackup extends _CommonModel
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        "is_auto",
        "file_name",
        "status_info",
        "is_completed"
    ];

    public $casts = [
        "is_auto"=>"boolean",
        "is_completed"=>"boolean",
        "created_at"=>"datetime: F j, y h:i a"
    ];
}
