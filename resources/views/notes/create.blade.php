<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mt-6 mb-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">

                @foreach($errors->all() as $error)
                    <p>{{$error}}</p>
                @endforeach

                <form action="{{ route('notes.store') }}" method="post">
                    @csrf
                    <x-input
                        type="text"
                        name="title"
                        field="title"
                        placeholder="Title"
                        class="w-full"
                        autocomplete="off"
                        :value="@old('title')"></x-input>

                    <x-textarea
                        name="content"
                        rows="10"
                        field="content"
                        placeholder="Start typing here..."
                        class="w-full mt-6"
                        :value="@old('content')"></x-textarea>

                    <x-button class="mt-6">Save Note</x-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
