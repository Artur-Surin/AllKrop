<?php

declare(strict_types=1);

namespace App\Livewire\Places;

use App\Models\Place;
use App\Models\PlaceCategory;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class CreatePlaceComponent extends Component
{
    use WithFileUploads;

    public string $name = '';

    public ?int $category_id = null;

    public string $area = 'Центр';

    public string $address = '';

    public string $phone = '';

    public string $hours = "пн-пт: 09:00 - 18:00\nсб-нд: 10:00 - 16:00";

    public string $descriptionText = '';

    public $mainImage;

    public array $galleryImages = [];

    protected function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'category_id' => 'required|exists:place_categories,id',
            'area' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:100',
            'hours' => 'required|string|max:1000',
            'descriptionText' => 'required|string|min:20|max:5000',
            'mainImage' => 'nullable|image|max:5120',
            'galleryImages' => 'nullable|array|max:10',
            'galleryImages.*' => 'nullable|image|max:5120',
        ];
    }

    // Features repeater structure: [['group' => 'Назва групи', 'items' => 'Пункт 1, Пункт 2']]
    public array $features = [
        ['group' => 'Послуги', 'items' => 'Wi-Fi, Термінал, Парковка'],
    ];

    // Honeypot field for bot protection
    public string $website = '';

    public bool $submitted = false;

    public function addFeatureGroup(): void
    {
        $this->features[] = ['group' => '', 'items' => ''];
    }

    public function removeFeatureGroup(int $index): void
    {
        unset($this->features[$index]);
        $this->features = array_values($this->features);
    }

    public function save(): void
    {
        // Anti-bot check
        if (! empty($this->website)) {
            $this->submitted = true;

            return;
        }

        $this->validate();

        // 1. Image upload handling
        $imagePath = null;
        if ($this->mainImage) {
            $imagePath = $this->mainImage->store('places', 'public');
        }

        // 2. Gallery uploads handling
        $galleryPaths = [];
        if (! empty($this->galleryImages)) {
            foreach ($this->galleryImages as $file) {
                $galleryPaths[] = $file->store('places/gallery', 'public');
            }
        }

        // 3. Description lines formatting
        $descriptionArray = array_values(array_filter(
            array_map('trim', explode("\n", $this->descriptionText)),
            fn ($line) => $line !== ''
        ));

        // 4. Features formatting for Filament compatibility
        $formattedFeatures = [];
        foreach ($this->features as $f) {
            $group = trim($f['group'] ?? '');
            $rawItems = trim($f['items'] ?? '');
            if ($group !== '' && $rawItems !== '') {
                $items = array_values(array_filter(array_map('trim', explode(',', $rawItems))));
                if (! empty($items)) {
                    $formattedFeatures[] = [
                        'group' => $group,
                        'items' => $items,
                    ];
                }
            }
        }

        // 5. Unique slug creation
        $baseSlug = Str::slug($this->name);
        $slug = $baseSlug;
        $counter = 1;
        while (Place::where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        // 6. Create Place in DB
        Place::create([
            'user_id' => auth()->id(),
            'name' => trim($this->name),
            'slug' => $slug,
            'category_id' => $this->category_id,
            'area' => trim($this->area),
            'address' => trim($this->address),
            'phone' => trim($this->phone),
            'hours' => trim($this->hours),
            'description' => $descriptionArray,
            'image' => $imagePath ?? '',
            'gallery' => $galleryPaths,
            'features' => $formattedFeatures,
            'rating' => '0.0',
            'is_published' => false, // Requires Admin Moderation
        ]);

        $this->submitted = true;
    }

    public function render()
    {
        $categories = PlaceCategory::orderBy('label')->get();

        return view('livewire.places.create-place-component', [
            'categories' => $categories,
        ]);
    }
}
