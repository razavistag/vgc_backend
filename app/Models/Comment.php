<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Arr;

class Comment extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'type_id',
        'document_id', // documentID
        'document_status', //status
        'comment',  //message
        'hrm_auto_id', //userID
        'email_add', //selectedEmails
        'hrm_name', //userName
        'is_read', //markas read / unread
        'is_send_email', //email sent or not
        'current_time', //executedTime
    ];

    public function transformAudit(array $data): array
    {
        Arr::set($data, 'recode_auto_id',  $this->attributes['document_id']);

        return $data;
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'hrm_auto_id');
    }
}
