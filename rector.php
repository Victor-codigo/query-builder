<?php

use Rector\Config\RectorConfig;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->withPreparedSets(
        deadCode: true,
    )
    ->withSkip([
        ReadOnlyPropertyRector::class,
    ])
    ->withPhpSets(php84: true)
    ->withTypeCoverageLevel(100)
;
