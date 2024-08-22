<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gantt extends Model
{
    protected $table = 'gantt'; // Specify the correct table name

    protected $fillable = [
        'name', 'start', 'end', 'client', 'parts'
    ];    // public $timestamps = false;
}