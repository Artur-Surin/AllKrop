<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$place = App\Models\Place::where('slug', 'kavyarnya-ranok')->first();
if ($place) {
    echo "Found: " . $place->name . "\n";
    echo "Category ID: " . ($place->category_id ?? 'null') . "\n";
} else {
    echo "Not found\n";
}
