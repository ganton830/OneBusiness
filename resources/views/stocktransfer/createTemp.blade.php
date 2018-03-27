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
                                                        <!-- table place -->
										                                </div>   
	                                                </div>
	                                            </div>
	                                              <!-- second product tab -->
	                                            <div class="tab-pane fade " id="tasks" >
                                                  <div class="row">
                                                       <!--add part  -->
                                                       <form class="form-horizontal" action="{{ route('stocks.store', [ 'corpID' => $corpID]) }}" method="POST" >
            {{ csrf_field() }}
            <input type="hidden" name="corpID" value="{{$corpID}}" >
          <div class="panel-body" style="margin: 30px 0px;">
            <div class="row" style="margin-bottom: 20px;">
                <div class="form-group">
                  <div class="col-sm-6">
                    <label class="control-label col-sm-2">
                        P.O#:
                      </label>
                      <div class="col-sm-4">
                        <select name="po" id="PO" class="form-control"  >
                          <option value=""></option>
                          @foreach($pos as $po)
                            <option value="{{$po->po_no}}" >{{$po->po_no}}</option>
                          @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-6">
                    <label class="control-label col-sm-2">
                      D.R#:
                    </label>
                    <div class="col-sm-5">
                      <input type="text" data-validation="required,length" data-validation-length="max12" data-validation-error-msg="D.R.# is required" data-validation-error-msg-length="D.R.# should not exceed 12 characters" class="form-control" name="RR_No"   >
                    </div>

                    <label class="control-label col-sm-1">
                      Date
                    </label>
                    <div class="col-sm-4">
                      <input type="date" class="form-control" name="RcvDate" id="" value="{{date('Y-m-d')}}" >
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-6">
                    <label class="control-label col-sm-2">
                      VENDOR
                    </label>
                    <div class="col-sm-10">
                      <select name="Supp_ID" class="form-control" >
                        @foreach($vendors as $vendor)
                          <option value="{{$vendor->Supp_ID}}">{{$vendor->VendorName}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <a class="pull-right btn btn-success {{ \Auth::user()->checkAccessByIdForCorp($corpID, 35, 'A') ? "" : "disabled" }} " id="pressF2" >
                    Add Row
                    <br>
                    (F2)
                    </a>
                  </div>
                </div>
                
            </div>
            <div class="table-responsive">
              <table id="table_editable" class="table table-bordered" style="width: 100% !important; dispaly: table;" >
                <tbody>
                  <tr>
                    <th style="max-width: 100px;margin: 0px;box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;">Item Code</th>
                    <th>Product Line</th>
                    <th>Brand</th>
                    <th>Description</th>
                    <th>Cost/Unit</th>
                    <th>Served</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Unit</th>
                    <th style="min-width: 100px;">Action</th>
                  </tr>

                  <tr class="editable" id="example" data-id="" style="display: none;">
                    <input type="hidden" name="add_type[]" class="input_type" value="add">
                    <td class="edit_ItemCode"  data-field="ItemCode" >
                      <span class="value_ItemCode"></span>
                      <input class="input_old_item_id" type="hidden" name="add_old_item_id[]" value="" >
                      <input class="input_item_id" type="hidden" name="add_item_id[]" value="" >
                      <input autocomplete="off" class="show_suggest input_ItemCode" type="hidden" name="add_ItemCode[]" id="" value="" >
                    </td>
                    <td class="edit_Prod_Line" data-field="Prod_Line" >
                      <span class="value_Prod_Line"></span>
                      <input autocomplete="off" class="show_suggest input_Prod_Line" type="hidden" name="add_Prod_Line[]" value="" >
                    </td>
                    <td class="edit_Brand" data-field="Brand" >
                      <span class="value_Brand"></span>
                      <input autocomplete="off" class="show_suggest input_Brand" type="hidden" name="add_Brand[]" id="" value="" >
                    </td>
                    <td class="edit_Description" >
                      <span class="value_Description"></span>
                    </td>
                    <td class="edit_Cost text-right" data-field="Cost" >
                    <span class="value_Cost"></span>
                      <input type="hidden" class="input_Cost" data-validation-error-msg="Invalid input: Please enter a number." data-validation="number" data-validation-allowing="float" data-validation-optional="true"  name="add_Cost[]" id="" value="" >
                    </td>
                    <td class="edit_ServedQty text-right" >
                      <span class="value_ServedQty"></span>
                    </td>
                    <td class="edit_Qty text-right" data-field="Qty" >
                      <span class="value_Qty"></span>
                      <input type="hidden" class="input_Qty"  data-validation-error-msg="Invalid input: Please enter a number."  data-validation="number" data-validation-allowing="float" data-validation-optional="true" name="add_Qty[]" id="" value="" >
                    </td>
                    <td class="edit_Sub text-right" >
                      <span class="value_Sub"></span>
                      <input type="hidden" class="input_Sub"  data-validation-error-msg="Invalid input: Please enter a number."  data-validation="number" data-validation-allowing="float" data-validation-optional="true" name="add_Sub[]" id="" value="" >
                    </td>
                    <td class="edit_Unit" >
                      <span class="value_Unit"></span>
                    </td>
                    <td class="text-center" >
                      <a class="btn btn-primary edit {{ \Auth::user()->checkAccessByIdForCorp($corpID, 35, 'E') ? "" : "disabled" }} " >
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a href="#" class="delete_row btn btn-danger {{ \Auth::user()->checkAccessByIdForCorp($corpID, 35, 'D') ? "" : "disabled" }} " >
                        <i class="fa fa-trash"></i>
                      </a>
                    </td>
                  </tr>

                  <tr class="" id="add-row" style="display: none;">
                    <input type="hidden" name="item_id" value="" class="input_item_id">
                    <td> <input autocomplete="off" type="text" name="ItemCode" class="form-control check_focus input_ItemCode"> </td>
                    <td> <input autocomplete="off" type="text" name="Prod_Line" class="form-control check_focus input_Prod_Line"> </td>
                    <td> <input autocomplete="off" type="text" name="Brand" class="form-control check_focus input_Brand"> </td>
                    <td> <input type="text" name="Description" id="" class="form-control input_Description"> </td>
                    <td> <input type="text" name="Cost" id="" data-validation-error-msg="Invalid input: Please enter a number."  data-validation="number" data-validation-allowing="float"  data-validation-optional="true" class="form-control input_Cost"> </td>
                    <td>0</td>
                    <td> <input type="text" name="Qty" id=""  data-validation-error-msg="Invalid input: Please enter a number."  data-validation="number" data-validation-allowing="float" value="1" data-validation-optional="true" class="input_Qty form-control"> </td>
                    <td> <input type="text" name="Sub" id=""  data-validation-error-msg="Invalid input: Please enter a number."  data-validation="number" data-validation-allowing="float" data-validation-optional="true" class="input_Sub form-control"> </td>
                    <td class="input_Unit" ></td>
                    <td class="text-center" >
                      <a class="btn btn-primary add_detail {{ \Auth::user()->checkAccessByIdForCorp($corpID, 35, 'A') ? "" : "disabled" }}" 
                        href="javascript:void(0);">
                        <i class="fa fa-check"></i>
                      </a>
                      <a type="button" data-href="#"  class="btn btn-danger delete_add_detail {{ \Auth::user()->checkAccessByIdForCorp($corpID, 35, 'D') ? "" : "disabled" }}" href="javascript:void(0);">
                        <i class="fa fa-trash"></i>
                      </a>
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>


            <table class="table table-bordered" id="recommend-table" style=" display: none; " >
              <thead>
                <tr style="display:table;width:99%;table-layout:fixed; background:  #f27b82" >
                  <th>Item Code</th>
                  <th>Product Line</th>
                  <th>Brand</th>
                  <th>Description</th>
                  <th>Unit</th>
                  <th>Unit Cost</th>
                </tr>
              </thead>
              <tbody style="display:block; max-height:300px; overflow-y:scroll; background: #f4b2b6;">
                @foreach($stockitems as $stockitem )
                  <tr class="recommend_row" style="display:table;width:100%;table-layout:fixed;" >
                    <td class="recommend_item_id" style="display: none;">{{$stockitem->item_id}} </td>
                    <td class="recommend_itemcode" >{{$stockitem->ItemCode}}</td>
                    <td class="recommend_prod_line" >{{$stockitem->product_line->Product}} </td>
                    <td class="recommend_prod_line_id" style="display: none;" >{{$stockitem->Prod_Line}} </td>
                    <td class="recommend_brand"  >{{$stockitem->brand->Brand}}</td>
                    <td class="recommend_brand_id" style="display: none;" >{{$stockitem->Brand_ID}}</td>
                    <td class="recommend_description">{{$stockitem->Description}}</td>
                    <td class="recommend_unit">{{$stockitem->Unit}}</td>
                    <td class="recommend_cost">{{$stockitem->LastCost}}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>

            <div class="row" style="margin-top: 200px;">
              <div class="col-sm-3 pull-right">
                <h4>
                  <strong>TOTAL AMOUNT:</strong>
                  <span id="total_amount" style="color:red">0.00</span>
                  <input type="hidden" name="total_amt" id="total_amt">
                </h4>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <a type="button" class="btn btn-default" href="{{ route('stocks.index', [ 'corpID' => $corpID]) }}">
                  <i class="fa fa-reply"></i> Back
                </a>
              </div>
              <div class="col-md-6">
                <button type="button" data-toggle="modal" class="btn btn-success pull-right save_button {{ \Auth::user()->checkAccessByIdForCorp($corpID, 35, 'A') ? "" : "disabled" }} " >
                  Save
                </button>
              </div>
            </div>

                <!-- Modal alert -->
                <div class="modal fade" id="confirm_save" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">
                          <strong>Confirm Save</strong>
                        </h4>
                      </div>
                      <div class="modal-body">
                        <p> Are you sure you want to save? </p>
                        <div class="checkbox">
                          <label> <input type="checkbox" name="PrintRR" id=""> Print RR Stub </label>
                        </div>
                      </div>
                      <div class="modal-footer" style="margin-top: 100px;">
                        <div class="col-md-6">
                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            <i class="fa fa-reply"></i> Back  
                          </button>
                        </div>
                        <div class="col-md-6">
                          <button class="btn btn-primary" id="submit-form" type="submit">Save</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End modal alert -->


          </div>
        </form>
                                                       <!-- end add -->
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

function showHidden(p){
    if(p==true)
    $('#addNewTransfer').append('<a href="{{route('stocktransfer.create' , ['corpID' => '7'] )}}"  class="pull-right">New Stock Transfer</a>');
    else
    $('#addNewTransfer').empty();
}

</script>


@endsection


