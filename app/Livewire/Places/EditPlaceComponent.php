<?php

declare(strict_types=1);

namespace App\Livewire\Places;

use App\Models\Place;
use App\Models\PlaceCategory;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class EditPlaceComponent extends Component
{
    use WithFileUploads;

    public Place $place;

    public string $name = '';

    public ?int $category_id = null;

    public string $area = 'Центр';

    public string $address = '';

    public string $phone = '';

    public string $hours = '';

    public string $descriptionText = '';

    public $newMainImage;

    public array $newGalleryImages = [];

    public ?string $existingImage = null;

    public array $existingGallery = [];

    public array $features = [];

    public bool $submitted = false;

    public function mount(Place $place): void
    {
        // 1. Authorization: Only place owner can edit
        if (auth()->id() !== $place->user_id) {
            abort(403, 'У вас немає прав для редагування цього закладу.');
        }

        $this->place = $place;
        $this->name = $place->name;
        $this->category_id = $place->category_id;
        $this->area = $place->area ?? 'Центр';
        $this->address = $place->address ?? '';
        $this->phone = $place->phone ?? '';
        $this->hours = is_array($place->hours) ? implode("\n", $place->hours) : ($place->hours ?? '');

        if (is_array($place->description)) {
            $this->descriptionText = implode("\n\n", $place->description);
        } else {
            $this->descriptionText = $place->description ?? '';
        }

        $this->existingImage = $place->image;
        $this->existingGallery = $place->gallery ?? [];

        // Formatting features repeater
        $rawFeatures = $place->features ?? [];
        $formatted = [];
        if (is_array($rawFeatures)) {
            foreach ($rawFeatures as $f) {
                $group = $f['group'] ?? '';
                $items = is_array($f['items'] ?? null) ? implode(', ', $f['items']) : ($f['items'] ?? '');
                $formatted[] = ['group' => $group, 'items' => $items];
            }
        }
        if (empty($formatted)) {
            $formatted = [['group' => 'Послуги', 'items' => '']];
        }
        $this->features = $formatted;
    }

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
            'newMainImage' => 'nullable|image|max:5120',
            'newGalleryImages' => 'nullable|array|max:10',
            'newGalleryImages.*' => 'nullable|image|max:5120',
        ];
    }

    public function addFeatureGroup(): void
    {
        $this->features[] = ['group' => '', 'items' => ''];
    }

    public function removeFeatureGroup(int $index): void
    {
        unset($this->features[$index]);
        $this->features = array_values($this->features);
    }

    public function removeExistingGalleryImage(int $index): void
    {
        if (isset($this->existingGallery[$index])) {
            unset($this->existingGallery[$index]);
            $this->existingGallery = array_values($this->existingGallery);
        }
    }

    public function save(): void
    {
        if (auth()->id() !== $this->place->user_id) {
            abort(403);
        }

        $this->validate();

        // 1. Update main image if new uploaded
        $imagePath = $this->existingImage;
        if ($this->newMainImage) {
            if ($this->existingImage && Storage::disk('public')->exists($this->existingImage)) {
                Storage::disk('public')->delete($this->existingImage);
            }
            $imagePath = $this->newMainImage->store('places', 'public');
        }

        // 2. Add new gallery images to existing ones
        $galleryPaths = $this->existingGallery;
        if (! empty($this->newGalleryImages)) {
            foreach ($this->newGalleryImages as $file) {
                $galleryPaths[] = $file->store('places/gallery', 'public');
            }
        }

        // 3. Format description
        $descriptionArray = array_values(array_filter(
            array_map('trim', explode("\n", $this->descriptionText)),
            fn ($line) => $line !== ''
        ));

        // 4. Format features
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

        // 5. Update Place record and set for re-moderation
        $this->place->update([
            'name' => trim($this->name),
            'category_id' => $this->category_id,
            'area' => trim($this->area),
            'address' => trim($this->address),
            'phone' => trim($this->phone),
            'hours' => trim($this->hours),
            'description' => $descriptionArray,
            'image' => $imagePath ?? '',
            'gallery' => $galleryPaths,
            'features' => $formattedFeatures,
            'is_published' => false, // Re-moderation required after update
            'rejection_reason' => null,
        ]);

        $this->submitted = true;
    }

    public function render()
    {
        $categories = PlaceCategory::orderBy('label')->get();

        return view('livewire.places.edit-place-component', [
            'categories' => $categories,
        ]);
    }
}
