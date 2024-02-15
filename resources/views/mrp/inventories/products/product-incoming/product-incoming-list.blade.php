@extends('mrp')
@section('title', $page_title)
@section('content')
    <div class="row ">
        <div class="col-xl-12">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                        <div class="white_box_tittle list_header">
                            <h4>{{ $page_title }}</h4>

                            <div class="box_right d-flex lms_block">
                                <a href="{{ route('mrp.inventory_product-list') }}">
                                    <div class="btn btn-warning ml-10">
                                        <i class="ti-back-left"></i>
                                        Back
                                    </div>
                                </a>
                                @if (auth()->user()->can('inventory_product_incoming-create'))
                                <a href="{{ route('mrp.product-incoming-create') }}">
                                    <div class="btn btn-primary ml-10">
                                        <i class="ti-plus"></i>
                                        Add New
                                    </div>
                                </a>
                                @endif
                            </div>
                        </div>
                        @if (Session::has('message'))
                            <div class="alert  {{ Session::get('alert-class', 'alert-info') }} d-flex align-items-center justify-content-between"
                                role="alert">
                                <div class="alert-text">
                                    <p>{{ Session::get('message') }}</p>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="ti-close  f_s_14"></i>
                                </button>
                            </div>

                        @endif
                        <div class="QA_table mb_30">
                            <!-- table-responsive -->
                            <table class="table lms_table_active3 " id="table-incoming">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Part Name</th>
                                        <th scope="col">Part Number</th>
                                        <th scope="col">Model</th>
                                        <th scope="col">Incoming</th>
                                        <th scope="col">PIC</th>
                                        <th scope="col">Shift</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <!-- datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/buttons.dataTables.min.css" />
@endpush
@push('js')

    <script src="{{ asset('assets') }}/vendors/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/datatable/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/datatable/js/dataTables.buttons.min.js"></script>
    <script>
        // if ($('.lms_table_active3').length) {
        //     $('.lms_table_active3').DataTable({
        //         bLengthChange: false,
        //         "bDestroy": false,
        //         language: {
        //             search: "<i class='ti-search'></i>",
        //             searchPlaceholder: 'Quick Search',
        //             paginate: {
        //                 next: "<i class='ti-arrow-right'></i>",
        //                 previous: "<i class='ti-arrow-left'></i>"
        //             }
        //         },
        //         columnDefs: [{
        //             visible: false
        //         }],
        //         responsive: true,
        //         searching: true,
        //         info: true,
        //         paging: true
        //     });
        // }

        var urlDelete = `{{ route('mrp.product-incoming-delete') }}`

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
    </script>

    <!-- Yajra -->
<script>
    getIncoming();

    // --- get data by yajra
    async function getIncoming() {
        $('#table-incoming').DataTable().clear().destroy();
        $('#table-incoming').DataTable({
            processing: true,
            serverSide: true,
            ajax: `{{ route('mrp.product-incoming-list-data') }}`,
            columns: [
                {
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {

                    data: 'date',
                    name: 'date',
                },
                {
                    data: 'part_name',
                    name: 'part_name'
                },
                {
                    data: 'part_number',
                    name: 'part_number'
                },
                {
                    data: 'model',
                    name: 'model'
                },
                {
                    data: 'incoming',
                    name: 'incoming'
                },
                {
                    data: 'pic',
                    name: 'pic'
                },
                {
                    data: 'shift',
                    name: 'shift'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'btnAction',
                    name: 'btnAction'
                },


            ],
            createdRow: function (row, data, dataIndex) {
            }
        });
    }
    </script>
@endpush
