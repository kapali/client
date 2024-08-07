@extends('layouts.app')

@section('content')
<?php
$cpage	= request()->has('page') ? request()->get('page') : '';
	$from	= request()->has('from') ? request()->get('from') : '';
	$url	= '?from='.$from.'&page='.$cpage;
$dwnload= ['pdf'=>'PDF','xls'=>'EXCEL','csv'=>'CSV'];
	$dwnicon= ['pdf'=>'pdf','xls'=>'excel','csv'=>'csv']; ?>
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
			<div class="col-md-8 button-chng my-1"> 	
				@if($access['is_add'] ==1)
				<a href="{{ url('foodunit/create?return='.$return) }}" class="btn  btn-sm"  
					title="{{ __('core.btn_create') }}"><i class=" fa fa-plus "></i> Create  </a>
				@endif

				{{-- <div class="btn-group"> --}}
					{{-- <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars"></i> Bulk Action </button> --}}
					<a href="javascript://ajax"  onclick="SximoDelete();" class="btn  btn-sm" title="{{ __('core.btn_remove') }}"><i class=" fa fa-minus-circle "></i>
							Remove  </a>
					<!-- <a href="javascript://ajax"  onclick="deleteperfunc1();" class="btn  btn-sm" title="{{ __('core.btn_remove') }}"><i class=" fa fa-minus-circle "></i>
							 Permanent Delete </a> -->
					<button type="button" class="tips btn btn-sm btn-white search_pop_btn"><i class="fa fa-search"></i> Search</button>
					
					{{-- <a href="{{ URL::to( 'variationunit/search') }}" class="btn btn-sm btn-white" onclick="AbserveModal(this.href,'Advance Search'); return false;" ><i class="fa fa-search"></i> Search</a>	 --}}	

				<!-- 	<a href="{{ url( $pageModule .'/export?do=excel&return='.$return) }}" class="btn  btn-sm"><i class=" fa fa-download "></i> Download </a> -->
					<button type="button" class="btn bg-transparent text-success border-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-download"></i> Download</button>
				<div class="dropdown-menu dropdown-menu-right" style="">
					@php $i =0; @endphp
					@foreach($dwnload as $dn => $dv)
					@if($i != 0)
					<div class="dropdown-divider"></div>
					@endif
					<a href="{!! url('foodunit/foodunitExport/'.$dn) !!}" class="dropdown-item"><i class="fas fa-file-{!! $dwnicon[$dn] !!}"></i> {!! $dv !!}</a>
					@php $i++; @endphp
					@endforeach
				</div>


					{{-- <ul class="dropdown-menu">
						@if($access['is_remove'] ==1)
						<li class="nav-item"><a href="javascript://ajax"  onclick="SximoDelete();" class="nav-link tips" title="{{ __('core.btn_remove') }}">
							Remove Selected </a></li>
							@endif 
							@if($access['is_add'] ==1)
							<li class="nav-item"><a href="javascript://ajax" class=" copy nav-link " title="Copy" > Copy selected</a></li>
							<div class="dropdown-divider"></div>
							<li class="nav-item"><a href="{{ url($pageModule .'/import?return='.$return) }}" onclick="SximoModal(this.href, 'Import CSV'); return false;" class="nav-link "> Import CSV</a></li>


							@endif
							<div class="dropdown-divider"></div>
							@if($access['is_excel'] ==1)
							<li class="nav-item"><a href="{{ url( $pageModule .'/export?do=excel&return='.$return) }}" class="nav-link "> Export Excel </a></li>	
							@endif
							@if($access['is_csv'] ==1)
							<li class="nav-item"><a href="{{ url( $pageModule .'/export?do=csv&return='.$return) }}" class="nav-link "> Export CSV </a></li>	
							@endif
							@if($access['is_pdf'] ==1)
							<li class="nav-item"><a href="{{ url( $pageModule .'/export?do=pdf&return='.$return) }}" class="nav-link "> Export PDF </a></li>	
							@endif
							@if($access['is_print'] ==1)
							<li class="nav-item"><a href="{{ url( $pageModule .'/export?do=print&return='.$return) }}" class="nav-link "> Print Document </a></li>	
							@endif
							<div class="dropdown-divider"></div>
							<li class="nav-item"><a href="{{ url($pageModule) }}"  class="nav-link "> Clear Search </a></li>



						</ul> --}}
					{{-- </div>     --}}   
			</div>

		</div>	
	</div>	
	<div class="p-3">
		<div class="table-container for-icon m-0">

				<!-- Table Grid -->
				
	 			{!! Form::open(array('url'=>'foodunit?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
				
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
										<a href="{{url('foodunit/'.$row->id.'?return='.$return)}}" class="tips btn btn-xs btn-primary" title="{!! Lang::get('core.btn_view') !!}"><i class="fa  fa-search "></i></a>
										@endif
										@if($access['is_edit'] == 1)
										<a  href="{{ url('foodunit/'.$row->id.'/edit?return='.$return) }}" class="tips btn btn-xs btn-success" title="{!! Lang::get('core.btn_edit') !!}"><i class="fa fa-edit "></i></a>
										<!-- <a  href="{{ URL::to('wallet?search=u_id:equal:'.$row->id.'') }}" class="tips btn btn-xs btn-success" title="click to view wallet details"><i class="fa fa-credit-card"></i></a>
										<a  href="{{ URL::to('offerwallet?search=cust_id:equal:'.$row->id.'') }}" class="tips btn btn-xs btn-success" title="click to view offer wallet details"><i class="fa fa-gift"></i></a> -->
										@endif
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
<!-- search model start -->
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

@stop

