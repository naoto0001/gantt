<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gant extends Model
{
    protected $table = 'gantt'; // Specify the correct table name

    protected $fillable = [
        'name', 'description', 'start', 'end', 'progress'
    ];    // public $timestamps = false;
}
