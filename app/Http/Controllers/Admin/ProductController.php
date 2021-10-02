<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Str;
use Validator;
use DB;

class ProductController extends Controller
{
    private $model;
    private $moduleName;
    private $data;
    private $tableId;
    private $bUrl;
    private $productData;

    public function __construct()
    {  
        $this->tableId = 'id';
        $this->model = Product::class;
        $this->moduleName = 'admin';
        $this->bUrl = $this->moduleName.'/products';
    }


    public function layout($pageName)
    {
        $this->data['tableID'] = $this->tableId;
        $this->data['bUrl'] = $this->bUrl;      
        echo view('products.'.$pageName.'', $this->data);
    }

    public function index(Request $request)
    {
        $this->data = [
            'title'         => 'Product List',
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
        $queryData = Product::orderBy( getOrder(Product::$sortable, $this->tableId)['by'], getOrder(Product::$sortable, $this->tableId)['order']);

        //filter by text.....
        if( $request->filled('filter') ){
            $this->data['filter'] = $filter = $request->get('filter');
            $queryData->where('name', 'like', '%'.$filter.'%');
        }

        $this->data['allData'] =  $queryData->paginate($perPage)->appends( request()->query() ); // paginate
        $this->layout('index');

    } 

    public function create()
    {
        $this->data = [
            'title'         => 'Add New Product',
            'page_icon'     => '<i class="fa fa-plus-circle"></i>',
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
            'objData'       => $this->model::where($this->tableId, $id)->first(),
        ];

        $this->layout('create');
    }

    public function store(Request $request)
    {
        $id = $request[$this->tableId];

        $rules = [
            'name'        => 'required',
            'price'        => 'required',
            'quantity'        => 'required',
        ];

        $attribute =[
            'name'      => 'Product Name',
            'price'      => 'Product Price',
            'quantity'      => 'Product Quantity',
        ];

        if(empty($id)) {
            $rules['picture'] = 'required';
            $attribute['picture'] = 'Product Image';
        } 

        $customMessages =[];

        $validator = Validator::make($request->all(), $rules, $customMessages, $attribute);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }  

        $this->productData = [ 
            'name' => $request['name'],
            'description' => $request['description'],
            'price' => $request['price'],
            'quantity'   => $request['quantity'],
        ];

        if($request->hasFile('picture')) {
            
            if(! empty($id)) {
                $productPic = $this->model::where($this->tableId, $id)->pluck('picture')->first();

                if(! empty($productPic)) {
                    $filePath = public_path('upload/products/'.$productPic);

                    if(file_exists($filePath)) {
                        unlink($filePath);
                    }
                    
                }               
            }

            $filename = time().'.'.$request->file('picture')->getClientOriginalExtension();
            $request->file('picture')->move(public_path('upload/products'), $filename);
            $this->productData['picture'] = $filename;
        }  

        if ( empty($id) ){
            // Insert Query
            $this->model::create($this->productData);
            return redirect($this->bUrl)->with('success', 'Record Successfully Created.');

        } else {
            // Update Query
            $this->model::where($this->tableId, $id)->update($this->productData);
            return redirect($this->bUrl)->with('success', 'Successfully Updated');
        }
    }

    public function show($id)
    {       
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if( !$id ){ exit('Bad Request!'); }

        $this->data = [
            'title'         => 'Product Information',
            'page_icon'     => '<i class="fa fa-eye"></i>',
            'objData'       => $this->model::where($this->tableId, $id)->first(),
        ];                 

        $this->layout('view');
    }

    public function destroy(Request $request, $id)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if( !$id ){ exit('Bad Request!'); }

        $this->data = [
            'title'     => 'Delete Product',
            'pageUrl'   => $this->bUrl.'/delete/'.$id,
            'page_icon' => '<i class="fa fa-book"></i>',
            'objData'   => $this->model::where($this->tableId, $id)->first(),
        ];

        if($request->method() === 'POST' ) {             

            $this->model::where($this->tableId, $id)->delete();
            echo json_encode(['fail' => FALSE, 'error_messages' => "Product was deleted"]);

        } else {
            $this->layout('delete');
        }
    }
}
