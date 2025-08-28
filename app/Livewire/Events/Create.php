<?php

namespace App\Livewire\Events;

use Livewire\Component;
use App\Models\Event;

class Create extends Component
{
    public $title;
    public $date;
    public $capacity;

    protected $rules = [
        'title'    => 'required|string|max:255',
        'date'     => 'required|date|after:now',
        'capacity' => 'required|integer|min:1',
    ];

    public function submit()
    {
        $this->validate();

        Event::create([
            'title'    => $this->title,
            'date'     => $this->date,
            'capacity' => $this->capacity,
        ]);

        session()->flash('success', 'Событие успешно создано!');
        return redirect()->route('events.index');
    }

    public function render()
    {
        return view('events.create');
    }
}
