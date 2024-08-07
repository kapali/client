<?php

namespace App\Models\Delivery;

use App\Models\BaseModel;
use Auth;

class PackageType extends BaseModel
{
    protected $connection = 'delivery';

    protected $fillable = [
        'company_id','package_name','status'
    ];

    protected $hidden = [
     	'company_id', 'created_type', 'created_by', 'modified_type', 'modified_by', 'deleted_type', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];

   
}