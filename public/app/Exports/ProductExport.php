<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use \App\ProductResponse;
use \App\Presence;
use DB;

class ProductExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$data = ProductResponse::select(DB::raw('product_id, coalesce(sum(case when response_id=1 then 1 end),0) as yes,coalesce(sum(case when response_id=0 then 1 end),0) as no'))->with(['product'])->groupBy('product_id')->get();

    	$arr[] = [
    			'Kode',
    			'Suka',
    			'Tidak Suka',
    			'Kunjungan',
    		];

        foreach ($data as $key) {
            $arr[] = [
                'code'=>$key->product->code,
                'yes'=>$key->yes,
                'no'=>$key->no,
                'visit'=>Presence::where('product_id',$key->product_id)->count()
            ];
        }

        return collect($arr);
    }
}
