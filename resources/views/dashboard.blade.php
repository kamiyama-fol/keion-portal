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
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <!-- スタジオ予約セクション -->
            <div class="mt-8">
                <!-- Alpine.jsを使ったプルダウン -->
                <div x-data="{ open: false }">
                    <!-- 見出しとアイコン -->
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                        {{ __('予約スタジオ') }}
                    </h2>

                    <!-- ここに予約表などのコンテンツを追加 -->
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <p class="text-gray-800"></p>

                        <!-- 予約表の例 -->
                        <table class="table-auto w-full mt-4">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">日付</th>
                                    <th class="px-4 py-2">時間</th>
                                    <th class="px-4 py-2">バンド</th>
                                    <th class="px-4 py-2">鍵返却</th>
                                    <th class="px-4 py-2">削除</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($hour = 8; $hour <= 20; $hour++)
                                    <tr>
                                        <td class="border px-4 py-2"></td>
                                        <td class="border px-4 py-2"></td>
                                        <td class="border px-4 py-2"></td>
                                        <td class="border px-4 py-2"></td>
                                        <td class="border px-4 py-2">削除</td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <!-- スタジオ予約セクション -->
            <div class="mt-8">
                <!-- Alpine.jsを使ったプルダウン -->
                <div x-data="{ open: false }">
                    <!-- 見出しとアイコン -->
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                        {{ __('所属バンド') }}
                    </h2>


                    <!-- ここに予約表などのコンテンツを追加 -->
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <p class="text-gray-800"></p>

                        <!-- 予約表の例 -->
                        <table class="table-auto w-full mt-4">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">バンド名</th>
                                    <th class="px-4 py-2">自分のパート</th>
                                    <th class="px-4 py-2">出場ライブ</th>

                                </tr>
                            </thead>
                            <tbody>
                                @for ($hour = 8; $hour <= 20; $hour++)
                                    <tr>
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
</x-app-layout>
