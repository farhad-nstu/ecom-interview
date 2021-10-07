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
use DB;
use App\Logs;

class OrderController extends Controller
{
    protected $products;
    protected $base_url;

    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->middleware("auth:users");
        $this->base_url = $urlGenerator->to("/");
        $this->orders = new Order;
    }

    public function getPaginatedData($token,$pagination=null)
    {
        $file_directory = $this->base_url."/upload/products";
        $user = auth("users")->authenticate($token);

        $user_id = $user->id;

        if($pagination == null || $pagination == "") {
            // $orders = $this->orders->orderBy("id", "DESC")->where('')->get()->toArray();
            $orders = DB::table('orders')
            		->join('products', 'orders.product_id', '=', 'products.id')
            		->select('orders.*', 'products.name', 'products.picture', 'products.price')
            		->where('orders.user_id', $user_id)
            		->orderBy("id", "DESC")
            		->get()->toArray();

            return response()->json([
                "success"=>true,
                "data"=>$orders,
                "file_directory"=>$file_directory
            ], 200);
        }

        $orders_paginated = DB::table('orders')
            		->join('products', 'orders.product_id', '=', 'products.id')
            		->select('orders.*', 'products.name', 'products.picture', 'products.price')
            		->where('orders.user_id', $user_id)
            		->orderBy("id", "DESC")
            		->paginate($pagination);

        // $orders_paginated = $this->orders->orderBy("id", "DESC")->paginate($pagination);

        return response()->json([
            "success"=>true,
            "data"=>$orders_paginated,
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

		    $non_paginated_search_query = DB::table('orders')
		    		->join('products', 'orders.product_id', '=', 'products.id')
		    		->select('orders.*', 'products.name', 'products.picture', 'products.price')
		    		->where('orders.user_id', $user_id)
		    		->where(function($query) use ($search) {
		        			$query->where("orders.order_status", "LIKE", "%$search%");
		        		})
		    		->orderBy("id", "DESC")
		    		->get()->toArray();

		    return response()->json([
		        "success"=>true,
		        "data"=>$non_paginated_search_query,
		        "file_directory"=>$file_directory
		    ], 200);
  		}

		$paginated_search_query = DB::table('orders')
				->join('products', 'orders.product_id', '=', 'products.id')
				->select('orders.*', 'products.name', 'products.picture', 'products.price')
				->where('orders.user_id', $user_id)
				->where(function($query) use ($search) {
		    			$query->where("orders.order_status", "LIKE", "%$search%");
		    		})
				->orderBy("id", "DESC")
				->paginate($pagination);

  		return response()->json([
      		"success"=>true,
      		"data"=>$paginated_search_query,
      		"file_directory"=>$file_directory
  		], 200);
	}

	public function getSingleData($id)
	{
       	$order = DB::table('orders')
       		->join('products', 'orders.product_id', '=', 'products.id')
       		->select('orders.*', 'products.name', 'products.picture', 'products.price', 'products.quantity', 'products.description')
       		->where('orders.id', $id)
       		->first();

       	if(!$order) {
       	    return response()->json([
       	       	"success"=>true,
       	       	"message"=>"Order with this id doesnt exist!"
       	   	], 500);
       	}

	   	$file_directory = $this->base_url."/upload/products";
	   	
	  	return response()->json([
	      	"success"=>true,
	      	"data"=>$order,
	      	"file_directory"=>$file_directory
	  	], 200);
	}

	public function editSingleData(Request $request, $id)
	{
		$findData = $this->orders->find($id);

	    if($findData->order_status == "approved" || $order->order_status == "rejected") {
       		return response()->json([
       		    "success"=>true,
       		    "message"=>"Order is approved or rejected by the admin!"
       		], 500);
       	}

	    $validator = Validator::make($request->all(), [
	        "product_quantity"=>"required",
	    ]);

	    if($validator->fails()) {
	        return response()->json([
	          	"success"=>false,
	          	"message"=>$validator->messages()->toArray()
	      	], 400);
	    }

	    if(!$findData) {
	        return response()->json([
	          	"success"=>false,
	          	"message"=>"Please this content has no valid id!"
	      	], 400);
	    }

	    $product = Product::where('id', $findData->product_id)->first();

	    /// Edit History Save
        $editHistoryData = [ 
            'order_id' => $findData->id,
            'product_id' => $findData->product_id,
            'user_id' => $findData->user_id,
            'product_quantity' => $findData->product_quantity,
            'order_date'   => $findData->order_date,
            'shipping_address'   => $findData->shipping_address,
            'shipping_cost'   => $findData->shipping_cost,
            'net_price'   => $findData->net_price,
            'order_status'   => $findData->order_status,
            'edit_date' => date('Y-m-d h:i:sa'),
        ];

        Logs::create($editHistoryData);
	    /// Edit History end

	    $findData->product_quantity = $request->product_quantity;
	    $findData->shipping_address = $request->shipping_address;

	    if($request->inside_outside == "Outside Dhaka") {
	    	$findData->shipping_cost = 100;
	    	$findData->net_price = $product->price * $request->product_quantity + 100;
        } else {
        	$findData->shipping_cost = 60;
	    	$findData->net_price = $product->price * $request->product_quantity + 60;
        }

	    $findData->update();

		return response()->json([
		  	"success"=>true,
		  	"message"=>"Order updated successfully",
		], 200);
	}
}
