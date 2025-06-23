<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DomainCheckController extends Controller
{
    public function check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'domain' => [
                'required','string','max:255',
                'regex:/^(?!-)[A-Za-z0-9-]{1,63}(?<!-)\.(com|net|org|io|ru|рф)$/u'
            ],
        ], ['domain.regex' => 'Недопустимый формат домена.']);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first('domain')], 422);
        }

        $domain    = Str::lower($request->domain);

        $hash = crc32($domain);

        $days = ($hash >> 1) % 365 + 1;

        $available = (bool) ($hash % 2);
        $expiresAt = Carbon::now()->addDays($days)->toDateString();

        return response()->json([
            'domain'     => $domain,
            'available'  => $available,
            'expires_at' => $expiresAt,
        ]);
    }
}
