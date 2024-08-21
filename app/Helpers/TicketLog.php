<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
if (! function_exists('log_event')) {
function log_event($type,$prefix, $message)
{
    $log_path = storage_path() . '/logs/khalti/' . date('Y-m-d') . '.log';
  
    $logger = new Logger($prefix. ' : ' . date('Y-d-m H:i:s'));
    $logger->pushHandler(new StreamHandler($log_path, Logger::INFO));
    
    switch ($type) {
        case 'error':
            $logger->error($message);
            break;
        case 'warning':
            $logger->warning($message);
            break;
        case 'info':
        default:
            $logger->info($message);
            break;
    }
}
}
