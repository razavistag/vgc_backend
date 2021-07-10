<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    protected $fillable = [
        'document_auto_id',
        'document_type',
        'document_name',
        'file_name',
        'file_extention',
        'file_size',
        'note',
    ];
}
