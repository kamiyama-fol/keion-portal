{{-- resources/views/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("こんにちは") }}
                </div>
            </div>

            <!-- スタジオ予約セクション -->
            <div class="mt-8">
                <!-- Alpine.jsを使ったプルダウン -->
                <div x-data="{ open: false }">
                    <!-- 見出しとアイコン -->
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center cursor-pointer" @click="open = !open">
                        {{ __('スタジオ予約') }}
                        <!-- 逆三角形アイコン -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </h2>

                    <!-- プルダウンメニュー -->
                    <div x-show="open" class="mt-4" x-cloak>
                        <!-- ここに予約表などのコンテンツを追加 -->
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <p class="text-gray-800"></p>

                            <!-- 予約表の例 -->
                            <table class="table-auto w-full mt-4">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">時間</th>
                                        <th class="px-4 py-2"><span>{{ \Carbon\Carbon::now()->startOfWeek()->format('Y/m/d') }}</span><br>月曜日</th>
                                        <th class="px-4 py-2"><span>{{ \Carbon\Carbon::now()->startOfWeek()->addDay()->format('Y/m/d') }}</span><br>火曜日</th>
                                        <th class="px-4 py-2"><span>{{ \Carbon\Carbon::now()->startOfWeek()->addDay(2)->format('Y/m/d') }}</span><br>水曜日</th>
                                        <th class="px-4 py-2"><span>{{ \Carbon\Carbon::now()->startOfWeek()->addDay(3)->format('Y/m/d') }}</span><br>木曜日</th>
                                        <th class="px-4 py-2"><span>{{ \Carbon\Carbon::now()->startOfWeek()->addDay(4)->format('Y/m/d') }}</span><br>金曜日</th>
                                        <th class="px-4 py-2"><span>{{ \Carbon\Carbon::now()->startOfWeek()->addDay(5)->format('Y/m/d') }}</span><br>土曜日</th>
                                        <th class="px-4 py-2"><span>{{ \Carbon\Carbon::now()->startOfWeek()->addDay(6)->format('Y/m/d') }}</span><br>日曜日</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($hour = 8; $hour <= 20; $hour++)
                                        <tr>
                                        <td class="border px-4 py-2">{{ $hour }}:00</td>
                                        <td class="border px-4 py-2"></td>
                                        <td class="border px-4 py-2"></td>
                                        <td class="border px-4 py-2"></td>
                                        <td class="border px-4 py-2"></td>
                                        <td class="border px-4 py-2"></td>
                                        <td class="border px-4 py-2"></td>
                                        <td class="border px-4 py-2"></td>
                                        </tr>
                                        @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- バンド登録セクション -->
            <div class="mt-8">
                <!-- Alpine.jsを使ったプルダウン -->
                <div x-data="{ open: false }">
                    <!-- 見出しとアイコン -->
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center cursor-pointer" @click="open = !open">
                        {{ __('バンド登録') }}
                        <!-- 逆三角形アイコン -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </h2>

                    <!-- プルダウンメニュー -->
                    <div x-show="open" class="mt-4" x-cloak>
                        <!-- ここに予約表などのコンテンツを追加 -->
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <p class="text-gray-800">代表者1名のみ応募してください。</p>

                            <!-- 予約表の例 -->
                            <table class="table-auto w-full mt-4">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">番号</th>
                                        <th class="px-4 py-2">学年</th>
                                        <th class="px-4 py-2">名前</th>
                                        <th class="px-4 py-2">パート</th>
                                        <th class="px-4 py-2">備考</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <tr>
                                        <td class="border px-4 py-2">{{ $i }}</td>
                                        <td class="border px-4 py-2"></td>
                                        <td class="border px-4 py-2"></td>
                                        <td class="border px-4 py-2"></td>
                                        <td class="border px-4 py-2"></td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>