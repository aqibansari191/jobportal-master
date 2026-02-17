<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobAplication extends Model
{
    use HasFactory;

    protected $table = 'jobs_application';
    protected $primaryKey = 'id';

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }
}
