<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HumanResources extends Model
{
    protected $fillable = [
        'task_name',
        'description',
        'assigned_to',
        'status',
        'due_date'
    ];

    // Define relationships with other models if necessary
}