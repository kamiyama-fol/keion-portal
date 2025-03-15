<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            {{ __('予約詳細') }}
        </h2>
    </x-slot>

    <div class="mt-8 max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-4">予約情報</h3>

        <div class="mb-4">
            <span class="font-semibold">予約日時:</span> {{ $reservation->use_datetime->format('Y/m/d H:i') }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">予約スタジオ:</span> {{ $reservation->studio->name }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">予約者名:</span> {{ $reservation->reservedUser->name }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">予約バンド:</span>
            @if (auth()->check() && ($reservation->reserved_user_id === auth()->id() || auth()->user()->admin))
                <form method="POST" action="{{ route('studio-reservations.update', $reservation->id) }}" >
                    @csrf
                    @method('PUT')
                    <input type="text" name="reserved_band_id" value="{{ $reservation->reserved_band_id }}" class="border rounded-md px-2 py-1" required>
                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded-md ml-2 hover:bg-blue-600">
                        更新
                    </button>
                </form>
            @else
                {{ $reservation->reserved_band_id ?? 'なし' }}
            @endif
        </div>
        @if (auth()->check())
            @if ($reservation->reserved_user_id === auth()->id() || auth()->user()->admin)
                <div class="mt-6">
                    <form method="POST" action="{{ route('studio-reservations.destroy', $reservation->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                            予約を削除
                        </button>
                    </form>
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
