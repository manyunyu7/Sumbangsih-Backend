<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Schema;

class ColekController extends Controller
{
    public function colek()
    {
        $qotd = Inspiring::quote();

        $message_id = "";
        $message_en = "";

        $changeLog = array();

        $response = [
            'http_response' => 200,
            'version' => "0.0.1",
            'quotes_of_the_day' => $qotd,
            'message_id' => $message_id,
            'message_en' => $message_en,
            'changeLog' => $changeLog,
        ];

        return response($response, 200);
    }

    public function drop($schemeName)
    {
        Schema::dropIfExists("$schemeName");
    }
}
