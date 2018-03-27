<?php
use App\Spodetail;
use App\Srcvdetail;
?>
@extends('layouts.app')

@section('header_styles')
	<link href="{{ asset('css/my.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<div class="container-fluid">
<div class="row">
    
<div id="togle-sidebar-sec" class="active">
      
      <!-- Sidebar -->
       <div id="sidebar-togle-sidebar-sec">
      <ul id="sidebar_menu" class="sidebar-nav">
           <li class="sidebar-brand"><a id="menu-toggle" href="#">Menu<span id="main_icon" class="glyphicon glyphicon-align-justify"></span></a></li>
      </ul>
        <div class="sidebar-nav" id="sidebar">     
          <div id="treeview_json"></div>
        </div>
      </div>
          
      <!-- Page content -->
      <div id="page-content-togle-sidebar-sec">
		@if(Session::has('alert-class'))
			<div class="alert alert-success col-md-8 col-md-offset-2 alertfade"><span class="fa fa-close"></span><em> {!! session('flash_message') !!}</em></div>
		@elseif(Session::has('flash_message'))
			<div class="alert alert-danger col-md-8 col-md-offset-2 alertfade"><span class="fa fa-close"></span><em> {!! session('flash_message') !!}</em></div>
		@endif
             <div class="col-md-12">
			 <h3 class="text-center">Stock Transfer</h3>
    	<div class="row">    
            <div class="panel panel-default">
                <div class="panel-heading">
                    Stock Transfer
                
                   
                </div>
                <div class="panel-body">


               <!-- www -->
               <section class="content">
                      <!--main content-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel">
                              
                                <div class="panel-body">
                                    <div class="bs-example">
                                      	<ul class="nav nav-tabs" style="margin-bottom: 15px;">
                                          <li class="active">
                                              <a href="#access" data-toggle="tab">Auto stock transfer</a>
                                          </li>
                                          <li>
                                              <a href="#tasks" data-toggle="tab">Stock Delivery</a>
                                          </li>

                                        
                                      	</ul>
                                        <!-- 4 tabs start -->
                                        <div  class="tab-content" style="padding: 1em;">
                                            <!-- first order tab  -->
	                                            <div class="tab-pane fade active in" id="access" >

                                                <div class="col-md-12">

                                                    <div class="row" style="border:1px solid lightgray;padding: 7px 7px 0px 7px;">
                                                        <div class="col-md-4">
                                                            <p>P.O.#: <span>{{$tmaster->po_no}}</span></p>
                                                            <p>P.O.Template: 
                                                            <span>
                                                            @if($tmaster_template)
                                                            {{$tmaster_template->po_tmpl8_desc}}
                                                            @endif
                                                            </span></p>
                                                            <p>P.O.Date: <span>{{$tmaster->po_date}}</span></p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p style="color:red;">*THIS IS ORIGINAL P.O.</p>
                                                            <p>Total Pieces: <span style="color:red;">dvo-PO1</span></p>
                                                            <p>Total Amount: <span style="color:red;"></span></p>
                                                        </div>
                                                        <div class="col-md-4" style="    padding-top: 10px;">
                                                            <button class="btn btn-default" style="width:9em;float:right;">Print</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form class="form-horizontal has-validation-callback" action="#" method="POST" >
                                                 {{ csrf_field() }}
                                                <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="table-responsive">
                                                                 <table id="table_editable_1" class="col-sm-12 table table-striped table-bordered" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr >

                                                                            <th>Item Code</th>
                                                                            @foreach($arr as $data)
                                                                            <th  style="width:15%;">{{$data->ShortName}}</th>
                                                                            @endforeach
                                                                            <th  style="color:blue;width:15%;">TOTAL</th>
                                                                            <th style="color:red;">STOCK</th>
                                                                            <th>action</th>
                                                                   
                                                                        </tr>
                                                                    </thead>

                                                                        
                                                                    <tbody> 
                                                                            @php
                                                                            $rowNo = 1;
                                                                            @endphp
                                                                        @foreach($tmaster_ItemCode_Distinct as $item)
                                                                        <tr  class="editable"  data-id="{{$item->po_no}}">
                                                                            <td  class="input_ItemCode"  >{{$item->ItemCode}}</td>
                                                                            @php
                                                                            $no = 1;
                                                                            @endphp

                                                                            @foreach($arr as $data)
                                                                                @php
                                                                                $count = count($arr);
                                                                                $dataBasedOnBranches =  Spodetail::where('Branch',$data->Branch)->where('ItemCode',$item->ItemCode)->where('po_no',$po_no)->get();
                                                                                @endphp
                                                                            <td id="item_{{$rowNo}}_{{$no}}">

                                                                                <span class="value_Cost">@if(isset($dataBasedOnBranches[0])){{$dataBasedOnBranches[0]->Qty}}@endif</span>

                                                                                <input type="hidden" data-validation-error-msg="Invalid input: Please enter a number."  
                                                                                data-validation="number" data-validation-allowing="float"  data-validation-optional="true" class="input_Cost"
                                                                                style="-webkit-box-sizing: border-box;height: 30px;padding: 5px 10px;font-size: 12px;line-height: 1.5;border-radius: 3px;
                                                                                display: block;width: 100%;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;" 
                                                                                onkeyup="keyupInput({{$rowNo}},{{$count}})" >

                                                                                <span class="error{{$no}}"  style="display:none;color: #a94442;    font-style: italic;">invalid number</span>

                                                                            </td>
                                                                            @php
                                                                            $no ++;
                                                                            @endphp

                                                                            @endforeach

                                                                            
                                                                            <td class="edit_Cost text-right" data-field="Cost" >
                                                                                <span class="value_Cost">@if(isset($dataBasedOnBranches[0])){{$dataBasedOnBranches[0]->Qty+$dataBasedOnBranches[0]->ServedQty}}@endif</span>
                                                                            </td>
                                                                       
                                                                            <td style="text-align:right;">
                                                                            
                                                                            @php
                                                                                $sum = 0 ;
                                                                                $dataBals =  Srcvdetail::where('ItemCode',$item->ItemCode)->get();
                                                                            @endphp

                                                                            @foreach($dataBals as $dataBal)

                                                                            @php
                                                                            $sum += $dataBal->Bal ;
                                                                            @endphp
                                                                            
                                                                            @endforeach

                                                                            {{$sum}}

                                                                            </td>
                                                                            <td class="text-center" >
                                                                                <!-- <a class="btn btn-primary edit" >
                                                                                    <i class="fa fa-pencil"></i>
                                                                                </a> -->
                                                                                <a class="btn btn-primary btn-md blue-tooltip  edit" data-title="Edit"  onclick="editRow({{$rowNo}},{{$no}})"
                                                                                data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" >
                                                                                    <span class="glyphicon glyphicon-pencil"></span>
                                                                                </a>
                                                                            </td>

                                                                        </tr>

                                                                            @php
                                                                            $rowNo++;
                                                                            @endphp

                                                                        @endforeach
                                                                        
                                                                    </tbody>
                                                                </table>
                                                            </div>   
                                                        </div>

                                                    </div>
	                                            </div>
                                                </form>

                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <button class="btn btn-default" style="width:8em;"  onclick="goBack()"><span style="    margin-right: 7px;" class="glyphicon glyphicon-arrow-left"></span>Back</button>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <button onclick="myFunction()" class="btn btn-info" style="background-color:green;width:9em;float:right;" >Transfer Stocks</button>
                                                        </div>
                                                    </div>    
                                                </div>



	                                              <!-- second product tab -->
	                                            <div class="tab-pane fade " id="tasks">

                                                        <!--  -->
                                                            <div class="row">
                                                                <div class="table-responsive">
                                                                <table id="list_menu_delivery" class="col-sm-12 table table-striped table-bordered" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>D.R.No</th>
                                                                            <th>Date</th>
                                                                            <th>Destination</th>
                                                                            <th>Rcvd</th>
                                                                            <th>Uploaded</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                
                                                                    <tbody >
                                                                            
                                                                   
                                                                            
                                                                    </tbody>

                                                                    </table>
                                                                </div>   
                                                            </div>
                                                    </div>
                                                        <!--  -->

                                                </div>
	                                            
                                           
     
                                        </div>
                                                <!-- 4 tabs end -->

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>


                </section>
              
                <!-- www -->



                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
<script src="http://onebusiness.shacknet.biz/OneBusiness/js/table-edits.min.js"></script>
<script src="http://onebusiness.shacknet.biz/OneBusiness/js/momentjs.min.js"></script>
<script src="http://onebusiness.shacknet.biz/OneBusiness/js/bootstrap-datetimepicker.min.js"></script>
<script>

$(document).ready(function() {

    $('#stockDetail').DataTable({
    "dom": '<"m-t-10"B><"m-t-10 pull-left"><"m-t-10 pull-right">rt<"pull-left m-t-10"i><"m-t-10 pull-right"p>',
   
    });

            // $("table tr").editable({

            //     // enable keyboard support
            //     keyboard: true,

            //     // double click to start editing
            //     dblclick: true,

            //     // enable edit buttons
            //     button: true,

            //     // CSS selector for edit buttons
            //     buttonSelector: ".edit",

            //     // uses select dropdown instead of input field
            //     dropdowns: {},

            //     // maintains column width when editing
            //     maintainWidth: true,

            //     // callbacks for edit, save and cancel actions

            //     edit: function(values) {
            //         // alert('edit');
            //     },
            //     save: function(values) {
            //         alert('save');
            //     },
            //     cancel: function(values) {
            //         // alert('cancel');
            //     }

            // });

});


function keyupInput(rowNo,count){

    for( var i = 1; i <=count ; i ++) {

     if( !( $('#item_'+rowNo+'_'+i).find('.input_Cost').val().match(/^-?\d+(?:[.]\d*?)?$/) ) ){

        $('#item_'+rowNo+'_'+i).find('.error'+i).show();
        $('#item_'+rowNo+'_'+i).find('.edit').attr('disabled', "");
        }
        else{
        $('#item_'+rowNo+'_'+i).find('.error'+i).hide();
        $('#item_'+rowNo+'_'+i).find('.edit').removeAttr('disabled');
        }
    }
}

function editRow(rowNo,count){

    if($('#item_'+rowNo+'_1').parents('.editable').find('.glyphicon').hasClass('glyphicon-pencil'))
    {
        $('#item_'+rowNo+'_1').parents('.editable').find('.glyphicon').removeClass('glyphicon-pencil').addClass('glyphicon-ok');
    
        for ( var i = 1; i < count ; i ++){

            $('#item_'+rowNo+'_'+i).find( ".input_Cost" ).val($('#item_'+rowNo+'_'+i).find('.value_Cost').text().replace(',', '')).attr("type", "text") ;
            $('#item_'+rowNo+'_'+i).find('.value_Cost').text("");
        }
    }
    else
    {
        $('#item_'+rowNo+'_1').parents('.editable').find('.glyphicon').removeClass('glyphicon-ok').addClass('glyphicon-pencil');
        
        for ( var i = 1; i < count ; i ++)
        {

            if($('#item_'+rowNo+'_'+i).find( ".input_Cost" ).val()!="")
                {
                    $('#item_'+rowNo+'_'+i).find('.value_Cost').text( parseFloat($('#item_'+rowNo+'_'+i).find( ".input_Cost" ).val()) )
                }
            else
            {
                $('#item_'+rowNo+'_'+i).find('.value_Cost').text('0');
            }

            $('#item_'+rowNo+'_'+i).find( ".input_Cost" ).attr("type", "hidden");
        }

    }


}


// $('body').on('keyup', '.input_Cost', function(){

//     var self = $(this);

//     if( !( $(this).parents('.editable').find('.input_Cost').val().match(/^-?\d+(?:[.]\d*?)?$/) ) ){

//     $(this).parents('.editable').find('.error').show();
//     $(this).parents('.editable').find('.edit').attr('disabled', "");
//     }
//     else{
//     $(this).parents('.editable').find('.error').hide();
//     $(this).parents('.editable').find('.edit').removeAttr('disabled');
//     }

// })

// $('body').on('click', '.edit', function(){
//       var self = $(this);


// if($(this).find('span').hasClass('glyphicon-pencil'))
//       {

//         $(this).find('span').removeClass('glyphicon-pencil').addClass('glyphicon-ok');

//         $(this).parents('.editable').find( ".input_Cost" ).val($(this).parents('.editable').find('.value_Cost').text().replace(',', '')).attr("type", "text") ;

//         $(this).parents('.editable').find('.value_Cost').text("");

//       } 
//     else{
            
            
//         $(this).find('span').removeClass('glyphicon-ok').addClass('glyphicon-pencil');
//         if( self.parents('.editable').find('.input_Cost').val() != "" )
//         {
//           self.parents('.editable').find('.value_Cost').text( parseFloat(self.parents('.editable').find('.input_Cost').val()).toFixed(2) );
//         }
//         else
//         {
//           self.parents('.editable').find('.value_Cost').text('0.00');
//         }   
//         self.parents('.editable').find( ".input_Cost" ).attr("type", "hidden");

//     }
    
//   });


function goBack() {
    window.history.back();
}



function myFunction() {
    confirm("Are you sure you want to transfer these items");
}



</script>



@endsection


