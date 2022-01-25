@extends('layouts.app')

@section('title', $vulnerability->title)

@section('content')
    <article>
        <h2 class="text-gray-900 dark:text-white text-3xl font-bold">{{ $vulnerability->title }}</h2>
        <a href="{{route('vulnerabilities.edit', $vulnerability->id)}}">Edit</a>
        <ul class="flex flex-wrap my-12 dark:text-white">
            @foreach($vulnerability->vulnerabilityFactors as $factor)
                <li class="w-full border-b md:w-1/2 md:border-r lg:w-1/8 p-8">
                    <div class="ml-4 text-xl">
                        {{ $factor->vulnerabilityFactorType->title }}
                    </div>
                    <div class="leading-loose text-gray-500 dark:text-gray-200 text-md">
                        {{ $factor->value }} {{ $factor->vulnerabilityFactorType->unit }}
                    </div>
                </li>
            @endforeach
        </ul>
        {!! $vulnerability->descriptionParsed !!}
    </article>
@endsection
