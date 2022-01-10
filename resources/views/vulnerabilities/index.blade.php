@foreach ($vulnerabilities as $item)
    <article>
        {{ $item->title }} {{ $item->excerpt }}
    </article>
@endforeach
