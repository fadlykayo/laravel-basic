<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    </head>
    <body>
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

            <div class="row">
                <form class="col-md-4" action="{{ route('product.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>sku</label>
                        <input class="form-control" name="sku" placeholder="sku" min="0" value="{{ old('sku', '') }}"/>
                    </div>
                    <div class="form-group">
                        <label>name</label>
                        <input class="form-control" name="name" placeholder="name" value="{{ old('name', '') }}"/>
                    </div>
                    <div class="form-group">
                        <label>stock</label>
                        <input class="form-control" type="number" name="stock" placeholder="stock" min="0" value="0" value="{{ old('stock', 0) }}"/>
                    </div>
                    <div class="form-group">
                        <label>price</label>
                        <input class="form-control" type="number" name="price" placeholder="price" min="0" value="0" step="1000" value="{{ old('price', 0) }}"/>
                    </div>
                    <div class="form-group">
                        <label>description</label>
                        <textarea class="form-control" style="height: 300px;" name="description" placeholder="description">
                            {{ old('description', '') }}
                        </textarea>
                    </div>
                    <button class="btn btn-success" type="submit">create</button>
                </form>
            </div>
        </div>
    </body>
</html>
