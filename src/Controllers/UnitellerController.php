<?php

namespace gitkv\Uniteller\Controllers;


use gitkv\Uniteller\Events\UnitellerCallbackEvent;
use gitkv\Uniteller\Facade\Uniteller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;


class UnitellerController extends Controller {

    public function callback(Request $request) {
        $payload = $request->all();
        Log::debug('Uniteller payment callback', $payload);
        if (!Uniteller::verifySignature($request->input('Signature'), $request->only('Order_ID', 'Status'))) {
            return 'fail';
        }
        event(new UnitellerCallbackEvent($payload));

        return 'success';

    }

    public function success(Request $request) {
        return view('uniteller::success', $request->all());
    }

    public function fail(Request $request) {
        return view('uniteller::fail', $request->all());
    }

}