{{-- resources/views/studio/table.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            {{ __('スタジオ予約') }}
        </h2>
    </x-slot>
    <!-- スタジオ予約セクション -->
    <div class="mt-8">
        <!-- Alpine.jsを使ったプルダウン -->
        <div x-data="{ open: false }">
            <!-- 見出しとアイコン -->

            <!-- プルダウンメニュー -->
            <!-- ここに予約表などのコンテンツを追加 -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <p class="text-gray-800"></p>

                <!-- 予約表の例 -->
                <table class="table-auto w-full mt-4">
                    <h3 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">日時</h3>
                    <thead>
                        <tr>
                            <th class="px-4 py-2">時間</th>
                            <th class="px-4 py-2">
                                <span>{{ \Carbon\Carbon::now()->startOfWeek()->format('Y/m/d') }}</span><br>月曜日
                            </th>
                            <th class="px-4 py-2">
                                <span>{{ \Carbon\Carbon::now()->startOfWeek()->addDay()->format('Y/m/d') }}</span><br>火曜日
                            </th>
                            <th class="px-4 py-2">
                                <span>{{ \Carbon\Carbon::now()->startOfWeek()->addDay(2)->format('Y/m/d') }}</span><br>水曜日
                            </th>
                            <th class="px-4 py-2">
                                <span>{{ \Carbon\Carbon::now()->startOfWeek()->addDay(3)->format('Y/m/d') }}</span><br>木曜日
                            </th>
                            <th class="px-4 py-2">
                                <span>{{ \Carbon\Carbon::now()->startOfWeek()->addDay(4)->format('Y/m/d') }}</span><br>金曜日
                            </th>
                            <th class="px-4 py-2">
                                <span>{{ \Carbon\Carbon::now()->startOfWeek()->addDay(5)->format('Y/m/d') }}</span><br>土曜日
                            </th>
                            <th class="px-4 py-2">
                                <span>{{ \Carbon\Carbon::now()->startOfWeek()->addDay(6)->format('Y/m/d') }}</span><br>日曜日
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($hour = 8; $hour <= 19; $hour++)
                            <tr>
                                <td class="border px-4 py-2">{{ $hour }}:00-{{ $hour + 1 }}:00</td>
                                <!-- 各曜日のセルにチェックボックスを追加 -->
                                @for ($add = 0; $add < 7; $add++)
                                    <td class="border px-4 py-2 text-center">
                                        <input type="checkbox"
                                            name="reservation[{{ $hour }}][{{ \Carbon\Carbon::now()->startOfWeek()->addDay($add)->format('Y/m/d') }}]">
                                    </td>
                                @endfor
                            </tr>
                        @endfor
                    </tbody>
                </table>
                <h3 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">区分</h3>
                <table class="table-auto w-full mt-4">
                    <thead>
                        <tr>
                            <th class="px-4 py-2"></th>
                            <th class="px-4 py-2">バンド名</th>
                            <th class="px-4 py-2">自分のパート</th>
                            <th class="px-4 py-2">出場ライブ</th>

                        </tr>
                    </thead>
                    <tbody>
                        @for ($hour = 0; $hour <= 3; $hour++)
                            <tr>
                                <td class="border px-4 py-2"><input type="radio" name="studio_time"
                                        value="" id=""></td>
                                <td class="border px-4 py-2">{{ $hour }}</td>
                                <td class="border px-4 py-2"></td>
                                <td class="border px-4 py-2"></td>
                            </tr>
                        @endfor
                            <tr>
                                <td class="border px-4 py-2">
                                    <input type="radio" name="studio_time"
                                    value="" id="">
                                </td>
                                <td class="border px-4 py-2">個人練</td>
                                <td class="border px-4 py-2"></td>
                                <td class="border px-4 py-2"></td>
                            </tr>
                    </tbody>

                </table>

                <x-primary-button class="">
                    {{ __('予約する') }}
                </x-primary-button>

            </div>

        </div>
    </div>
</x-app-layout>
