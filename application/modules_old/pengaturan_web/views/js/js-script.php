<link href="<?php echo theme_assets('inspina') ?>css/plugins/select2/select2.min.css" rel="stylesheet">
<link href="<?php echo theme_assets('inspina') ?>css/plugins/select2/select2-bootstrap4.min.css" rel="stylesheet">
<script src="<?php echo theme_assets('inspina') ?>js/plugins/select2/select2.full.min.js"></script>
<script>
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
                    res = JSON.parse(res)
                    res.forEach(element => {
                        $('#lokasi_kab_kota').append(
                            "<option value='"+element.id+"'>"+element.text+"</option>"
                        );
                    });
                 },
                 error: function(err) {
                    $('#lokasi_kab_kota').empty();
                 }
             })
         }else {
            $('#lokasi_kab_kota').empty();
         }
     })

});
</script>