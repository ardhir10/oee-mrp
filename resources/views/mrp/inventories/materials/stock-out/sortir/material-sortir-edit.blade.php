@extends('mrp')
@section('title', $page_title)
@section('content')
<div class="row ">
    <div class="col-xl-6">
        <div class="white_card mb_30 shadow pt-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <div>
                        <form action="{{route('mrp.material-sortir-update',$material_sortir->id)}}" method="post">
                            @method('patch')
                            @csrf
                            <div class="form-group">
                                <label>Material</label>
                                <select class="form-control @error('inventory_material_list_id') is-invalid @enderror" name="inventory_material_list_id" id="inventory_material_list_id">
                                    <option disabled selected>Choose Part Name</option>
                                    @foreach ($inven_materials as $material)
                                        <option value="{{ $material->id }}" 
                                            {{ ((old('inventory_material_list_id') ?? $material_sortir->inventoryMaterialList->material->id) == $material->material->id) ? 'selected' : '' }}>
                                            {{ $material->material->material_code }} | {{ $material->material->material_name }} | {{ $material->material->part_number }}</option>
                                    </option>
                                    @endforeach
                                </select>
                                @error('inventory_material_list_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Qty Recheck</label>
                                <input type="number" min="0" value="{{$material_sortir->qty_sortir}}" id="qty_sortir" onkeyup="changeStock()"
                                    class="form-control @error('qty_sortir') is-invalid @enderror" name="qty_sortir">
                                @error('qty_sortir')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            
                            <div class="form-group">
                                <label>PIC</label>
                                <select class="form-control @error('employee_id') is-invalid @enderror" name="employee_id">
                                    <option disabled selected>Choose PIC</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ ((old('employee_id') ?? $material_sortir->employee->id) == $employee->id) ? 'selected' : '' }}>{{ $employee->employee_name }}</option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Current Stock</label>
                                <input type="number" min="0" value="{{ $material_sortir->current_stock }}" class="form-control  
                                    @error('current_stock') is-invalid @enderror" id="current_stock" data-language="en" readonly
                                    name="current_stock" autocomplete="off"> 
                                    @error('current_stock')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                                
                                <div class="form-group">
                                <label for="">Description <small>(Optional)</small></label>
                                <textarea 
                                    class="form-control @error('description') is-invalid @enderror" name="description">{{$material_sortir->description}}</textarea>
                                @error('description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            </div>
                            <a href="{{ route('mrp.material-sortir-list') }}">
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
    let current_stock = Number($('#current_stock').val()) + Number($('#qty_sortir').val());
    console.log(current_stock);
   

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
    $('#inventory_material_list_id').change(function(){
        axios.get("/mrp/material-o/api/" + $(this).val())
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
        let sortir = $('#qty_sortir').val()
        let stock = $('#current_stock').val()


        $('#current_stock').val(current_stock - Number(sortir))
            
    }
    
</script>
@endpush
