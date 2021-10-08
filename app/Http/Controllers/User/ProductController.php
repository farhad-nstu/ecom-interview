<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Order;
use Validator;
use Illuminate\Routing\UrlGenerator;
use File;
use Auth;
use App\Mail\OrderInformed;

class ProductController extends Controller
{
    protected $products;
    protected $base_url;

    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->middleware("auth:users");
        $this->base_url = $urlGenerator->to("/");
        $this->products = new Product;
    }

    public function getPaginatedData($token,$pagination=null)
    {
        $file_directory = $this->base_url."/upload/products";
        $user = auth("users")->authenticate($token);

        $user_id = $user->id;

        if($pagination == null || $pagination == "") {
            $products = $this->products->orderBy("id","DESC")->get()->toArray();

            return response()->json([
                "success"=>true,
                "data"=>$products,
                "file_directory"=>$file_directory
            ], 200);
        }

        $products_paginated = $this->products->orderBy("id","DESC")->paginate($pagination);

        return response()->json([
            "success"=>true,
            "data"=>$products_paginated,
            "file_directory"=>$file_directory
        ], 200);
    }

    public function searchData($search, $token, $pagination = null)
	{
	    $file_directory = $this->base_url."/upload/products";
	    $user = auth("users")->authenticate($token);
	    $user_id = $user->id;

	    $search = explode("%20", $search);
	    $search = implode(" ", $search);

	    if($pagination == null || $pagination == "") {
		    $non_paginated_search_query = $this->products::where(function($query) use ($search) {
		        $query->where("name", "LIKE", "%$search%");
		    })->orderBy("id","DESC")->get()->toArray();

		    return response()->json([
		        "success"=>true,
		        "data"=>$non_paginated_search_query,
		        "file_directory"=>$file_directory
		    ], 200);
  		}

  		$paginated_search_query = $this->products::where(function($query) use ($search) {
   			$query->where("name", "LIKE", "%$search%");
		})->orderBy("id","DESC")->paginate($pagination);

  		return response()->json([
      		"success"=>true,
      		"data"=>$paginated_search_query,
      		"file_directory"=>$file_directory
  		], 200);
	}

	public function order_product(Request $request, $id, $token)
	{
		$user = auth("users")->authenticate($token);
	    $user_id = $user->id;
	    $product = $this->products::where('id', $id)->first();

        if($product->quantity <= 0 || $product->quantity < $request->product_quantity) {
            return response()->json([
                "success"=>true,
                "message"=>"Requested amount of product is not available right now!"
            ], 200);
        }

		$orderData = [ 
            'product_id' => $id,
            'user_id' => $user_id,
            'product_price' => $product->price,
            'product_quantity' => $request->product_quantity,
            'order_date'   => date('Y-m-d h:i:sa'),
            'shipping_address'   => $request->shipping_address,
            'order_status'   => "processing",
        ];

        if($request->inside_outside == "Outside Dhaka") {
            $orderData['shipping_cost'] = 100;
            $orderData['net_price'] = $product->price * $request->product_quantity + 100;
        } else {
            $orderData['shipping_cost'] = 60;
            $orderData['net_price'] = $product->price * $request->product_quantity + 60;
        }

        Order::create($orderData);

        $data = array(
            'message' => $request->product_quantity." piece of ".$product->name." is ordered by ".$user->firstname." ".$user->lastname." at ".date("F j, Y, g:i a"),
        );

        \Mail::to("admin@gmail.com")->send(new OrderInformed($data));

        return response()->json([
            "success"=>true,
            "message"=>"Order placed successfully"
        ], 200);
    }

    public function product_details($id)
    {
        $file_directory = $this->base_url."/upload/products";
        $findData = $this->products::find($id);

        if(!$findData) {
          return response()->json([
             "success"=>true,
             "message"=>"Product with this id doesnt exist"
         ], 500);
        }

        return response()->json([
          "success"=>true,
          "data"=>$findData,
          "file_directory"=>$file_directory
        ], 200);
    }
}
