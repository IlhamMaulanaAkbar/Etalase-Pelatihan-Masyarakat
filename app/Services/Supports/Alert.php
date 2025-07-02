<?php

namespace App\Services\Supports;

class Alert
{
    const SUCCESS = 'success';
    const ERROR = 'danger';
    const WARNING = 'warning';
    const INFO = 'info';

    public static function message($message, $type = Alert::SUCCESS)
    {
        session()->flash('alert', [
            'message' => $message,
            'type' => $type,
        ]);
    }

    public static function success($message)
    {
        self::message($message, Alert::SUCCESS);
    }

    public static function error($message)
    {
        self::message($message, Alert::ERROR);
    }

    public static function warning($message)
    {
        self::message($message, Alert::WARNING);
    }
}
