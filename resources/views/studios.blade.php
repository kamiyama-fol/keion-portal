<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            {{ __('Studio Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            

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
                                        <!-- スタジオ名 -->
                                        <td class="border px-4 py-2">
                                            <div x-data="{ editing: false, name: '{{ $studio->name }}' }">
                                                <span x-show="!editing" id="studio-name-{{ $studio->id }}">
                                                    {{ $studio->name }}
                                                </span>

                                                <!-- 編集モードの時に表示される入力フィールド -->
                                                <input x-show="editing" x-model="name"
                                                type="text"
                                                class="border rounded px-2 py-1 w-full" />

                                                <button @click="editing = !editing; updateStudio({{ $studio->id }})" class="text-blue-500 ml-2">
                                                    <span x-show="!editing">編集</span>
                                                    <span x-show="editing">保存</span>
                                                </button>
                                                
                                            </div>
                                        </td>
                                        <td class="border px-4 py-2">{{ $studio->user ? $studio->user->name : 'Unknown' }}</td>
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
                        {{ __('スタジオ登録') }}
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

                        <div class="overflow-hidden sm:rounded-lg">
                        <div class="p-6 text-gray-1000">
                            {{ __('ここで管理するスタジオを登録できます。') }}<br>
                            {{ __('登録したスタジオの名前を変更することができません。ご注意ください。') }}<br>
                            {{ __('（誤った名前を登録してしまった場合は一度削除して再度作成してください。') }}
                        </div>
                    </div>
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
                                class="bg-blue-500 px-4 py-2 shadow-md rounded-lg rounded hover:bg-blue-600  mb-4">
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
            if (confirm(
                'このスタジオを削除しますか？\n一度削除すると元に戻せません。\nスタジオを削除すると予約情報も同時に削除されます。')) {
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

        function updateStudio(id) {
        const name = document.getElementById('studio-name-' + id).previousElementSibling.value;

        fetch(`/studios/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                name: name
            })
        })
        .then(response => response.json())
        .then(data => {
            // 編集が成功した場合、ページを更新
            if (data.success) {
                document.getElementById('studio-name-' + id).textContent = name;
            }
        })
        .catch(error => console.error('Error:', error));
    }
    </script>
</x-app-layout>
