<?php

$files = glob(__DIR__.'/app/Filament/Resources/*.php');

foreach ($files as $file) {
    $content = file_get_contents($file);

    // Check if file has Tables\Actions
    if (strpos($content, 'Tables\\Actions') === false) {
        continue;
    }

    // Add use Filament\Actions; if not present
    if (strpos($content, 'use Filament\\Actions;') === false) {
        $content = str_replace(
            'use Filament\\Tables;',
            "use Filament\\Tables;\nuse Filament\\Actions;",
            $content
        );
    }

    // Replace Tables\Actions with Actions
    $content = str_replace('Tables\\Actions\\', 'Actions\\', $content);

    file_put_contents($file, $content);
    echo 'Fixed: '.basename($file)."\n";
}
