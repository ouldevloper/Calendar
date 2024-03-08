<?php

namespace App\Presenter;

use App\Domain\Event\Contracts\IEventRepository;
use App\Domain\Event\UseCases\AddEvent\Request\AddEventInputPort;
use App\Persistense\Repositories\EventRepository;
use App\Presentation\Middlewares\CoreMiddleware;
use App\UseCase\AddEventInteractor;
use Core\App;

class Kernel extends App {
    protected static array $Container = [];public static array $middlewares = [
        'cors'  => CoreMiddleware::class,
        'cors1' => CoreMiddleware::class,
    ];

    public final static function singleton(string $key, string $value, ?array $parms=null):void
    {
        $obj = self::$Container[$key] ?? null;
        if(!isset($obj) || !$obj)
        {
            $newObj = is_null($parms) ? new $value : new $value($parms);
            self::$Container[$key] = new $newObj;
        }
    }
    public final static function bind(string $key, string|callable $value):void
    {
        self::$Container[$key] = is_string($value) ? new $value : $value;
    }

    public final static function app(string $key):mixed
    {
        return self::$Container[$key];
    }

    public final static function get(string $key):mixed
    {
        $retObj =  self::$Container[$key] ?? null;
        return match (gettype($retObj)){
            'string' => new $retObj,
            'callable' => $retObj,
            default => null
        };
    }
}

Kernel::bind(IEventRepository::class, EventRepository::class);
Kernel::bind(AddEventInputPort::class, AddEventInteractor::class);