<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelaryModel extends Model
{
    use HasFactory;

    protected $table = 'selary_type';
    protected $primaryKey = 'id';


}
