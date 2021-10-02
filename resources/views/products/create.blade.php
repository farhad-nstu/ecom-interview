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

        <div class="row">
          <div class="col-sm-6">

            <div class="form-group row">
              <label for="name" class="col-sm-4 col-form-label">Title <code>*</code></label>
              <div class="col-sm-8">
                <input type="text" name="name" id="name" class="form-control" value="{{ getValue('name', $objData) }}" placeholder="Enter Title">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-4 col-form-label" for="picture">Upload Image</label>
              <div class="col-sm-8 documents">
                <div class="custom-file">
                  <input name="picture" type="file" class="custom-file-input" id="picture" style="opacity: 1;">
                  <label class="custom-file-label" for="picture">Choose image</label>
                </div> <br>
                <small class="text-muted">(Insert JPG, JPEG, PNG File)</small>
              </div>
            </div>

          </div>
          <div class="col-sm-6">

            <div class="form-group row">
              <label for="quantity" class="col-sm-4 col-form-label">Quantity</label>
              <div class="col-sm-8">
                <input type="text" name="quantity" id="quantity" class="form-control" value="{{ getValue('quantity', $objData) }}" placeholder="Enter Quantity">
              </div>
            </div>

            <div class="form-group row">
              <label for="price" class="col-sm-4 col-form-label">Price</label>
              <div class="col-sm-8">
                <input class="form-control" name="price"
                    value="{{ getValue('price', $objData) }}" type="text" placeholder="Enter Price" id="price">
              </div>
            </div>

          </div>
        </div>

        <div class="form-group row">
          <label for="description" class="col-sm-2 col-form-label">Description</label>
          <div class="col-sm-10">
            <textarea type="text" name="description" class="form-control" id="summernote" placeholder="text here...">
              {{ getValue('description', $objData) }}
            </textarea>
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