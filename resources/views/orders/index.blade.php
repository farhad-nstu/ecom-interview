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
                <a href="{{url($bUrl.'/create')}}" class="btn bg-gradient-info custom_btn"><i class="mdi mdi-plus"></i> <i class="fa fa-plus-circle"></i> Add New </a>
              </button>

            </div>
          </div>

          <div class="card-body frontoffice-body">

            <div class="col-md-10">
              <form action="{{url($bUrl)}}" method="get" class="form-inline">
                <div class="form-row">
                  <div class="col">
                    <input type="text" name="filter" value="{{ $filter ?? '' }}" placeholder="Search by product name..."
                           class="form-control float-left search_input" />
                  </div>

                  <div class="row">
                    <div class="col">
                      <input type="submit" class="btn btn-primary" value="Filter" />
                      &nbsp;<a class="btn btn-default" href="{{ url($bUrl) }}"> Reset </a>
                    </div>
                  </div>
                </div>
              </form>

              <br>

              <div class="col">
                @if( !empty( Request::query() ) )

                  @if( array_key_exists( 'filter', Request::query() ) )

                    Showing results for

                    @if(!empty($filter) )
                      '{{ $filter }}'
                    @endif

                  @endif

                @endif
              </div>
            </div>

            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="text-center">SL</th>
                  <th class="text-center">User</th>
                  <th class="sort" data-row="name" id="name">Title</th>
                  <th class="text-center">Quantity</th>
                  <th class="text-right">Price</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Date</th>
                  <th class="text-center">Manage</th>
                </tr>
              </thead>

              <tbody>
                @if ($allData->count() > 0)

                  @php
                    $c = 1;
                  @endphp

                  @foreach ($allData as $data)
                    <tr>
                      <td class="text-center">{{ $c+$serial }}</td>
                      <td class="text-center">{{ $data->firstname." ".$data->lastname }}</td>
                      <td class="pl-1">
                        {{ $data->name }} <br> <br>
                        <img src="{{ asset('upload/products/'.$data->picture) }}" width="100" height="80">
                      </td>
                      <td class="text-center">{{ $data->product_quantity }}</td>
                      <td class="text-right">{{ $data->net_price }}</td>
                      <td class="text-center">
                        <a class="dropdown-item" id="action" data-toggle="modal" data-target="#windowmodal"
                              href="{{url($bUrl.'/status/'.$data->$tableID)}}">
                          <button class="btn btn-sm btn-primary">{{ get_status($data->order_status) }}</button>
                        </a>
                      </td>
                      <td class="text-center">{{ $data->order_date }}</td>
                      <td class="text-center">
                        <div class="btn-group">

                        <div class="btn-group">
                          <button type="button" class="btn btn-outline-info">
                            <a href="{{ url($bUrl.'/'.$data->$tableID.'/edit-history') }}">Edit History</a>
                          </button>

                          <button type="button" class="btn btn-outline-info dropdown-toggle dropdown-hover dropdown-icon"
                            data-toggle="dropdown">
                          </button>

                          <div class="dropdown-menu" role="menu" style="">
                            <a class="dropdown-item" href="{{url($bUrl.'/'.$data->$tableID.'/edit')}}"><i
                                class="fa fa-edit"></i>Edit</a>

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" id="action" data-toggle="modal" data-target="#windowmodal"
                              href="{{url($bUrl.'/delete/'.$data->$tableID)}}"><i class="fa fa-trash"></i>Delete</a>
                          </div>
                        </div> 
                      </td>
                    </tr>

                    @php
                      $c++;
                    @endphp

                  @endforeach

                @else

                  <tr>
                    <td colspan="5">There is nothing found.</td>
                  </tr>

                @endif
              </tbody>           
            </table>

            <div class="row mt-4">
              @include('layouts.per_page')
              <div class="col-md-9">
                <div class="pagination_table">
                  {!! $allData->render() !!}
                </div>
              </div>
            </div>

          </div>

          <div class="card-footer">
            {{$title}}
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- Modal -->
  <div class="modal fade" id="windowmodal" tabindex="-1" role="dialog" aria-labelledby="windowmodal"
       aria-hidden="true">
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
  <!-- Modal End -->

@endsection

@push('js')
  <script>
    $(document).ready(function() {

      $('#per_page').on('change', function() {

        $.ajax({
          type: 'POST',
          url: '{{ url($bUrl) }}',
          data: $(this).serialize(),
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(data) {
            window.location.href = '{{ url($bUrl) }}';
          }
        });

      });

    });
  </script>
@endpush