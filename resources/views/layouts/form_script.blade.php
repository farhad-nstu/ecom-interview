    <script>
        function formValidation(id, name=''){
            var value = $('#'+id).val();
            if(name == ''){
                name = id;
            }
            name = name.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                return letter.toUpperCase();
            });
            if(value ==''){
                $('#'+id).next('.from_error').html(name+' field is required');
                $('#'+id).css({"border-color":"red"});
                return false;
            }else {
                $('#'+id).next('.from_error').html('');
                $('#'+id).css({"border-color":"#bac2d2"});
                return true;
            }
        }
        function readURL(input, id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#'+id).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $('.onlyNumber').on('keyup', function(e)
        {
            if (/\D/g.test(this.value))
            {
                this.value = this.value.replace(/\D/g, '');
            }
        });
    </script>
