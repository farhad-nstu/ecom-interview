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


/*****
 * getOrder()
 * sorting table fields by asc or desc
 ***
 * @$fields must be indexed array.
 * @$default must need a db table field name.
 **/

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


if ( ! function_exists('getValueImage')) {
    function getValueImage($old, $data){
        if (!empty($data->$old) && is_file($data->$old)){
            return getImage($data->$old);
        }
        return url('backend/images/default-avatar.png');
    }
}

if ( ! function_exists('imageUpload')) {
    function imageUpload($request, $image, $path){
        if ($request->file($image)) {
            $imageFile = $request->file($image);
            $imageName = 'uploads/'.$path.'/'.uniqid().rand().time().'.'.$imageFile->getClientOriginalExtension();
            Image::make($imageFile)->save($imageName);
            return $imageName;
        }
    }
}

if ( ! function_exists('imageUpdate')) {
    function imageUpdate($request, $image, $path, $imageName){
        if ($request->file($image)) {
            unlinkImage($imageName);
            $name = imageUpload($request, $image, $path);
            return $name;
        }
        return $imageName;
    }
}

if (! function_exists('getImage')) {
    function getImage($data){
        return (is_file($data)) ? url($data):'';
    }
}

if (! function_exists('unlinkImage')) {
    function unlinkImage($data){
        return (is_file($data)) ? unlink($data):'';
    }
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

// Email Send
function emailSend($to, $subject, $data,$view='mail'){

    Mail::send('email.'.$view, $data, function ($message) use ($to, $subject){
        return $message->to($to)->subject($subject)->from('hotel@gov.bd');
    });
}

