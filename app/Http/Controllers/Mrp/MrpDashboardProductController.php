<?php

namespace App\Http\Controllers\Mrp;

use App\Http\Controllers\Controller;
use App\Models\Mrp\MrpWipProcess;
use App\Models\Mrp\MrpInventoryMaterialIncoming;
use App\Models\Mrp\MrpInventoryProductList;
use App\Models\Mrp\MrpInventoryProductIncoming;
use App\Models\Mrp\MrpInventoryProductOut;
use App\Models\Mrp\MrpInventoryMaterialOut;
use App\Models\Mrp\MrpInventoryShipment;
use App\Models\Mrp\MrpInventoryMaterialList;
use Illuminate\Http\Request;
use DateTime;
use Carbon\Carbon;

class MrpDashboardProductController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = "Dahsboard MRP";

        // Target Min dan Max
        // $min = MrpInventoryMaterialList::get();
        // $max = MrpInventoryMaterialList::get();
        // $min_product = MrpInventoryProductList::get();
        // $max_product = MrpInventoryProductList::get();

        // $target_material_min = $min->sum('target_min');
        // $target_material_max = $max->sum('target_max');
        // $target_product_min = $min_product->sum('target_min');
        // $target_product_max = $max_product->sum('target_max');
        // End Target Min dan Max

        $data['date'] = [];
        $data['stock_in_material'] = [];
        $data['stock_out_material'] = [];
        $data['diff_stock_material'] = [];
        $data['stock_in_product'] = [];
        $data['stock_out_product'] = [];
        $data['diff_stock_product'] = [];
        $data['target_material'] = [];
        $data['target_product'] = [];
        $data['target_material_min'] = [];
        $data['target_material_max'] = [];
        $data['target_product_min'] = [];
        $data['target_product_max'] = [];
        
        $data['start_date'] = $request->dateMonth;
        $data['status'] = 'generate';
        $data['max'] = MrpInventoryMaterialList::orderBy('created_at','desc')->get();

        if ($request->typeInterval == 'daily') {
            $data_start = $request->dateMonth;
            $start_date = new DateTime(Carbon::parse($data_start)->format('Y/m/d'));
            $end_date = new DateTime(Carbon::parse($data_start)->endOfMonth()->format('Y/m/d'));
        }else if( $request->typeInterval == 'monthly' ){
            $data_start = $request->dateYear;
            $start_date = new DateTime(Carbon::parse($data_start)->format('Y/m/d'));
            $end_date = new DateTime(Carbon::parse($data_start)->endOfMonth()->format('Y/m/d'));
        }else{
            $start_date = new DateTime(date('Y/m/01 00:00:00'));
            $end_date = new DateTime(date('Y/m/t 23:59:59'));
        }

        if($request->type == 'Material'){
            $data['inventory'] =  MrpInventoryMaterialList::orderBy('id', 'asc')->get();
            $diff_stock_material = 0 ;
            for($day = clone $start_date; $day <= $end_date; $day->modify('+1 day')){
                array_push($data['date'], $day->format('d'));
                $material_incoming = MrpInventoryMaterialIncoming::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                $material_out = MrpInventoryMaterialOut::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                $material = MrpInventoryMaterialList::get();
                
                $stock_in_material = $material_incoming->sum('material_incoming');
                $stock_out_material = $material_out->sum('material_outgoing');
                
                $initial_stock = $material[0]->initial_stock;
                
                if($day->format('d') == '01') 
                {
                    $diff_stock_material = $initial_stock + $stock_in_material - $stock_out_material;
                } else {
                    $diff_stock_material = $diff_stock_material + $stock_in_material - $stock_out_material;

                }


                $target_material_min = $material->sum('target_min');
                $target_material_max = $material->sum('target_max');

                
                if ($material[0]->total_target_day == 0) {
                    $target_material = 0;
                }else{
                    $target_material =  round($diff_stock_material / $material[0]->total_target_day) ;
                    
                }
                
                array_push($data['stock_in_material'], $stock_in_material);
                array_push($data['stock_out_material'], $stock_out_material);
                array_push($data['diff_stock_material'], $diff_stock_material);
                array_push($data['target_material'], $target_material);
                array_push($data['target_material_min'], $target_material_min);
                array_push($data['target_material_max'], $target_material_max);

            }
        }else if($request->type == 'Product'){
            $data['inventory'] =  MrpInventoryProductList::orderBy('id', 'asc')->get();

            $diff_stock_product = 0 ;
            for($day = clone $start_date; $day <= $end_date; $day->modify('+1 day')){
                array_push($data['date'], $day->format('d'));
                $product_incoming = MrpInventoryProductIncoming::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                $product_out = MrpInventoryProductOut::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                $product = MrpInventoryProductList::get();
                
                $stock_in_product = $product_incoming->sum('product_incoming');
                $stock_out_product = $product_out->sum('product_outgoing');
                
                $initial_stock = $product[0]->initial_stock;
                
                if($day->format('d') == '01') 
                {
                    $diff_stock_product = $initial_stock + $stock_in_product - $stock_out_product;
                } else {
                    $diff_stock_product = $diff_stock_product + $stock_in_product - $stock_out_product;

                }


                $target_product_min = $product->sum('target_min');
                $target_product_max = $product->sum('target_max');

                
                if ($product[0]->total_target_day == 0) {
                    $target_product = 0;
                }else{
                    $target_product =  round($diff_stock_product / $product[0]->total_target_day) ;
                    
                }
                
                array_push($data['stock_in_product'], $stock_in_product);
                array_push($data['stock_out_product'], $stock_out_product);
                array_push($data['diff_stock_product'], $diff_stock_product);
                array_push($data['target_product'], $target_product);
                array_push($data['target_product_min'], $target_product_min);
                array_push($data['target_product_max'], $target_product_max);
            }
        } else {
            $data['inventory'] =  MrpInventoryMaterialList::get();
                $diff_stock_material = 0;
                for($day = clone $start_date; $day <= $end_date; $day->modify('+1 day')){
                array_push($data['date'], $day->format('d'));
                $material_incoming = MrpInventoryMaterialIncoming::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                $material_out = MrpInventoryMaterialOut::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                $material = MrpInventoryMaterialList::get();
                
                $stock_in_material = $material_incoming->sum('material_incoming');
                $stock_out_material = $material_out->sum('material_outgoing')  ;

                $initial_stock = $material[0]->initial_stock;
                
                if($day->format('d') == '01') 
                {
                    $diff_stock_material = $initial_stock + $stock_in_material - $stock_out_material;
                } else {
                    $diff_stock_material = $diff_stock_material + $stock_in_material - $stock_out_material;

                }


                $target_material_min = $material->sum('target_min');
                $target_material_max = $material->sum('target_max');

                
                if ($material[0]->total_target_day == 0) {
                    $target_material = 0;
                }else{
                    $target_material =  round($diff_stock_material / $material[0]->total_target_day) ;
                    
                }

                array_push($data['stock_in_material'], $stock_in_material);
                array_push($data['stock_out_material'], $stock_out_material);
                array_push($data['diff_stock_material'], $diff_stock_material);
                array_push($data['target_material'], $target_material);
                array_push($data['target_material_min'], $target_material_min);
                array_push($data['target_material_max'], $target_material_max);
            }

        }
        return view('mrp.dashboard.dashboard-list-product',$data);
    }  

    public function material_chart(Request $request)
    {   

        $data['stock_in_material'] = [];
        $data['stock_out_material'] = [];
        $data['diff_stock_material'] = [];
        $data['target'] = [];
        $data['targetmin'] = [];
        $data['targetmax'] = [];
        $data['date'] = [];
        $start_date = new DateTime(date('Y/m/01 00:00:00'));
        $end_date = new DateTime(date('Y/m/t 23:59:59'));
        $data1 = $request->date_value;
        $tahun = substr($data1, 0, 4);
        $bulan = substr($data1, 5, 2);
        $date_all = $tahun."/".$bulan."/01";
        $date_fix_start = new DateTime(date('Y/m/01 00:00:00', strtotime($date_all)));
        $date_fix_end = new DateTime(date('Y/m/t 00:00:00', strtotime($date_all)));
        $data['inventory'] =  MrpInventoryMaterialList::orderBy('id', 'asc')->get();

        if ($request->tipe_interval == "realtime") {
            # code...
            $data['date_realtime'] = date('F Y');
            
            $diff_stock_material = 0;

            for($day = clone $start_date; $day <= $end_date; $day->modify('+1 day')){
                array_push($data['date'], $day->format('d'));
                $material_incoming = MrpInventoryMaterialIncoming::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')])->where("material_id", $request->id_mats)->get();
                $material_out = MrpInventoryMaterialOut::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')])->where("inventory_material_list_id", $request->id_mats)->get();
                $material_list = MrpInventoryMaterialList::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')])->where('id', $request->id_mats)->get();
                $material = MrpInventoryMaterialList::where('id', $request->id_mats)->get();
                
                $stock_out_material = $material_out->sum('material_outgoing');
                $stock_in_material = $material_incoming->sum('material_incoming');
                // $diff_stock_material = $material_list->sum('stock');
                $initial_stock = $material[0]->initial_stock;
                
                if($day->format('d') == '01') 
                {
                    $diff_stock_material = $initial_stock + $stock_in_material - $stock_out_material;
                } else {
                    $diff_stock_material = $diff_stock_material + $stock_in_material - $stock_out_material;

                }


                $target_material_min = $material->sum('target_min');
                $target_material_max = $material->sum('target_max');

                
                if ($material[0]->total_target_day == 0) {
                    $target_material = 0;
                }else{
                    $target_material =  round($diff_stock_material / $material[0]->total_target_day) ;
                    
                }
                
                array_push($data['stock_in_material'], $stock_in_material);
                array_push($data['stock_out_material'], $stock_out_material);
                array_push($data['diff_stock_material'], $diff_stock_material);
                array_push($data['target'], $target_material);
                array_push($data['targetmin'], $target_material_min);
                array_push($data['targetmax'], $target_material_max);
            }
        }elseif($request->tipe_interval == "daily"){
                # code...
            $data['date_realtime'] = $request->date_daily;
            
            $diff_stock_material = 0; 

            for($day = clone $date_fix_start; $day <= $date_fix_end; $day->modify('+1 day')){
                array_push($data['date'], $day->format('d'));
                $material_incoming = MrpInventoryMaterialIncoming::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')])->where("material_id", $request->id_mats)->get();
                $material_out = MrpInventoryMaterialOut::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')])->where("inventory_material_list_id", $request->id_mats)->get();
                $material_list = MrpInventoryMaterialList::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')])->where('id', $request->id_mats)->get();
                $material = MrpInventoryMaterialList::where('id', $request->id_mats)->get();
                $stock_out_material = $material_out->sum('material_outgoing');
                $stock_in_material = $material_incoming->sum('material_incoming');
                // $diff_stock_material = $material_list->sum('stock');
                $initial_stock = $material[0]->initial_stock;
                if($day->format('d') == '01') 
                {
                    $diff_stock_material = $initial_stock + $stock_in_material - $stock_out_material;
                } else {
                    $diff_stock_material = $diff_stock_material + $stock_in_material - $stock_out_material;

                }


                $target_material_min = $material->sum('target_min');
                $target_material_max = $material->sum('target_max');

                

                // $targetmin = $material_list->sum('target_min');
                // $targetmax = $material_list->sum('target_max');
                
                if ($material[0]->total_target_day == 0) {
                    $target_material = 0;
                }else{
                    $target_material =  round($diff_stock_material / $material[0]->total_target_day) ;
                    
                }
                
                array_push($data['stock_in_material'], $stock_in_material);
                array_push($data['stock_out_material'], $stock_out_material);
                array_push($data['diff_stock_material'], $diff_stock_material);
                array_push($data['target'], $target_material);
                array_push($data['targetmin'], $target_material_min);
                array_push($data['targetmax'], $target_material_max);
            }
        }
            return response()->json([
                'success' => true,
                'message' => 'show List ',
                // 'data' => $data['stock_in_material'],
                'data' => [
                    'in' => $data['stock_in_material'],
                    'out' => $data['stock_out_material'],
                    'diff' => $data['diff_stock_material'],
                    'target' => $data['target'],
                    'target_min' => $data['targetmin'],
                    'target_max' => $data['targetmax'],
                    'date_realtime' => $data['date_realtime'],
                    'tipe' => $request->tipe_interval,
                    'date' => $request->date_value,
                ],
            ], 200);
    }
    
    public function material_chart_monthly(Request $request)
    {   

        $data['stock_in_material'] = [];
        $data['stock_out_material'] = [];
        $data['diff_stock_material'] = [];
        $data['target'] = [];
        $data['targetmin'] = [];
        $data['targetmax'] = [];
        $data['date'] = [];
        $data1 = $request->year_value;
        $date_all = $data1."/01/01";
        $date_fix_start = new DateTime(date('Y/01/01 00:00:00', strtotime($date_all)));
        $date_fix_end = new DateTime(date('Y/12/01 00:00:00', strtotime($date_all)));
        $data['inventory'] =  MrpInventoryMaterialList::orderBy('id', 'asc')->get();
            
        $diff_stock_material = 0;

        for($day = clone $date_fix_start; $day <= $date_fix_end; $day->modify('+1 month')){
            array_push($data['date'], $day->format('m'));
            $material_incoming = MrpInventoryMaterialIncoming::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-t 23:59:59')])->where("material_id", $request->id_mats)->get();
            $material_out = MrpInventoryMaterialOut::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-t 23:59:59')])->where("inventory_material_list_id", $request->id_mats)->get();
            $material_list = MrpInventoryMaterialList::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-t 23:59:59')])->where('id', $request->id_mats)->get();
            $material = MrpInventoryMaterialList::where('id', $request->id_mats)->get();
            
            $stock_out_material = $material_out->sum('material_outgoing');
            $stock_in_material = $material_incoming->sum('material_incoming');
            // $diff_stock_material = $material_list->sum('stock');
            $initial_stock = $material[0]->initial_stock;
            if($day->format('m') == '01') 
            {
                $diff_stock_material = $initial_stock + $stock_in_material - $stock_out_material;
            } else {
                $diff_stock_material = $diff_stock_material + $stock_in_material - $stock_out_material;

            }


            $target_material_min = $material->sum('target_min');
            $target_material_max = $material->sum('target_max');

            

            // $targetmin = $material_list->sum('target_min');
            // $targetmax = $material_list->sum('target_max');
            
            if ($material[0]->total_target_day == 0) {
                $target_material = 0;
            }else{
                $target_material =  round($diff_stock_material / $material[0]->total_target_day) ;
                
            }
            
            array_push($data['stock_in_material'], $stock_in_material);
            array_push($data['stock_out_material'], $stock_out_material);
            array_push($data['diff_stock_material'], $diff_stock_material);
            array_push($data['target'], $target_material);
            array_push($data['targetmin'], $target_material_min);
            array_push($data['targetmax'], $target_material_max);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'show List ',
            // 'data' => $data['stock_in_material'],
            'data' => [
                'in' => $data['stock_in_material'],
                'out' => $data['stock_out_material'],
                'diff' => $data['diff_stock_material'],
                'target' => $data['target'],
                'target_min' => $data['targetmin'],
                'target_max' => $data['targetmax'],
                'date' => $data['date'],
                'year' => $data1,
            ],
        ], 200);
    }

    public function product_chart(Request $request)
    {
        
        $data['stock_in_product'] = [];
        $data['stock_out_product'] = [];
        $data['diff_stock_product'] = [];
        $data['target'] = [];
        $data['targetmin'] = [];
        $data['targetmax'] = [];
        $data['date'] = [];
        $start_date = new DateTime(date('Y/m/01 00:00:00'));
        // $end_date = new DateTime(date('Y/m/t 23:59:59'));
        $end_date = new DateTime(date('Y/m/t 23:59:59'));
        $data1 = $request->date_value;
        $tahun = substr($data1, 0, 4);
        $bulan = substr($data1, 5, 2);
        $date_all = $tahun."/".$bulan."/01";
        $date_fix_start = new DateTime(date('Y/m/01 00:00:00', strtotime($date_all)));
        $date_fix_end = new DateTime(date('Y/m/t 00:00:00', strtotime($date_all)));
        $data['inventory'] =  MrpInventoryProductList::orderBy('id', 'asc')->get();
            
            if ($request->tipe_interval == "realtime") {

                $diff_stock_product = 0;
                for($day = clone $start_date; $day <= $end_date; $day->modify('+1 day')){
                    array_push($data['date'], $day->format('d'));
                    $product_incoming = MrpInventoryProductIncoming::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')])->where("inventory_product_list_id", $request->id_prods)->get();
                    $product_out = MrpInventoryProductOut::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')])->where("inventory_product_list_id", $request->id_prods)->get();
                    $product_list = MrpInventoryProductList::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')])->where('id', $request->id_prods)->get();
                    $product = MrpInventoryProductList::where('id', $request->id_prods)->get();
                    
                    $target_product_min = $product->sum('target_min');
                    $target_product_max = $product->sum('target_max');
                    $stock_in_product = $product_incoming->sum('product_incoming');
                    $stock_out_product = $product_out->sum('product_outgoing');
                    
                    // $diff_stock_product = $product_list->sum('stock');

                    
                    $initial_stock = $product[0]->initial_stock;
                    if($day->format('d') == '01') 
                    {
                        $diff_stock_product = $initial_stock + $stock_in_product - $stock_out_product;
                    } else {
                        $diff_stock_product = $diff_stock_product + $stock_in_product - $stock_out_product;

                    }

                    
                    if ($product[0]->total_target_day == 0) {
                        $target_product = 0;
                    }else{
                        $target_product =  round($diff_stock_product / $product[0]->total_target_day) ;
                        
                    }
                    
                    array_push($data['stock_in_product'], $stock_in_product);
                    array_push($data['stock_out_product'], $stock_out_product);
                    array_push($data['diff_stock_product'], $diff_stock_product);
                    array_push($data['target'], $target_product);
                    array_push($data['targetmin'], $target_product_min);
                    array_push($data['targetmax'], $target_product_max);
                }
                
            }elseif($request->tipe_interval == "daily"){

                $diff_stock_product = 0;
                for($day = clone $date_fix_start; $day <= $date_fix_end; $day->modify('+1 day')){
                    array_push($data['date'], $day->format('d'));
                    $product_incoming = MrpInventoryProductIncoming::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')])->where("inventory_product_list_id", $request->id_prods)->get();
                    $product_out = MrpInventoryProductOut::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')])->where("inventory_product_list_id", $request->id_prods)->get();
                    $product_list = MrpInventoryProductList::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')])->where('id', $request->id_prods)->get();
                    $product = MrpInventoryProductList::where('id', $request->id_prods)->get();
                    
                    $target_product_min = $product->sum('target_min');
                    $target_product_max = $product->sum('target_max');
                    $stock_in_product = $product_incoming->sum('product_incoming');
                    $stock_out_product = $product_out->sum('product_outgoing');
                    
                    // $diff_stock_product = $product_list->sum('stock');
                    $initial_stock = $product[0]->initial_stock;
                    if($day->format('d') == '01') 
                    {
                        $diff_stock_product = $initial_stock + $stock_in_product - $stock_out_product;
                    } else {
                        $diff_stock_product = $diff_stock_product + $stock_in_product - $stock_out_product;

                    }

                    
                    if ($product[0]->total_target_day == 0) {
                        $target_product = 0;
                    }else{
                        $target_product =  round($diff_stock_product / $product[0]->total_target_day) ;
                        
                    }
                    
                    array_push($data['stock_in_product'], $stock_in_product);
                    array_push($data['stock_out_product'], $stock_out_product);
                    array_push($data['diff_stock_product'], $diff_stock_product);
                    array_push($data['target'], $target_product);
                    array_push($data['targetmin'], $target_product_min);
                    array_push($data['targetmax'], $target_product_max);
                }

            }

            return response()->json([
                'success' => true,
                'message' => 'show List ',
                // 'data' => $data['stock_in_product'],
                'data' => [
                    'in' => $data['stock_in_product'],
                    'out' => $data['stock_out_product'],
                    'diff' => $data['diff_stock_product'],
                    'target' => $data['target'],
                    'target_min' => $data['targetmin'],
                    'target_max' => $data['targetmax'],
                ],
            ], 200);
    }

    public function product_chart_monthly(Request $request) 
    {
        $data['stock_in_product'] = [];
        $data['stock_out_product'] = [];
        $data['diff_stock_product'] = [];
        $data['target'] = [];
        $data['targetmin'] = [];
        $data['targetmax'] = [];
        $data['date'] = [];
        $data1 = $request->year_value;
        $data_date = [];
        $date_all = $data1."/01/01";
        $date_fix_start = new DateTime(date('Y/01/01 00:00:00', strtotime($date_all)));
        $date_fix_end = new DateTime(date('Y/12/01 00:00:00', strtotime($date_all)));
        $data['inventory'] =  MrpInventoryProductList::orderBy('id', 'asc')->get();
        
        $diff_stock_product = 0;

        for($day = clone $date_fix_start; $day <= $date_fix_end; $day->modify('+1 month')){
            array_push($data['date'], $day->format('m'));
            array_push($data_date, $day->format('Y-m-d'));
            $product_incoming = MrpInventoryProductIncoming::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-t 23:59:59')])->where("inventory_product_list_id", $request->id_prods)->get();
            $product_out = MrpInventoryProductOut::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-t 23:59:59')])->where("inventory_product_list_id", $request->id_prods)->get();
            $product_list = MrpInventoryProductList::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-t 23:59:59')])->where('id', $request->id_prods)->get();
            $product = MrpInventoryProductList::where('id', $request->id_prods)->get();
            
            $target_product_min = $product->sum('target_min');
            $target_product_max = $product->sum('target_max');
            $stock_in_product = $product_incoming->sum('product_incoming');
            $stock_out_product = $product_out->sum('product_outgoing');
            
            // $diff_stock_product = $product_list->sum('stock');
            $initial_stock = $product[0]->initial_stock;
            if($day->format('m') == '01') 
            {
                $diff_stock_product = $initial_stock + $stock_in_product - $stock_out_product;
            } else {
                $diff_stock_product = $diff_stock_product + $stock_in_product - $stock_out_product;

            }

            
            if ($product[0]->total_target_day == 0) {
                $target_product = 0;
            }else{
                $target_product =  round($diff_stock_product / $product[0]->total_target_day) ;
                
            }
            
            array_push($data['stock_in_product'], $stock_in_product);
            array_push($data['stock_out_product'], $stock_out_product);
            array_push($data['diff_stock_product'], $diff_stock_product);
            array_push($data['target'], $target_product);
            array_push($data['targetmin'], $target_product_min);
            array_push($data['targetmax'], $target_product_max);
        }

            return response()->json([
                'success' => true,
                'message' => 'show List ',
                // 'data' => $data['stock_in_product'],
                'data' => [
                    'in' => $data['stock_in_product'],
                    'out' => $data['stock_out_product'],
                    'diff' => $data['diff_stock_product'],
                    'target' => $data['target'],
                    'target_min' => $data['targetmin'],
                    'target_max' => $data['targetmax'],
                    'date' => $data['date'],
                    'year' => $data1,
                    'test' => $data_date,
                ],
            ], 200);
    }

    
    
}
