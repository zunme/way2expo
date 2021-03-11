<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class AdminbaseController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
     protected function removeHtmlTagsOfFields(array $inputs, array $excepts = array(), array $htmlarr = array() )
    {
        foreach ($inputs as $index => $in){
            if( is_array($inputs[$index]) ) {
                $inputs[$index] = $this->removeHtmlTagsOfFields($in, $excepts, $htmlarr);
            }
            else if( (!in_array($index , $excepts ) && !in_array($index , $htmlarr ) && $in != '') || is_numeric($index) ) {
                $inputs[$index] = htmlentities(strip_tags($in), ENT_QUOTES, 'UTF-8');
            }
            else if (  in_array($index , $htmlarr ) && $in != '' ) {
                $inputs[$index] = htmlentities($in, ENT_QUOTES, 'UTF-8');
            }
        }
        return $inputs;
    }
}
