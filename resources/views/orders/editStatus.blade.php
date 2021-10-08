@include('layouts.header')
<style type="text/css">
  .alert {
    padding: 6px 10px;
    margin-top: 10px
  }

  .alert-warning {
    display: none;
  }

  .alert-success {
    display: none;
  }
</style>

<div class="modal-content">
  <div class="modal-header">
    <h4 class="modal-title" id="myModalLabel"> {{$title}} </h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
      aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body">
      <form method="post" action="{{url($pageUrl)}}" id="delete">
        @csrf

        <div class="alert alert-warning" role="alert">&nbsp;</div>
        <div class="alert alert-success" role="alert">&nbsp;</div>

        <div class="fbody">

          <input type="hidden" name="id" id="id" value="{{ $objData->id }}" />

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

          <div class="form-group row">
            <div class="col-sm-4"></div>
            <div class='col-sm-8'>
              <input type="submit" value="Update" class="btn btn-primary" id="submit" />
            </div>
          </div>

        </div>
      </from>
    </div>
    <div class="modal-footer">
      <button type="button" data-reload="true" class="btn btn-secondary dismiss" data-dismiss="modal">Close</button>
    </div>


    @include('layouts.footerscript')

    <script>
      $(function() {
        $('form#delete').each(function() {
          $this = $(this);
          $this.find('#submit').on('click', function(event) {
            event.preventDefault();
            var str = $this.serialize();
            $.post('{{ url($pageUrl) }}', str, function(response) {
              var jsonObj = $.parseJSON(response);
              if (jsonObj.fail == false) {
                $this.find('.alert-success').html(jsonObj.error_messages).hide()
                .slideDown();
                $this.find('.fbody').hide();
              } else {
                $this.find('.alert-warning').html(jsonObj.error_messages).hide()
                .slideDown();
              }
            });

          });
        });
      });
    </script>