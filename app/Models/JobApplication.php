<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    //
    protected $guarded = [];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function job_owner()
    {
        return $this->belongsTo(User::class, 'job_owner_id');
    }

}
