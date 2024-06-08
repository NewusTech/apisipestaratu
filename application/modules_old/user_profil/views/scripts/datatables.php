<script type="text/javascript">
	var t = $('#datatable').DataTable({
        initComplete: function() {
              var api = this.api();
              $('#datatable_filter input')
                  .off('.DT')
                  .on('input.DT', function() {
                      api.search(this.value).draw();
              });
          },
              oLanguage: {
              sProcessing: "loading..."
          },
            responsive: true,
            processing: true,
            serverSide 		: true,
			ajax:{
				url 		: "<?php echo $url;?>",
				type 		: "POST"
			},
			columns 		:[
                {data: null, orderable:false, searchable:false, render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                }},
                {data: 'first_name'},
                {data: 'last_name'},
                {data: 'lokasi_alamat'},
                {data: 'nama'},
                {data: 'action',orderable:false,searchable:false},
			],


        });


</script>