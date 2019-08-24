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

        @foreach ($data as $item)
            Detail product {{$item["id"]}}
            <a href="{{ route('product.edit', $item["id"]) }}">Edit</a>
            <a href="{{ route('product.show', $item["id"]) }}">Show</a>
            <br/>
        @endforeach

        <br/>
        <a href="{{ route('product.create') }}">Create product</a>
    </body>
</html>
