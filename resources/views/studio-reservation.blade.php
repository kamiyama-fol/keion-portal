<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            {{ __('スタジオ予約') }}
        </h2>


    </x-slot>

    <div class="mt-8">

        <!-- スタジオ予約セクション -->
        <div class="bg-white shadow-md rounded-lg p-6">

            <!-- 左右の矢印ボタン -->
            <div class="ml-auto flex items-center">
                <!-- 前の週へのボタン -->
                <a href="{{ route('reservations.create', ['week_start' => $startOfWeek->copy()->subWeek()->format('Y-m-d')]) }}"
                    class="mr-4">
                    <x-primary-button>← 前の週</x-primary-button>
                </a>

                <!-- 次の週へのボタン -->
                <a
                    href="{{ route('reservations.create', ['week_start' => $startOfWeek->copy()->addWeek()->format('Y-m-d')]) }}">
                    <x-primary-button>次の週 →</x-primary-button>
                </a>
            </div>
            <form method="POST" action="{{ route('studio-reservations.store', $StudioReservation->id) }}">
                @csrf
                @method('PATCH')
                <table class="table-auto w-full mt-4">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">時間</th>
                            @for ($day = 0; $day < 7; $day++)
                                <th class="px-4 py-2">
                                    <!-- 各曜日の日付を表示 -->
                                    <span>{{ $startOfWeek->copy()->addDay($day)->format('Y/m/d') }}</span><br>
                                    {{ ['月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日', '日曜日'][$day] }}
                                </th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @for ($hour = 8; $hour <= 19; $hour++)
                            <tr>
                                <td class="border px-4 py-2">{{ $hour }}:00-{{ $hour + 1 }}:00</td>
                                @for ($day = 0; $day < 7; $day++)
                                    <td class="border px-4 py-2 text-center">
                                        <input type="checkbox"
                                            name="reservation[{{ $hour }}][{{ $startOfWeek->copy()->addDay($day)->format('Y/m/d') }}]" />
                                    </td>
                                @endfor
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</x-app-layout>
