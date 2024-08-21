<?php

use Illuminate\Support\Facades\Log;
if (! function_exists('logUserAction')) {
function logUserAction($type,$prefix, $context = [])
{
    
    switch ($type) {
        case 'error':   
            Log::channel('userlog')->error($prefix, $context);
            break;
        case 'warning':
            Log::channel('userlog')->warning($prefix, $context);
            break;
        case 'info':
            Log::channel('userlog')->info($prefix, $context);
            break;
        default:
            Log::channel('userlog')->info($prefix, $context);
            break;
    }
}
}
