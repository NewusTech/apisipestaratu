<link href="<?php echo theme_assets('inspina') ?>css/plugins/select2/select2.min.css" rel="stylesheet">
<link href="<?php echo theme_assets('inspina') ?>css/plugins/select2/select2-bootstrap4.min.css" rel="stylesheet">
<script src="<?php echo theme_assets('inspina') ?>js/plugins/select2/select2.full.min.js"></script>
<script>
$(document).ready(function() {
$.fn.select2.defaults.set("theme", "bootstrap4");
   
     $('#lokasi_kab_kota').select2();
     $('#lokasi_kec').select2();
     $('#lokasi_kel').select2();

     
    $.ajax({
        url: "<?=base_url()?>lokasi/getKecById",
        data: {id:135},
        method: 'post',
        success: function(res) {
        $('#lokasi_kec').empty()
            try {
            res = JSON.parse(res)
            res.forEach(element => {
                $('#lokasi_kec').append(
                    "<option value='"+element.id+"'>"+element.text+"</option>"
                );
            });
            } catch(e) {

            }
        },
        error: function(err) {
        $('#lokasi_kec').empty()
        }
    });

     $('.select2Kec').change(function(e) {
         e.preventDefault();
         var id = $(this).val();
         if(id!='') {
             $.ajax({
                 url: "<?=base_url()?>lokasi/getKelById",
                 data: {id:id},
                 method: 'post',
                 success: function(res) {
                    $('#lokasi_kel').empty()
                     try {
                        res = JSON.parse(res)
                        res.forEach(element => {
                            $('#lokasi_kel').append(
                                "<option value='"+element.id+"'>"+element.text+"</option>"
                            );
                        });
                     } catch(e) {

                     }
                 },
                 error: function(err) {
                    $('#lokasi_kel').empty();
                 }
             })
         }else {
            $('#lokasi_kel').empty();
         }
     })
});
</script>