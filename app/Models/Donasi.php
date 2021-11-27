<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    use HasFactory;

    protected $appends = ['accounts_detail', 'name','user_detail','status_desc'];

    public function getAccountDetailAttribute()
    {
        return DonationAccount::find($this->accounts_id);
    }

    public function getStatusDescAttribute()
    {
        switch ($this->is_verified){
            case "1" :
                return "Terverifikasi";
                break;
            case "0" :
                return "Pending";
                break;
            case "3" :
                return "Tidak Valid";
                break;
        }
        return "Tidak Diketahui";
    }

    public function getUserDetailAttribute()
    {
        return User::find($this->user_id);
    }

    public function getNameAttribute()
    {
        if ($this->show_as == "" || $this->show_as == null)
            return User::find($this->user_id)->name;
        else
            return $this->show_as;
    }


}
