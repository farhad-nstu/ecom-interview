<!-- sweetalert js-->
<script src="{{asset('backend/plugins/sweetalert/sweetalert.js')}}"> </script>
<!-- DataTables  & Plugins -->
<script src="{{url('backend')}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{url('backend')}}/plugins/jszip/jszip.min.js"></script>
<script src="{{url('backend')}}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{url('backend')}}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{url('backend')}}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
{{--<script src="{{url('backend')}}/js/adminlte.min.js"></script>--}}
<script src="{{url('backend')}}/js/demo.js"></script>
<script>
    $( document ).ready(function() {
        $(document).on('click', '.sweet', function (e) {
            e.preventDefault();
            var th = $(this);
            var url = $(this).attr("href");
            swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this imaginary file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn-danger',
                    confirmButtonText: 'Yes, delete it!',
                    closeOnConfirm: false,
                    //closeOnCancel: false
                },
                function () {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax(
                        {
                            url: url,
                            type: 'delete',
                            success: function (response)
                            {
                                swal("Deleted!", "Your imaginary file has been deleted!", "success");
                                th.parents("tr").hide();
                            },
                            error: function(xhr) {

                            }
                        });

                });

        });
    });
</script>

