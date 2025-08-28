<div class="max-w-2xl mx-auto space-y-6">

    <div class="bg-white shadow rounded-xl p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $event->title }}</h2>
        <p class="text-gray-600">
            {{ $event->date->format('d.m.Y H:i') }}
        </p>
        <p class="text-sm text-gray-500 mt-1">
            Вместимость: <span class="font-medium">{{ $event->registrations()->count() }}</span> / {{ $event->capacity }}
        </p>
    </div>

    @if($errors->has('participants'))
        <div class="p-3 bg-red-100 text-red-700 rounded-lg text-sm mt-3">
            {{ $errors->first('participants') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-6">

        @foreach($participants as $i => $participant)
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 relative">

                <h3 class="font-semibold text-gray-700 mb-3">
                    Участник #{{ $i + 1 }}
                </h3>

                <div class="space-y-3">
                    <input type="text"
                           wire:model="participants.{{ $i }}.name"
                           placeholder="Имя"
                           class="w-full rounded-lg border border-gray-100 shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500 p-2.5 text-sm">
                    @error("participants.$i.name") <span class="text-sm text-red-500">{{ $message }}</span> @enderror

                    <input type="email"
                           wire:model="participants.{{ $i }}.email"
                           placeholder="Email"
                           class="w-full rounded-lg border border-gray-100 shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500 p-2.5 text-sm">
                    @error("participants.$i.email") <span class="text-sm text-red-500">{{ $message }}</span> @enderror

                    <input type="text"
                           wire:model="participants.{{ $i }}.phone"
                           placeholder="Телефон"
                           class="w-full rounded-lg border border-gray-100 shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500 p-2.5 text-sm">
                    @error("participants.$i.phone") <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                @if($i > 0)
                    <button type="button"
                            wire:click="removeParticipant({{ $i }})"
                            class="absolute top-3 right-3 text-red-500 hover:text-red-700 text-sm">
                        x
                    </button>
                @endif
            </div>
        @endforeach

        <div class="flex flex-col sm:flex-row gap-3">
            <button type="button"
                    wire:click="addParticipant"
                    class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                Добавить участника
            </button>

            <button type="submit"
                    class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 transition">
                Зарегистрироваться
            </button>
        </div>
    </form>
</div>
