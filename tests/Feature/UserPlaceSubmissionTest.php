<?php

namespace Tests\Feature;

use App\Livewire\Places\CreatePlaceComponent;
use App\Livewire\Places\EditPlaceComponent;
use App\Models\Place;
use App\Models\PlaceCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UserPlaceSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_access_place_creation_page(): void
    {
        $response = $this->post('/register', [
            'name' => 'Іван Петренко',
            'email' => 'ivan@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/places/add');
        $this->assertAuthenticated();

        $this->get('/places/add')->assertStatus(200);
    }

    public function test_authenticated_user_can_submit_a_place_for_moderation(): void
    {
        $user = User::factory()->create();
        $category = PlaceCategory::create([
            'key' => 'food',
            'label' => 'Заклади харчування',
            'description' => 'Кав\'ярні та ресторани',
            'icon' => 'UtensilsCrossed',
        ]);

        Livewire::actingAs($user)
            ->test(CreatePlaceComponent::class)
            ->set('name', 'Нова кав\'ярня Krop')
            ->set('category_id', $category->id)
            ->set('area', 'Центр')
            ->set('address', 'вул. Дворцова, 10')
            ->set('phone', '+380501234567')
            ->set('hours', 'пн-нд: 08:00 - 21:00')
            ->set('descriptionText', "Чудова затишна кав'ярня у центрі Кропивницького.\nСмачна кава та десерти.")
            ->call('save');

        $this->assertDatabaseHas('places', [
            'name' => 'Нова кав\'ярня Krop',
            'slug' => 'nova-kaviarnia-krop',
            'user_id' => $user->id,
            'is_published' => false,
        ]);

        $place = Place::where('slug', 'nova-kaviarnia-krop')->first();
        $this->assertFalse($place->is_published);
        $this->assertEquals($user->id, $place->user_id);
    }

    public function test_owner_can_edit_place_and_triggers_remoderation(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $category = PlaceCategory::create([
            'key' => 'cafe',
            'label' => 'Кав\'ярні',
            'description' => 'Кава',
            'icon' => 'Coffee',
        ]);

        $place = Place::create([
            'user_id' => $user->id,
            'name' => 'Стара Назва',
            'slug' => 'stara-nazva',
            'category_id' => $category->id,
            'area' => 'Центр',
            'address' => 'вул. Соборна, 5',
            'phone' => '+380500000000',
            'hours' => '09:00 - 18:00',
            'description' => ['Початковий опис закладу'],
            'rating' => '0.0',
            'is_published' => true,
        ]);

        // Non-owner gets 403 Forbidden
        Livewire::actingAs($otherUser)
            ->test(EditPlaceComponent::class, ['place' => $place])
            ->assertStatus(403);

        // Owner can update details
        Livewire::actingAs($user)
            ->test(EditPlaceComponent::class, ['place' => $place])
            ->set('name', 'Оновлена Назва Загалу')
            ->set('descriptionText', 'Новий оновлений детальний опис закладу власником.')
            ->call('save');

        $place->refresh();
        $this->assertEquals('Оновлена Назва Загалу', $place->name);
        $this->assertFalse($place->is_published); // Must trigger re-moderation
    }
}
