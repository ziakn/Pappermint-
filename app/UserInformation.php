<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{

    protected $fillable = [
        'user_id', 'qid_no', 'passport_no','city','address','type','document_copy','passport_copy','status'
    ];

}
