<?php

namespace App\Livewire\Events;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Event;

class Register extends Component
{
    public Event $event;

    public $participants = [
        ['name' => '', 'email' => '', 'phone' => ''],
    ];

    protected function rules()
    {
        return [
            'participants.*.name'  => 'required|string|max:255',
            'participants.*.email' => [
                'required','email',
                Rule::unique('registrations', 'email')->where('event_id', $this->event->id)
            ],
            'participants.*.phone' => 'nullable|string|max:20',
        ];
    }

    protected $messages = [
        'participants.*.name.required'  => 'Пожалуйста, введите имя участника.',
        'participants.*.name.string'    => 'Имя должно быть строкой.',
        'participants.*.name.max'       => 'Имя не должно превышать :max символов.',
    
        'participants.*.email.required' => 'Введите email участника.',
        'participants.*.email.email'    => 'Укажите корректный email.',
        'participants.*.email.unique'   => 'Этот email уже зарегистрирован на данное событие.',
    
        'participants.*.phone.string'   => 'Телефон должен быть строкой.',
        'participants.*.phone.max'      => 'Телефон не должен превышать :max символов.',
    ];
    
    protected $validationAttributes = [
        'participants.*.name'  => 'Имя',
        'participants.*.email' => 'Email',
        'participants.*.phone' => 'Телефон',
    ];    

    public function addParticipant()
    {
        $this->participants[] = ['name' => '', 'email' => '', 'phone' => ''];
    }

    public function removeParticipant($index)
    {
        unset($this->participants[$index]);
        $this->participants = array_values($this->participants);
    }

    public function submit()
    {
        $this->validate();

        if ($this->event->registrations()->count() + count($this->participants) > $this->event->capacity) {
            $this->addError('participants', 'Мест больше нет, регистрация невозможна.');
            return;
        }

        DB::transaction(function () {
            foreach ($this->participants as $p) {
                $this->event->registrations()->create($p);
            }

            // сброс кеша событий
            Cache::tags('events')->flush();
        });

        session()->flash('success', 'Вы успешно зарегистрированы!');
        return redirect()->route('events.index');
    }

    public function render()
    {
        return view('events.register');
    }
}
