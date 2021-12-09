<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $appends = ['photo_path', 'date_indo'];

    function getPhotoPathAttribute()
    {
        return asset($this->photo);
    }

    function getDateIndoAttribute()
    {
        $dbDate = Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)
            ->locale('id')->isoFormat('dddd, D MMMM Y');
        return $dbDate;
    }

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:00',
    ];

}
