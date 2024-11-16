<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            {{ __('Studio Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __('Manage your studios here.') }}
                </div>
            </div>

            <!-- スタジオ一覧セクション -->
            <div class="mt-8">
                <div x-data="{ open: false }">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                        {{ __('スタジオ一覧') }}
                    </h2>

                    <div class="bg-white shadow-md rounded-lg p-6 mt-4">
                        <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-gray-700 font-semibold">スタジオ名</th>
                                    <th class="px-4 py-2 text-left text-gray-700 font-semibold">作成者</th>
                                    <th class="px-4 py-2 text-left text-gray-700 font-semibold">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($studios as $studio)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border px-4 py-2">{{ $studio->name }}</td>
                                        <td class="border px-4 py-2">{{ $studio->made_by }}</td>
                                        <td class="border px-4 py-2">
                                            <button class="bg-red-500 text-white px-4 py-2 rounded"
                                                onclick="deleteStudio({{ $studio->id }})">
                                                削除
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- スタジオ作成セクション -->
            <div class="mt-8">
                <div x-data="{ open: false }">
                    <!-- プルダウン見出し -->
                    <h2 @click="open = !open"
                        class="font-semibold text-xl text-gray-800 leading-tight flex items-center cursor-pointer">
                        {{ __('スタジオ作成') }}
                        <span class="ml-2 text-gray-600">
                            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 15l-7-7-7 7" />
                            </svg>
                        </span>
                    </h2>

                    <!-- フォーム内容 -->
                    <div x-show="open" class="bg-white shadow-md rounded-lg p-6 mt-4">
                        <!-- フォーム部分 -->
                        <!-- フォーム部分 -->
                        <form action="{{ route('studios.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="studios" class="block text-gray-700 font-medium">スタジオ名 (1行につき1スタジオ)</label>
                                <textarea name="studios" id="studios" rows="5"
                                    class="w-full mt-2 p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-300"
                                    placeholder="例: スタジオA&#10;スタジオB&#10;スタジオC"></textarea>
                            </div>

                            <!-- スタジオ作成ボタン -->
                            <button type="submit"
                                class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 focus:outline-none mb-4">
                                作成
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 削除処理用スクリプト -->
    <script>
        function deleteStudio(id) {
            if (confirm('このスタジオを削除しますか？')) {
                fetch(`/studios/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(() => {
                    location.reload();
                });
            }
        }
    </script>
</x-app-layout>
