<!-- <hr style="background-color: blue;"> -->
<form action="{{ route('store-product-out') }}" method="POST">
    @csrf

    <div class="card-body">
        <div class="form-group">
            <label for="date">DATE</label>
            <input type="date" value="" class="form-control @error('date') is-invalid @enderror" name="date" id="date">

            @error('date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <label>Product Name</label>

            <select class="form-control @error('product_id') is-invalid @enderror" name="product_id" id="product_id">
                <option disabled selected>Choose Product Name</option>
                @foreach ($products as $product)
                <option value="{{ $product->id }}"
                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
                    {{ $product->product_code }} | {{ $product->part_name }} | {{ $product->part_number }}</option>
                @endforeach
            </select>
            @error('product_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        
        <div class="form-group">
            <label>Shift</label>

            <select class="form-control @error('shift_id') is-invalid @enderror" name="shift_id" id="shift_id">
                <option disabled selected>Choose Shift</option>
                @foreach ($shifts as $shift)
                <option value="{{ $shift->id }}"
                    {{ old('shift_id') == $shift->id ? 'selected' : '' }}>
                    {{ $shift->shift_name }}</option>
                @endforeach
            </select>
            @error('shift_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="status">Status Machine</label>
            <!-- <input type="text" value="" class="form-control @error('status') is-invalid @enderror" name="status" id="status" placeholder="Input status..."> -->
            <textarea class="form-control @error('status') is-invalid @enderror" name="status" style="height:2.4rem;" id="status" placeholder="Input status...">{{old('status')}}</textarea>
            @error('status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</form> 
