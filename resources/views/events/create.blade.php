<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow space-y-4">
    <h2 class="text-xl font-bold">Создать событие</h2>

    <form wire:submit.prevent="submit" class="space-y-4">
        <div>
            <label class="block text-sm font-medium mb-1">Название</label>
            <input type="text" wire:model="title"
                   class="w-full border border-gray-200 rounded-lg p-2 focus:ring focus:ring-blue-200">
            @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Дата</label>
            <input type="datetime-local" wire:model="date"
                   class="w-full border border-gray-200 rounded-lg p-2 focus:ring focus:ring-blue-200">
            @error('date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Вместимость</label>
            <input type="number" wire:model="capacity"
                   class="w-full border border-gray-200 rounded-lg p-2 focus:ring focus:ring-blue-200">
            @error('capacity') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Создать
        </button>
    </form>
</div>
