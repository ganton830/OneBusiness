<?php

namespace App\Http\Controllers;

use App\Tmaster;
use App\Spodetail;
use App\Delivery;

use DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StocktransferController extends Controller
{
    public function index()
    {
        // echo "string";

        if(!isset($_GET['status']))
        {
            $status=1;

            
        }
        else{
            $status = $_GET['status'];
        }

    if($status==1)
        {
            $tmaster_data = Tmaster::where('served',0)->limit(100)->get();
        }
        else if($status==2)
        {
            $tmaster_data = Tmaster::where('served',1)->limit(100)->get();
        }
        else if($status==3)
        {
            $tmaster_data = Tmaster::limit(100)->get();
        }


        $delivery_data = Delivery::limit(1000)->get();


        return view('stocktransfer/index',compact(array('tmaster_data','delivery_data','status')));
        
    }

    

    public function  tmasterDetail($id)
    {
        $tmaster_ItemCode_Distinct = Spodetail::where('po_no',$id)->distinct()->get(['ItemCode']);
        
        $tmaster_Branch_Distinct = Spodetail::where('po_no',$id)->distinct()->get(['Branch']);
        $arr = [];
        $global_data = DB::table('t_sysdata')->get()->all();
        foreach($global_data as $data){
           foreach($tmaster_Branch_Distinct as $branch)
            if($data->Branch == $branch->Branch){
                $arr[] = $data;
                break;
            }
        }
     

        $tmaster = Tmaster::find($id);
        $tmaster_template = $tmaster->getSpotmpl8hdrData;
        $po_no = $id;

        // $test = Spodetail::where('ItemCode','PCA-050')->where('Branch',28)->where('po_no',1)->get();
        // dd($test);  
        // $tmaster_detail  = $tmaster->getTmasterDetailData;        

    return view('stocktransfer/show',compact('tmaster_ItemCode_Distinct','arr','tmaster','tmaster_template','po_no'));
   
    }


    public function markToserved($id){

        $tmaster = Tmaster::where( 'po_no',$id)->update([
            'served'=>1
        ]);   

        
        return response()->json(array('msg'=>'success'), 200);   

    }




}
