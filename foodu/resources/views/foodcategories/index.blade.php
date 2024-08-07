@extends('layouts.app')

@section('content')
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
	<div class="toolbar-nav" >   
		<div class="row">
			<div class="col-md-8 my-1 button-chng"> 	
				@if($access['is_add'] ==1)
				<a href="{{ url('foodcategories/create?return='.$return) }}" class="btn  btn-sm"  
				title="{{ __('core.btn_create') }}"><i class=" fa fa-plus "></i> Create  </a>
				@endif
				<a href="javascript://ajax"  onclick="SximoDelete();" class="btn  btn-sm" title="{{ __('core.btn_remove') }}"><i class=" fa fa-minus-circle "></i>
					Remove  </a>
					<button type="button" class="tips btn btn-sm btn-white search_pop_btn"><i class="fa fa-search"></i> Search</button>
					{{-- <a href="{{ URL::to( 'foodcategories/search') }}" class="btn btn-sm btn-white" onclick="AbserveModal(this.href,'Advance Search'); return false;" ><i class="fa fa-search"></i> {!! trans('core.btn_search') !!}</a>	 --}}  
				</div>
			</div>	
	</div>	
		<div class="p-3">
			<div class="table-container for-icon m-0">
				{!! Form::open(array('url'=>'foodcategories/store?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
				<table class="table  table-hover " id="{{ $pageModule }}Table">
					<thead>
						<tr>
							<th style="width: 3% !important;" class="number"> No </th>
							<th  style="width: 3% !important;"> <input type="checkbox" class="checkall minimal-green" /></th>
							@foreach ($tableGrid as $t)
							@if($t['view'] =='1')				
							<?php $limited = isset($t['limited']) ? $t['limited'] :''; 
							if(SiteHelpers::filterColumn($limited ))
							{
								$addClass='class="tbl-sorting" ';
								if($insort ==$t['field'])
								{
									$dir_order = ($inorder =='desc' ? 'sort-desc' : 'sort-asc'); 
									$addClass='class="tbl-sorting '.$dir_order.'" ';
								}
								echo '<th align="'.$t['align'].'" '.$addClass.' width="'.$t['width'].'">'.\SiteHelpers::activeLang($t['label'],(isset($t['language'])? $t['language'] : array())).'</th>';				
							} 
							?>
							@endif
							@endforeach
							<th  style="width: 10% !important;">{{ __('core.btn_action') }}</th>
						</tr>
					</thead>
					<tbody>        						
						@foreach ($rowData as $row)
						<tr>
							<td class="thead"> {{ ++$i }} </td>
							<td class="tcheckbox"><input type="checkbox" class="ids minimal-green" name="ids[]" value="{{ $row->id }}" />  </td>

							@foreach ($tableGrid as $field)
							@if($field['view'] =='1')
							<?php $limited = isset($field['limited']) ? $field['limited'] :''; ?>
							@if(SiteHelpers::filterColumn($limited ))
							<?php $addClass= ($insort ==$field['field'] ? 'class="tbl-sorting-active" ' : ''); ?>
							<td align="{{ $field['align'] }}" width=" {{ $field['width'] }}"  {!! $addClass !!} >					 
								{!! SiteHelpers::formatRows($row->{$field['field']},$field ,$row ) !!}						 
							</td>
							@endif	
							@endif					 
							@endforeach	
							<td>
								@if($access['is_detail'] ==1)
								<a href="{{url('foodcategories/'.$row->id.'?return='.$return)}}" class="tips btn btn-xs btn-primary" title="{!! Lang::get('core.btn_view') !!}"><i class="fa  fa-search "></i></a>
								@endif
								@if($access['is_edit'] == 1)
								<a  href="{{ url('foodcategories/'.$row->id.'/edit?return='.$return) }}" class="tips btn btn-xs btn-success" title="{!! Lang::get('core.btn_edit') !!}"><i class="fa fa-edit "></i></a>
								@endif
							</td>		 
						</tr>
						@endforeach
					</tbody>
				</table>
				<input type="hidden" name="action_task" value="" />
				{!! Form::close() !!}
			</div>
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
					$('#SximoTable').submit();
				}
			})
/*			$(".search_pop_btn").on('click', function(){ 
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
								$('#neworder_modal').modal('show');
							}
						});
						if(count == 0){
							$('.loaderOverlay').hide();
							$('#neworder_modal').modal('show');
						}
					}
				});
			});
			$(document).on('click','.order_search_btn',function(){
				var search_val,oper,name,search = '';
				var url = window.location.origin + window.location.pathname;
				$('.fieldsearch').each(function(){
					search_val = $(this).find('.search_pop').val();
					oper = $(this).find('.oper').val();
					name = $(this).find('.search_pop').data('name');
					if(search_val != ''){
						search +=  name+':'+oper+':'+search_val+'|';
					}
				});
				window.location.href = url+'?search='+search;
			});*/

		});
	</script>	

	@stop