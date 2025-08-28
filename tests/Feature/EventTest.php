<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use App\Livewire\Events\Register;
use App\Livewire\Events\Index;
use App\Models\Event;
use App\Models\Registration;

class EventTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_renders_event_list()
    {
        Event::factory()->create(['title' => 'LaravelConf']);

        $this->get('/events')
            ->assertStatus(200)
            ->assertSee('LaravelConf');
    }

    #[Test]
    public function it_registers_participant()
    {
        $event = Event::factory()->create(['capacity' => 2]);

        Livewire::test(Register::class, ['event' => $event])
            ->set('participants.0.name', 'John Doe')
            ->set('participants.0.email', 'john@gmail.com')
            ->call('submit')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('registrations', [
            'event_id' => $event->id,
            'email' => 'john@gmail.com',
        ]);
    }

    #[Test]
    public function it_rejects_duplicate_email_within_same_event()
    {
        $event = Event::factory()->create(['capacity' => 5]);

        Registration::create([
            'event_id' => $event->id,
            'name' => 'Alice',
            'email' => 'alice@gmail.com',
        ]);

        Livewire::test(Register::class, ['event' => $event])
            ->set('participants.0.name', 'Bob')
            ->set('participants.0.email', 'alice@gmail.com')
            ->call('submit')
            ->assertHasErrors(['participants.0.email']);
    }

    #[Test]
    public function it_rejects_registration_if_capacity_exceeded()
    {
        $event = Event::factory()->create(['capacity' => 1]);

        Registration::create([
            'event_id' => $event->id,
            'name' => 'Alice',
            'email' => 'alice@gmail.com',
        ]);

        Livewire::test(Register::class, ['event' => $event])
            ->set('participants.0.name', 'Bob')
            ->set('participants.0.email', 'bob@gmail.com')
            ->call('submit')
            ->assertHasErrors(['participants']);
    }

    #[Test]
    public function it_caches_event_list_and_invalidates_on_registration()
    {
        Cache::flush();

        $event = Event::factory()->create(['capacity' => 10]);

        // Создаем компонент и принудительно вызываем render для кеширования
        $component = Livewire::test(Index::class)
            ->set('filter', 'upcoming')
            ->set('sort', 'date')
            ->call('$refresh');

        // Правильный ключ кеша (пустой search дает дополнительный _)
        $cacheKey = "events___upcoming_date_page_1";
        
        $cachedData = Cache::tags('events')->get($cacheKey);
        $this->assertNotNull($cachedData, "Ключ {$cacheKey} должен существовать в теговом кеше");

        Livewire::test(Register::class, ['event' => $event])
            ->set('participants.0.name', 'Charlie')
            ->set('participants.0.email', 'charlie@gmail.com')
            ->call('submit');

        $this->assertNull(Cache::tags('events')->get($cacheKey), "Ключ {$cacheKey} должен быть удалён после регистрации");
    }
}
