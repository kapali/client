<?php 
if(isset($_GET['location']) && !empty($_GET['location'])) {
    $location = explode('-',$_GET['location']);
}

?>
@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

@section('title') {{ __('Shops') }} @stop

@section('styles')
@parent
    <link rel="stylesheet"  type='text/css' href="{{ asset('assets/plugins/cropper/css/cropper.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
    <style type="text/css">
        .pac-container{
            z-index: 9999999999!important;
        }
    </style>
@stop

@section('content')
@include('common.admin.includes.image-modal')
<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">{{ __('store.admin.shops.title') }}</span>
            <h3 class="page-title">{{ __('store.admin.shops.title') }}  {{ __('List') }}</h3>
        </div>
    </div>
    <div class="row mb-4 mt-20">
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0 pull-left">{{ __('store.admin.shops.title') }}</h6>
                    @if(isset($location) && $location[1] > 0)
                        <a href="{{url('admin/shops')}}" class="badge badge-info ml-4"><i class="fa fa-times"></i> {{$location[0]}}</a>
                    @endif

                    <a href="javascript:;" class="btn btn-success pull-right add"><i class="fa fa-plus"></i> {{ __('store.admin.shops.add') }}</a>


                </div>

                <div class="col-md-12">
                    <div class="note_txt">
                         @if(Helper::getDemomode() == 1)
                        <p>** Demo Mode : {{ __('admin.demomode') }}</p>
                        <span class="pull-left">(*personal information hidden in demo)</span>
                        @endif
                    </div>
                </div>

                <table id="data-table" class="table table-hover table_width display">
                <thead>
                    <tr>
                            <th data-value="id">{{ __('admin.id') }}</th>
                            <th data-value="store_type_id">{{ __('store.admin.shops.store_type') }}</th>
                            <th data-value="store_name">{{ __('store.admin.shops.name') }}</th>
                            <th data-value="email">{{ __('store.admin.shops.email') }}</th>
                            <th data-value="store_location">{{ __('store.admin.shops.address') }}</th>
                            <th data-value="contact_number">{{ __('store.admin.shops.contactno') }}</th>
                            <th>{{ __('store.admin.shops.status') }}</th>
                            <th>{{ __('admin.action') }}</th>

                    </tr>
                 </thead>


                </table>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
@parent

<script src="{{ asset('assets/plugins/data-tables/js/buttons.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/jszip.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/pdfmake.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/vfs_fonts.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/buttons.html5.min.js')}}"></script>

<script src = "{{ asset('assets/plugins/cropper/js/cropper.js')}}" > </script>
<script src = "{{ asset('assets/layout/js/crop.js')}}" > </script>
<script>
var tableName = '#data-table';
var table = $(tableName);
$(document).ready(function() {

    $('.add').on('click', function(e) {
        e.preventDefault();
        $.get("{{ url('admin/shops/create') }}", function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });

    $('body').on('click', '.edit', function(e) {
        e.preventDefault();
        $.get("{{ url('admin/shops/') }}/"+$(this).data('id')+"/edit", function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });


    table = table.DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": getBaseUrl() + "/admin/store/shops",
            "type": "GET",
            'beforeSend': function (request) {
                showLoader();
            },
            "headers": {
                "Authorization": "Bearer " + getToken("admin")
            },data: function(data){

                var info = $(tableName).DataTable().page.info();
                delete data.columns;

                data.page = info.page + 1;
                data.search_text = data.search['value'];
                data.order_by = $(tableName+' tr').eq(0).find('th').eq(data.order[0]['column']).data('value');
                data.order_direction = data.order[0]['dir'];
                @if(isset($location) && $location[1] > 0)
                    data.location = {{$location[1]}};
                @endif
            },
            dataFilter: function(data){

                var json = parseData( data );

                json.recordsTotal = json.responseData.total;
                json.recordsFiltered = json.responseData.total;
                json.data = json.responseData.data;
                hideLoader();
                return JSON.stringify( json ); // return JSON string
            }
        },
        "columns": [
            { "data": "id" ,render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
              }
            },
            { "data": function (data, type, row) {

                return data.storetype.name;
            }
            },
            { "data": "store_name" },
            { "data": function (data, type, dataToSet) {
                if({{Helper::getEncrypt()}} == 1){
                    return protect_email(data.email)
                }
                else{
                    return data.email
                }

            } },
            { "data": "store_location" },
            { "data": function (data, type, dataToSet) {
                if({{Helper::getEncrypt()}} == 1){
                    return protect_number(data.contact_number);
                }
                else{
                    return data.contact_number ;
                }
            } },
            { "data": "status" ,render: function (data, type, row) {

                if(data ==1){
                        return "<label class='switch'><input type='checkbox' class='status_enable switch-warning' checked data-id='"+row.id+"' data-value='"+row.status+"'> <span class='slider round'></span></label>"
                   }else{
                    return "<label class='switch'><input type='checkbox' class='status_enable'  data-id='"+row.id+"' data-value='"+row.status+"'> <span class='slider round'></span></label>"
                   }
            }
            },

            { "data": function (data, type, row) {

                if(data.status ==1){
                    var status ="Disable";
                }else{
                    var status="Enable";
                }

                if({{Helper::getDemomode()}} != 1){
                    var button='<div class="input-group-btn action_group"> <li class="action_icon"> <button type="button"class="btn btn-info btn-block "data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true" title="View"></i></button>'+
                           '<ul class="dropdown-menu"><li><a href="javascript:;" data-id="'+data.id+'" class="dropdown-item category"><i class="fa fa-plus"></i>Category</a>'+
                            '</li> <li><a href="javascript:;" data-id="'+data.id+'" class="dropdown-item items"><i class="fa fa-plus"></i> Items</a> </li> ';
                            if(data.storetype.category=='FOOD' && data.storetype!=null){
                             button +='<li > <a class="dropdown-item addon" data-id="'+data.id+'"  href="javascript:;"><i class="fa fa-plus" aria-hidden="true" title="Add on"></i>AddOn</a> </li>'
                            }

                             button +='<li><a href="javascript:;" data-id="'+data.id+'" class="dropdown-item edit"><i class="fa fa-edit"></i> Edit</a> </li><li><a href="javascript:;" data-id="'+data.id+'" class="dropdown-item logs"><i class="fa fa-database"></i> Logs</a> </li><li><a href="javascript:;" data-id="'+data.id+'" class="dropdown-item wallet"><i class="fa fa-google-wallet"></i> Wallet Details</a> </li>';
                        button +='</ul> </li></div>';
                     return  button;
                }

            }},



        ],
        responsive: true,
        paging:true,
            info:true,
            lengthChange:false,
            dom: 'Bfrtip',
            buttons: [{
               extend: "copy",
               exportOptions: {
                   columns: [":visible :not(:last-child)"]
               }
            }, {
               extend: "csv",
               exportOptions: {
                   columns: [":visible :not(:last-child)"]
               }
            }, {
               extend: "excel",
               exportOptions: {
                   columns: [":visible :not(:last-child)"]
               }
            }, {
               extend: "pdf",
               exportOptions: {
                   columns: [":visible :not(:last-child)"]
               }
            }],"drawCallback": function () {

                var info = $(this).DataTable().page.info();
                if (info.pages<=1) {
                   $('.dataTables_paginate').hide();
                   $('.dataTables_info').hide();
                }else{
                    $('.dataTables_paginate').show();
                    $('.dataTables_info').show();
                }
            }
    } );

    $('body').on('click', '.status_enable', function() {
        var id = $(this).data('id');
        var value = $(this).data('value');

         $(".status-modal").modal("show");
            $(".status-modal-btn")
                .off()
                .on("click", function() {


                    var url = getBaseUrl() + "/admin/store/shops/"+id+'/updateStatus?status='+value;

                    $.ajax({
                        type:"GET",
                        url: url,
                        headers: {
                            Authorization: "Bearer " + getToken("admin")
                        },
                        'beforeSend': function (request) {
                            showInlineLoader();
                        },
                        success:function(data){
                            $(".status-modal").modal("hide");

                            var info = $('#data-table').DataTable().page.info();
                            console.log(info.page);
                            table.order([[ info.page, 'asc' ]] ).draw( false );
                            alertMessage("Success", data.message, "success");
                            hideInlineLoader();
                        }
                    });
                });

    });


    $('body').on('click', '.addon', function(e) {
       window.location.replace("{{ url('') }}"+"/admin/shopsaddon/"+$(this).data('id')+"/index");

    });

    $('body').on('click', '.category', function(e) {
       window.location.replace("{{ url('') }}"+"/admin/shopscategory/"+$(this).data('id')+"/index");

    });

    $('body').on('click', '.items', function(e) {
       window.location.replace("{{ url('') }}"+"/admin/shopsitems/"+$(this).data('id')+"/index");

    });

    $('body').on('click', '.logs', function(e) {
        e.preventDefault();
        $.get("{{ url('admin/storelogs/') }}/"+$(this).data('id'), function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });

    $('body').on('click', '.wallet', function(e) {
        e.preventDefault();

        $.get("{{ url('admin/storewallet/') }}/"+$(this).data('id'), function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });

    $('body').on('click', '.priceform', function(e) {
        e.preventDefault();
        $.get("{{ url('admin/priceform/') }}/"+$(this).data('id'), function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });

} );
</script>
@stop