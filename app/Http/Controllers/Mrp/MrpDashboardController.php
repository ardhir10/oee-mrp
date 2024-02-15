<?php

namespace App\Http\Controllers\Mrp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mrp\MrpPlanningProduction;
use App\Models\Mrp\MrpProduction;
use App\Models\Mrp\MrpWipProcess;
use App\Models\Mrp\MrpProductionProcess;
use App\Models\Mrp\MrpInventoryMaterialIncoming;
use App\Models\Mrp\MrpInventoryProductList;
use App\Models\Mrp\MrpInventoryProductIncoming;
use App\Models\Mrp\MrpInventoryProductOut;
use App\Models\Mrp\MrpInventoryMaterialOut;
use App\Models\Mrp\MrpInventoryShipment;
use App\Models\Mrp\MrpMaterialSortirOK;
use App\Models\Mrp\MrpMaterialSortirNG;
use App\Models\Mrp\MrpProductSortirOK;
use App\Models\Mrp\MrpProductSortirNG;
use App\Models\Mrp\MrpMaterialSortir;
use App\Models\Mrp\MrpProductSortir;
use App\Models\Mrp\MrpInventoryMaterialList;
use App\Models\Mrp\MrpBomMaterial;
use App\Models\Mrp\MrpBom;
use App\Models\Mrp\MrpInventoryMaterial;
use App\Models\Mrp\MrpMaterial;
use DateTime;
use Carbon\Carbon;


class MrpDashboardController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:customer-list', ['only' => ['index']]);
    }

    // public function filterCard(Request $request)
    // {
    //     $date = $request->date;
    //     $startDate = date('Y-m-01 00:00:00', strtotime($date));
    //     $endDate = date('Y-m-t 23:59:59', strtotime($date));

    //     if ($request->material == "all") {
    //         $incoming = MrpInventoryMaterialIncoming::sum('material_incoming');
    //         $sortir = MrpMaterialSortirOK::sum('qty_ok');
    //         $conveyorproduction = MrpInventoryMaterialOut::sum('material_outgoing');
    //         $sortirmaterial = MrpMaterialSortir::sum('qty_sortir');
    //         $rejectmaterial = MrpMaterialSortirNG::sum('qty_ng');
    //     } else {
    //         $ids = MrpInventoryMaterialList::where('material_id', $request->material)->get()->pluck('id');
    //         $incoming = MrpInventoryMaterialIncoming::whereIn('material_id', $ids)->sum('material_incoming');
    //         $sortir = MrpMaterialSortirOK::whereIn('inventory_material_list_id', $ids)->sum('qty_ok');
    //         $conveyorproduction = MrpInventoryMaterialOut::whereIn('inventory_material_list_id', $ids)->sum('material_outgoing');
    //         $sortirmaterial = MrpMaterialSortir::whereIn('inventory_material_list_id', $ids)->sum('qty_sortir');
    //         $rejectmaterial = MrpMaterialSortirNG::whereIn('inventory_material_list_id', $ids)->sum('qty_ng');
    //     }

    //     $data['sumconveyorproduction'] = $conveyorproduction;
    //     $data['sumsortirmaterial'] = $sortirmaterial;
    //     $data['suminsortirmaterial'] = $sortir;
    //     $data['sumrejectmaterial'] = $rejectmaterial;
    //     $data['sumconveyorlogistic'] = $incoming + $sortir;

    //     return $data;
    // }

    // public function filterCardProduct(Request $request)
    // {
    //     $date = $request->date;
    //     $startDate = date('Y-m-01 00:00:00', strtotime($date));
    //     $endDate = date('Y-m-t 23:59:59', strtotime($date));

    //     if ($request->product == "all") {
    //         $sortir = MrpProductSortirOK::sum('qty_ok');
    //         $sortirproduct = MrpProductSortir::sum('qty_sortir');
    //         $rejectproduct = MrpProductSortirNG::sum('qty_ng');
    //     } else {
    //         $ids = MrpInventoryProductList::where('product_id', $request->product)->get()->pluck('id');
    //         $sortir = MrpProductSortirOK::whereIn('inventory_product_list_id', $ids)->sum('qty_ok');
    //         $sortirproduct = MrpProductSortir::whereIn('inventory_product_list_id', $ids)->sum('qty_sortir');
    //         $rejectproduct = MrpProductSortirNG::whereIn('inventory_product_list_id', $ids)->sum('qty_ng');
    //     }

    //     $data['sumsortirproduct'] = $sortirproduct;
    //     $data['suminsortirproduct'] = $sortir;
    //     $data['sumrejectproduct'] = $rejectproduct;

    //     return $data;
    // }

    





    public function indexProduct(Request $request)
    {
 
        // CARD DASHBOARD

        // $data['sumconveyorproduction'] = MrpInventoryMaterialOut::sum('material_outgoing');
        // $data['sumsortirmaterial'] = MrpMaterialSortir::sum('qty_sortir');
        // $data['suminsortirmaterial'] = MrpMaterialSortirOK::sum('qty_ok');
        // $data['sumrejectmaterial'] = MrpMaterialSortirNG::sum('qty_ng');
        // $incoming = MrpInventoryMaterialIncoming::sum('material_incoming');
        // $sortir = MrpMaterialSortirOK::sum('qty_ok');
        
        // $data['sumconveyorlogistic'] = $incoming + $sortir;
    
        // $data['sumsortirproduct'] = MrpProductSortir::sum('qty_sortir');
        // $data['suminsortirproduct'] = MrpProductSortirOK::sum('qty_ok');
        // $data['sumrejectproduct'] = MrpProductSortirNG::sum('qty_ng');
        // $data['conveyor_logistic'] = MrpInventoryMaterialIncoming::orderBy('id', 'asc')->get();
    
        $data['page_title'] = 'Dashboard';
        $data['start_date'] = $request->start_date;
        // $data['end_date'] = $request->end_date;
        $data['status'] = 'generate';
        $data['max'] = MrpInventoryMaterialList::orderBy('created_at','desc')->get();

        if ($request->start_date) {
            $data_start = $request->start_date;
            $start_date = new DateTime(Carbon::parse($data_start)->format('Y/m/d'));
            $end_date = new DateTime(Carbon::parse($data_start)->endOfMonth()->format('Y/m/d'));
        }else{
            $start_date = new DateTime(date('Y/m/01 00:00:00'));
            $end_date = new DateTime(date('Y/m/t 23:59:59'));
        }

        // dd($start_date);

        // Target Min dan Max
        $min = MrpInventoryMaterialList::get();
        $max = MrpInventoryMaterialList::get();
        $min_product = MrpInventoryProductList::get();
        $max_product = MrpInventoryProductList::get();

        $target_material_min = $min->sum('target_min');
        $target_material_max = $max->sum('target_max');
        $target_product_min = $min_product->sum('target_min');
        $target_product_max = $max_product->sum('target_max');
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
        $data['target_material_min'] = $target_material_min;
        $data['target_material_max'] = $target_material_max;
        $data['target_product_min'] = $target_product_min;
        $data['target_product_max'] = $target_product_max;
 
        // 
        for($day = clone $start_date; $day <= $end_date; $day->modify('+1 day')){
                   array_push($data['date'], $day->format('d'));
                    $material_incoming = MrpInventoryMaterialIncoming::find()->whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                    $material_out = MrpInventoryMaterialOut::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                    $material_list = MrpInventoryMaterialList::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                    
                    $stock_in_material = $material_incoming->sum('material_incoming');
                    $stock_out_material = $material_out->sum('material_outgoing')  ;
                    
                    $diff_stock_material = $material_list->sum('stock');

                    if ($material_list->sum('total_target_day') == 0) {
                        $target_material = 0;
                    }else{
                        $target_material =  round($material_list->sum('stock') / $material_list->sum('total_target_day')) ;

                    }

                   array_push($data['stock_in_material'], $stock_in_material);
                   array_push($data['stock_out_material'], $stock_out_material);
                   array_push($data['diff_stock_material'], $diff_stock_material);
                   array_push($data['target_material'], $target_material);
                }

        

        for($day = clone $start_date; $day <= $end_date; $day->modify('+1 day')){
             $product_incoming = MrpWipProcess::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
             $product_out = MrpInventoryShipment::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
             $product_list = MrpInventoryProductList::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);

             $stock_in_product = $product_incoming->sum('qty_good');
             $stock_out_product = $product_out->sum('quantity');
             $diff_stock_product = $product_list->sum('stock');
            
            if ($product_list->sum('total_target_day') == 0) {
                 $target_product = 0;
            }else{
                $target_product =  round($product_list->sum('stock') / $product_list->sum('total_target_day')) ;

                    }
            array_push($data['stock_in_product'], $stock_in_product);
            array_push($data['stock_out_product'], $stock_out_product);
            array_push($data['diff_stock_product'], $diff_stock_product);
            array_push($data['target_product'], $target_product);
         }

         $data['inventory_material'] = MrpInventoryMaterialList::get();
         $data['inventory_product'] = MrpInventoryProductList::get();
        
         
        return view('mrp.dashboard.dashboard-list-product',$data);
    }  
    
    public function index(Request $request)
    {
 
        
    
        $data['page_title'] = 'Dashboard';
        $data['start_date'] = $request->start_date;
        $data['status'] = 'generate';
        $data['max'] = MrpInventoryMaterialList::orderBy('created_at','desc')->get();

        if ($request->start_date) {
            $data_start = $request->start_date;
            $start_date = new DateTime(Carbon::parse($data_start)->format('Y/m/d'));
            $end_date = new DateTime(Carbon::parse($data_start)->endOfMonth()->format('Y/m/d'));
        }else{
            $start_date = new DateTime(date('Y/m/01 00:00:00'));
            $end_date = new DateTime(date('Y/m/t 23:59:59'));
        }


        // Target Min dan Max
        $min = MrpInventoryMaterialList::get();
        $max = MrpInventoryMaterialList::get();
        $min_product = MrpInventoryProductList::get();
        $max_product = MrpInventoryProductList::get();

        $target_material_min = $min->sum('target_min');
        $target_material_max = $max->sum('target_max');
        $target_product_min = $min_product->sum('target_min');
        $target_product_max = $max_product->sum('target_max');
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
        $data['target_material_min'] = $target_material_min;
        $data['target_material_max'] = $target_material_max;
        $data['target_product_min'] = $target_product_min;
        $data['target_product_max'] = $target_product_max;
 
        // 
        for($day = clone $start_date; $day <= $end_date; $day->modify('+1 day')){
                   array_push($data['date'], $day->format('d'));
                    $material_incoming = MrpInventoryMaterialIncoming::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                    $material_out = MrpInventoryMaterialOut::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                    $material_list = MrpInventoryMaterialList::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                    
                    $stock_in_material = $material_incoming->sum('material_incoming');
                    $stock_out_material = $material_out->sum('material_outgoing')  ;
                    
                    $diff_stock_material = $material_list->sum('stock');

                    if ($material_list->sum('total_target_day') == 0) {
                        $target_material = 0;
                    }else{
                        $target_material =  round($material_list->sum('stock') / $material_list->sum('total_target_day')) ;

                    }

                   array_push($data['stock_in_material'], $stock_in_material);
                   array_push($data['stock_out_material'], $stock_out_material);
                   array_push($data['diff_stock_material'], $diff_stock_material);
                   array_push($data['target_material'], $target_material);
                }

        

        for($day = clone $start_date; $day <= $end_date; $day->modify('+1 day')){
             $product_incoming = MrpWipProcess::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
             $product_out = MrpInventoryShipment::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
             $product_list = MrpInventoryProductList::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);

             $stock_in_product = $product_incoming->sum('qty_good');
             $stock_out_product = $product_out->sum('quantity');
             $diff_stock_product = $product_list->sum('stock');
            
            if ($product_list->sum('total_target_day') == 0) {
                 $target_product = 0;
            }else{
                $target_product =  round($product_list->sum('stock') / $product_list->sum('total_target_day')) ;

                    }
            array_push($data['stock_in_product'], $stock_in_product);
            array_push($data['stock_out_product'], $stock_out_product);
            array_push($data['diff_stock_product'], $diff_stock_product);
            array_push($data['target_product'], $target_product);
         }

         $data['inventory_material'] = MrpInventoryMaterialList::get();
         $data['inventory_product'] = MrpInventoryProductList::get();
        
         
        return view('mrp.dashboard.dashboard-list',$data);
    }  
    // FILTER MATERIAL

    public function filterMaterial(Request $request) {
        $data_start = $request->date;
        if($request->material != 'all'){
            
            $mats_choose = MrpInventoryMaterialList::where('material_id', $request->material)->first();
            $material_choose = $mats_choose->material->material_name . ' '. '|';
            $part_number = $mats_choose->material->part_number;
            $data['material_choose'] = $material_choose;
            $data['part_number'] = $part_number;
            $data['month_material'] = $data_start;


        }else{
            $data['material_choose'] = "All Material";
            $data['part_number'] = "";
            $data['month_material'] = $data_start;

        }
        
        // $part_number = $mats_choose->material->part_number;
        

        $start_date = new DateTime(Carbon::parse($data_start)->format('Y/m/d'));
        $end_date = new DateTime(Carbon::parse($data_start)->endOfMonth()->format('Y/m/d'));

        // Target Min dan Max
        if($request->material == 'all'){
            $min = MrpInventoryMaterialList::get();
            $max = MrpInventoryMaterialList::get();
        }else{
            $ids = MrpInventoryMaterialList::where('material_id', $request->material)->get()->pluck('id');
            $min = MrpInventoryMaterialList::whereIn('id', $ids);
            $max = MrpInventoryMaterialList::whereIn('id', $ids);
        }
        

        $target_material_min = $min->sum('target_min');
        $target_material_max = $max->sum('target_max');
        // End Target Min dan Max


        $data['date'] = [];
        $data['stock_in_material'] = [];
        $data['stock_out_material'] = [];
        $data['diff_stock_material'] = [];
        $data['target_material'] = [];
        $data['target_material_min'] = $target_material_min;
        $data['target_material_max'] = $target_material_max;
        
 
        for($day = clone $start_date; $day <= $end_date; $day->modify('+1 day')){
            array_push($data['date'], $day->format('d'));
            // $plan = MrpPlanningProduction::orderBy('id');

            if ($request->material == "all") {
                $material_incoming = MrpInventoryMaterialIncoming::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                $material_out = MrpInventoryMaterialOut::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                $target = MrpInventoryMaterialList::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                // $min = MrpInventoryMaterialList::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                // $max = MrpInventoryMaterialList::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
            } else {
                $ids = MrpInventoryMaterialList::where('material_id', $request->material)->get()->pluck('id');
                $material_incoming = MrpInventoryMaterialIncoming::whereIn('material_id', $ids)->whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                $material_out = MrpInventoryMaterialOut::whereIn('inventory_material_list_id', $ids)->whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                $target = MrpInventoryMaterialList::whereIn('id', $ids)->whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                // $min = MrpInventoryMaterialList::whereIn('id', $ids)->whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                // $max = MrpInventoryMaterialList::whereIn('id', $ids)->whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
            }



            $stock_in_material = $material_incoming->sum('material_incoming');
            $stock_out_material = $material_out->sum('material_outgoing')  ;

            if ($target->sum('total_target_day') == 0) {
                $target_material = 0;
            }else{
                $target_material =  round($target->sum('stock') / $target->sum('total_target_day')) ;

            }
            // $target_material = $target->sum('total_target_day')  ;
            // dd();
            // if($stock_in_material >= $stock_out_material)
            // {
            //     $diff_stock_material =    $material_incoming->sum('material_incoming') - $material_out->sum('material_outgoing');
            // }else{
            //     $diff_stock_material =  $material_out->sum('material_outgoing') - $material_incoming->sum('material_incoming');
                
            // }
            $diff_stock_material = $target->sum('stock');

            // $target_min = $min->sum('target_min');
            // $target_max = $max->sum('target_max');
            array_push($data['stock_in_material'], $stock_in_material);
            array_push($data['stock_out_material'], $stock_out_material);
            array_push($data['diff_stock_material'], $diff_stock_material);
            array_push($data['target_material'], $target_material);
            // array_push($data['target_material_min'], $target_min);
            // array_push($data['target_material_max'], $target_max);
            
        }
        dd($data['diff_stock_material']);

        return $data;
    }

    // FILTER PRODUCT

    public function filterProduct(Request $request) {
        $data_start = $request->date;
        $start_date = new DateTime(Carbon::parse($data_start)->format('Y/m/d'));
        $end_date = new DateTime(Carbon::parse($data_start)->endOfMonth()->format('Y/m/d'));

        if($request->product != 'all'){
            $prods_choose = MrpInventoryProductList::where('product_id', $request->product)->first();
            $product_choose = $prods_choose->product->part_name . ' '. '|';
            $part_number = $prods_choose->product->part_number;
            $data['product_choose'] = $product_choose;
            $data['part_number'] = $part_number;
            $data['month_product'] = $data_start;

        }else{
            $data['product_choose'] = "All Product";
            $data['part_number'] = "";
            $data['month_product'] = $data_start;


        }
        
        // $part_number = $mats_choose->material->part_number;
        // dd($start_date);
        // Target Min dan Max
        if($request->product == 'all'){
            $min = MrpInventoryProductList::get();
            $max = MrpInventoryProductList::get();
        }else{
            $ids = MrpInventoryProductList::where('product_id', $request->product)->get()->pluck('id');
            $min = MrpInventoryProductList::whereIn('id', $ids);
            $max = MrpInventoryProductList::whereIn('id', $ids);
        }
        

        $target_product_min = $min->sum('target_min');
        $target_product_max = $max->sum('target_max');
        // End Target Min dan Max

        $data['date'] = [];
        $data['stock_in_product'] = [];
        $data['stock_out_product'] = [];
        $data['diff_stock_product'] = [];
        $data['target_product'] = [];
        $data['target_product_min'] = $target_product_min;
        $data['target_product_max'] = $target_product_max;
 
        for($day = clone $start_date; $day <= $end_date; $day->modify('+1 day')){
            array_push($data['date'], $day->format('d'));
            // $plan = MrpPlanningProduction::orderBy('id');

            if ($request->product == "all") {
                $product_incoming = MrpInventoryProductIncoming::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                $product_out = MrpInventoryProductOut::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                $target = MrpInventoryProductList::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);

            } else {
                $ids = MrpInventoryProductList::where('product_id', $request->product)->get()->pluck('id');
                $product_incoming = MrpInventoryProductIncoming::whereIn('inventory_product_list_id', $ids)->whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                $product_out = MrpInventoryProductOut::whereIn('inventory_product_list_id', $ids)->whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                $target = MrpInventoryProductList::whereIn('id', $ids)->whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
            }



            $stock_in_product = $product_incoming->sum('product_incoming');
            // dd($stock_in);
            $stock_out_product = $product_out->sum('product_outgoing')  ;
            // if($stock_in_product >= $stock_out_product)
            // {
            //     $diff_stock_product =    $product_incoming->sum('product_incoming') - $product_out->sum('product_outgoing');
            // }else{
            //     $diff_stock_product =  $product_out->sum('product_outgoing') - $product_incoming->sum('product_incoming');
                
            // }
            $diff_stock_product = $target->sum('stock');
            // $target_product = $target->sum('total_target_day')  ;
            if ($target->sum('total_target_day') == 0) {
                $target_product = 0;
            }else{
                $target_product =  round($target->sum('stock') / $target->sum('total_target_day')) ;

            }

            array_push($data['stock_in_product'], $stock_in_product);
            array_push($data['stock_out_product'], $stock_out_product);
            array_push($data['diff_stock_product'], $diff_stock_product);
            array_push($data['target_product'], $target_product);

        }


        return $data;
    }

    public function dashboardLogistic()
    {
        $data['page_title'] = 'List';
        $data['material_incomings'] = MrpInventoryMaterialIncoming::orderBy('id', 'asc')->get();

        return view('mrp.dashboard.conveyor-logistic.conveyor_logistic-list', $data);
    }

    public function dashboardProduction()
    {
        $data['page_title'] = 'Conveyor Production';
        $data['material_outs'] = MrpInventoryMaterialOut::orderBy('id', 'asc')->get();

        return view('mrp.dashboard.conveyor-production.conveyor_production-list', $data);
    }

    public function dashboardTotalSortir()
    {
        $data['page_title'] = 'Conveyor Production';
        $data['material_sortirs'] = MrpMaterialSortir::orderBy('id', 'asc')->get();

        return view('mrp.dashboard.total-sortir.total_sortir-list', $data);
    }

    public function dashboardTotalIn()
    {
        $data['page_title'] = 'Conveyor Production';
        $data['material_sortirs'] = MrpMaterialSortirOk::orderBy('id', 'asc')->get();

        return view('mrp.dashboard.sortir-ok.sortir_ok-list', $data);
    }
    public function dashboardTotalNg()
    {
        $data['page_title'] = 'Conveyor Production';
        $data['material_sortirs'] = MrpMaterialSortirNg::orderBy('id', 'asc')->get();

        return view('mrp.dashboard.sortir-ng.sortir_ng-list', $data);
    }
    
    
}
