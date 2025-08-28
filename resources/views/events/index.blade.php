<div class="space-y-6">

    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Список событий</h1>
        <a href="{{ route('events.create') }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-1 transition">
            Создать событие
        </a>

    </div>

    <div class="flex flex-col sm:flex-row gap-3">
        <input type="text"
               wire:model.live="search"
               placeholder="Поиск по названию..."
               class="flex-1 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm p-2.5 shadow-sm">

        <select wire:model.live="filter"
                class="rounded-lg border border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm p-2.5 shadow-sm">
            <option value="upcoming">Будущие</option>
            <option value="past">Прошедшие</option>
            <option value="all">Все</option>
        </select>
    </div>

    <div class="overflow-hidden bg-white rounded-xl shadow">
        <table class="w-full border-collapse">
            <thead class="bg-gray-50 text-gray-600 text-sm">
                <tr>
                    <th class="px-6 py-3 text-left font-medium">Название</th>
                    <th class="px-6 py-3 text-left font-medium cursor-pointer hover:text-blue-600"
                        wire:click="$set('sort','date')">
                        Дата
                    </th>
                    <th class="px-6 py-3 text-left font-medium">Участники</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($events as $event)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-6 py-4 text-gray-800 font-medium">
                            <a href="{{ route('events.register', $event) }}" class="text-blue-600 hover:underline">
                                {{ $event->title }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ $event->date->format('d.m.Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
                                {{ $event->registrations_count >= $event->capacity ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                {{ $event->registrations_count }}/{{ $event->capacity }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-800 font-medium flex items-center gap-2">
                            <a href="{{ route('events.register', $event) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-1 transition">
                                Регистрация
                            </a>
                            <form wire:submit.prevent="deleteEvent({{ $event->id }})">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg shadow hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-1 transition">
                                    Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                            Нет событий
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $events->links() }}
    </div>

</div>
