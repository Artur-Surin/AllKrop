<?php

declare(strict_types=1);

namespace App\Livewire\Places;

use App\Models\Place;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class UserPlacesComponent extends Component
{
    public function render()
    {
        $user = auth()->user();

        $places = Place::where('user_id', $user->id)
            ->with('category')
            ->latest()
            ->get();

        return view('livewire.places.user-places-component', [
            'places' => $places,
        ]);
    }
}
