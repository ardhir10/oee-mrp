@extends('mrp')
@section('title', $page_title)
@section('content')
<div class="row ">
    <div class="col-xl-6">
        <div class="white_card mb_30 shadow pt-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <div>
                        <form action="{{route('mrp.material-incoming-update',$material_incoming->id)}}" method="post">
                            @method('patch')
                            @csrf
                            <div class="form-group">
                                <label>Part Name</label>
                                <select class="form-control @error('material_id') is-invalid @enderror" name="material_id" id="material_id">
                                    <option disabled selected>Choose Part Name</option>
                                    @foreach ($inven_material_list as $material)
                                        <option value="{{ $material->id }}" 
                                            {{ ((old('material_id') ?? $material_incoming->inventoryMaterialList->material->id) == $material->material->id) ? 'selected' : '' }}>
                                            {{ $material->material->material_code }} | {{ $material->material->material_name }} | {{ $material->material->part_number }}</option>
                                    @endforeach
                                </select>
                                @error('material_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Qty</label>
                                <input type="number" min="0" onkeyup="changeStock()" value="{{$material_incoming->material_incoming}}" id="material_incoming"
                                    class="form-control @error('material_incoming') is-invalid @enderror" name="material_incoming">
                                @error('material_incoming')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Lot Material</label>
                                <input type="text" maxlength="8" value="{{$material_incoming->lot_material}}" id="lot_material"
                                    class="form-control @error('lot_material') is-invalid @enderror" name="lot_material">
                                @error('lot_material')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- <div class="form-group">
                                <label for="sortir">Sortir</label>
                                <input type="number" onkeyup="changeStock()" value="{{$material_incoming->sortir}}" id="sortir"
                                    class="form-control @error('sortir') is-invalid @enderror" name="sortir">
                                @error('sortir')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div> --}}
                            
                            <div class="form-group">
                                <label>PIC</label>
                                <select class="form-control @error('employee_id') is-invalid @enderror" name="employee_id">
                                    <option disabled selected>Choose PIC</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ ((old('employee_id') ?? $material_incoming->employee->id) == $employee->id) ? 'selected' : '' }}>{{ $employee->employee_name }}</option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- <div class="form-group">
                                <label>Machine</label>
                                <select class="form-control @error('machine_id') is-invalid @enderror" name="machine_id">
                                    <option disabled selected>Choose Machine</option>
                                    @foreach ($machines as $machine)
                                        <option value="{{ $machine->id ?? '' }}" {{ ((old('machine_id') ?? $material_incoming->machine->id ?? '') == $machine->id ?? '') ? 'selected' : '' }}>{{ $machine->machine_name ?? ''}}</option>
                                    @endforeach
                                </select>
                                @error('machine_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> --}}
                            <div class="form-group">
                                <label for="">Tanggal Masuk Conveyor</label>
                                <input type="text" value="{{ $material_incoming->tanggal_masuk_convetor }}" class="form-control digits datepicker-here 
                                    @error('tanggal_masuk_convetor') is-invalid @enderror" id="" data-language="en"
                                    name="tanggal_masuk_convetor" autocomplete="off">
                                    @error('tanggal_masuk_convetor')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                                <div class="form-group">
                                    <label for="">Current Stock</label>
                                    <input type="text" value="{{ $material_incoming->current_stock }}" class="form-control 
                                        @error('current_stock') is-invalid @enderror" id="current_stock" data-language="en" readonly
                                        name="current_stock" autocomplete="off"> 
                                        @error('current_stock')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>
                                
                                <div class="form-group">
                                <label for="">Description <small>(Optional)</small></label>
                                <textarea 
                                    class="form-control @error('description') is-invalid @enderror" name="description">{{$material_incoming->description}}</textarea>
                                @error('description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            </div>
                            <a href="{{ route('mrp.material-incoming-list') }}">
                                <button type="button" class="btn btn-warning btn-sm">Back</button>
                            </a>
                            <button class="btn btn-success btn-sm">Save</button>
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
<link rel="stylesheet" href="{{ asset('assets') }}/vendors/datepicker/date-picker.css"> 

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
<script src="{{ asset('assets') }}/vendors/datepicker/datepicker.js"></script>
<script src="{{ asset('assets') }}/vendors/datepicker/datepicker.en.js"></script>
<script src="{{ asset('assets') }}/vendors/datepicker/datepicker.custom.js"></script>

<script>
    let current_stock = $('#current_stock').val() - $('#material_incoming').val();
    console.log(current_stock);
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

    $('#material_id').change(function(){
        axios.get("/mrp/material-incoming/api/" + $(this).val())
            .then(function (response) {
                // handle success
                current_stock = response.data.stock
                $('#current_stock').val(response.data.stock)
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });
    })
    
    function changeStock() {
        let incoming = $('#material_incoming').val()
        let stock = $('#current_stock').val()


        $('#current_stock').val(current_stock + Number(incoming))
            
    }
</script>
@endpush
