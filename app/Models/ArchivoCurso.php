<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoCurso extends Model
{
    use HasFactory;
    protected $table = 'archivo_curso';
    public $timestamps = false;
}
