@if (isset($pagetype) && $pagetype=="report")

	<script src="{{asset('/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('/js/dataTables.buttons.min.js')}}"></script>
	<script src="{{asset('/js/jszip.min.js')}}"></script>
	<script src="{{asset('/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('/js/dataTables.searchPanes.min.js')}}"></script>
	<script src="{{asset('/js/pdfmake.min.js')}}"></script>
	<script src="{{asset('/js/vfs_fonts.js')}}"></script>
	<script src="{{asset('/js/buttons.html5.min.js')}}"></script>
	<script src="{{asset('/js/buttons.colVis.min.js')}}"></script>


	<script>


		// TABLES WITH FILTERS
		$('#products thead tr').clone(true).appendTo( '#products thead' );
		$('#products thead tr:eq(1) th:not(:last)').each( function (i) {
			var title = $(this).text();
			$(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" value="" />' );

			$( 'input', this ).on( 'keyup change', function () {
				if ( table.column(i).search() !== this.value ) {
					table
						.column(i)
						.search( this.value )
						.draw();
				}
			} );
		} );


		var table = $('#products,.products2').DataTable( {
			orderCellsTop: true,
			fixedHeader: true,
			"paging": true,
			"footer": false,
			"pageLength": 100,
			"filter": true,
			"ordering": true,
			deferRender: true,
			dom: 'Bfrtip',
			"order": [0, "asc"],

			buttons: [{
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
			{
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
			{
                extend: 'copyHtml5',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },

				'csv', 'print','colvis',

			]
		});





		$('.buttons-pdf').click(function(){
			$("#products th:last-child, #products td:last-child").remove();
		})
	</script>
@endif
<!--Footer-->
<footer id="footer" class="navbar navbar-expand-lg navbar-dark bg-dark">

        <!--Copyright-->
        <div class="footer-text">
            © {{date("Y")}} Copyright:
            <a href="https://ibotoempire.com/"> Iboto Empire </a>
        </div>
        <!--/.Copyright-->
</footer>
<!--/.Footer-->