<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        This is product list page
        <br/>
        <br/>
        <a href="{{ route('product.create') }}">create product</a>
        <br/>
        <br/>
        <a href="{{ route('product.show', 1) }}">detail product 1</a>
        <br/>
        <a href="{{ route('product.show', 2) }}">detail product 2</a>
        <br/>
        <a href="{{ route('product.show', 3) }}">detail product 3</a>
        <br/>
        <a href="{{ route('product.show', 4) }}">detail product 4</a>
        <br/>
        <a href="{{ route('product.show', 5) }}">detail product 5</a>
        <ul>
            @foreach ($data as $key => $value)
                @if ($key === 'age')
                    @continue
                @endif

                <li>{{ $loop->iteration }}) {{ $key }} = {{ $value }}</li>
            @endforeach
        </ul>
    </body>
</html>
