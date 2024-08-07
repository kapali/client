@extends('layouts.app')

@section('content')
<link href="{{ asset(CNF_THEME.'/js/datatable/jquery.dataTables.min.css')}}" rel="stylesheet">		

	<script type="text/javascript" src="{{ asset(CNF_THEME.'/js/datatable/download/jquery.dataTables.min.js')}}"></script> 
	<script type="text/javascript" src="{{ asset(CNF_THEME.'/js/datatable/download/dataTables.buttons.min.js')}}"></script> 
	<script type="text/javascript" src="{{ asset(CNF_THEME.'/js/datatable/download/buttons.flash.min.js')}}"></script> 
	<script type="text/javascript" src="{{ asset(CNF_THEME.'/js/datatable/download/jszip.min.js')}}"></script> 
	<script type="text/javascript" src="{{ asset(CNF_THEME.'/js/datatable/download/pdfmake.min.js')}}"></script> 
	<script type="text/javascript" src="{{ asset(CNF_THEME.'/js/datatable/download/vfs_fonts.js')}}"></script> 
	<script type="text/javascript" src="{{ asset(CNF_THEME.'/js/datatable/download/buttons.html5.min.js')}}"></script> 
	<script type="text/javascript" src="{{ asset(CNF_THEME.'/js/datatable/download/buttons.print.min.js')}}"></script>
<div class="page-header"><div class=""><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>
<div class="">
  <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
        <li class="breadcrumb-item active">{{ $pageTitle }}</li>
      </ul>	  
</div>
</div>
<div class="m-sm-4 m-3 box-border">
	<div class="sbox-title"> 
		<h5> <i class="fa fa-table"></i> </h5>
		<div class="sbox-tools">
			@if( \Request::query('search') != '' )
			<a href="{{ URL::to($pageModule) }}" style="display: block ! important;" class="btn btn-xs btn-white tips" title="Clear Search" >
			<i class="fa fa-trash-o"></i> {!! trans('core.abs_clr_search') !!} 
			</a>
			@endif
			<a href="#" class="btn btn-xs btn-white tips" title="" data-original-title=" Configuration">
			<i class="fa fa-cog"></i>
			</a>	 
		</div>
	</div>
	<div class="toolbar-nav px-1" >   
		<div class="">
		   <div class="col-md-8 my-1 button-chng"> 	
				<!-- @if($access['is_add'] ==1)
				<a href="{{ url('cashondeliveryorder/create?return='.$return) }}" class="btn  btn-sm"  
					title="{{ __('core.btn_create') }}"><i class=" fa fa-plus "></i> search</a>
				@endif
			-->
			<button type="button" class="tips btn btn-sm btn-white search_pop_btn" data-toggle="modal" ><i class="fa fa-search"></i> Search</button> 
		   </div>

			{{-- <div class="btn-group">
					<button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars"></i> Bulk Action </button>
			        <ul class="dropdown-menu">
			        @if($access['is_remove'] ==1)
						 <li class="nav-item"><a href="javascript://ajax"  onclick="SximoDelete();" class="nav-link tips" title="{{ __('core.btn_remove') }}">
						Remove Selected </a></li>
					@endif 
					@if($access['is_add'] ==1)
						<li class="nav-item"><a href="javascript://ajax" class=" copy nav-link " title="Copy" > Copy selected</a></li>
						<div class="dropdown-divider"></div>
						<li class="nav-item"><a href="{{ url($pageModule .'/import?return='.$return) }}" onclick="SximoModal(this.href, 'Import CSV'); return false;" class="nav-link "> Import CSV</a></li>

						
					@endif 	 	
			    </div>    
			</div> 
			<div class="col-md-4 text-right">
				<div class="input-group ">
				    <div class="input-group-prepend">
				        <button type="button" class="btn btn-default btn-sm " >
				        	<!--  onclick="SximoModal('{{ url($pageModule."/search") }}','Advance Search'); " >
				        	<i class="fa fa-search"></i> search </button>
				        </div>
				       	<!-- /btn-group -->
				      	<input type="text"  class="form-control form-control-sm onsearch" data-target="{{ url($pageModule) }}" aria-label="..." >
				  		<td id="field_order_details"><input type="text" name="order_details" data-name="order_details" class="form-control input-sm search_pop" value=""></td>

				    </div>
				</div>    
			</div>	 --}}
	    </div>
	</div>    
		<div class="p-3">
			<div class="table-container m-0" >


				<!-- Table Grid -->

				{!! Form::open(array('url'=>'cashondeliveryorder?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}

				<table class="table  table-hover" id="{{ $pageModule }}Table">
					<thead>
						          <tr>                                
	                                <th> Order Id </th>
	                                <th> Date </th>                                                     
	                                <th> Ordered Time </th> 
	                                <th>Cust Name</th>
	                                @if(\Auth::user()->group_id!='3')
	                                <th>Cust Mobile</th>
	                                @endif
	                                <th> Shop Name </th>
	                                <th> Grand Total </th>
	                                <th>Delivery Boy</th>
	                                <th> Status </th>
	                                <th> {!! trans('core.time') !!} </th>   
	                                <th> Payment Status </th>
	                                <th> {!! trans('core.abs_payment_type') !!}</th>
	                                @if(PICKDEL_OPTION == 'enable')
	                                <th> Customer Preference </th>
	                                @endif
	                                @if(PREORDER_OPTION == 'enable')
	                                <th> Order Type </th>
	                                @endif
	                                <th width="70" >View</th>
	                            </tr>
								
							</tr>
						</thead>

						<tbody>        						
						@foreach ($rowData as $key => $row)
	                            <?php $res_call = \AbserveHelpers::getRestaurantDetails($row->res_id); 
	                                    date_default_timezone_set("Asia/Kolkata"); ?>
	                                    
	                                    <tr @if($row->delivery_type=='razorpay' && $row->delivery =='unpaid') style="background-color: #FBD9D9" @endif>                         
	                                        <td>{{$row->id}}</td>   
	                                        <td>{{\AbserveHelpers::getdateformat($row->date)}}</td> 
	                                        <td>{{date('g:i a',$row->time)}}</td>
	                                        <td>{{ AbserveHelpers::getuname($row->cust_id) }}</td>	
	                                        @if(\Auth::user()->group_id!='3')                       
	                                        <td>{{$row->mobile_num}}</td>
	                                        @endif
	                                        <td> {{ AbserveHelpers::restsurent_name($row->res_id) }} </td>
	                                        @if(\Auth::user()->group_id == '1')
	                                        <td>{{($row->accept_grand_total > 0) ? \AbserveHelpers::CurrencyValueBackend($row->accept_grand_total - $row->cash_offer) : \AbserveHelpers::CurrencyValueBackend($row->grand_total - $row->cash_offer)}}</td>
	                                        @else
	                                        <td>{{($row->accept_grand_total > 0) ? \AbserveHelpers::CurrencyValueBackend($row->accept_grand_total - $row->cash_offer) : \AbserveHelpers::CurrencyValueBackend($row->grand_total - $row->cash_offer)}}</td>
	                                        @endif
	                                        <td>{!! AbserveHelpers::getboyname($row->id) !!} </td>
	                                        <td>
	                                       <span class="label status {{  \AbserveHelpers::getStatusLabel($row->status) }}">{{ \AbserveHelpers::getStatusTiming($row->status) }}</span>
	                                        </td>
	                                        <td>{{\AbserveHelpers::getOrderStatusTime($row->id,$row->status)}}</td>
	                                        <td>{!! ($row->delivery =='paid' ? '<span class="label label-success">Paid</span>' : '<span class="label label-danger">Unpaid</span>')  !!}</td>
	                                        <td>{{ $row->delivery_type }}</td> 
	                                        @if(PICKDEL_OPTION == 'enable')
	                                        <td>{{ strtoupper($row->delivery_preference) }}</td>
	                                        @endif
	                                        <td>{{ strtoupper($row->order_type) }}</td>
	                                        <td>
												  @if($row->is_dispute==1)
												  <a href="javascript:void(0);" ><span class="label label-danger">Dispute already sent</span></a>
												  @else
												  <a href="javascript:void(0);" class="dispute" data-id="{!!$row->id!!}"><span class="label label-info">Dispute</span></a>
												  @endif
												  
												  <a href="javascript:void(0);" class="btn order-details" data-id="{!!$row->id!!}"><i class="fa fa-info-circle"></i></a>
											</td>
	                                    </tr>
	                       

								
								@endforeach

							</tbody>

						</table>
						<input type="hidden" name="action_task" value="" />

						{!! Form::close() !!}


						<!-- End Table Grid -->
	        </div>
		</div>
</div>
			@include('footer')
			@include('admin/search')

			<script>
				$(document).ready(function(){
					$('.copy').click(function() {
						var total = $('input[class="ids"]:checkbox:checked').length;
						if(confirm('are u sure Copy selected rows ?'))
						{
							$('input[name="action_task"]').val('copy');
			$('#SximoTable').submit();// do the rest here	
		}
	})	

				});	
			</script>	



			<div class="modal fade" id="orderModal" role="dialog">
				<div class="modal-dialog modal-lg">
					<div class="modal-content order-content">

					</div>
				</div>
			</div>
			<div id="hidden_block" style="display:none;">
				<b>Select Dispute Category:</b>
				<select class="form-control" required name="dispute_category_id" id="dispute_category_id">
					<option value="0">Please select</option>

				</select>
				<span id="category_error" style="color:red;" ></span><BR>
				<BR>
				</div>

				<script>
					$(document).on("click",'.dispute',function(){

						var oid = $(this).attr('data-id');
						$(".modal-dialog").addClass(" modal-sm").removeClass(" modal-lg");
						$(".order-content").html('<div class="modal-header"><button type="button" class="close" data-dismiss="modal" id="modal_close">&times;</button><h4 class="modal-title">Notification</h4></div><div class="modal-body">'+

							'<div id="import_select"></div>'+
							'<b>Dispute Reason:</b><textarea class="form-control" id="dispute_reason"></textarea><span id="reason_error" style="color:red;" ></span></div><div class="modal-footer"><button class="btn btn-success" type="button" id="dispute_submit">Submit</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>');
						$("#hidden_block").css("display","block");
						$("#import_select").append($("#hidden_block").html());

						$("#dispute_submit").attr('data-oid',oid);
						$('#orderModal').modal('show');

					});
					$(document).on("click",'#dispute_submit',function(){ 

						var oid = $(this).attr('data-oid');
						var reason = $("#dispute_reason").val();
						var dispute_category_id = $("#dispute_category_id").val();
						if(dispute_category_id == 0){
							$("#category_error").html("Dispute category is empty!"); 

							event.preventDefault();
						}
						if($.trim(reason).length > 0 && dispute_category_id != 0 ){
							$("#dispute_submit").attr('disabled','true');

							$.ajax({
								type : 'POST',
								url : base_url+'/orders/dispute',
								data : {
									oid : oid,reason:reason, dispute_category_id:dispute_category_id
								},
								success:function(result){

									$('.message-control').show().html(result.message);

									setTimeout(function(){

										$('.message-control').hide();

										window.location.reload();

									},3000);

								}
							});
						}else if($.trim(reason).length == 0){

							$("#reason_error").html("Reason field is empty!"); 
						}

					});
					$(document).on("click",'#modal_close',function(){ 
						$("#modal_close").css("display","none");
					});
					$(document).on("click",'#dispute_category_id',function(){
						if($("#dispute_category_id").val() != 0)
							$("#category_error").html(""); 
						else
							$("#category_error").html("Dispute category is empty!"); 	
					});

					$(document).on("keyup",'#dispute_reason',function(){

						if($.trim($(this).val()).length == 0)
							$("#reason_error").html("Reason field is empty!"); 
						else
							$("#reason_error").html(""); 	
					});


					$(document).on('click','.order-details',function(){
						var base_url = '<?php echo URL::to(''); ?>';
						var id = $(this).attr('data-id');
						$.ajax({
							type : 'POST',
							url : base_url+'/user/allorderdetails',
							data : {id:id},
							success:function(data){
								$(".modal-dialog").removeClass(" modal-sm").addClass(" modal-lg");
								$('#orderModal').modal('show');
								$('.order-content').html(data);
							}
						})

					});
					$(".search_pop_btn").on('click', function(){ 
						$('.loaderOverlay').show(); 
				    	$.ajax({
							url:'user/userdatas',
							type: 'post',
							dataType : 'json',
							data: { group_id : '4', type : 'users' },
							success:function(res){
								var count = res.datas.length;
								$('.usernameDatas').html('<option value="">Select</option>');
								$.each(res.datas, function(key,value){
									$('.usernameDatas').append('<option value="'+value.id+'">'+value.username+'</option>');
									if(!--count){
										$('.loaderOverlay').hide();
										$('#abserve-modal').modal('show');
									}
								});
								if(count == 0){
									$('.loaderOverlay').hide();
									$('#abserve-modal').modal('show');
								}
							}
						});
					});

				</script>
<!-- 
   <script>    
$(document).ready(function(){
	$('.search').DataTable( {
        dom: 'Bfrtip',
        buttons: [            
            { extend:'csv',text: '<i class="fa fa-download"></i>&nbsp;Download',title: 't_completed_orders'}
        ],
         "order": [[ 0, "desc" ]]
    } );
    $('.buttons-csv').addClass('tips btn btn-sm btn-white');
	$('.do-quick-search').click(function(){
		$('#AbserveTable').attr('action','{{ URL::to("orders/multisearch")}}');
		$('#AbserveTable').submit();
	});	
	setInterval(function(){
		location.reload();
	}, 200000);
	$('#example1_info').hide();
	$('#example1_paginate').hide();
});

</script> -->
         

 

				@stop
