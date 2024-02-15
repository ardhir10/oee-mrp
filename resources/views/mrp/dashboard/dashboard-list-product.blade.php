@extends('mrp')

@section('title', $page_title)

@section('content')
<style>

</style>
{{-- <div class="row ">
    <div class="col-xl-12">
        <div class="white_card mb_30 shadow ">
            <div class="white_card_header">
                <div class="row align-items-center justify-content-between flex-wrap">
                    <div class="col-6">
                        <div class="main-title">
                            <h3 class="m-0 d-inline">{{$page_title}}</h3>
                        </div>
                    </div>

                    <form action="{{ route('dashboard') }}" class="col-1 row">
                        <div class="col-lg-4 text-right d-flex justify-content-end">
                            <select class="nice_Select2 max-width-220" onchange="selectDate(event)" id="type_interval" name="typeInterval">
                                <option value="realtime" {{  Request::get('typeInterval') == "realtime" ? 'selected' : '' }}>Realtime</option>
                                <option value="daily" {{  Request::get('typeInterval') == "daily" ? 'selected' : '' }}>Daily</option>
                                <option value="monthly" {{  Request::get('typeInterval') == "monthly" ? 'selected' : '' }}>Monthly</option>
                            </select>
                            
                            <input type="year" class="d-none" name="dateYear" id="interval_month" value="{{date('Y')}}">
                            
                            <input type="month" name="dateMonth" class="d-none" id="interval_date" value="{{date('Y-m')}}">
                                
                            <select class="nice_Select2 max-width-220" onchange="selectType(event)" id="typeData" name="type">
                                <option value="Material" id="typeMaterial" {{  Request::get('type') == "Material" ? 'selected' : '' }}>Material</option>
                                <option value="Product" id="typeProduct" {{  Request::get('type') == "Product" ? 'selected' : '' }}>Product</option>
                            </select>

                            <button class="button btn-sm btn-primary" type="submit">SUBMIT</button>
                        </div>
                    </form>
                </div>

                <div class="row align-items-center justify-content-between flex-wrap">
                    <div class="col-5"></div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="row">
<div class="col-md-5">
    <div class="white_card mb_30 shadow">
        <div class="card-header tx-medium bd-0 tx-white  d-flex justify-content-between align-items-center"
            style="border-radius: 122px;border-bottom-left-radius: 0px;">
            <h6 class="card-title tx-uppercase text-dark tx-12 mg-b-0">{{$page_title}}</h6>
            <span class="tx-12 tx-uppercase" id=""></span>
        </div><!-- card-header -->
        <div class="card-body  d-xs-flex justify-content-between align-items-center">
            <div class="d-md-flex pd-y-20 pd-md-y-0">   
                <form action="{{ route('dashboard') }}" method="get">
                    <div class="row">
                        <div class="col-lg-12">
                            
                                <span>Select Periode :</span>
                                <br>
                                <div class="input-group " id="datepicker-area">
                                    <span class="input-group-append">
                                        <select class="form-control max-width-220" onchange="selectDate(event)" id="type_interval" name="typeInterval">
                                            <option value="realtime" {{  Request::get('typeInterval') == "realtime" ? 'selected' : '' }}>Realtime</option>
                                            <option value="daily" {{  Request::get('typeInterval') == "daily" ? 'selected' : '' }}>Daily</option>
                                            <option value="monthly" {{  Request::get('typeInterval') == "monthly" ? 'selected' : '' }}>Monthly</option>
                                        </select>
                                        
                                        <input type="year" class="d-none" name="dateYear" id="interval_month" value="{{date('Y')}}">
                                        
                                        <input type="month" name="dateMonth" class="datepicker-year d-none" id="interval_date" value="{{date('Y-m')}}">
                                            
                                        <select class="form-control max-width-220" onchange="selectType(event)" id="typeData" name="type">
                                            <option value="Material" id="typeMaterial" {{  Request::get('type') == "Material" ? 'selected' : '' }}>Material</option>
                                            <option value="Product" id="typeProduct" {{  Request::get('type') == "Product" ? 'selected' : '' }}>Product</option>
                                        </select>

                                    
                                    <span class="input-group-append">
                                        <button type="submit"  class="btn btn-info btn-flat">
                                            <div><i class="fa fa-paper-plane"></i></div>
                                        </button>
                                    </span>
                                </div>
                                <small class="text-muted"><i>*Default ,this date</i></small>
                            

                        </div>
                    </div>
                </form>

            </div>

        </div><!-- card-body -->
    </div><!-- card -->
</div>
</div>
<br>

<div class="row">
    @foreach ($inventory as $product)
    <div class="col-xl-12">
        <div class="white_card mb_30 shadow pt-4">
            <div class="white_card_body">
                <div class="row">
                    <div class="col-12">
                        <button class="btn-sm btn-success mb-2 float-right" onclick="screenShoot('savePNG2_'+{{$product->id}}, '{{ $product->material->part_number ?? $product->product->part_number }} | {{ $product->material->material_name ?? $product->product->part_name }}')"><i class="fa fa-download" aria-hidden="true"></i> Download PNG</button>
                        <table class="table table-bordered" id="savePNG2_{{$product->id}}">
                            <thead>
                                <th colspan="4" >Stock 
                                    <span>{{ Request::get('type') }}</span> - 
                                    {{ $product->material->part_number ?? $product->product->part_number }} | {{ $product->material->material_name ?? $product->product->part_name }} <span style="float: right;" id="bulan">{{ Request::get('typeInterval') == "monthly" ? Request::get('dateYear') : date('F Y', strtotime(Request::get('dateMonth')."-01")) }}</span>
                                </th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="100%">
                                        <div style="text-align: center;">
                                            <div class="chart-container mg-b-20" style="position: relative; margin: auto; height:400px; width: 100%;" id="chartContainerProduct">
                                                <div id="inventory_{{ $product->material->part_number ?? $product->product->part_number }}" style="width:100%; height:400px;">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@push('js')
<script src="{{asset('assets')}}/js/jquery.easypiechart.min.js"></script>
<script src="{{asset('assets')}}/vendors/apex_chart/apex-chart2.js"></script>
<script src="{{ asset('assets') }}/vendors/echart/echarts.min.js"></script>
<script src="{{asset('assets')}}/js/html2canvas.js"></script>
<script src="{{asset('assets')}}/js/fileSaver.js"></script>


<script>
    function screenShoot(id, name) {
        html2canvas($("#"+id), {
                onrendered: function (canvas) {
                    theCanvas = canvas;


                    canvas.toBlob(function (blob) {
                        saveAs(blob, "Stock - "+name+".png");
                    });
                }
            });
    }

 

    // Apex Chart
    /* -------------------------------------------------------------------------- */
    /*                                     chart                                    */
    /* -------------------------------------------------------------------------- */

    let type_interval = $('#type_interval').val();

    function selectDate(e) {
        let type = $(e.target).find("option:selected").val();

        if (type === 'daily') {
            $('#interval_date').removeClass('d-none');
            $('#interval_month').addClass('d-none');
        } else if (type === 'monthly') {
            $('#interval_date').addClass('d-none');
            $('#interval_month').removeClass('d-none');
        } else {
            $('#interval_date').addClass('d-none');
            $('#interval_month').addClass('d-none');
        }
    }
    
    
</script>
<script>

    //MATERIAL
    let date = @json($date);
    let data = @json($inventory);
    let target_material_min = @json($target_material_min);
    let target_material_max = @json($target_material_max);
    let date_value = "{{ Request::get('dateMonth') }}";
    let year_value = "{{ Request::get('dateYear') }}";
    let tipe_interval = "{{ Request::get('typeInterval') }}";
    // let interval_month = $('#interval_month').val();

    if ("{{ Request::get('typeInterval') }}" == "monthly") {
        if ("{{ Request::get('type') }}" == "Material") {
            console.log(data);
                data.forEach(om => {
                    id_mats = om.id
                    $.ajax({
                        url:"{{ route('material-chart-monthly') }}",
                        type:"POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id_mats,
                            tipe_interval,
                            year_value,
                            
                            

                        },
                        success:function (data) {
                            $('#body-chart').removeClass('d-none');
                            console.log(data.data);
                            $('bulan').text(data.data.data1)
                            let stock_in_material = data.data.in;
                            let stock_out_material = data.data.out;
                            let diff_stock_material = data.data.diff;
                            let target = data.data.target;
                            let target_min = data.data.target_min;
                            let target_max = data.data.target_max;
                            let date_val = data.data.date;
                            
                            let divId ='inventory_'+om.material.part_number;
                            generateChartMaterial(divId, date_val, stock_in_material, stock_out_material, diff_stock_material, target, target_min, target_max); 
                        }
                    });
                });

            } else {
                //PRODUCT
            let target_product_min = @json($target_product_min);
            let target_product_max = @json($target_product_max);
            console.log(data);
                data.forEach(om => {
                    id_prods = om.id
                    $.ajax({
                        url:"{{ route('product-chart-monthly') }}",
                        type:"POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id_prods,
                            tipe_interval,
                            year_value

                        },
                        success:function (data) {
                            console.log(data.data);
                            $('#body-chart').removeClass('d-none');
                            let stock_in_product = data.data.in;
                            let stock_out_product = data.data.out;
                            let diff_stock_product = data.data.diff;
                            let target = data.data.target;
                            let target_min = data.data.target_min;
                            let target_max = data.data.target_max;
                            let date_val = data.data.date;

                            
                            let divId ='inventory_'+om.product.part_number;
                            generateChartProduct(divId, date_val, stock_in_product, stock_out_product, diff_stock_product, target, target_min, target_max); 
                        }
                    });
                });
                    
            }
    }else if("{{ Request::get('typeInterval') }}" == "daily" || "{{ Request::get('typeInterval') }}" == "realtime"){
        if ("{{ Request::get('type') }}" == "Material") {
    console.log(data);
    let date_daily = $('interval_date').val()
        data.forEach(om => {
            id_mats = om.id
            $.ajax({
				url:"{{ route('material-chart') }}",
				type:"POST",
				data: {
                    "_token": "{{ csrf_token() }}",
					id_mats,
                    tipe_interval,
                    date_value,
                    date_daily
				},
				success:function (data) {
                    // console.log(data.data.date_realtime);
                    $('#body-chart').removeClass('d-none');
                    // $('#inventory_'+om.material.part_number).text(data.data.date_realtime);
                    let stock_in_material = data.data.in;
                    let stock_out_material = data.data.out;
                    let diff_stock_material = data.data.diff;
                    let target = data.data.target;
                    let target_min = data.data.target_min;
                    let target_max = data.data.target_max;
                    
                    let divId ='inventory_'+om.material.part_number;
                    generateChartMaterial(divId, date, stock_in_material, stock_out_material, diff_stock_material, target, target_min, target_max); 
				}
			});
        });

    } else {
        //PRODUCT
            let target_product_min = @json($target_product_min);
            let target_product_max = @json($target_product_max);
            console.log(data);
                data.forEach(om => {
                    id_prods = om.id
                    $.ajax({
                        url:"{{ route('product-chart') }}",
                        type:"POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id_prods,
                            tipe_interval,
                            date_value

                        },
				success:function (data) {
                    console.log(data.data);
                    $('#body-chart').removeClass('d-none');
                    let stock_in_product = data.data.in;
                    let stock_out_product = data.data.out;
                    let diff_stock_product = data.data.diff;
                    let target = data.data.target;
                    let target_min = data.data.target_min;
                    let target_max = data.data.target_max;
                    
                    let divId ='inventory_'+om.product.part_number;
                    generateChartProduct(divId, date, stock_in_product, stock_out_product, diff_stock_product, target, target_min, target_max); 
				}
			});
        });
            
    }
}else{
    tipe_interval = "realtime";
    date_value = $('#interval_date').val();
        data.forEach(om => {
            id_mats = om.id
            $.ajax({
				url:"{{ route('material-chart') }}",
				type:"POST",
				data: {
                    "_token": "{{ csrf_token() }}",
					id_mats,
                    tipe_interval,
                    date_value
				},
				success:function (data) {
                    console.log(data);
                    $('#body-chart').removeClass('d-none');
                    // $('#inventory_'+om.material.part_number).text(data.data.date_realtime);
                    let stock_in_material = data.data.in;
                    let stock_out_material = data.data.out;
                    let diff_stock_material = data.data.diff;
                    let target = data.data.target;
                    let target_min = data.data.target_min;
                    let target_max = data.data.target_max;
                    
                    let divId ='inventory_'+om.material.part_number;
                    generateChartMaterial(divId, date, stock_in_material, stock_out_material, diff_stock_material, target, target_min, target_max); 
				}
			});
        });
}
    

    
    



    function generateChartMaterial(divId, date, stock_in_material, stock_out_material, diff_stock_material, target, target_min, target_max) {

        var option;
        option = {
            responsive: true,
            maintainAspectRatio: false,
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'cross',
                    crossStyle: {
                        color: '#999'
                    }
                }
            },
            toolbox: {
                feature: {
                    dataView: {
                        show: false,
                        readOnly: false
                    },
                    magicType: {
                        show: true,
                        type: ['line', 'bar']
                    },
                    restore: {
                        show: true
                    },
                    saveAsImage: {
                        show: false
                    }
                }
            },
            dataZoom: [{
                type: 'inside'
            }, {
                type: 'slider'
            }],
            legend: {
                data: ['Tanggal','Stock In', 'Stock Out','Ending Stock', 'Actual Stock (Day)', 'Target Min', 'Target Max']
            },
            xAxis: [{
                type: 'category',
                data: date,
                axisPointer: {
                    type: 'shadow'
                }
            }],
            yAxis: [
                {
                    type: 'value',
                    name: '',
                    min: 0,
                    axisLabel: {
                        formatter: '{value} pcs'
                    }
                },
                {
                    type: 'value',
                    name: 'Target',
                    min: 0,
                    max: function (value) {
                        return Math.ceil(Number(value.max) *1);
                    },
                    // interval: 100,
                    axisLabel: {
                        formatter: '{value} Day'
                    },
                }
            ],
            // color : ['#4908B6','#F78642','#A2D3C6','blue'],
            series: [
                // SETPOINT
                // {
                //     name: 'Target Max',
                //     type: 'bar',
                //     show:false,
                //     yAxisIndex:1,
                //     itemStyle: {
                //         color: '#1F2227'
                //     },
                //     markLine : {
                //         symbol:['circle','pin'],
                //         label :{
                //             show:true,
                //             position:'start'
                //         },
                //         data:[
                //             {
                //                 show:true,
                //                 yAxis:target_max,
                //                 lineStyle : {
                //                     type : 'solid'
                //                 }
                //             }
                //         ]
                //     }
                // },
                // {
                //     name: 'Target Min',
                //     type: 'bar',
                //     show:false,
                //     yAxisIndex:1,
                //     itemStyle: {
                //         color: 'red'
                //     },
                //     markLine : {
                //         symbol:['circle','none'],
                //         label :{
                //             show:true,
                //             position:'start'
                //         },
                //         data:[
                //             {
                //                 show:true,
                //                 yAxis:target_min,
                //                 lineStyle : {
                //                     type : 'solid'
                //                 }
                //             }
                //         ]
                //     }
                // },
                // SETPOINT

                {
                    name: 'Stock In',
                    type: 'bar',
                    data: stock_in_material,
                    yAxisIndex:0,
                    itemStyle: {
                        color: '#28a745'
                    },
                     
                },
                
                {
                    name: 'Stock Out',
                    type: 'bar',
                    data: stock_out_material,
                    yAxisIndex:0,
                    itemStyle: {
                        color: '#dc3545'
                    }
                },
                

                {
                    name: 'Ending Stock',
                    type: 'bar',
                    data: diff_stock_material,
                    yAxisIndex:0,
                    itemStyle: {
                        color: '#884FFB'
                    }
                },
                {
                    name: 'Actual Stock (Day)',
                    type: 'line',
                    data: target,
                    yAxisIndex:1,
                    itemStyle: {
                        color: 'blue'
                    },
                   
                },
                {
                    name: 'Target Min',
                    type: 'line',
                    data: target_min,
                    yAxisIndex:1,
                    itemStyle: {
                        color: 'red'
                    },
                   
                },
                {
                    name: 'Target Max',
                    type: 'line',
                    data: target_max,
                    yAxisIndex:1,
                    itemStyle: {
                        color: 'green'
                    },
                   
                },
                
                
            ]
        };

        var myChart = echarts.init(document.getElementById(divId));
        myChart.setOption(option);
        option && myChart.setOption(option);


          
    }

    

    function generateChartProduct(divId, date, stock_in_product, stock_out_product, diff_stock_product, target, target_min, target_max) {

            var option;
            option = {
                responsive: true,
                maintainAspectRatio: false,
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'cross',
                        crossStyle: {
                            color: '#999'
                        }
                    }
                },
                toolbox: {
                    feature: {
                        dataView: {
                            show: false,
                            readOnly: false
                        },
                        magicType: {
                            show: true,
                            type: ['line', 'bar']
                        },
                        restore: {
                            show: true
                        },
                        saveAsImage: {
                            show: false
                        }
                    }
                },
                dataZoom: [{
                type: 'inside'
                }, {
                    type: 'slider'
                }],
                legend: {
                    data: ['Tanggal','Stock In', 'Stock Out','Ending Stock', 'Actual Stock (Day)', 'Target Min', 'Target Max']
                },
                xAxis: [{
                    type: 'category',
                    data: date,
                    axisPointer: {
                        type: 'shadow'
                    }
                }],
                yAxis: [
                    {
                        type: 'value',
                        name: '',
                        min: 0,
                        axisLabel: {
                            formatter: '{value} pcs'
                        }
                    },
                    {
                        type: 'value',
                        name: 'Target',
                        min: 0,
                        max: function (value) {
                            return Math.ceil(Number(value.max) *1);
                        },
                        // interval: 100,
                        axisLabel: {
                            formatter: '{value} Day'
                        },
                    }
                ],
                // color : ['#4908B6','#F78642','#A2D3C6','blue'],
                series: [
                    // SETPOINT
                    // {
                    //     name: 'Target Max',
                    //     type: 'bar',
                    //     show:false,
                    //     yAxisIndex:1,
                    //     itemStyle: {
                    //         color: '#1F2227'
                    //     },
                    //     markLine : {
                    //         symbol:['circle','pin'],
                    //         label :{
                    //             show:true,
                    //             position:'start'
                    //         },
                    //         data:[
                    //             {
                    //                 show:true,
                    //                 yAxis:target_max,
                    //                 lineStyle : {
                    //                     type : 'solid'
                    //                 }
                    //             }
                    //         ]
                    //     }
                    // },
                    // {
                    //     name: 'Target Min',
                    //     type: 'bar',
                    //     show:false,
                    //     yAxisIndex:1,
                    //     itemStyle: {
                    //         color: 'red'
                    //     },
                    //     markLine : {
                    //         symbol:['circle','none'],
                    //         label :{
                    //             show:true,
                    //             position:'start'
                    //         },
                    //         data:[
                    //             {
                    //                 show:true,
                    //                 yAxis:target_min,
                    //                 lineStyle : {
                    //                     type : 'solid'
                    //                 }
                    //             }
                    //         ]
                    //     }
                    // },
                    // SETPOINT

                    {
                        name: 'Stock In',
                        type: 'bar',
                        data: stock_in_product,
                        yAxisIndex:0,
                        itemStyle: {
                            color: '#28a745'
                        },
                        
                    },
                    
                    {
                        name: 'Stock Out',
                        type: 'bar',
                        data: stock_out_product,
                        yAxisIndex:0,
                        itemStyle: {
                            color: '#dc3545'
                        }
                    },
                    

                    {
                        name: 'Ending Stock',
                        type: 'bar',
                        data: diff_stock_product,
                        yAxisIndex:0,
                        itemStyle: {
                            color: '#884FFB'
                        }
                    },
                    {
                        name: 'Actual Stock (Day)',
                        type: 'line',
                        data: target,
                        yAxisIndex:1,
                        itemStyle: {
                            color: 'blue'
                        },
                    
                    },
                    {
                        name: 'Target Min',
                        type: 'line',
                        data: target_min,
                        yAxisIndex:1,
                        itemStyle: {
                            color: 'red'
                        },
                    
                    },
                    {
                        name: 'Target Max',
                        type: 'line',
                        data: target_max,
                        yAxisIndex:1,
                        itemStyle: {
                            color: 'green'
                        },
                    
                    },
                    
                    
                ]
            };

            var myChart = echarts.init(document.getElementById(divId));
            myChart.setOption(option);
            option && myChart.setOption(option);


            
    }
   

</script>


@endpush
