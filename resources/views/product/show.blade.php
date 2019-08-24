<!doctype html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{{ asset("css/app.css") }}">
    </head>
    <body>
        <h1>Data ID: {{$id}}</h1>

        <div class="container" style="margin-top: 20px; background-color: orange; padding: 20px;">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="col-md-4" action="{{ route("product.destroy", $id) }}" method="POST">

                @csrf

                @method("DELETE")

                <button class="btn btn-danger" type="submit">Delete</button>

            </form>

        </div>

    </body>
</html>
