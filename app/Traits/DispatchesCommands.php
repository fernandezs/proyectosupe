<?php

namespace App\Traits;

trait DispatchesCommands
{

    public function execute($command, $handler, array $input = [], array $middleware = [])
    {
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler($command, $handler);
        return $bus->dispatch($command, $input, $middleware);
    }
}