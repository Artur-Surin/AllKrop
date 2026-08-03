<?php

$files = [
    'app/Filament/Resources/EventResource.php',
    'app/Filament/Resources/NewsResource.php',
    'app/Filament/Resources/EventResource/Pages/EditEvent.php',
    'app/Filament/Resources/NewsResource/Pages/EditNews.php',
    'app/Filament/Resources/PlaceResource/Pages/EditPlace.php',
    'app/Filament/Resources/PlaceCategoryResource/Pages/EditPlaceCategory.php',
    'app/Filament/Resources/LandmarkResource/Pages/EditLandmark.php',
    'app/Filament/Resources/TransportRouteResource/Pages/EditTransportRoute.php',
    'app/Filament/Resources/ServiceGroupResource/Pages/EditServiceGroup.php',
];

foreach ($files as $file) {
    $path = __DIR__.'/'.$file;
    if (! file_exists($path)) {
        echo "Not found: $file\n";

        continue;
    }

    $content = file_get_contents($path);

    // Remove ViewAction lines
    $content = preg_replace('/\s*Tables\\Actions\\ViewAction::make\(\),?\n?/', "\n", $content);
    $content = preg_replace('/\s*Actions\\ViewAction::make\(\),?\n?/', "\n", $content);

    // Remove unused import if present
    $content = preg_replace('/^use Filament\\Tables\\Actions;$/m', '', $content);

    file_put_contents($path, $content);
    echo "Fixed: $file\n";
}
