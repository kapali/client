<?php

namespace App\Exports;

use App\Http\Controllers\Excel;
use App\Models\Weeklypaymentfordeliveryboy;
use Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;



class Weeklypaymentfordeliveryboyexport implements FromView,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function __construct($request)
    {
        $this->request = $request->all();
    }
    public function headings(): array
    {
        return [
            'username',
            'phone_number',
            'email',
            'active',
            'address',
            'customer_wallet',
        ];
    }
    public function view(): View
    {
       $search     = $this->request->search ?? '';
        $location_id    = $this->request->location_id ?? '';
        $date       = $this->request->date ?? '';
        $status     = $this->request->status ?? '';
        // \DB::enableQueryLog();
        $customers      =  Weeklypaymentfordeliveryboy::query()->select('id','username','email','phone_number');
          return view('weeklypaymentfordeliveryboy.Weeklypaymentfordeliveryboy', [
            'resultData' => $customers->get() 
        ]);
        print_r($customers);exit();
    }


}