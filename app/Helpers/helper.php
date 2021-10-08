<?php
//use Intervention\Image\Image;

use Illuminate\Support\Facades\Mail;
use \Illuminate\Support\Facades\DB;

function validation_errors($errors) {
    if($errors->any()){
        echo '<div class="alert alert-danger"><ul>';
        foreach ($errors->all() as $error){
            echo '<li>'.$error.'</li>';
        }
        echo '</ul></div>';
    }
}

function get_status($data) {
    if($data == "approved"){        
        echo 'Approved';
    } elseif ($data == "rejected") {
        echo 'Rejected';
    } elseif ($data == "processing") {
        echo 'Processing';
    } elseif ($data == "shipped") {
        echo 'Shipped';
    } elseif ($data == "delivered") {
        echo 'Delivered';
    }
}

function getOrder($fields, $default){

    $getOrder = [];

    $order = Request::get('order') ?? 2; // OrderStatus asc or desc;
    $by = Request::get('by'); // by field name;

    //define ASC or DESC
    if($order == 1) $getOrder['order'] = "ASC";
    elseif( $order == 2) $getOrder['order'] = "DESC";
    else $getOrder['order'] = "DESC";

    // define order by which field
    if(!empty($by) ){
        if(array_key_exists($by, $fields)){
            $getOrder['by'] = $fields[$by];
        }else $getOrder['by'] = $default;

    }else{
        $getOrder['by'] = $default;
    }
    return $getOrder;
}

function getValue($field, $data, $default=null) {
    return (!empty($data) && !empty($data->$field)) ? $data->$field : old($field,$default);
}

// Menu active class add
if (! function_exists('activeMenu')) {
    function activeMenu($sig, $data){
        return (Request::segment($sig) == $data)?'active':'';
    }
}
// Menu menu open class add
if (! function_exists('menuOpen')) {
    function menuOpen($sig, $data){
        return (Request::segment($sig) == $data)?'menu-open':'';
    }
}

if (! function_exists('change_date_format')) {
    function change_date_format($targetDate) {
        $date = new DateTime($targetDate);
        $formateDate = $date->format('F j, Y, g:i a');
        return $formateDate;
    }
}

