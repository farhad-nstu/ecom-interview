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
            'title'         => 'Add New Award',
            'page_icon'     => '<i class="fa fa-plus-circle"></i>',
            'objData'       => '',
        ];

        $this->data['employees'] =  HrmsEmployee::all();

        $this->layout('create');
    }

    public function edit($id)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if( !$id ){ exit('Bad Request!'); }

        $this->data = [
            'title'         => 'Edit Award',
            'page_icon'     => '<i class="fa fa-edit"></i>',
            'objData'       => $this->model::where($this->tableId, $id)->first(),
        ];

        $this->data['employees'] =  HrmsEmployee::all();

        $this->layout('create');
    }

    public function store(Request $request)
    {
        $id = $request[$this->tableId];

        $rules = [
            'employee_id'        => 'required',
            'award_title'        => 'required|string',
        ];

        $attribute =[
            'employee_id'      => 'Employee',
            'award_title'      => 'Title',
        ];

        $customMessages =[];

        $validator = Validator::make($request->all(), $rules, $customMessages, $attribute);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }  

        $this->awardData = [ 
            'employee_id' => $request['employee_id'],
            'award_title' => $request['award_title'],
            'award_ground'   => $request['award_ground'],
            'award_date'   => $request['award_date'],
        ];

        if($request->hasFile('award_document')) {
            
            if(! empty($id)) {
                $awardDocument = $this->model::where($this->tableId, $id)->pluck('award_document')->first();

                if(! empty($awardDocument)) {
                    $filePath = public_path('uploads/hrms/'.$request['employee_id'].'/awards/'.$awardDocument);

                    if(file_exists($filePath)) {
                        unlink($filePath);
                    }
                    
                }               
            }

            $filename = time().'.'.$request->file('award_document')->getClientOriginalExtension();
            $request->file('award_document')->move(public_path('uploads/hrms/'.$request['employee_id'].'/awards'), $filename);
            $this->awardData['award_document'] = $filename;
        }  

        if ( empty($id) ){
            // Insert Query
            $this->model::create($this->awardData);

            $log_title = 'Hrms (Employee Id - '.$this->awardData['employee_id'].', award- '.$this->awardData ['award_title'] .') was created by '. Sentinel::getUser()->full_name;
            Logs::create($log_title,'award_create');

            return redirect($this->bUrl)->with('success', 'Record Successfully Created.');

        }else{
            // Update Query
            $this->model::where($this->tableId, $id)->update($this->awardData);

            $log_title = 'Hrms (Employee Id - '.$this->awardData['employee_id'].', award- '.$this->awardData ['award_title'] .') was updated by '. Sentinel::getUser()->full_name;
            Logs::create($log_title,'award_update');

            return redirect($this->bUrl)->with('success', 'Successfully Updated');
        }
    }

    public function show($id)
    {       
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if( !$id ){ exit('Bad Request!'); }

        $this->data = [
            'title'         => 'Award Information',
            'page_icon'     => '<i class="fa fa-eye"></i>',
            'objData'       => $this->model::with(['employee'])->where($this->tableId, $id)->first(),
        ];                 

        $this->layout('view');

    }

    public function destroy(Request $request, $id)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if( !$id ){ exit('Bad Request!'); }

        $this->data = [
            'title'     => 'Delete Award',
            'pageUrl'   => $this->bUrl.'/delete/'.$id,
            'page_icon' => '<i class="fa fa-book"></i>',
            'objData'   => $this->model::where($this->tableId, $id)->first(),
        ];

        $this->data['tableID'] = $this->tableId;
        $this->data['bUrl'] = $this->bUrl;

        if($request->method() === 'POST' ){
              
            $employee = $this->data['objData']->employee_id;
            $award = $this->data['objData']->award_title;

            HrmsAward::where('award_id',$id)->delete();

            $log_title = 'Hrms (Employee Id - '.$employee.', award- '.$award.') was deleted by '. Sentinel::getUser()->full_name;
            Logs::create($log_title,'award_delete');

            echo json_encode(['fail' => FALSE, 'error_messages' => "Award ".$this->data['objData']->award_title." was deleted."]);
        }else{
            return view($this->moduleName.'::awards.delete', $this->data);
        }

    }
}
