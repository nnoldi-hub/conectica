<?php

/**
 * Manual PSR-4 / files autoloader for packages that could not be installed
 * via Composer on the production host (escapeshellarg/escapeshellcmd are
 * disabled there, which breaks Composer entirely).
 *
 * This file is self-contained and does NOT touch vendor/composer/* at all,
 * so it cannot conflict with the Composer-managed autoloader already
 * present on the server. It only needs the package folders themselves to
 * be present under vendor/.
 *
 * Packages covered: barryvdh/laravel-dompdf, dompdf/dompdf,
 * dompdf/php-font-lib, dompdf/php-svg-lib, sabberworm/php-css-parser,
 * thecodingmachine/safe.
 */

$vendorPath = __DIR__.'/../vendor';

$psr4Prefixes = [
    'Barryvdh\\DomPDF\\' => $vendorPath.'/barryvdh/laravel-dompdf/src/',
    'Dompdf\\' => $vendorPath.'/dompdf/dompdf/src/',
    'FontLib\\' => $vendorPath.'/dompdf/php-font-lib/src/FontLib/',
    'Svg\\' => $vendorPath.'/dompdf/php-svg-lib/src/Svg/',
    'Sabberworm\\CSS\\' => $vendorPath.'/sabberworm/php-css-parser/src/',
];

spl_autoload_register(function (string $class) use ($psr4Prefixes): void {
    foreach ($psr4Prefixes as $prefix => $baseDir) {
        if (! str_starts_with($class, $prefix)) {
            continue;
        }

        $relativeClass = substr($class, strlen($prefix));
        $file = $baseDir.str_replace('\\', '/', $relativeClass).'.php';

        if (is_file($file)) {
            require $file;
        }

        return;
    }
});

// thecodingmachine/safe classmap + files autoload. Must be loaded before
// sabberworm/php-css-parser, which calls Safe\* functions at file scope.
foreach ([
    $vendorPath.'/thecodingmachine/safe/lib/DateTime.php',
    $vendorPath.'/thecodingmachine/safe/lib/DateTimeImmutable.php',
] as $file) {
    if (is_file($file)) {
        require_once $file;
    }
}

// SafeExceptionInterface must load before the concrete exceptions that
// implement it.
$safeExceptionInterface = $vendorPath.'/thecodingmachine/safe/lib/Exceptions/SafeExceptionInterface.php';
if (is_file($safeExceptionInterface)) {
    require_once $safeExceptionInterface;
}

foreach (glob($vendorPath.'/thecodingmachine/safe/lib/Exceptions/*.php') ?: [] as $file) {
    require_once $file;
}

foreach (glob($vendorPath.'/thecodingmachine/safe/generated/Exceptions/*.php') ?: [] as $file) {
    require_once $file;
}

if (is_file($vendorPath.'/thecodingmachine/safe/lib/special_cases.php')) {
    require_once $vendorPath.'/thecodingmachine/safe/lib/special_cases.php';
}

foreach (glob($vendorPath.'/thecodingmachine/safe/generated/*.php') ?: [] as $file) {
    require_once $file;
}

// dompdf/dompdf classmap (lib/) — not PSR-4, load directly.
foreach (glob($vendorPath.'/dompdf/dompdf/lib/*.php') ?: [] as $file) {
    require_once $file;
}

// sabberworm/php-css-parser "files" autoload.
foreach ([
    $vendorPath.'/sabberworm/php-css-parser/src/Rule/Rule.php',
    $vendorPath.'/sabberworm/php-css-parser/src/RuleSet/RuleContainer.php',
] as $file) {
    if (is_file($file)) {
        require_once $file;
    }
}
