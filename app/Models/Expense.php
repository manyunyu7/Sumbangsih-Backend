<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $appends = ['event'];

    function getEventAttribute(){
        return EatEvent::find($this->event_id);
    }

}
