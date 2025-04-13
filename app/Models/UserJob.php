<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserJob extends Model
{
    protected $table = 'usertablejob';

    protected $fillable = [
        'jobid', 'jobname',
    ];

    // The code below will not require the fields created_at and updated_at in Eloquent
    public $timestamps = false;

    // The code below customizes your primary key field name (default is 'id')
    protected $primaryKey = 'jobid';
}
