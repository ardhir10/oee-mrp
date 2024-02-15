<!-- <hr style="background-color: blue;"> -->
<form action="{{ route('store-out-api') }}" method="POST">
    @csrf

    <div class="card-body">
        
        <div class="form-group">
            <label for="">Qty Out</label>
            <input  type="number" min="0" value="" id="product_outgoing" class="form-control " name="product_outgoing">
        </div>

        <div class="form-group">
            <label>Delivery</label>
            <select class="form-control delivery_id" name="delivery_shipment_id" id="delivery_shipment_id" onchange="selectDelivery(event)">
                <option disabled selected>Choose Delivery</option>
                @foreach ($delivery_shipments as $deliv)
                        <option value="{{ $deliv->id }}" data-unitid="{{$deliv->customer_id}}"
                            {{ old('delivery_id') == $deliv->id ? 'selected' : '' }}>
                            {{ $deliv->dn_code }}</option>
                    @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Customer</label>
            <select class="form-control customer_deliv" id="delivery_shipment_id" onchange="selectCustomer(event)">
                <option disabled selected>Choose Customer</option>
                @foreach ($delivery_shipments as $deliv)
                        <option value="{{ $deliv->customer_id }}" data-unitid="{{ $deliv->id }}"
                            {{ old('delivery_id') == $deliv->id ? 'selected' : '' }}>
                            {{ $deliv->customer->customer_name }}</option>
                    @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="date">PIC</label>
            <select class="form-control" name="employee_id" id="employee_id">
                <option disabled selected>Choose PIC</option>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}"
                        {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                        {{ $employee->employee_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="">Description <small>(Optional)</small></label>
            <textarea class="form-control" name="description" id="description">
                {{ old('description') }}
            </textarea>
        </div>
    </div>
</form> 

<script>
    function selectDelivery(e){
        var target = event.target;
        var parent = target.parentElement.parentElement;//parent of "target"
        let unitid = $(event.target).parent().parent().find('.delivery_id option:selected').attr('data-unitid');
        $(event.target).parent().parent().find('.customer_deliv').val(unitid)

        console.log(unitid);
    }

    function selectCustomer(e){
        var target = event.target;
        var parent = target.parentElement.parentElement;//parent of "target"
        let unitid = $(event.target).parent().parent().find('.customer_deliv option:selected').attr('data-unitid');
        $(event.target).parent().parent().find('.delivery_id').val(unitid)

        console.log(unitid);
    }
</script>