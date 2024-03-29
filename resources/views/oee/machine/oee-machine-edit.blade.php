@extends('oee')

@section('title', $page_title)

@section('content')
<div class="row ">
    <div class="col-xl-6">
        <div class="white_card mb_30 shadow pt-4">
            <div class="white_card_body">
                <div class="">
                    <div>
                        <form action="{{ route('oee.machine.update',$machine->id) }}" method="post">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                <label for="">Display Ident</label>
                                <input type="text" value="{{ $machine->ident }}"
                                    class="form-control @error('ident') is-invalid @enderror" name="ident">
                                @error('ident')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Display Name</label>
                                <input type="text" value="{{ $machine->name }}"
                                    class="form-control @error('name') is-invalid @enderror" name="name">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Display Code</label>
                                <input type="text" value="{{ $machine->code }}"
                                    class="form-control @error('code') is-invalid @enderror" name="code">
                                @error('code')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Display Index</label>
                                <input type="number" value="{{ $machine->index }}"
                                    class="form-control @error('index') is-invalid @enderror" name="index">
                                @error('index')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Status</label>
                                <select name="status" class="form-control" id="">
                                    <option value="1" {{$machine->status === 1 ? 'selected' :'' }}>Active</option>
                                    <option value="0" {{$machine->status === 0 ? 'selected' :'' }}>Inactive</option>
                                </select>
                                
                                @error('status')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Target Defect</label>
                                <input type="number" step="0.01" value="{{ $machine->target_defect_rate }}"
                                    class="form-control @error('target_defect_rate') is-invalid @enderror" name="target_defect_rate">
                                @error('target_defect_rate')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="">Target Efficiency</label>
                                <input type="number" step="0.01" value="{{ $machine->target_effeciency }}"
                                    class="form-control @error('target_effeciency') is-invalid @enderror" name="target_effeciency">
                                @error('target_effeciency')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="">Cycle Time</label>
                                <input type="number" step="0.01" value="{{ $machine->cycle_time }}"
                                    class="form-control @error('cycle_time') is-invalid @enderror" name="cycle_time">
                                @error('cycle_time')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                    </div>
                </div>
                <a href="{{ route('oee.machine.index') }}">
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
@endsection

@push('css')
<!-- datatable CSS -->
<link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/responsive.dataTables.min.css" />
<link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/buttons.dataTables.min.css" />
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
<script src="{{ asset('assets') }}/vendors/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/vendors/datatable/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('assets') }}/vendors/datatable/js/dataTables.buttons.min.js"></script>
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
