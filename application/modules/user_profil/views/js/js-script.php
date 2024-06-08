<link href="<?php echo theme_assets('inspina') ?>css/plugins/select2/select2.min.css" rel="stylesheet">
<link href="<?php echo theme_assets('inspina') ?>css/plugins/select2/select2-bootstrap4.min.css" rel="stylesheet">
<script src="<?php echo theme_assets('inspina') ?>js/plugins/select2/select2.full.min.js"></script>
<script>

function setPasswordDefault() {
    $('#password').val("12345678");
    $('#password_confirm').val("12345678");
}
$(document).ready(function() {
    $.fn.select2.defaults.set("theme", "bootstrap4");
    $('.select2Provinsi').select2({
         minimumInputLength: 3,
         ajax: { 
           url: '<?= base_url() ?>lokasi/getProvinsi',
           type: "post",
           dataType: 'json',
           delay: 250,
           data: function (params) {
              return {
                searchTerm: params.term // search term
              };
           },
           processResults: function (response) {
              return {
                 results: response
              };
           },
           cache: true
         }
     });
     $('#lokasi_kab_kota').select2();
     $('#lokasi_kec').select2();
     $('#lokasi_kel').select2();

     $('.select2Provinsi').change(function(e) {
         e.preventDefault();
         var id = $(this).val();
         if(id!='') {
             $.ajax({
                 url: "<?=base_url()?>lokasi/getKabKotaById",
                 data: {id:id},
                 method: 'post',
                 success: function(res) {
                    $('#lokasi_kab_kota').empty();
                    $('#lokasi_kec').empty();
                    $('#lokasi_kel').empty();
                     try {
                        res = JSON.parse(res)
                        res.forEach(element => {
                            $('#lokasi_kab_kota').append(
                                "<option value='"+element.id+"'>"+element.text+"</option>"
                            );
                        });
                     } catch(e) {

                     }
                 },
                 error: function(err) {
                    $('#lokasi_kab_kota').empty();
                    $('#lokasi_kec').empty();
                    $('#lokasi_kel').empty();
                 }
             })
         }else {
            $('#lokasi_kab_kota').empty();
            $('#lokasi_kec').empty();
            $('#lokasi_kel').empty();
         }
     })

     $('.select2Kab').change(function(e) {
         e.preventDefault();
         var id = $(this).val();
         if(id!='') {
             $.ajax({
                 url: "<?=base_url()?>lokasi/getKecById",
                 data: {id:id},
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
             })
         }else {
            $('#lokasi_kec').empty();
         }
     })

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