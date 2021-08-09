<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class Attachment extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'document_auto_id',
        'document_type',
        'document_name',
        'file_name',
        'file_extention',
        'file_size',
        'note',
    ];

    public function transformAudit(array $data): array
    {
        Arr::set($data, 'recode_auto_id',  $this->attributes['document_auto_id']);
        Arr::set($data, 'user_name',  Auth::user()->name);

        return $data;
    }

}
