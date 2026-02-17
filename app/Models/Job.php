<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    // protected $table = 'job';
    // protected $primaryKey = 'id';
    //  protected $fillable=[
    //     'title',
    //     'status',
    //     'category_id',
    //     'job_type_id',
    //     'vacancy',
    //     'salary',
    //     'status',
    //     'location',
    //     'description',
    //     'benefits',
    //     'responsibility',
    //     'keywords',
    //     'experience',
    //     'company_name',
    //     'company_location',
    //     'company_website'
    // ];

    protected $table = 'job';
    protected $primaryKey = 'id';

    public function jobType(){
    return $this->belongsTo(JobType::class);
}
    public function category(){
    return $this->belongsTo(category::class);
}

    public function applications(){
    return $this->hasMany(JobAplication::class);
}


    public function user(){
    return $this->belongsTo(user::class);
}

    public function selary(){
    return $this->belongsTo(SelaryModel::class);
}
}
