<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class UserJob extends Model{
        protected $table = 'usertablejob';
        protected $fillable = [
        'jobid', 'jobname',
    ];

    
    //The code below will not require the field create_at and update_at in Eloquent
    public $timestamps = false;
    
    //The code will customize your primary key field name, default in Eloquent is 'id'
     protected $primaryKey = 'jobid';
     
}