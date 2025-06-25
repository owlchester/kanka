<?php

declare(strict_types=1);

$packagesToInstall = [
    'driftingly/rector-laravel',
    'rector/rector',
    'webmozart/assert',
];
composer_require(...$packagesToInstall);

$hash = md5(implode(' ', $packagesToInstall));
$rectorDir = cpx_path(".exec_cache/$hash");

$rectorConfigFile = <<<'PHP'
<?php declare(strict_types=1);
use Rector\Config\RectorConfig;
return RectorConfig::configure()
    ->withRules([
        \RectorLaravel\Rector\ClassMethod\AddGenericReturnTypeToRelationsRector::class,
    ]);
PHP;

file_put_contents("$rectorDir/rector.php", $rectorConfigFile);

exec("$rectorDir/vendor/bin/rector process app --config=$rectorDir/rector.php --no-progress-bar", $output, $return_var);

echo implode("\n", $output);
