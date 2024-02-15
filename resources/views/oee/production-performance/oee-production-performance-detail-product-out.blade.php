@extends('oee')

@section('title', $page_title)

@push('css')
<!-- datatable CSS -->
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/responsive.dataTables.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/buttons.dataTables.min.css" />
<!-- <link rel="stylesheet" href="{{asset('assets')}}/css/alert/alertify.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/css/alert/alertify.rtl.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/css/alert/themes/bootstrap.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/css/alert/themes/bootstrap.rtl.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/css/alert/themes/default.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/css/alert/themes/default.rtl.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/css/alert/themes/semantic.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/css/alert/themes/semantic.rtl.min.css" /> -->
<style>
    .chart {
        position: relative;
        display: inline-block;
        width: 150px;
        height: 150px;
        margin-top: 20px;
        text-align: center;
    }

    .chart canvas {
        position: absolute;
        top: 0;
        left: 0;
    }

    .percent {
        display: inline-block;
        line-height: 150px;
        z-index: 2;
        font-weight: 600;
        font-size: 30px;
        color: #645C5C !important;
    }

    .percent-simbol {
        display: inline-block;
        line-height: 150px;
        z-index: 2;
        font-weight: 600;
        font-size: 30px;
    }

    .tags-overview {
        color: #645c5c;
        /* font-weight: bold; */
        font-weight: bolder;
    }


    /* NEW */



    .progress-group {

        text-align: left;

    }

    .progress,
    .progress>.progress-bar,
    .progress .progress-bar,
    .progress>.progress-bar .progress-bar {

        border-radius: 14px !important;

        /*background: #E288A2 !important;*/

    }

    .progress {
        height: 10px !important;
        background-color: #00bdaf1c;
    }

    .a {
        background-color: #319ec92e;
    }

    .p {
        background-color: #f292001f;
    }

    .q {
        background-color: #94c12024;
    }



    .progress-bar-light-blue,
    .progress-bar-a {
        background-color: #319EC9 !important;

    }

    .progress-bar-p {
        background-color: #F29200 !important;

    }

    .progress-bar-q {
        background-color: #94C120 !important;

    }

    .tags-overview {

        color: #645c5c;

        /*font-weight:bold;*/

    }



    .tags-percent-a {
        color: #645C5C;
        font-weight: bold;
    }

    .tags-percent-p {
        color: #645C5C;
        font-weight: bold;
    }

    .tags-percent-q {
        color: #645C5C;
        font-weight: bold;
    }

    .square-10 {
        right: 12px;
        bottom: 11px;
        position: absolute;
        border-radius: 100%;
        border: 2px solid #fff;
        width: 15px;
        height: 15px;
        border-radius: 50%;
    }


    .white_card .white_card_body {
        padding: 5px 30px 45px 30px !important;
    }

    .action_btn2 {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        background: transparent;
        line-height: 30px;
        text-align: center;
        color: red;
        font-size: 12px;
        transition: .3s;
        display: inline-block;
        flex: 32px 0 0;
    }

    /* line 574, G:/admin_project/8 admin/management_html/scss/_button.scss */
    .action_btn2:hover {
        background: red;
        color: #fff;
        box-shadow: 0 5px 10px rgba(136, 79, 251, 0.26);
    }
</style>
@endpush

@section('content')
<div class="row ">
    <div class="col-xl-12">
        <div class="white_card mb_30 shadow ">
            <div class="white_card_header" style="padding:22px 30px 8px 30px !important;">
                <div class="row align-items-center justify-content-between flex-wrap mb-2">
                    <div class="col-lg-4">
                        <div class="main-title d-inline">
                            <h3 class="m-0">{{$page_title}}</h3>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="main-title text-center">
                            <span style="font-size: 18px; color:red;">{{$machine->ident}}</span>
                        </div>
                    </div>
                    <div class="col-lg-4 text-right d-flex justify-content-end">
                        <select class="nice_Select2 max-width-220" onchange="selectType(event)" id="type_interval">
                            <option value="realtime">Realtime</option>
                            <option value="daily">Daily</option>
                            <option value="monthly">Monthly</option>
                        </select>

                        <input type="year" class="hilang input-year" name="interval" id="interval_month" value="{{date('Y')}}">
                        <input type="date" class="hilang input-date" name="interval" id="interval_date" value="{{date('m/d/Y')}}">
                        <input type="date" class="hilang input-date2" name="interval" id="interval_date2" value="{{date('m/d/Y')}}">
                        <button class="button btn-sm btn-primary" onclick="getApiTrending()">SUBMIT</button>
                    </div>
                </div>
                <div class="row align-items-center justify-content-between flex-wrap">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4 text-right d-flex justify-content-end">
                        <button class="btn-sm btn-success mb-2 float-right" onclick="screenShoot('screen', '{{$machine->ident}}')">Download <i class="fa fa-download" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class=" card_box position-relative mb_30 white_bg  shadow bd-0 rounded-20 " id="screen">
            <div class="white_box_tittle" style="padding:10px">
                <div class="main-title2 text-center pt-1">
                    <h6 class="mb-2 nowrap " style="font-size: 18px;">
                        <span class="range-waktu">{{date('Y-m-d')}}</span>
                        <span class="type-daily hilang">Daily</span>
                        <span class="type-monthly hilang">Monthly</span>
                        <span class="type-realtime">Realtime</span>
                        Product Out <span style="font-size: 18px; color:red;">{{$machine->ident}}</span>
                    </h6>
                </div>
            </div>
            <div class="card-body text-center" style="padding:15px 0px 15px 30px">
                <div id="main-trending" style="height: 500px"></div>
            </div><!-- card-body -->
        </div><!-- card -->
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="white_card mb_50 shadow pt-4">
            <div class="float-right d-flex lms_block pr-4">
                <button class="btn btn-primary btn-sm float-right" onclick="addTrouble()">
                    <i class="ti-plus"></i>
                    &nbsp;Add New
                </button>
            </div>
            <div class="white_card_body">
                <div class="QA_section">
                    <!-- <div class="white_box_tittle list_header">
                        <h4>{{$page_title}}</h4>
                    </div> -->

                    <!-- <form action="{{ route('oee.alarm-setting.store') }}" method="post" class="col-12 row"> -->
                    <div class="QA_table mb_60">
                        <!-- table-responsive -->
                        <table class="table lms_table_active3 ">
                            <thead>
                                <tr>
                                    <th scope="col">DATE</th>
                                    <th scope="col">PRODUCT NAME </th>
                                    <th scope="col">SHIFT</th>
                                    <th scope="col">PIC</th>
                                    <th scope="col">STATUS Machine</th>
                                </tr>
                            </thead>
                            <tbody id="effeciencyBody">
                                <!-- <tr>
                                        <td><input type="date" value="" class="form-control @error('date') is-invalid @enderror" name="date" id="date"></td>
                                        <td><input type="text" value="" class="form-control @error('trouble') is-invalid @enderror" name="trouble" id="trouble"></td>
                                        <td><input type="text" value="" class="form-control @error('cause') is-invalid @enderror" name="cause" id="cause"></td>
                                        <td><input type="text" value="" class="form-control @error('action') is-invalid @enderror" name="action" id="action"></td>
                                        <td><input type="text" value="" class="form-control @error('status') is-invalid @enderror" name="status" id="status"></td>
                                    </tr> -->
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-success btn-sm float-right" onclick="storeProductOut()">
                        <i class="ti-save"></i>
                        &nbsp;Save
                    </button>
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')

<!-- Socket -->
<script src="{{asset('assets/js/socket.io.js')}}"></script>
<script src="{{asset('assets')}}/js/jquery.easypiechart.min.js"></script>
<script src="{{asset('assets')}}/vendors/apex_chart/apex-chart2.js"></script>

<script src="{{asset('assets')}}/vendors/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.responsive.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.buttons.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.buttons.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/buttons.flash.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/jszip.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/pdfmake.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/vfs_fonts.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/buttons.html5.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/buttons.print.min.js"></script>
<script src="{{asset('assets')}}/js/html2canvas.js"></script>
<script src="{{asset('assets')}}/js/fileSaver.js"></script>
<script>
    let machine = @JSON($machine);

    function screenShoot(id, machine) {
        html2canvas($("#" + id), {
            onrendered: function(canvas) {
                theCanvas = canvas;


                canvas.toBlob(function(blob) {
                    saveAs(blob, "Detail-Product-Out-" + machine + ".png");
                });
            }
        });
    }

    function addTrouble() {
        $.confirm({
            title: 'Create Product Out',
            content: 'URL:/oee/create-product-out',
            columnClass: 'medium',
            type: 'blue',
            typeAnimated: true,
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function() {
                        let date, product_id, shift_id, machine_id, PIC, status;
                        date = this.$content.find('#date').val();
                        product_id = this.$content.find('#product_id').val();
                        shift_id = this.$content.find('#shift_id').val();
                        machine_id = machine.id;
                        PIC = `{{ Auth::user()->name }}`;
                        status = this.$content.find('#status').val();

                        $.ajax({
                            type: 'POST',
                            url: '/oee/store-product-out',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}",
                                date,
                                product_id,
                                shift_id,
                                machine_id,
                                PIC,
                                status
                            },
                            async: false,
                            success: function(data) {
                                // console.log(data);
                                alert("Succes Insert Data");
                                location.reload();
                            },
                            error: function(data) {
                                // console.log(data);
                                $.alert(data.responseJSON.message);
                            }
                        });
                    }
                },
                cancel: function() {
                    //close
                },
            },
            onContentReady: function() {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function(e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }
    if ($('.lms_table_active3').length) {
        var tableLms = $('.lms_table_active3').DataTable({
            bLengthChange: false,
            "bDestroy": false,
            language: {
                paginate: {
                    next: "<i class='ti-arrow-right'></i>",
                    previous: "<i class='ti-arrow-left'></i>"
                }
            },
            columnDefs: [{
                visible: false
            }],
            responsive: true,
            searching: false,
            info: true,
            paging: true,
            dom: 'Bfrtip',
            buttons: ['csv', 'excel']
        });
    }

    getProductOut();
    async function getProductOut(startDate = null, endDate = null, type = null) {
        const resp = await axios.get("{{ route('get-product-out') }}", {
            params: {
                startDate,
                endDate,
                type,
            }
        });
        if (resp.data.status == 200) {
            tableLms.clear().draw();
            $(".delete").remove();
            console.log(resp.data);
            resp.data.product_out.forEach(d => {
                console.log(d);
                if (d.machine_id == machine.id) {
                    tr = $(
                        `<tr onclick="deleteData(event,${d.id},'${d.product_id}')" class="delete"><td>${d.date}</td><td>${d.product_id}</td><td>${d.shift_id}</td><td>${d.pic}</td><td>${d.status}</td></tr>`
                    )

                    tableLms.row.add(tr[0]).draw();
                }
            });


            // $("#effeciencyBody").append(tr);
        }

        // console.log(resp.data.message);
    }

    var urlDelete = `{{ route('delete-product-out') }}`

    function deleteData(event, id, textData) {
        event.preventDefault();
        $.confirm({
            title: 'Are you sure for delete data ?',
            content: textData,
            buttons: {
                confirm: {
                    btnClass: 'btn-red',
                    keys: ['enter'],
                    action: function() {
                        axios.delete(urlDelete, {
                                params: {
                                    id: id,
                                    text: textData
                                }
                            })
                            .then(function(response) {
                                // handle success
                                alert(response.data.message + ' ' + textData);
                                // console.log(response.data.message + ' ' + textData);
                                location.reload();
                            })
                            .catch(function(error) {
                                // handle error
                                console.log(error);
                            })
                            .then(function() {
                                // always executed
                            });

                    }
                },
                cancel: {
                    btnClass: 'btn-dark',
                    keys: ['esc'],

                },

            }
        });
    }

    // --- Trending Data
    // ./CHART

    console.log(machine.ident.slice(0, 2));
    // variable for save station
    station = [];

    // pengecekan ident machine
    // slice buat ngambil string 
    // parameter 1 posisi karakter pertama yang mau dipotong
    // parameter 2 panjang karakter yang mau di potong
    if (machine.ident.slice(0, 2) == 'MA') {
        // jika 2 karakter di awal mesin adalah MA, maka station akan berisi:
        station = [
            'Actual',
            'Plan',
            'Diff',
        ];
    } else if (machine.ident.slice(0, 2) == 'UP') {
        // jika 2 karakter di awal mesin adalah UP, maka station akan berisi:
        station = [
            'Actual',
            'Plan',
            'Diff',
        ];
    }

    console.log(station);

    // buat nyimpen color
    colors = [
        '#9EDE73',
        'red',
        'blue',
        // '#000000',
        // 'green',
        // '#FAFF00',
        // '#B05B3B',
        // '#001E6C',
        // '#28FFBF',
        // '#AA2EE6',
        // '#D8AC9C',
        // '#9EDE73',
        // '#D90165',
        // '#61B15A',
        // '#D35D6E',
        // '#FCF876',
        // '#9BA4B4',
        // '#F56A79',
        // 'red',
        // 'blue',
    ];

    // buat nyimpen configuration series, yg nanti nya di pake di atribut series buat chart nya
    configSeries = [];

    configSeries.push({
        data: [],
        type: 'line',
        name: 'Plan',
        yAxisIndex: 1,
        label: {
            fontSize: 12,
            color: 'black',
            show: true,
        },
        symbol: 'line',
        itemStyle: {
            color: 'red'
        },
    })
    configSeries.push({
        data: [],
        type: 'line',
        name: 'Diff',
        yAxisIndex: 1,
        label: {
            fontSize: 12,
            color: 'black',
            show: true,
        },
        symbol: 'line',
        itemStyle: {
            color: 'blue'
        },
    })

    // looping variable station yg udah di set berdasarkan ident
    station.forEach((s, i) => {
        // set variable configseries
        configSeries.push({
            name: s,
            label: {
                show: true,
                position: 'inside'
            },
            data: [],
            type: 'bar',
            stack: 'PO',
            itemStyle: {
                color: colors[i]
            },
            emphasis: {
                focus: 'series'
            },
            symbol: "pin",
        });
    });

    console.log(station);
    console.log(configSeries);

    // CHART
    var option;
    option = {
        legend: {
            data: station // get variable station
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross',
                crossStyle: {
                    color: '#999'
                }
            }
        },
       
        dataZoom: [{
                type: 'inside',
                start: 0,
            },
            {
                start: 0,
                handleSize: '100%',
                handleStyle: {
                    color: '#fff',
                    shadowBlur: 10,
                    shadowColor: 'rgba(0, 0, 0, 0.6)',
                    shadowOffsetX: 2,
                    shadowOffsetY: 2
                }
            }
        ],
        toolbox: {
            show: true,
            feature: {
            dataZoom: {
                yAxisIndex: "none"
            },
            dataView: {
                readOnly: false
            },
            magicType: {
                type: ["line", "bar"]
            },
            restore: {},
            saveAsImage: {}
            }
        },
        xAxis: {
            type: 'category',
            boundaryGap: true,
            data: [],
        },
        grid: {
            left: 40,
            right: 40,
            bottom: '10%',
            top: '23%',
            containLabel: true
        },
        // yAxis: {
        //     type: 'value',
        //     axisLabel: {
        //         formatter: '{value} %'
        //     },
        //     max: 100,
        //     interval: 20
        // },
        yAxis: [{
                type: 'value',
                name: 'Actual',
                nameTextStyle:{
                    fontSize: 14,
                    fontWeight: 'bold' ,
                    color: '#293B5F',
                },
                min: 0,
                max: function(value) {
                    return Math.ceil(Number(value.max) * 1.2);
                },
                // interval: 10,
                axisLabel: {
                    formatter: '{value} pcs',
                    fontSize: 14,
                },
            },
            {
                type: 'value',
                name: 'PLAN & DIFF',
                nameTextStyle:{
                    fontSize: 13,
                    fontWeight: 'bold' ,
                    color: '#293B5F',
                },
                // min: 0,
                max: function(value) {
                    return Math.ceil(Number(value.max) * 1.1);
                },
                // interval: 0.5,
                axisLabel: {
                    fontSize: 13,
                    formatter: '{value} pcs'
                },
            }
        ],
        series: configSeries,
    };
    var myChart = echarts.init(document.getElementById('main-trending'));
    myChart.setOption(option);
    option && myChart.setOption(option);


    let type_interval = $('#type_interval').val();
     $('.input-date').on('change',function(){
            if($('.input-date').val() === $('.input-date2').val()){
                $('.range-waktu').text($('.input-date').val());
            }else{
                $('.range-waktu').text($('.input-date').val() +' - '+$('.input-date2').val());
            }
    })

    $('.input-date2').on('change',function(){   
             if($('.input-date').val() === $('.input-date2').val()){
                $('.range-waktu').text($('.input-date').val());
            }else{
                $('.range-waktu').text($('.input-date').val() +' - '+$('.input-date2').val());
            }

    })
    $('.input-year').on('change',function(){
            let dt = $('.input-year').val();

            $('.range-waktu').text(dt);

    })

    function selectType(e) {
        let type = $(e.target).find("option:selected").val();
        if (type === 'daily') {
            $('#interval_date').removeClass('hilang');
            $('#interval_date2').removeClass('hilang');
            $('#interval_month').addClass('hilang');
            $('.type-daily').removeClass('hilang');
            $('.type-monthly').addClass('hilang');
            $('.type-realtime').addClass('hilang');
            
            let dt = $('.input-date').val();
            $('.range-waktu').text(dt);
            
        } else if (type === 'monthly') {
            $('#interval_date').addClass('hilang');
            $('#interval_date2').addClass('hilang');
            $('#interval_month').removeClass('hilang');
            $('.type-daily').addClass('hilang');
            $('.type-monthly').removeClass('hilang');
            $('.type-realtime').addClass('hilang');
            let dt = $('.input-year').val();
            $('.range-waktu').text(dt);
        } else if (type === 'realtime') {
            $('#interval_date').addClass('hilang');
            $('#interval_date2').addClass('hilang');
            $('#interval_month').addClass('hilang');
            $('.type-daily').addClass('hilang');
            $('.type-monthly').addClass('hilang');
            $('.type-realtime').removeClass('hilang');
            let dt =  `{{date('Y-m-d')}}`;
            $('.range-waktu').text(dt);
        }
    }
    const getApiTrending = async () => {
        let date;
        let date2;
        let type = $('#type_interval').val();

        if (type === 'daily') {
            date = $('#interval_date').val();
            date2 = $('#interval_date2').val();
        } else if (type === 'monthly') {
            date = $('#interval_month').val();
        } else {
            date = `{{date('Y-m-d')}}`
            date2 = `{{date('Y-m-d')}}`
        }
        console.log(date)
        console.log(date2)
        try {
            getProductOut(date, date, type);
            const resp = await axios.post(base_url + '/api/oee/production-performance-detail-product-out', {
                'name': machine.name,
                'type': type,
                'date_from': date,
                'date_to': date2,
            });
            // -- generate chart
            let datetimes = [];
            let groupXaxis = [];
            let production_output = [];
            let production_plan = [];
            let production_diff = [];
            resp.data.all_values.forEach(vlues => {
                vlues.data.forEach(dts => {
                    console.log(dts.shift_name)
                    dts.forEach(dtl => {
                        groupXaxis.push(dtl.shift_name)
                        var vll = dtl.values;
                        // console.log('test',(vll.st10_direction + vll.st9_interface) );
                        production_plan.push(vll.production_plan ?? 0)
                        production_diff.push(vll.production_diff ?? 0)
                        if (machine.ident.slice(0, 2) == 'MA') {
                            production_output.push(vll.production_output)
                            
                        } else {
                            production_output.push(vll.production_output)
                        }
                    });
                });
            });
            var emphasisStyle = {
                itemStyle: {
                    shadowBlur: 10,
                    shadowColor: 'rgba(0,0,0,0.3)'
                }
            };


            option.xAxis = [{
                    position: "bottom",
                    data: groupXaxis
                },
                {
                    position: "bottom",
                    data: resp.data.datetime,
                    interval: 1,
                    axisLine: {
                        show: false
                    },
                    axisTick: {
                        alignWithLabel: false,
                        length: 40,
                        align: "left",
                        interval: function(index, value) {
                            return value ? true : false;
                        }
                    },
                    axisLabel: {
                        margin: 30
                    },
                    splitLine: {
                        show: true,
                        interval: function(index, value) {
                            return value ? true : false;
                        }
                    }
                }
            ];

            // console.log("adawd", (production_defect_rate));
            if (machine.ident.slice(0, 2) == 'MA') {
                option.series[0].data = fixValArray(production_plan, 0)
                option.series[1].data = fixValArray(production_diff, 0);
                option.series[2].data = production_output

            } else if (machine.ident.slice(0, 2) == 'UP') {
                option.series[0].data = fixValArray(production_plan, 0);
                option.series[1].data = fixValArray(production_diff, 0);
                option.series[2].data = production_output
            }

            myChart.setOption(option);
            // console.log(resp.data);


        } catch (err) {
            // Handle Error Here
            console.error(err);
        }
    };
    getApiTrending();
    setInterval(() => {
        type_interval = $('#type_interval').val();
        if (type_interval === 'realtime') {
            getApiTrending();
            console.log("Data Updated");
        }
    }, 109000);

    function fixValArray(data, del = 2) {
        value = [];
        data.forEach(element => {
            value.push(element.toFixed(del));
        });
        return value;
    }


    function fix_val(val, del = 2) {
        if (val != undefined || val != null) {
            var rounded = val.toFixed(del).toString().replace('.', ","); // Round Number
            return this.numberWithCommas(rounded); // Output Result
        }

    }

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "");
    }
</script>
@endpush