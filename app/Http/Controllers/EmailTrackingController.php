<?php

namespace App\Http\Controllers;

use App\Models\EmailLog;
use Illuminate\Http\Response;

class EmailTrackingController extends Controller
{
    private const PIXEL = "\x47\x49\x46\x38\x39\x61\x01\x00\x01\x00\x80\x00\x00\x00\x00\x00\xff\xff\xff\x21\xf9\x04\x01\x00\x00\x00\x00\x2c\x00\x00\x00\x00\x01\x00\x01\x00\x00\x02\x02\x44\x01\x00\x3b";

    public function pixel(string $token): Response
    {
        $log = EmailLog::query()->where('tracking_token', $token)->first();

        if ($log && $log->status !== 'opened') {
            $log->update([
                'status' => 'opened',
                'opened_at' => now(),
            ]);
        }

        return response(self::PIXEL, 200, [
            'Content-Type' => 'image/gif',
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
        ]);
    }
}
