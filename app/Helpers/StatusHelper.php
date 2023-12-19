<?php
namespace App\Helpers;

use App\Models\Klien;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class StatusHelper
{
    
    public static function push_status($klien_id, $status = NULL)
    {
        return Klien::where('id', $klien_id)->update(['status' => $status ]);
    }
}