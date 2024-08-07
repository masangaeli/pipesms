<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    //Fillables
    protected $fillable = [
        
        'user_id', 'first_name','middle_name',

        'last_name', 'phone_number'
    
    ];


    //Relation Ship to Message
    public function message()
    {
        return $this->hasMany(QueueMessage::class);
    }
}
