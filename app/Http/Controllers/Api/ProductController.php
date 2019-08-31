<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use Redirect;
use Exception;
use DB;

use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $data = (new Product)->all()->toArray();

        return response()->json([
            "status" => "SUCCESS",
            "code" => "000",
            "data" => ["products" => $data] // dikelompokan dalam products
            "meta" => [
                "page" => [
                    "current" => 1,
                    "total" => 3
                ],
                "list" => [
                    "current" => 15,
                    "total" => 40
                ],
                "search" => [
                    "searchables" => [
                        "sku",
                        "name"
                    ],
                    "active" => ""
                ],
                "sort" => [
                    "searchables" => [
                        "name",
                        "created_at"
                    ],
                    "active" => "-name" // - DESC
                ],
                "filters" => [
                    "filterables" => [
                        "category" => [
                            "car",
                            "bike"
                        ],
                        "owner" => [
                            "user1",
                            "user2"
                        ],
                        "status" => [
                            "ACTIVE",
                            "INACTIVE"
                        ]
                    ],
                    "category" => [
                        "car",
                        "bike"
                    ],
                    "status" => [
                        "ACTIVE"
                    ]
                ],
            ]
        ]);
    }

    public function create()
    {
        return view("product.create");
    }

    public function store(Request $request)
    {
        return $this->save($request);
    }

    public function update(Request $request, string $id)
    {
        return $this->save($request, $id);
    }

    public function edit($id)
    {
        $data = $this->getData($id);

        return view("product.edit", compact("id", "data"));
    }

    public function show($id)
    {
        $data = $this->getData($id);

        return view("product.show", compact("data", "id"));
    }

    public function destroy(string $id)
    {
        $data = $this->getData($id);

        $data->delete();

        return Redirect::route("product.index");
    }

    public function getData(string $id)
    {
        $data = (new Product)->where("id", "=", $id)->first();

        if (is_null($data)) {
            abort(404);
        }

        return $data;
    }

    private function save(Request $request, string $id = null)
    {
        // get form data
        $inputData = $request->all();

        // $data["office"] = "Rebelworks";

        // validate form data
        $rules = [
            "sku" => "required|min:7|unique:products,sku,$id,id,deleted_at,NULL", // soft delete - cek dokumentasi
            "name" => "required|min:7",
            "stock" => "required|numeric|min:0",
            "price" => "required|numeric|min:0",
            "description" => "nullable",
        ];

        $messages = [
            "name.required" => "name is required",
            "name.min" => "7 characters min",
        ];

        $validator = Validator::make($inputData, $rules, $messages);

        if ($validator->fails()) {
            return Redirect::back()
            ->withErrors($validator) // untuk mengeluarkan error di halaman view
            ->withInput(); // mengembalikan data2 yg sebelumnya ke form input
        }

        // clean up form data
        unset($inputData["_token"]); // menghapus form input bernama _token (csrf)
        unset($inputData["_method"]);

        // save form data
        $data = (new Product);

        if (!is_null($id)) {
            $data = $data->where("id", "=", $id)->first();
        }

        DB::beginTransaction(); // untuk memulai transaction ke database
        try {
            foreach ($inputData as $column => $value) {
                $data->{$column} = $value;
            }
            // sama kayak:
            // $data->sku = $data["sku"];
            // $data->name = $data["name"];

            $data->save();
        } catch (Exception $e) {
            DB::rollback();

            return Redirect::back()
                ->withErrors(["db" => $e->getMessage()])
                ->withInput();
        }
        DB::commit(); // save ke DB

        // cara lain:
        // $data = (new Product)->create($data);

        return Redirect::route("product.index");
    }
}

// var_dump("test me")
// print_r("test me")

// dd($request->input("name"));
// dd($request->all());
// $data["name"] = $request->input("name");
// php artisan make:migration create-products-table --create=products
// php artisan migrate
// php artisan migrate:rollback
// php artisan migrate:refresh --step 1
// php artisan migrate --pretend
// php artisan make:seeder ProductSeeder
// php artisan make:model Product
// php artisan db:seed
// php artisan db:seed --class="ProductSeeder"
// php artisan migrate:refresh --seed
