<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueueMessage extends Model
{
    use HasFactory;

    //Fillables
    protected $fillable = [
        
        'user_id', 'contact_id', 'group_id', 'to_phone_number','message_data'
    
    ];
}
