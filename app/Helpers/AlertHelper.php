<?php

if (!function_exists('alert_success')) {

    function alert_success($message): void
    {
        $key = 'notify';
        $value = ['type' => 'success', 'message' => $message];
        Session::flash($key, $value);
    }
}

if (!function_exists('alert_error')) {

    function alert_error($message): void
    {
        $key = 'notify';
        $value = ['type' => 'error', 'message' => $message];
        Session::flash($key, $value);
    }
}
