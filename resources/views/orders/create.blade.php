@push('css')
<style>
#tooltip {
  position: absolute;
  right: -2%;
  top: 25%;
}

#tooltip .fa {
  font-size: 14px;
  color: #666
}

.documents .tooltiptext {
  visibility: hidden;
  width: 250px;
  background-color: white;
  color: green;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;

  /* Position the tooltip */
  position: absolute;
  z-index: 1;
}

.documents:hover .tooltiptext {
  visibility: visible;
}
</style>

@endpush

@extends("master")
@section("content")
<!-- Main content -->
<section class="container-fluid">
  <div class="card">

    <div class="card-header">
      <h2 class="card-title"> {!! $page_icon !!} &nbsp; {{ $title }} </h2>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
          <i class="fas fa-minus"></i>
        </button>

        <button type="button" class="btn btn-tool" >
          <a href="{{url($bUrl)}}" class="btn btn-info btn-sm"><i class="mdi mdi-plus"></i> <i class="fa fa-arrow-left"></i> Back</a>
        </button>
      </div>
    </div>

    <form method="post" action="{{url($bUrl.'/store')}}" enctype="multipart/form-data">
      @csrf

      <div class="card-body">

        {!! validation_errors($errors) !!}

        <input type="hidden" value="{{ getValue($tableID, $objData) }}" id="id" name="{{ $tableID }}">

        <input type="hidden" value="1" id="id" name="user_id">

        <div class="row">
          <div class="col-sm-6">

            <div class="form-group row">
              <label for="employee" class="col-sm-4 col-form-label">Product <code>*</code></label>
              <div class="col-sm-8">
                <select name="product_id" id="product_id" class="form-control select2" style="width: 100%;">
                  <option value="">Select Product</option>
                  @foreach($products as $product)
                  <option  {{($product->id == getValue('product_id',$objData))? 'selected':''}} value="{{$product->id}}">{{$product->name}}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label for="product_quantity" class="col-sm-4 col-form-label">Quantity <code>*</code></label>
              <div class="col-sm-8">
                <input type="text" name="product_quantity" id="product_quantity" class="form-control" value="{{ getValue('product_quantity', $objData) }}" placeholder="Enter Quantity">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Order Date</label>
              <div class="col-sm-8">
                <input class="form-control dateOfBirth" name="order_date"
                    value="{{ getValue('order_date', $objData) }}" type="text" autocomplete="off" placeholder="YY-MM-DD" id="order_date" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label for="shipping_address" class="col-sm-4 col-form-label">Shipping Address</label>
              <div class="col-sm-8">
                <input type="text" name="shipping_address" id="shipping_address" class="form-control" value="{{ getValue('shipping_address', $objData) }}">
              </div>
            </div>

          </div>
          <div class="col-sm-6">

            <div class="form-group row">
              <label for="shipping_cost" class="col-sm-4 col-form-label">Shipping Cost</label>
              <div class="col-sm-8">
                <input type="text" name="shipping_cost" id="shipping_cost" class="form-control" value="{{ getValue('shipping_cost', $objData) }}">
              </div>
            </div>

            <div class="form-group row">
              <label for="net_price" class="col-sm-4 col-form-label">Net Price</label>
              <div class="col-sm-8">
                <input class="form-control" name="net_price"
                    value="{{ getValue('net_price', $objData) }}" type="text" id="net_price">
              </div>
            </div>

            <div class="form-group row">
              <label for="order_status" class="col-sm-4 col-form-label">Status</label>
              <div class="col-sm-8">
                <select name="order_status" id="order_status" class="form-control" style="width: 100%;">
                  <option value="">Select Status</option>
                  <option {{(getValue('order_status', $objData) == 'approved') ? 'selected':''}} value="approved">Approved
                  </option>
                  <option {{(getValue('order_status', $objData) == 'rejected') ? 'selected':''}} value="rejected">Rejected
                  </option>
                  <option {{(getValue('order_status', $objData) == 'processing') ? 'selected':''}} value="processing">Processing
                  </option>
                  <option {{(getValue('order_status', $objData) == 'shipped') ? 'selected':''}} value="shipped">Shipped
                  </option>
                  <option {{(getValue('order_status', $objData) == 'delivered') ? 'selected':''}} value="delivered">Delivered
                  </option>
                </select>
              </div>
            </div>

          </div>
        </div>

      </div>

      <div class="card-footer">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group row">
              <div class="col-sm-4"></div>
              <div class="col-sm-8">
                @if(empty(getValue($tableID, $objData)))
                <button type="submit" class="btn btn-primary">Save</button>&nbsp;&nbsp;
                @else 
                <button type="submit" class="btn btn-primary">Update</button>&nbsp;&nbsp;
                @endif 
                <a href="{{url($bUrl)}}" class="btn btn-warning">Cancel</a>
              </div> 
            </div>
          </div>
        </div>
      </div>

    </form>
  </div>
</section>
@endsection

@push('js')
  <script>
    $(function() {
      $('[data-toggle="tooltip"]').tooltip()

      $('[data-toggle="documents"]').tooltip()
    })
  </script>
@endpush