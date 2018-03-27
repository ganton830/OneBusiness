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
                    
                <div class="row">
                    <div class="col-xs-9">
                        <h4>Stock Transfer</h4>
                    </div>
                    <div class="col-xs-3"  id="addNewTransfer" >


                        <!-- <a href="http://onebusiness.shacknet.biz/OneBusiness/stocks/create?corpID=7" class="pull-right">Add Stock</a> -->
                        
                        
                    </div>
               
                    </div>   
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
                                              <a href="#access" data-toggle="tab"  onclick="showHidden(false)">Auto stock transfer</a>
                                          </li>
                                          <li>
                                              <a href="#tasks" data-toggle="tab" onclick="showHidden(true)">Stock Delivery</a>
                                          </li>
                                   
                                        
                                      	</ul>
                                        <!-- 4 tabs start -->
                                        <div  class="tab-content" style="padding: 1em;">
                                            <!-- first order tab  -->
	                                            <div class="tab-pane fade active in" id="access" >
	                                                <div class="row">
	                                                	<div class="table-responsive">
										                   <table id="list_menu" class="col-sm-12 table table-striped table-bordered" cellspacing="0" width="100%">
										                        <thead>
										                            <tr>
										                                <th>P.O.#</th>
										                                <th>P.O.Date</th>
										                                <th>P.O.Template</th>
										                                <th>Status</th>
										                                <th>Total Count</th>
										                                <th>Total Amount</th>
										                                <th>Action</th>
										                            </tr>
										                        </thead>
										                        <tbody>
                                                                @foreach ($tmaster_data as $item) 
										                        	<tr  id="emp{{$item->po_no}}">
										                            <td>{{$item->po_no}}</td>
											                        <td>{{$item->po_date}}</td>
											                        <td>
                                                                        @php
                                                                        $template = $item->getSpotmpl8hdrData;
                                                                        @endphp
                                                                        @if($template)
                                                                        {{$template->po_tmpl8_desc}}
                                                                        @endif
                                                                    </td>
											                        <td 
                                                                    @if($item->served==0)
                                                                    Unserved
                                                                    @elseif($item->served==1)
                                                                    Served
                                                                    @endif
                                                                    </td>
											                        <td  style="text-align: center;">{{number_format($item->tot_pcs)}}</td>
											                        <td  style="text-align: right;">{{number_format((float)$item->total_amt, 2)}}</td>
											                        <td  style="text-align: center;">

                                                                        <a class="btn btn-success btn-md blue-tooltip " data-title="View PO Details"
                                                                            href="{{ route('tmaster.details',$item->po_no) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="view PO detail">
                                                                            <span class="glyphicon glyphicon-eye-open"></span>
                                                                        </a>
                                                                      
                                                                        <a class="btn btn-primary btn-md blue-tooltip " data-title="View original Details" 
                                                                            href="{{ route('tmaster.originaldetails',$item->po_no) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="view original detail">
                                                                            <span class="glyphicon glyphicon-eye-open"></span>
                                                                        </a>
                                                                       
                                                                        <a class="btn btn-danger btn-md blue-tooltip " data-title="Edit" onclick="markToserved({{$item->po_no}})"
                                                                            data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Corporation">
                                                                            <span class="glyphicon glyphicon-ok"></span>
                                                                        </a>
                                                                        

											                        	 <!-- <a  href="{{ route('tmaster.details',$item->po_no) }}"  class="filterIcon1"><span class="glyphicon glyphicon-eye-open"></span></a>   -->
											                        	 <!-- <a  class="filterIcon1"><span class="glyphicon glyphicon-pencil"></span></a>  -->
                                             
											                        </td>
											                        </tr>
                                                                    @endforeach

											                      <!--   <span class="glyphicon glyphicon-eye-open"></span>
											                        <span class="glyphicon glyphicon-pencil"></span>
											                        <span class="glyphicon glyphicon-ok"></span> -->
											                        
										                        </tbody>
										                    </table>
										                </div>   
	                                                </div>
	                                            </div>
	                                              <!-- second product tab -->
	                                            <div class="tab-pane fade " id="tasks" >

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
                                                                            
                                                                    @foreach ($delivery_data as $item) 
                                                                        <tr  class="editable"   data-id="1">
                                                                            <td  data-field="Txfr_ID">{{$item->Txfr_ID}}</td>
                                                                            <td  data-field="Txfr_Date">{{$item->Txfr_Date}}</td>
                                                                            <td  data-field="Destination"></td>
                                                                            <td  style="text-align:center;">
                                                                            @if($item->Rcvd==1)
                                                                                <input type="checkbox" checked disabled class="rcvdCheckbox{{$item->Txfr_ID}}">
                                                                            @else
                                                                                <input type="checkbox" disabled  class="rcvdCheckbox{{$item->Txfr_ID}}">
                                                                            @endif
                                                                            </td>
                                                                            <td  style="text-align:center;">
                                                                            @if($item->Uploaded==1)
                                                                                <input type="checkbox" checked  disabled class="uploadCheckbox{{$item->Txfr_ID}}">
                                                                            @else
                                                                                <input type="checkbox"  disabled class="uploadCheckbox{{$item->Txfr_ID}}">
                                                                            @endif
                                                                            </td>
                                                                            <td  style="text-align:center;">

                                                                            <a class="btn btn-primary btn-md blue-tooltip edit" data-title="Edit"  onclick="onEditRow({{$item->Txfr_ID}})"

                                                                                 data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Corporation">
                                                                                <span  id="editable{{$item->Txfr_ID}}" class="glyphicon glyphicon-pencil"></span>
                                                                             </a>
                                                                            <a class="btn btn-danger btn-md sweet-4 red-tooltip " data-title="Delete" href="#" rel=""
                                                                                id="11" corp-name="Corp test" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete Corporation">
                                                                                <span class="glyphicon glyphicon-trash"></span>
                                                                            </a>


                                                                                <!-- <a  class="filterIcon1 edit"><span class="glyphicon glyphicon-pencil"></span></a>        
                                                                                <a  class="filterIcon1"><span class="glyphicon glyphicon-trash"></span></a>         -->

                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                            
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

    

    $('#list_menu').DataTable({
    "dom": '<"m-t-10"B><"m-t-10 pull-left"l><"m-t-10 pull-right"f><"#selectId">rt<"pull-left m-t-10"i><"m-t-10 pull-right"p>',
   
    });

    $("#selectId").append('<div class="filterDiv1"><label class="filterLabel1">Filters </label><select onChange="filter()" class="filterSelect1"><option value="1">Unserved</option><option value="2">Served </option><option value="3">All </option></select></div>');
    // $('[data-toggle="tooltip"]').tooltip(); 

      $('#list_menu_delivery').DataTable({
    "dom": '<"m-t-10"B><"m-t-10 pull-left"l><"m-t-10 pull-right"f><"#selectId_1">rt<"pull-left m-t-10"i><"m-t-10 pull-right"p>',
   
    });

    $("#selectId_1").append('<div class="filterDiv1"><label class="filterLabel1">Filters </label><select class="filterSelect2"><option value="1">In-transit</option><option value="2">Received</option><option value="3">All </option></select></div>');
    // $('[data-toggle="tooltip"]').tooltip(); 

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
            @if($status==1)       
                    $('.filterSelect1').val(1)
            @elseif($status==2)     
                    $('.filterSelect1').val(2)
            @elseif($status==3)     
                    $('.filterSelect1').val(3)
            @endif

});



function onEditRow(param){

    
    if($('#editable'+param).hasClass('glyphicon-pencil')){

         $(".rcvdCheckbox"+param).attr("disabled", false);
         $(".uploadCheckbox"+param).attr("disabled", false);
    }
    else{

         $(".rcvdCheckbox"+param).attr("disabled", true);
         $(".uploadCheckbox"+param).attr("disabled", true);
         
    }
    
}

// $('#tasks').click(function(){
//     alert('ssss');
// })

function showHidden(p){
    if(p==true)
    $('#addNewTransfer').append('<a href="{{route('stocktransfer.create' , ['corpID' => '7'] )}}"  class="pull-right">New Stock Transfer</a>');
    else
    $('#addNewTransfer').empty();
}

</script>

<script>
    var tmasterId;
    var urlmarkToserved;


    function filter(){
        var selectedValue = $('.filterSelect1').val();
        document.location.href="?status="+selectedValue;
    }


    function markToserved(id){

    tmasterId = id;
    urlmarkToserved=tmasterId+'/markToserved';


        $.ajax(
        {
        url : urlmarkToserved,
        type : 'GET',
        success: function(response)
        {
            
            $('#emp'+tmasterId).addClass('selected');
            var table = $('#emp'+tmasterId).closest('table').DataTable();
            table.row('.selected').remove().draw( false );
            $('#emp'+tmasterId).closest('table').DataTable().destroy();
            $('#delete_confirm').modal('hide');            
            // alert(response)
            // $(this).prev().click()
            alert('success');
        }
        
        });
    }
</script>

<script>
    $(function() {
        
        // $("input.rcvdCheckbox").attr("disabled", true);
      var pickers = {};

      $('table tr').editable({
          
        dropdowns: {
          sex: ['Male', 'Female']
        },
        edit: function(values) {
           
          $(".edit span", this)
            .removeClass('glyphicon-pencil')
            .addClass('glyphicon-ok')
            .attr('title', 'Save');

           

        //   pickers[this] = new Pikaday({
        //     field: $("td[data-field=birthday] input", this)[0],
        //     format: 'MMM D, YYYY'
        //   });
        },
        save: function(values) {
          $(".edit span", this)
            .removeClass('glyphicon-ok')
            .addClass('glyphicon-pencil')
            .attr('title', 'Edit');

           

          if (this in pickers) {
            pickers[this].destroy();
            delete pickers[this];
          }
        },
        cancel: function(values) {
          $(".edit i", this)
            .removeClass('glyphicon-ok')
            .addClass('glyphicon-pencil')
            .attr('title', 'Edit');

          if (this in pickers) {
            pickers[this].destroy();
            delete pickers[this];
          }
        }
      });
    });
  </script>
@endsection


