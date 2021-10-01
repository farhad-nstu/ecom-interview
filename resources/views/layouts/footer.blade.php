
    <!-- /.content -->
      </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; {{ date('Y') }} <a href="">MOHAMMAD FARHAD</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.0.5
      </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <script>var APP_URL = {!! json_encode(url('/')) !!};</script>
    <script>var pageUrl = {!! json_encode(url($pageUrl ?? '')) !!};</script>

    <!-- jQuery -->
    <script src="{{ asset('backend') }}/plugins/jquery/jquery.min.js"></script>

    @stack('plugin')

    <script type="text/javascript" src="{{url('/')}}/backend/plugins/datepicker/jquery-ui.js"></script>

    <!-- Bootstrap 4 -->
    <script src="{{ asset('backend') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="{{ asset('backend') }}/plugins/select2/js/select2.full.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('backend') }}/dist/js/adminlte.js"></script>
    <!-- Summernote -->
    <script src="{{ asset('backend') }}/plugins/summernote/summernote-bs4.min.js"></script>

    <script src="{{url('backend/custom.js')}}"></script>
    <script src="{{url('backend/js/demo.js')}}"></script>
    <script src="{{url('backend/js/app-helper.js')}}"></script>
    <script src="{{url('backend/js/admin-scripts.js')}}"></script>
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/summernote/summernote-bs4.js">

    <script>
      $(function() {
        $('[data-toggle="tooltip"]').tooltip()
        $('.select2').select2()
        $('#summernote').summernote()
      });
    </script>

    @stack('js')

    @stack('data_table')
    <script src="{{asset('backend/plugins/toastr/toastr.min.js')}}" ></script>
    <!--Show Toaster Notification -->
    @if((Session::has('success')) || (Session::has('error')) || Session::has('message')))
      <script type="text/javascript">
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
        }
        @if (Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
        @elseif(Session::has('message'))
            toastr.info('{{Session::get('message')}}');
        @elseif(Session::has('error'))
            toastr.error('{{ Session::get('error') }}');
        @endif
      </script>
    @endif 
  </body>
</html>