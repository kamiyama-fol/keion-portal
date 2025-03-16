<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            {{ __('予約ログ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center mb-4">
                        {{ __('予約ログ') }}
                    </h2>

                    <form method="GET" action="{{ route('studio-reservations.index') }}" class="mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">開始日</label>
                                <input type="date" name="start_date" id="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">終了日</label>
                                <input type="date" name="end_date" id="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="action" class="block text-sm font-medium text-gray-700">動作</label>
                                <select name="action" id="action" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">すべて</option>
                                    <option value="reserved">予約</option>
                                    <option value="canceled">キャンセル</option>
                                </select>
                            </div>
                            <div>
                                <label for="reserved_user_name" class="block text-sm font-medium text-gray-700">予約者名</label>
                                <input type="text" name="reserved_user_name" id="reserved_user_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="reserved_band_id" class="block text-sm font-medium text-gray-700">予約バンド</label>
                                <input type="text" name="reserved_band_id" id="reserved_band_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div class="mt-6">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    絞り込み
                                </button>
                            </div>
                        </div>
                    </form>

                    <table class="table-auto w-full mt-4">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">日時</th>
                                <th class="px-4 py-2">動作</th>
                                <th class="px-4 py-2">予約者名</th>
                                <th class="px-4 py-2">予約バンド</th>
                                <th class="px-4 py-2">タイムスタンプ</th>
                                <th class="px-4 py-2">削除</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservations as $reservation)
                                <tr>
                                    <td class="border px-4 py-2">{{ $reservation->use_datetime }}</td>
                                    <td class="border px-4 py-2">
                                        {{ $reservation->deleted_at ? 'キャンセル' : '予約' }}
                                    </td>
                                    <td class="border px-4 py-2">{{ $reservation->reservedUser->name }}</td>
                                    <td class="border px-4 py-2">{{ $reservation->reserved_band_id }}</td>
                                    <td class="border px-4 py-2">
                                        {{ $reservation->deleted_at ? $reservation->deleted_at : $reservation->created_at }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        @if (!$reservation->deleted_at)
                                            <form method="POST" action="{{ route('studio-reservations.destroy', $reservation->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">削除</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
