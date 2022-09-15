<?php

use Illuminate\Support\Facades\Log;

function reportError(Throwable $throwable) :void
{
    Log::error(
        $throwable->getMessage() . PHP_EOL
        . 'in line: ' . $throwable->getFile() . PHP_EOL
        . 'in file: ' . $throwable->getFile()
    );
}
