<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('ライブ詳細') }}
            </h2>
            <div class="flex space-x-4">
                @if (Auth::user()->admin == 1)
                    <a href="{{ route('lives.edit', $live) }}" class="inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-600 focus:bg-indigo-600 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('編集') }}
                    </a>
                    <form action="{{ route('lives.destroy', $live) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 focus:bg-red-600 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" onclick="return confirm('本当に削除しますか？')">
                            {{ __('削除') }}
                        </button>
                    </form>
                @endif
                <a href="{{ route('lives.bands.create', $live) }}" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:bg-green-600 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('バンド登録') }}
                </a>
                <a href="{{ route('lives.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('一覧に戻る') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">{{ __('ライブ名') }}</h3>
                        <p class="text-gray-700">{{ $live->name }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">{{ __('開催日時') }}</h3>
                        <p class="text-gray-700">{{ $live->held_date->format('Y年m月d日 H:i') }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">{{ __('エントリー締切日時') }}</h3>
                        <p class="text-gray-700">{{ $live->entry_due->format('Y年m月d日 H:i') }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">{{ __('参加バンド') }}</h3>
                        @if($live->bands->count() > 0)
                            <ul class="list-disc list-inside text-gray-700">
                                @foreach($live->bands as $band)
                                    <li>
                                        <a href="{{ route('bands.show', $band) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $band->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-700">参加バンドはまだありません。</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
