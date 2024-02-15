@extends('mrp')

@section('title', $page_title)

@section('content')
<div class="row ">
    <div class="col-xl-6">
        <div class="white_card mb_30 shadow pt-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <div>
                        <form action="{{route('mrp.vehicle-store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="">Car Code</label>
                                <input type="text" value="{{old('car_code')}}"
                                    class="form-control @error('car_code') is-invalid @enderror" name="car_code">
                                @error('car_code')
                                <span class="text-danger">*Car Code Wajib Diisi!</span>
                                @enderror
                                <br>
                                <label for="">Type</label>
                                <input type="text" value="{{old('type')}}"
                                    class="form-control @error('type') is-invalid @enderror" name="type">
                                @error('type')
                                <span class="text-danger">*Type Wajib Diisi!</span>
                                @enderror
                                <br>
                                <label for="">Driver</label>
                                <input type="text" value="{{old('driver')}}"
                                    class="form-control @error('driver') is-invalid @enderror" name="driver">
                                @error('driver')
                                <span class="text-danger">*Driver Wajib Diisi!</span>
                                @enderror
                                <br>
                                <label for="">Description <small>(Optional)</small></label>
                                <textarea 
                                    class="form-control @error('description') is-invalid @enderror" name="description">{{old('description')}}</textarea>
                                @error('description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                               
                            </div>
                            <a href="{{ route('mrp.vehicle-list') }}">
                                <button type="button" class="btn btn-warning btn-sm">
                                    <i class="ti-back-left"></i>
                                    Back</button>
                            </a>
                            <button class="btn btn-success btn-sm">
                                <i class="ti-save"></i>
                                Save</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<!-- datatable CSS -->
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/responsive.dataTables.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/buttons.dataTables.min.css" />
<style>
    .table tr {
        cursor: pointer;
    }

    .table-hover-custom>tbody>tr:hover {
        background-color: #d1cfcfda !important;
    }

</style>
@endpush
@push('js')
<script src="{{asset('assets')}}/vendors/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.responsive.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.buttons.min.js"></script>
<script>
    // $('.row-permission').click(function () {
    //     let data = $(this).find('td input:checkbox');
    //     console.log(data.prop('checked', !data.is(':checked')));
    // });
    // $('#checkAll').click(function (e) {
    //     // var table= $(e.target).closest('.table');
    //     let find = $('.lms_table_active3').find('tr td input:checkbox').prop('checked', true);
    //     console.log(find);
    // });
    // $('#uncheckAll').click(function (e) {
    //     // var table= $(e.target).closest('.table');
    //     let find = $('.lms_table_active3').find('tr td input:checkbox').prop('checked', false);
    //     console.log(find);
    // });

    if ($('.lms_table_active3').length) {
        $('.lms_table_active3').DataTable({
            bLengthChange: false,
            "bDestroy": false,
            language: {
                search: "<i class='ti-search'></i>",
                searchPlaceholder: 'Quick Search',
                paginate: {
                    next: "<i class='ti-arrow-right'></i>",
                    previous: "<i class='ti-arrow-left'></i>"
                }
            },
            columnDefs: [{
                visible: false
            }],
            responsive: true,
            searching: true,
            info: true,
            paging: true
        });
    }

</script>
@endpush
