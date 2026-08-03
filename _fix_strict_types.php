<?php

$dirs = ['app/Http/Controllers', 'app/Models', 'app/Services', 'app/Providers', 'app/Console', 'app/Filament'];
$count = 0;

foreach ($dirs as $dir) {
    $path = __DIR__.'/'.$dir;
    if (! is_dir($path)) {
        continue;
    }

    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
    foreach ($files as $file) {
        if ($file->getExtension() !== 'php') {
            continue;
        }

        $content = file_get_contents($file->getRealPath());
        if (strpos($content, 'declare(strict_types=1)') !== false) {
            continue;
        }

        $content = str_replace('<?php', "<?php\n\ndeclare(strict_types=1);", $content);
        file_put_contents($file->getRealPath(), $content);
        echo 'Fixed: '.$file->getRealPath()."\n";
        $count++;
    }
}

echo "Total files fixed: $count\n";
