@extends('layouts.app')

@section('content')
<div class="page-header">
	<div class=""><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>
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
			<div class="col-md-8 button-chng my-1"> 	
				<button type="button" class="tips btn btn-sm btn-white search_pop_btn"><i class="fa fa-search"></i> Search</button>
				{{-- <a href="{{ URL::to( 'restaurantrating/search') }}" class="btn btn-sm btn-white" onclick="AbserveModal(this.href,'Advance Search'); return false;" ><i class="fa fa-search"></i> Search</a> --}}	
				<a href="javascript://ajax"  onclick="SximoDelete();" class="btn btn-sm btn-white" title="{{ __('core.btn_remove') }}">
				Remove  </a>
			</div>
		</div>
	</div>
	<div class="p-3">	
		<div class="table-container for-icon m-0">
			{!! Form::open(array('url'=>'restaurantrating/store'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
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
						@if($field['field'] == 'cust_id')
						<td>{!! \AbserveHelpers::getuname($row->cust_id) !!}</td>
						@elseif($field['field'] == 'res_id')
						<td>{!! \AbserveHelpers::restsurent_name($row->res_id) !!}</td>
						@else
						<?php $addClass= ($insort ==$field['field'] ? 'class="tbl-sorting-active" ' : ''); ?>
						<td align="{{ $field['align'] }}" width=" {{ $field['width'] }}"  {!! $addClass !!} >					 
							{!! SiteHelpers::formatRows($row->{$field['field']},$field ,$row ) !!}						 
						</td>
						@endif	
						@endif	
						@endif					 
						@endforeach
						<td>
							@if($access['is_detail'] ==1)
							<a href="{{ url('restaurantrating/'.$row->id.'?return='.$return)}}" class="nav-link tips" title="{{ __('core.btn_view') }}"> {{ __('core.btn_view') }}<i class="fa  fa-search "></i> </a>
							@endif
							@if($access['is_edit'] ==1)
							<a  href="{{ url('restaurantrating/'.$row->id.'/edit?return='.$return) }}" class="nav-link  tips" title="{{ __('core.btn_edit') }}"> {{ __('core.btn_edit') }} <i class="fa  fa-search "></i></a>
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

	});	
</script>	
@stop