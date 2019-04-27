<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div>
            <input name="name" placeholder="name"/>
        </div>
        <div>
            <input name="sku" placeholder="sku"/>
        </div>
        <button>create</button>
    </body>
</html>
