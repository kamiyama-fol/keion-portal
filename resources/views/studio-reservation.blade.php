<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            {{ __('スタジオ予約') }}
        </h2>
    </x-slot>

    <div class="mt-8">
        <!-- 管理モード切り替えボタン -->
        @if (auth()->user()->admin)
            <div class="mb-4 text-right">
                <button onclick="toggleAdminMode()" id="admin-toggle" class="bg-red-500 text-white px-4 py-2 rounded-md">
                    管理モード: <span id="admin-mode-text">OFF</span>
                </button>
            </div>
        @endif

        <!-- スタジオ選択タブ -->
        <div class="bg-gray-100 p-4 rounded-md shadow-md flex items-center space-x-4 mb-4">
            @foreach ($studios as $studio)
                <a href="{{ route('studio-reservations.create', ['studio_id' => $studio->id, 'week_start' => $startOfWeek->format('Y-m-d')]) }}"
                    class="px-6 py-2 rounded-md shadow-md border
                        {{ $currentStudioId == $studio->id ? 'bg-blue-500 text-white border-blue-500' : 'bg-gray-200 text-gray-700 border-gray-300' }}
                        hover:bg-blue-400 hover:text-white transition-colors duration-200 ease-in-out">
                    {{ $studio->name }}
                </a>
            @endforeach
        </div>

        <!-- スタジオ予約セクション -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('studio-reservations.store') }}">
                @csrf
                @method('POST')
                <table class="table-auto w-full mt-4">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">時間</th>
                            @for ($day = 0; $day < 7; $day++)
                                <th class="px-4 py-2">
                                    @php
                                        $currentDate = $startOfWeek->copy()->addDay($day);
                                        $isPastDate = $currentDate->isPast();
                                    @endphp
                                    <span class="{{ $isPastDate ? 'text-gray-500' : '' }}">
                                        {{ $currentDate->format('Y/m/d') }}
                                    </span><br>
                                    {{ ['日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日'][$day] }}
                                </th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @for ($hour = 8; $hour <= 19; $hour++)
                            <tr>
                                <td class="border px-4 py-2">{{ $hour }}:00-{{ $hour + 1 }}:00</td>
                                @for ($day = 0; $day < 7; $day++)
                                    @php
                                        $date = $startOfWeek->copy()->addDay($day);
                                        $isPast = $date->isPast() && !$date->isToday();
                                        $timeKey = $date->format('Y-m-d') . ' ' . $hour . ':00';
                                        $reservation = isset($reservations[$timeKey])
                                            ? $reservations[$timeKey]->first()
                                            : null;
                                    @endphp
                                    <td class="border px-4 py-2 text-center {{ $isPast ? 'bg-gray-200' : '' }}">
                                        @if ($reservation)
                                            <span class="text-red-500 font-bold">
                                                {{ $reservation->reservedUser->name ?? '不明' }}
                                            </span>
                                            @if ($reservation->user_id === auth()->id() || auth()->user()->admin)
                                            <form method="POST"
                                            action="{{ route('studio-reservations.destroy', ['studio_reservation' => $reservation->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-green-500 text-white px-4 py-2 rounded">削除する</button>
                                        </form>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="ml-2 text-white bg-red-500 px-2 py-1 rounded-md admin-delete hidden">削除</button>
                                                </form>
                                            @endif
                                        @elseif (!$isPast)
                                            <input type="checkbox"
                                                name="reservation[{{ $hour }}][{{ $date->format('Y-m-d') }}]" />
                                            <input type="hidden" name="studio_id" value="{{ $currentStudioId }}">
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                        @endfor
                    </tbody>
                </table>
                <button type="submit" class="bg-blue-500 px-4 py-2 shadow-md rounded-lg hover:bg-blue-600 mb-4">
                    予約する
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleAdminMode() {
            let adminModeText = document.getElementById("admin-mode-text");
            let deleteButtons = document.querySelectorAll(".admin-delete");
            let isActive = adminModeText.innerText === "ON";
            adminModeText.innerText = isActive ? "OFF" : "ON";
            deleteButtons.forEach(btn => {
                btn.classList.toggle("hidden", isActive);
            });
        }
    </script>
</x-app-layout>
