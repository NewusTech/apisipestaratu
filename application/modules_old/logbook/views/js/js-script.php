<link href="<?php echo theme_assets('inspina') ?>css/plugins/select2/select2.min.css" rel="stylesheet">
<link href="<?php echo theme_assets('inspina') ?>css/plugins/select2/select2-bootstrap4.min.css" rel="stylesheet">
<script src="<?php echo theme_assets('inspina') ?>js/plugins/select2/select2.full.min.js"></script>
<script>
$(document).ready(function() {
   $(window).on('popstate', function() {
      location.reload(true);
   });
$.fn.select2.defaults.set("theme", "bootstrap4");
   var kab = $('#lokasi_kec').select2({
            minimumInputLength: 0,
            ajax: { 
            url: '<?= base_url() ?>lokasi/getKecamatanByIdSearch/'+<?=getPengaturanIdentitas()->kabupaten?>,
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

     $('#lokasi_kab_kota').change(function(e) {
      e.preventDefault();
      var id = $(this).val();
      if(id!='') {
         
      }
     })
     
});
</script>