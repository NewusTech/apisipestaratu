<script type="text/javascript">
    var t2 = $('#datatable2').DataTable();
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
                {data: 'judul'},
                {data: 'user'},
                {data: 'nama'},
                {data: 'tanggal',orderable:false,searchable:false},
                {data: 'action',orderable:false,searchable:false},
			],


        });

        

</script>