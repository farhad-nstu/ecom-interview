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
</style>

@endpush

@extends("master")
@section("content")
<!-- Main content -->
<section class="container-fluid">
  <!-- Default box -->
  <div class="card">

    <div class="card-header">
      <h2 class="card-title"> {!! $page_icon !!} &nbsp; {{ $title }} </h2>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
          <i class="fas fa-minus"></i>
        </button>

        <button type="button" class="btn btn-tool">
          <a href="{{url($bUrl.'/'.$objData->id.'/edit')}}" class="btn btn-info btn-sm"><i class="mdi mdi-plus"></i>
              <i class="fa fa-edit"></i> Edit</a>
          <a href="{{url($bUrl)}}" class="btn btn-info btn-sm"><i class="mdi mdi-plus"></i> <i
                class="fa fa-arrow-left"></i> Back</a>
        </button>
      </div>
    </div>

    <div class="card-body">
      <div class="col-md-11">
        <div class="row">
          <div class="col-md-6">

            <div class="row">
              <label class="col-sm-3">Product Title</label>
              <div class="col-sm-9">
                {{ getValue('name', $objData) }}
              </div>
            </div>

            <div class="row">
              <label class="col-sm-3">Price</label>
              <div class="col-sm-9">
                {{ getValue('price', $objData) }} Tk
              </div>
            </div>

          </div>
          <div class="col-md-6">

            <div class="row">
              <label class="col-sm-3">Quantity</label>
              <div class="col-sm-9">
                {{ getValue('quantity', $objData) }}
              </div>
            </div>

            <div class="row">
              <label class="col-sm-3">Picture</label>
              <div class="col-sm-9">
                <img src="{{ asset('upload/products/'.getValue('picture', $objData)) }}" width="180" height="140">
              </div>
            </div>

          </div>
        </div>

        <div class="row">
          <label class="col-sm-3">Description</label>
          <div class="col-sm-9">
            {!! getValue('description', $objData) !!}
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
<!-- /.content -->



<!-- Modal -->
<div class="modal fade" id="windowmodal" tabindex="-1" role="dialog" aria-labelledby="windowmodal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="windowmodal">&nbsp;</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="spinner-border"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection