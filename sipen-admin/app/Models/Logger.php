<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth,Session;
class Logger extends Model
{
    protected $table='logger';
    protected static $SUCCESS   = 'S';
    protected static $INFO	= 'I';
    protected static $WARNING   = 'W';
    protected static $EXCEPTION = 'E';

    private function Log($alert, $title, $message)
    {
        $log = new self;
        $log->fkuser  = Auth::user() ? Auth::user()->id : null;
        $log->alert  = $alert;
        $log->title = $title;
        $log->message  = $message;
        $log->app_id = 1;
        @$log->save();
    }

    public static function Success($title, $message)
    {
        $log = new self;
        $log->Log(self::$SUCCESS, $title, $message);
    }

    public static function Info($title, $message)
    {
        $log = new self;
        $log->Log(self::$INFO, $title, $message);
    }

    public static function Warning($title, $message)
    {
        $log = new self;
        $log->Log(self::$WARNING, $title, $message);
    }

    public static function Exception($title, $ex)
    {
        $log = new self;
        $message  = "Path: {$ex->getFile()} Line: {$ex->getLine()}\n";
        $message .= "Error Message: {$ex->getMessage()}";
        $log->Log(self::$EXCEPTION, $title, $message);
    }


}
