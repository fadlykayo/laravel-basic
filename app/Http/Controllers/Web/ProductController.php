<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;
use Redirect;
use Exception;
use DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        return view('product.index', compact('data'));
    }

    public function store(Request $request)
    {
        // get form data
        $data = $request->all();

        // $data['office'] = 'Rebelworks';

        // validate form data
        $rules = [
            'sku' => 'required|min:7|unique:products,sku,null,id,deleted_at,NULL', // soft delete
            'name' => 'required|min:7',
            'stock' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable',
        ];

        $messages = [
            'name.required' => 'name is required',
            'name.min' => '7 characters min',
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return Redirect::back()
            ->withErrors($validator)
            ->withInput();
        }

        // clean up form data
        unset($data['_token']);

        // save form data
        $product = (new Product);

        DB::beginTransaction();
        try {
            foreach ($data as $column => $value) {
                $product->{$column} = $value;
            }
            // sama kayak:
            // $product->sku = $data['sku'];
            // $product->name = $data['name'];

            $product->save();
        } catch (Exception $e) {
            DB::rollback();

            return Redirect::back()
                ->withErrors(['db' => $e->getMessage()])
                ->withInput();
        }
        DB::commit();

        // cara lain:
        // $product = (new Product)->create($data);

        return Redirect::route('product.index');
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
// php artisan db:seed
// php artisan db:seed --class='ProductSeeder'
// php artisan migrate:refresh --seed
