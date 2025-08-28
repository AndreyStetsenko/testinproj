<?php

namespace App\Livewire\Events;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use App\Models\Event;

class Index extends Component
{
    public $search = '';
    public $filter = 'upcoming';
    public $sort = 'date';

    public function deleteEvent(int $eventId): void
    {
        $event = Event::findOrFail($eventId);
        $event->delete();

        Cache::flush();

        session()->flash('success', 'Событие удалено');
    }

    public function render()
    {
        $cacheKey = "events__{$this->search}_{$this->filter}_{$this->sort}_page_" . request('page', 1);

        $query = Event::withCount('registrations')
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->filter === 'upcoming', fn($q) => $q->where('date', '>=', now()))
            ->when($this->filter === 'past', fn($q) => $q->where('date', '<', now()))
            ->orderBy($this->sort);
    
        $events = Cache::tags('events')->remember($cacheKey, now()->addMinutes(1), function () use ($query) {
            return $query->simplePaginate(10);
        });
    
        return view('events.index', compact('events'));    
    }
}
