<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Auth,Session;

class Logger extends Model
{
    protected $table = 'logger';
    protected $fillable = ['fkuser','alert', 'title', 'message','app_id'];

    protected static $SUCCESS   = 'S';
    protected static $INFO			 = 'I';
    protected static $WARNING   = 'W';

    protected static $EXCEPTION = 'E';

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\Models\Usuario', 'user_id');
    }

    public function app()
    {
        return $this->belongsTo('App\Models\App');
    }

    public function cssClass()
    {
        switch ($this->type) {
            case self::$SUCCESS: return 'success';
            case self::$INFO: return 'info';
            case self::$WARNING: return 'warning';
            case self::$EXCEPTION: return 'danger';
        }
    }

    public function icon()
    {
        switch ($this->type) {
            case self::$SUCCESS: return icon('check fa-lg');
            case self::$INFO: return icon('info-circle fa-lg');
            case self::$WARNING: return icon('warning fa-lg');
            case self::$EXCEPTION: return icon('bug fa-lg');
        }
    }

    public function types()
    {
        $types[self::$SUCCESS]   = 'Sucesso';
        $types[self::$INFO] 		 = 'Informação';
        $types[self::$WARNING] 	 = 'Advertência';
        $types[self::$EXCEPTION] = 'Exceção';

        return $types;
    }

    private function log($alert, $title, $message)
    {
        $log = new self;
        $log->fkuser  = Auth::user() ? Auth::user()->id : null;
        $log->alert  = $alert;
        $log->title = $title;
        $log->message  = $message;
        $log->app_id = Session::get('app_id');
        @$log->save();
    }

    public static function success($title, $text)
    {
        $log = new self;
        $log->log(self::$SUCCESS, $title, $text);
    }

    public static function info($title, $text)
    {
        $log = new self;
        $log->log(self::$INFO, $title, $text);
    }

    public static function warning($title, $text)
    {
        $log = new self;
        $log->log(self::$WARNING, $title, $text);
    }

    public static function exception($title, $text)
    {
        $log = new self;
        $log->log(self::$EXCEPTION, $title, $text);
    }



    public static function cssClass2($types)
    {
        switch ($types) {
            case 'S': return 'success';
            case 'I': return 'info';
            case 'W': return 'warning';
            case 'E': return 'danger';
        }
    }

    public static function icone($types)
    {
        switch ($types) {
            case 'S': return icon('check fa-lg');
            case 'I': return icon('info-circle fa-lg');
            case 'W': return icon('warning fa-lg');
            case 'E': return icon('bug fa-lg');
        }
    }
}
