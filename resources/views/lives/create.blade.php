<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ライブ登録') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('lives.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('ライブ名')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="held_date" :value="__('開催日時')" />
                            <x-text-input id="held_date" name="held_date" type="datetime-local" class="mt-1 block w-full" :value="old('held_date')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('held_date')" />
                        </div>

                        <div>
                            <x-input-label for="entry_due" :value="__('エントリー締切日時')" />
                            <x-text-input id="entry_due" name="entry_due" type="datetime-local" class="mt-1 block w-full" :value="old('entry_due')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('entry_due')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('登録') }}</x-primary-button>
                            <a href="{{ route('lives.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('キャンセル') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
