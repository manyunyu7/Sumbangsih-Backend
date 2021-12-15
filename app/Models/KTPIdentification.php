<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KTPIdentification extends Model
{
    protected $appends = ['user_detail'];
    use HasFactory;
    protected $table = "ktp";

    function getUserDetailAttribute(){
        return User::find($this->user_id);
    }

}
