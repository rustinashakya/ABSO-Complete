<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SearchLog;
class LogController extends Controller
{

    public function showUserLogs(Request $req)
    {  
        $rdate = $req->input('date', date('Y-m-d'));
        // dd($rdate);
        // date('Y-m-d')
        if(isset($rdate)){
            $log_file_path = storage_path('logs/khalti/'. $rdate.'.log');
        }else{
        $log_file_path = storage_path('logs/khalti/'. date('Y-m-d').'.log');
        }
        if (!file_exists($log_file_path)) {
            return response('Log file not found', 404);
        }

        $log_data = array_reverse(file($log_file_path));
        // dd($log_data);
        foreach ($log_data as $log){

        preg_match('/\[(.+?)\]/', $log, $dateMatches);
        preg_match('/(\w+?):/', $log, $actionMatches);
        preg_match('/\.(\w+?):/', $log, $levelMatches);
        $message = substr(strstr($log, ': '), 2);
        $messageData = explode(': ', $message);
        $messageLevel = strtoupper($levelMatches[1]);
        $data = '';
        if (preg_match('/: ({.+?})/', $log, $matches)) {
            $data = json_decode($matches[1], true);

        }
        if ($messageLevel === 'INFO' || $messageLevel === 'ERROR' || ($messageLevel === 'WARNING' && count($messageData) > 1)) {
            $message = $messageData[1];
        }
        preg_match('/\[(.+?)\]\s+(.+?):\s+(.+?)\s+(.+?):\s+(.+?)\s+(.+?)\[(.*?)\]/', $log, $matches);
        $actionMatches = explode(' : ', $matches[2]);

        $action = $actionMatches[0];
        $jsonMessage = json_encode($data, JSON_PRETTY_PRINT);
        $printMessage = json_decode($jsonMessage);
        // dump($jsonMessage,$printMessage);
        $date=date('Y-m-d', strtotime($dateMatches[1]));
        $time = date('H:i:s', strtotime($dateMatches[1]));
        $level=strtoupper($levelMatches[1]);
        $action=ucwords(str_replace('_', ' ', $action));


        $logdata[]=[
            'date'=> $date,
            'time'=> $time,
            'level'=> $level,
            'action'=> $action,

        ];



    }



        return view('admin.logs.user_log',compact('logdata','printMessage','date',));

    }

}

