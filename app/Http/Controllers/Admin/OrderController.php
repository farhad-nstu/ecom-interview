<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\Product;
use Illuminate\Support\Str;
use Validator;
use DB;

class OrderController extends Controller
{
    private $model;
    private $moduleName;
    private $data;
    private $tableId;
    private $bUrl;
    private $orderData;

    public function __construct()
    {  
        $this->tableId = 'id';
        $this->model = Order::class;
        $this->moduleName = 'admin';
        $this->bUrl = $this->moduleName.'/orders';
    }


    public function layout($pageName)
    {
        $this->data['tableID'] = $this->tableId;
        $this->data['bUrl'] = $this->bUrl;      
        echo view('orders.'.$pageName.'', $this->data);
    }

    public function index(Request $request)
    {
        $this->data = [
            'title'         => 'Order List',
            'pageUrl'         => $this->bUrl,
            'page_icon'     => '<i class="fa fa-book"></i>',
        ];

        //result per page
        $perPage = session('per_page') ?: 20;

        //table item serial starting from 0
        $this->data['serial'] = ( ($request->get('page') ?? 1) -1) * $perPage;

        if($request->method() === 'POST'){
            session(['per_page' => $request->post('per_page') ]);
        }

        // model query...
        $queryData = Order::orderBy( getOrder(Order::$sortable, $this->tableId)['by'], getOrder(Order::$sortable, $this->tableId)['order']);

        //filter by text.....
        if( $request->filled('filter') ) {
            $this->data['filter'] = $filter = $request->get('filter');
            $queryData->where('name', 'like', '%'.$filter.'%');
        }

        $queryData = DB::table('orders')
                    ->join('products', 'orders.product_id', '=', 'products.id')
                    ->join('users', 'orders.user_id', '=', 'users.id')
                    ->select('orders.*', 'products.id as product_id', 'products.name as name', 'products.picture', 'users.firstname', 'users.lastname')
                    ->orderBy( getOrder(Order::$sortable, $this->tableId)['by'], getOrder(Order::$sortable, $this->tableId)['order']);

		//filter by text.....
		if( $request->filled('filter') ){
			$this->data['filter'] = $filter = $request->get('filter');

			$queryData->where('orders.order_date', 'like', '%'.$filter.'%');
			$queryData->orWhere('orders.order_status', 'like', '%'.$filter.'%');
			$queryData->orWhere('products.name', 'like', '%'.$filter.'%');
			$queryData->orWhere('users.firstname', 'like', '%'.$filter.'%');
			$queryData->orWhere('users.lastname', 'like', '%'.$filter.'%');
		}

        $this->data['allData'] =  $queryData->paginate($perPage)->appends( request()->query() ); // paginate
        $this->layout('index');

    } 

    public function create()
    {
        $this->data = [
            'title'         => 'Add New',
            'page_icon'     => '<i class="fa fa-plus-circle"></i>',
            'products'		=> Product::all('id', 'name'),
            'objData'       => '',
        ];

        $this->layout('create');
    }

    public function edit($id)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if( !$id ){ exit('Bad Request!'); }

        $this->data = [
            'title'         => 'Edit Product',
            'page_icon'     => '<i class="fa fa-edit"></i>',
            'products'		=> Product::all('id', 'name'),
            'objData'       => $this->model::where($this->tableId, $id)->first(),
        ];

        $this->layout('create');
    }

    public function store(Request $request)
    {
        $id = $request[$this->tableId];

        $rules = [
            'product_id'        => 'required',
            'user_id'        => 'required',
            'product_quantity'        => 'required',
            'order_date'        => 'required',
            'net_price'        => 'required',
            'order_status'        => 'required',
        ];

        $attribute =[
            'product_id'      => 'Product Name',
            'user_id'      => 'Product Price',
            'product_quantity'      => 'Product Quantity',
            'order_date'      => 'Order Date',
            'net_price'      => 'Net Price',
            'order_status'      => 'Order Status',
        ];

        $customMessages =[];

        $validator = Validator::make($request->all(), $rules, $customMessages, $attribute);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }  

        $this->orderData = [ 
            'product_id' => $request['product_id'],
            'user_id' => $request['user_id'],
            'product_quantity' => $request['product_quantity'],
            'order_date'   => $request['order_date'],
            'shipping_address'   => $request['shipping_address'],
            'shipping_cost'   => $request['shipping_cost'],
            'net_price'   => $request['net_price'],
            'order_status'   => $request['order_status'],
        ];

        if ( empty($id) ) {
            // Insert Query
            $this->model::create($this->orderData);
            return redirect($this->bUrl)->with('success', 'Record Successfully Created.');

        } else {
            // Update Query
            $this->model::where($this->tableId, $id)->update($this->orderData);
            return redirect($this->bUrl)->with('success', 'Successfully Updated');
        }
    }

    public function destroy(Request $request, $id)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if( !$id ){ exit('Bad Request!'); }

        $this->data = [
            'title'     => 'Delete Order',
            'pageUrl'   => $this->bUrl.'/delete/'.$id,
            'page_icon' => '<i class="fa fa-book"></i>',
            'objData'   => $this->model::where($this->tableId, $id)->first(),
        ];

        if($request->method() === 'POST' ) {             

            $this->model::where($this->tableId, $id)->delete();
            echo json_encode(['fail' => FALSE, 'error_messages' => "Order was deleted"]);

        } else {
            $this->layout('delete');
        }
    }
}
