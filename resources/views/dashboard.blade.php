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

                    <div class="bg-white shadow-md rounded-lg p-6">
                        <p class="text-gray-800"></p>

                        <!-- 予約表 -->
                        <table class="table-auto w-full mt-4">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">日時</th>
                                    <th class="px-4 py-2">スタジオ</th>
                                    <th class="px-4 py-2">バンド</th>
                                    <th class="px-4 py-2">鍵返却</th>
                                    <th class="px-4 py-2">削除</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($myReservations as $myReservation)
                                    @php
                                        // 予約時間の終了時間
                                        $reservationEnd = \Carbon\Carbon::parse($myReservation->use_datetime);

                                        // その日の予約を取得（同じスタジオ & 同じ日付）
                                        $otherReservations = $myReservations->filter(function ($res) use ($myReservation) {
                                            return $res->studio_id == $myReservation->studio_id &&
                                                \Carbon\Carbon::parse($res->use_datetime)->format('Y-m-d') ==
                                                \Carbon\Carbon::parse($myReservation->use_datetime)->format('Y-m-d');
                                        });

                                        // 予約の終了時間より後の予約があるか
                                        $hasLaterReservation = $otherReservations->contains(function ($res) use ($reservationEnd) {
                                            return \Carbon\Carbon::parse($res->use_datetime)->greaterThan($reservationEnd);
                                        });

                                        // 鍵返却が必要かどうか
                                        $needKeyReturn = !$hasLaterReservation;
                                    @endphp

                                    <tr>
                                        <td class="border px-4 py-2">{{ $myReservation->use_datetime }}</td>
                                        <td class="border px-4 py-2">{{ $myReservation->studio->name}}</td>
                                        <td class="border px-4 py-2">{{ $myReservation->reserved_band_id }}</td>
                                        <td class="border px-4 py-2">
                                            {{ $needKeyReturn ? '必要' : '不要' }}
                                        </td>
                                        <td class="border px-4 py-2">
                                            <form method="POST"
                                                action="{{ route('studio-reservations.destroy', $myReservation->id )}}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-green-500 text-white px-4 py-2 rounded">削除する</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
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

                    <div class="bg-white shadow-md rounded-lg p-6">
                        <p class="text-gray-800"></p>

                        <!-- バンド一覧-->
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
