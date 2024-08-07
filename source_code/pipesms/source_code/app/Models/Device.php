<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    //Fillables
    protected $fillable = ['user_id', 'device_title', 'device_info'];


    //Relation Ship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
