<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTemplate extends Model
{
    use HasFactory;
    protected $table='user_templates';
    protected $fillable=['username','type_id','email','phone'];
}
