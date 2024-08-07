@extends('layouts.app')

@section('content')
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>
{!! Form::open(array('url'=>'customer?return='.$return, 'class'=>'form-horizontal validated sximo-form','files' => true ,'id'=> 'FormTable' )) !!}
<div class="toolbar-nav">
	<div class="row">
	</div>
</div>	
<div class="p-3">
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>		
	<div class="row m-0">
		<div class="col-md-12">
			<fieldset>
				<legend> Customer</legend>
				{!! Form::hidden('id', $row['id']) !!}					
				<div class="form-group row  " >
					<label for="Username" class=" control-label col-md-4 text-md-right"> Username <span class="asterix"> * </span></label>
					<div class="col-md-6">
						<input  type='text' name='username' id='username' value='{{ $row['username'] }}' 
						required     class='form-control form-control-sm ' /> 
					</div> 
					<div class="col-md-2">

					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Email" class=" control-label col-md-4 text-md-right"> Email <span class="asterix"> * </span></label>
					<div class="col-md-6">
						<input  type='email' name='email' id='email' value='{{ $row['email'] }}' 
						required     class='form-control form-control-sm ' /> 
					</div> 
					<div class="col-md-2">

					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Avatar" class=" control-label col-md-4 text-md-right"> Avatar </label>
					<div class="col-md-6">

						<div class="fileUpload btn " > 
							<span>  <i class="fa fa-camera"></i>  </span>
							<div class="title"> Browse File </div>
							<input type="file" name="avatar" class="upload"   accept="image/x-png,image/gif,image/jpeg"     />
						</div>
						<div class="avatar-preview preview-upload">
							{!! SiteHelpers::showUploadedFile( $row["avatar"],"/uploads/users/") !!}
						</div>

					</div> 
					<div class="col-md-2">
					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Active" class=" control-label col-md-4 text-md-right"> Active </label>
					<div class="col-md-6">
						<input type='radio' name='active' value ='1'  @if($row['active'] == '1') checked="checked" @endif class='minimal-green' > Active 

						<input type='radio' name='active' value ='0'  @if($row['active'] == '0') checked="checked" @endif class='minimal-green' > Inactive 

						<input type='radio' name='active' value ='2'  @if($row['active'] == '2') checked="checked" @endif class='minimal-green' > Block  
					</div> 
					<div class="col-md-2">
					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Phone Number" class=" control-label col-md-4 text-md-right"> Phone Number </label>
					<div class="col-md-6">
						<input  type='text' name='phone_number' id='phone_number' value='{{ $row['phone_number'] }}' 
						class='form-control form-control-sm ' /> 
					</div> 
					<div class="col-md-2">
					</div>
				</div>
				<div class="col-md-12 text-center mt-4" >
					<div class="submitted-button">
						<button name="apply" class="tips btn btn-sm btn-green  "  title="{{ __('core.btn_back') }}" ><i class="fa  fa-check"></i> {{ __('core.sb_apply') }} </button>
						<button name="save" class="tips btn btn-sm btn-black"  id="saved-button" title="{{ __('core.btn_back') }}" ><i class="fa  fa-paste"></i> {{ __('core.sb_save') }} </button>
						<button type="button" onclick="location.href='{{ URL::to('customer?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {!! Lang::get('core.sb_cancel') !!} </button>
					</div>	
				</div>
			</fieldset>
		</div>
	</div>
	<input type="hidden" name="action_task" value="save" />
</div>
</div>		
{!! Form::close() !!}
@if(isset($row['id']) && $row['id'] !='')
<div class="table-responsive tableFixHead sbox-content" style="min-height:300px;">
	<table class="table table-striped">
		<thead>
			<tr>
				<th class="number"> No </th>
				<th>Address</th>				
				<th>Building</th>
				<th>Landmark</th>
				<th>Address type</th>
			</tr>
		</thead>
		<?php $i=0; ?>
		<tbody> 
			@foreach ($user_address as $row) 
			<tr>
				<td width="30">{{ ++$i }}</td>	
				<td>{{$row->address}}</td>
				<td>{{$row->building}}</td>					
				<td>{{$row->landmark}}</td>
				<td>{{ ($row->address_type == '1') ? 'Home' : (($row->address_type == '2') ? 'Work' : 'Others') }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endif
<script type="text/javascript">
	$(document).ready(function() { 
		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("customer/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
	});
</script>		 
@stop