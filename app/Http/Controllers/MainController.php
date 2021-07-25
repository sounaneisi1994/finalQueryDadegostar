<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index()
    {
        $topics = DB::select("
        SELECT topics.id as topic_id,
               (SELECT count(1) from tickets as t where topics.id = t.topic_id)
        FROM tickets
        right JOIN topics ON topics.id = tickets.topic_id
        GROUP BY topics.id
    ");

        return response()->json(
            $topics
        );
    }
}
