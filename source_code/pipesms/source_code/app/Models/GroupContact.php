<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupContact extends Model
{
    use HasFactory;

    //Fillables
    protected $fillable = ['user_id', 'group_id', 'contact_id'];
}
