{{-- resources/views/profile/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            {{ __('名簿') }}
        </h2>
    </x-slot>
    <!-- スタジオ予約セクション -->
    <div class="mt-8">
        <!-- 予約表の例 -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <p class="text-gray-800"></p>

            <table class="table-auto w-full mt-4">
                <thead>
                    <tr>
                        <th class="px-4 py-2">id</th>
                        <th class="px-4 py-2">名前</th>
                        <th class="px-4 py-2">学年</th>
                        <th class="px-4 py-2">表示名</th>
                        <th class="px-4 py-2">メールアドレス</th>
                        <th class="px-4 py-2">管理者</th>
                        <!--
                        <th class="px-4 py-2">削除</th>
                        -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="border px-4 py-2">{{ $user->id }}</td>
                            <td class="border px-4 py-2">{{ $user->name }}</td>
                            <td class="border px-4 py-2"></td>
                            <td class="border px-4 py-2">{{ $user->display_name }}</td>
                            <td class="border px-4 py-2">{{ $user->email }}</td>
                            <td class="border px-4 py-2 flex justify-center items-center">
                                <form method="POST" action="{{ route('users.toggleAdmin', ['user' => $user->id]) }}">
                                    @csrf
                                    @method('PATCH')
                                    <x-primary-button class="">
                                        @if ($user->admin == 1)
                                            {{ __('管理者') }}
                                        @else
                                            {{ __('部員') }}
                                        @endif
                                    </x-primary-button>
                                </form>
                            </td>
                            <!--
                            <td class="border px-4 py-2">
                                <form method="POST" action="{{ route('users.destroy', ['user' => $user->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-primary-button class="bg-red-500 hover:bg-red-700 text-white">
                                        {{ __('削除') }}
                                    </x-primary-button>
                                </form>
                            </td>
                        </tr>-->
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>