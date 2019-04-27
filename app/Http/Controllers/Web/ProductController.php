<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();

        $data['office'] = 'Rebelworks';

        $rules = [
            'name' => 'required|min:7',
        ];

        $messages = [
            'name.required' => 'name is required',
            'name.min' => '7 characters min',
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            dd($validator->errors()->messages());
        }

        return view('product.index', compact('data'));
    }

    public function create()
    {
        return view('product.create');
    }

    public function show($id)
    {
        return view('product.show', compact('id'));
    }
}

// var_dump('test me')
// print_r('test me')

// dd($request->input('name'));
// dd($request->all());
// $data['name'] = $request->input('name');
// php artisan make:migration create-products-table --create=products
// php artisan migrate
// php artisan migrate:rollback
// php artisan migrate:refresh --step 1
// php artisan migrate --pretend
// php artisan make:seeder ProductSeeder
// php artisan make:model Product
