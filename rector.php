<?php

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->withPreparedSets(
        deadCode: true,
    )
    ->withPhpSets(php56: true)
    ->withTypeCoverageLevel(100)
;
