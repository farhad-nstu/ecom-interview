@push('css')
  <style>
    input.form-control.float-left.search_input{
      width: 250px;
    }
    ul.pagination{
      float: right;
    }
  </style>
@endpush
@extends("master")
@section("content")

  <section class="content">
    <!-- Default box -->
    <div class="row">

      <div class="col-12">
        <div class="card">

          <div class="card-header">
            <h2 class="card-title"> {!! $page_icon !!} &nbsp; {{ $title }} </h2>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>

              <button type="button" class="btn btn-tool" >
                <a href="{{url($bUrl)}}" class="btn bg-gradient-info custom_btn"><i class="mdi mdi-plus"></i> <i class="fa fa-plus-circle"></i> back</a>
              </button>

            </div>
          </div>

          <div class="card-body frontoffice-body">

            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="text-center">SL</th>
                  <th class="text-left">User</th>
                  <th class="text-left">Title</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Order Date</th>
                  <th class="text-center">Edit Date</th>
                  <th class="text-center">Quantity</th>
                  <th class="text-right">Price</th>
                </tr>
              </thead>

              <tbody>
                @if ($allData->count() > 0)

                  @foreach ($allData as $key => $data)
                    <tr>
                      <td class="text-center">{{ ++$key }}</td>
                      <td class="text-center">{{ $data->firstname." ".$data->lastname }}</td>
                      <td class="pl-1">
                        {{ $data->name }} <br> <br>
                        <img src="{{ asset('upload/products/'.$data->picture) }}" width="100" height="80">
                      </td>
                      <td class="text-center">
                        <a class="dropdown-item" id="action" data-toggle="modal" data-target="#windowmodal"
                              href="{{url($bUrl.'/status/'.$data->$tableID)}}">
                          <button class="btn btn-sm btn-primary">{{ get_status($data->order_status) }}</button>
                        </a>
                      </td>
                      <td class="text-center">{{ $data->order_date }}</td>
                      <td class="text-center">{{ $data->edit_date }}</td>
                      <td class="text-center">{{ $data->product_quantity }}</td>
                      <td class="text-right">{{ $data->net_price }}</td>
                    </tr>

                  @endforeach

                @else

                  <tr>
                    <td colspan="5">There is nothing found.</td>
                  </tr>

                @endif
              </tbody>           
            </table>

          </div>

          <div class="card-footer">
            {{$title}}
          </div>

        </div>
      </div>
    </div>
  </section>

@endsection