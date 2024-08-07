@extends('layouts.app')

@section('content')

<div class="page-content row">
	<!-- Page header -->
	<div class="page-header">
		<div class="page-title">
			<h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
		</div>
		<!-- <ul class="breadcrumb">
			<li><a href="{{ URL::to('dashboard') }}">{!! Lang::get('core.home') !!}</a></li>
			<li><a href="{{ URL::to('weeklypaymentforhost?return='.$return) }}">{{ $pageTitle }}</a></li>
			<li class="active">{!! Lang::get('core.addedit') !!} </li>
		</ul> -->

	</div>
	
	<div class="page-content-wrapper">

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
		<div class="sbox animated fadeInRight">
			<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
			<div class="sbox-content"> 	

				{!! Form::open(array('url'=>\URL::to('/').'/transferamountboy', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}	
				<?php 	//$from=base64_decode(explode("||",$_GET['date'])[0]);
				//$to=base64_decode(explode("||",$_GET['date'])[1]); ?>
				{{--<input type="hidden" name="fromdate" value="{!!date('Y-m-d',strtotime($from))!!}">	
				<input type="hidden" name="todate" value="{!!date('Y-m-d',strtotime($to))!!}">--}}
				<input type="hidden" name="boy_id" value='{!!$id!!}'>
				<input type="hidden" name="pay_amount" value='{!!$amount!!}'>
				<input type="hidden" name="pay_order_id[]" value='{!!\AbserveHelpers::DelboypayableorderId($id)!!}'>
				<div class="col-md-12">
					<?php $currsymbol = \AbserveHelpers::getCurrencySymbol();?>		
					<fieldset><legend> Payment Details</legend>
						<div class="form-group " >
							<label for="Id" class=" control-label col-md-4 text-left"> Payable amount :</label>
							<div class="col-md-6" style="padding-top: 10px;">
								{!! $currsymbol !!} {!!$amount!!}  
							</div> 
							<div class="col-md-2">

							</div>
						</div> 
					</fieldset>
				</div>
				<div style="clear:both"></div>
				<div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
						<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> Transfer</button>
						<button type="button" onclick="location.href='{{ URL::to('weeklypaymentforhost?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {!! Lang::get('core.sb_cancel') !!} </button>
					</div>	  

				</div> 

				{!! Form::close() !!}
			</div>
		</div>		 
	</div>	
</div>			 
<script type="text/javascript">
	$(document).ready(function() { 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		

	});
</script>		 
@stop