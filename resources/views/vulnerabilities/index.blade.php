@extends('layouts.app')

@section('title', 'Vulnerabilities')

@section('content')
    <h1 class="text-gray-900 dark:text-white text-3xl font-bold">Vulnerabilities</h1>

    @if(session()->has('success'))
        <x-alerts.success/>
    @endif

    @unless(empty($vulnerabilities->items()))
        <div class="flex flex-wrap">
            @foreach ($vulnerabilities as $item)
                <div class="overflow-hidden basis-1/4 border-gray-200 border-2">
                    <div class="bg-white dark:bg-gray-800 w-full p-4">
                        <a class="font-semibold text-indigo-500"
                           href="{{route('vulnerabilities.show', $item->id)}}">{{ $item->title }}</a>
                        {{ $item->excerpt }}
                        <form method="POST" action="{{route('vulnerabilities.destroy', $item->id)}}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <div class="form-group">
                                <x-buttons.delete/>
                            </div>
                        </form>
                    </div>
                </div>
        @endforeach
        </div>

    @else
        There is nothing here, yet. You can add something.
    @endif

    {{ $vulnerabilities->links() }}
@endsection

