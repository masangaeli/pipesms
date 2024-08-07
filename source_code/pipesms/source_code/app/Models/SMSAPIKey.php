<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMSAPIKey extends Model
{
    use HasFactory;

    //Fillables
    protected $fillable = [
        'user_id', 'device_id', 'api_key'
    ];

}
