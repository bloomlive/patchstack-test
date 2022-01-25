@extends('layouts.app')

@section('title', 'Create new Vulnerability')

@section('content')

    @if ($errors->any())
        <x-alerts.error>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alerts.error>
    @endif

    <form class="flex w-full" action="{{route('vulnerabilities.store')}}" method="POST">
        @csrf
        <div class="w-full max-w-2xl px-5 py-10 m-auto mt-10 bg-white rounded-lg shadow dark:bg-gray-800">
            <div class="mb-6 text-3xl font-light text-center text-gray-800 dark:text-white">
                Create new vulnerability
            </div>
            <div class="grid max-w-xl grid-cols-2 gap-4 m-auto">
                <div class="col-span-2">
                    <div class=" relative ">
                        <input type="text" id="contact-form-name" name="title" value="{{ old('title') ?? null }}"
                               class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                               placeholder="Title"/>
                    </div>
                </div>
                <div class="col-span-2">
                    <label class="text-gray-700" for="excerpt">
                        <textarea
                            class="flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                            id="excerpt" placeholder="Enter excerpt for index" name="excerpt" rows="5"
                            cols="40">{{ old('excerpt') ?? null }}</textarea>
                    </label>
                </div>
                <div class="col-span-2">
                    <label class="text-gray-700" for="description">
                        <textarea
                            class="flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                            id="description" placeholder="Enter your comment" name="description" rows="5"
                            cols="40">{{ old('description') ?? null }}</textarea>
                    </label>
                </div>
                @foreach ($vulnerabilityFactorTypes as $vulnerabilityFactorType)
                    <div class="col-span-2 py-2 px-4">
                        <div class="flex">
                            <h2 class="max-w-sm mx-auto md:w-1/3">
                                {{ $vulnerabilityFactorType->title }}
                            </h2>
                            <div class="max-w-sm mx-auto md:w-2/3">
                                <div class="relative">
                                    <input type="text" id="typevalue"
                                           name="vulnerability_type_value[{{$vulnerabilityFactorType->id}}]"
                                           class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-span-2 text-right">
                <button type="submit"
                        class="py-2 px-4  bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg ">
                    Send
                </button>
            </div>
        </div>
    </form>
@endsection
