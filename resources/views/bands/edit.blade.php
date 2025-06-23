<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('バンド編集') }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('bands.show', $band) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('詳細に戻る') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('bands.update', $band) }}" class="space-y-6" id="band-form">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('バンド名')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $band->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        @if(!$band->live)
                            <div>
                                <x-input-label for="live_id" :value="__('参加するライブ')" />
                                <select id="live_id" name="live_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">選択してください</option>
                                    @foreach(App\Models\Live::orderBy('held_date', 'desc')->get() as $liveOption)
                                        <option value="{{ $liveOption->id }}" {{ old('live_id', $band->live_id) == $liveOption->id ? 'selected' : '' }}>
                                            {{ $liveOption->name }} ({{ $liveOption->held_date->format('Y/m/d H:i') }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('live_id')" />
                            </div>
                        @endif

                        <div>
                            <div class="flex items-center gap-4 mb-4">
                                <x-input-label :value="__('メンバー')" class="text-lg font-semibold" />
                                <button type="button" id="add-member" class="inline-flex items-center px-3 py-1.5 bg-blue-500 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    {{ __('メンバーを追加') }}
                                </button>
                            </div>

                            <div id="members-container" class="space-y-4">
                                @foreach($band->members as $index => $member)
                                    <div class="member-row flex items-center gap-4 mb-4">
                                        <div class="flex-1">
                                            <x-input-label :value="__('名前')" />
                                            <div class="relative">
                                                <x-text-input type="text" name="members[{{ $index }}][name]" class="mt-1 block w-full member-name" placeholder="名前を入力" :value="old('members.' . $index . '.name', $member->name)" required />
                                                <div class="member-search-results absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-sm mt-1 hidden"></div>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <x-input-label :value="__('パート')" />
                                            <x-text-input type="text" name="members[{{ $index }}][part]" class="mt-1 block w-full" placeholder="パートを入力" :value="old('members.' . $index . '.part', $member->part)" required />
                                        </div>
                                        <div class="flex items-end">
                                            <button type="button" class="remove-member inline-flex items-center px-3 py-1 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 focus:bg-red-600 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                {{ __('削除') }}
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <x-input-error class="mt-2" :messages="$errors->get('members')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('更新') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- メンバー入力フィールドのテンプレート -->
    <template id="member-template">
        <div class="member-row flex items-center gap-4 mb-4">
            <div class="flex-1">
                <x-input-label :value="__('名前')" />
                <div class="relative">
                    <x-text-input type="text" name="members[INDEX][name]" class="mt-1 block w-full member-name" placeholder="名前を入力" required />
                    <div class="member-search-results absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-sm mt-1 hidden"></div>
                </div>
            </div>
            <div class="flex-1">
                <x-input-label :value="__('パート')" />
                <x-text-input type="text" name="members[INDEX][part]" class="mt-1 block w-full" placeholder="パートを入力" required />
            </div>
            <div class="flex items-end">
                <button type="button" class="remove-member inline-flex items-center px-3 py-1 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 focus:bg-red-600 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('削除') }}
                </button>
            </div>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded');

            const membersContainer = document.getElementById('members-container');
            const addMemberButton = document.getElementById('add-member');
            const memberTemplate = document.getElementById('member-template');

            console.log('Elements:', {
                membersContainer,
                addMemberButton,
                memberTemplate
            });

            let memberCount = {{ count($band->members) }};

            // メンバーを追加する関数
            function addMember() {
                console.log('Adding member...');

                if (!memberTemplate) {
                    console.error('Member template not found');
                    return;
                }

                const memberRow = memberTemplate.content.cloneNode(true);
                console.log('Cloned template:', memberRow);

                const memberInputs = memberRow.querySelectorAll('input');
                console.log('Found inputs:', memberInputs.length);

                // インデックスを設定
                memberInputs.forEach(input => {
                    input.name = input.name.replace('INDEX', memberCount);
                });

                // 削除ボタンのイベントリスナーを設定
                const removeButton = memberRow.querySelector('.remove-member');
                if (removeButton) {
                    removeButton.addEventListener('click', function() {
                        this.closest('.member-row').remove();
                    });
                }

                // メンバー名の検索機能を設定
                const nameInput = memberRow.querySelector('.member-name');
                const searchResults = memberRow.querySelector('.member-search-results');

                if (nameInput && searchResults) {
                    nameInput.addEventListener('input', function() {
                        const query = this.value.trim();
                        if (query.length < 2) {
                            searchResults.classList.add('hidden');
                            return;
                        }

                        // ここでユーザー検索APIを呼び出す
                        fetch(`/api/users/search?q=${encodeURIComponent(query)}`)
                            .then(response => response.json())
                            .then(data => {
                                searchResults.innerHTML = '';
                                if (data.length > 0) {
                                    data.forEach(user => {
                                        const div = document.createElement('div');
                                        div.className = 'p-2 hover:bg-gray-100 cursor-pointer';
                                        div.textContent = user.name;
                                        div.addEventListener('click', function() {
                                            nameInput.value = user.name;
                                            searchResults.classList.add('hidden');
                                        });
                                        searchResults.appendChild(div);
                                    });
                                    searchResults.classList.remove('hidden');
                                } else {
                                    searchResults.classList.add('hidden');
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching users:', error);
                                searchResults.classList.add('hidden');
                            });
                    });
                }

                if (membersContainer) {
                    membersContainer.appendChild(memberRow);
                    console.log('Member added successfully');
                    memberCount++;
                } else {
                    console.error('Members container not found');
                }
            }

            // メンバー追加ボタンのイベントリスナー
            if (addMemberButton) {
                addMemberButton.addEventListener('click', function(e) {
                    console.log('Add member button clicked');
                    e.preventDefault();
                    e.stopPropagation();
                    addMember();
                });
            } else {
                console.error('Add member button not found');
            }

            // 既存の削除ボタンにイベントリスナーを設定
            document.querySelectorAll('.remove-member').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.member-row').remove();
                });
            });
        });
    </script>
</x-app-layout>
