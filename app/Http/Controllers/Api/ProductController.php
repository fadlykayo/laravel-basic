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

        return $this->constructSuccessResponse(["products" => $data]); // dikelompokan dalam products
    }

    public function show($id)
    {
        $data = $this->getData($id);

        return $this->constructSuccessResponse(["product" => $data]);
    }

    public function store(Request $request)
    {
        $data = $this->saveData($request);

        if (isset($data["error"])) {
            return $this->constructErrorResponse($data["error"]);
        }

        return $this->constructSuccessResponse([
            "created_id" => $data->id,
            "product" => $data
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $this->saveData($request, $id);

        if (isset($data["error"])) {
            return $this->constructErrorResponse($data["error"]);
        }

        return $this->constructSuccessResponse([
            "updated_id" => $id,
            "product" => $data
        ]);
    }

    public function destroy(string $id)
    {
        $data = $this->getData($id);

        $data->delete();

        return $this->constructSuccessResponse([
            "deleted_id" => $id,
        ]);
    }

    public function getData(string $id)
    {
        $data = (new Product)->where("id", "=", $id)->first();

        if (is_null($data)) {
            abort(404);
        }

        return $data;
    }

    private function constructSuccessResponse($data)
    {
        // api/products?page=1&search=asd&sort=-name&category=car,bike&status=ACTIVE

        return response()->json([
            "status" => "SUCCESS",
            "code" => "000",
            "data" => $data,
        ]);
    }

    private function constructErrorResponse($error)
    {

        return response()->json([
            "status" => "ERROR",
            "code" => "119",
            "message" => implode(" | ", $error)
        ]);
    }

    private function saveData(Request $request, string $id = null)
    {
        // get form data
        $inputData = $request->all();

        // validate form data
        $rules = [
            "sku" => "required|min:7|unique:products,sku,$id,id,deleted_at,NULL", // soft delete - cek dokumentasi
            "name" => "required|min:7",
            "stock" => "required|numeric|min:0",
            "price" => "required|numeric|min:0",
            "description" => "nullable",
        ];

        $messages = [
            "name.required" => "name is required.",
            "name.min" => "7 characters min.",
        ];

        $validator = Validator::make($inputData, $rules, $messages);

        if ($validator->fails()) {
            // dd($validator->errors()->all());
            return ["error" => $validator->errors()->all()]; // implode = join
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

            $data->save();
        } catch (Exception $e) {
            DB::rollback();

            return ["error" => $e->getMessage()];
        }
        DB::commit(); // save ke DB

        return $data;
    }
}

// "meta" => [
//     "page" => [
//         "current" => 1,
//         "total" => 3
//     ],
//     "list" => [
//         "current" => 15,
//         "total" => 40
//     ],
//     "search" => [
//         "searchables" => [
//             "sku",
//             "name"
//         ],
//         "active" => ""
//     ],
//     "sort" => [
//         "searchables" => [
//             "name",
//             "created_at"
//         ],
//         "active" => "-name" // - DESC
//     ],
//     "filters" => [
//         "filterables" => [
//             "category" => [
//                 "car",
//                 "bike"
//             ],
//             "owner" => [
//                 "user1",
//                 "user2"
//             ],
//             "status" => [
//                 "ACTIVE",
//                 "INACTIVE"
//             ]
//         ],
//         "active" => [
//             "category" => [
//                 "car",
//                 "bike"
//             ],
//             "status" => [
//                 "ACTIVE"
//             ]
//         ]
//     ],
// ]
