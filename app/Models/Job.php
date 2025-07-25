<?php

namespace App\Models;

//if you use factory it is mandatary 
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jobType(){
        return $this->belongsTo(JobType::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function applications(){
        return $this->hasMany(JobApplication::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
