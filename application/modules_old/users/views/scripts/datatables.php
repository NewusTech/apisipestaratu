<script type="text/javascript">
function setPasswordDefault() {
    $(document).getElementById('password').value = "12345678";
    $(document).getElementById('password_confirm').value = "12345678";
}


	$('#datatable').DataTable({
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
                {data: 'first_name'},
                {data: 'last_name'},
                {data: 'email'},
                {data: 'groups'},
                {data: 'status'},
                {data: 'action'},
			],


        });
</script>