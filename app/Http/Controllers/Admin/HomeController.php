<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	private $moduleName;
	private $data;
	private $bUrl;

	public function __construct()
	{	
		$this->moduleName = 'admin';
		$this->bUrl = $this->moduleName.'/dashboard';
	}


	public function layout($pageName)
	{
		$this->data['bUrl'] = $this->bUrl;		
		echo view($pageName, $this->data);
	}

    public function dashboard()
    {
    	$this->data = [
            'title'         => 'Ecommerce Dashboard',
			'pageUrl'         => $this->bUrl,
            'page_icon'     => '<i class="fa fa-book"></i>',
        ];

    	$this->layout('dashboard');
    }
}
