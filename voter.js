$(document).ready(function() {

	// where is the crud api?
	var rootURL = 'voter_php_crud_api.php';

	// using "scroller" datatables extension...
	var dataTable = $('#voterdata').DataTable({
		"select": true,
		"buttons": [ "copy", "csv", "pdf", "print"],
		"dom": "Blrtip",
		"scroller": true, // use the scroller
		"scrollY": 400, // depth of scroller row area
		"scrollCollapse": true, // if not enough rows, then shrink row area
		"lengthChange": false, // hide the page item/length control top left
		"searching": false, // hide built-in search box top right
		"deferRender": true, // only process rows that will show now
		// buttons text...
		buttons: {
			buttons: [
				{ extend: 'copy', text: 'Copy All' },
				'csv',
				'pdf',
				'print'
			]
		},
		// what is each column...
		// ... Database column names are case sensitive...
		"columns": [
			{
				"data": "Name"
			}, {
				"data": "Details"
			}, {
				"data": "Address"
			}
		],
		// what to do with each column...
		"columnDefs": [
			{ // Name
				"targets": [0],
				"visible": true,
				"searchable": false
			}, { // Details
				"targets": [1],
				"visible": true,
				"searchable": false
			}, { // Address
				"targets": [2],
				"visible": true,
				"searchable": false
			}
		]
	});
	
	// get data ...
	// server transform to json objects...
	//findAll('voter_php_crud_api.php/voters?order=id&page=1,5000&transform=1');
	// local transform to json objects...
	//findAll('voter_php_crud_api.php/voters?order=id&page=1,5000');
	function findAll(search) {
		$.ajax({
			type: 'GET',
			url: search,
			dataType: 'json',
			success: function(response) {
				console.log('Success: ', response);
				dataTable.clear();
				// ... server transform to json objects...
				//dataTable.rows.add(response['voters']);
				// ... local transform to json objects...
				console.log(php_crud_api_transform(response)['voters']);
				dataTable.rows.add(php_crud_api_transform(response)['voters']);
				dataTable.draw();
			},
			error: function(xhr, type) {
				console.log(xhr, type);
			}
		});
	}

	// when return key pressed in search box, set url (filter and order) and refresh dataTable.
	// ...order required for page-limiting query item...
	$('.search-input-text').on('keypress', function(ev) {
		if (ev.keyCode == 13) {
			// server transform to json objects...
			//var outPut = rootURL + "/voters?page=1,5000&transform=1";
			// local transform to json objects...
			var outPut = rootURL + "/voters?columns=Name,Details,Address&page=1,5000";
			var n = $('#Name').val().trim();
			var f = $('#First').val().trim();
			var a = $('#Address').val().trim();
			var s = $('#Street').val().trim();
			// collect filters and get ready to set order...
			if (n !== "") {
				outPut += "&filter[]=Name,sw," + n;
				n = "Name";
			}
			if (f !== "") {
				outPut += "&filter[]=First,sw," + f;
				f = "First";
			}
			if (a !== "") {
				outPut += "&filter[]=Address,sw," + a;
				a = "Address";
			}
			if (s !== "") {
				outPut += "&filter[]=Street,sw," + s;
				s = "Street";
			}
			if ((n + f + a + s) !== "") {
				outPut += "&satisfy=all";
				// simple way to only join non-empty strings...
				outPut += "&order=" + $.grep([n, f, a, s], Boolean).join(",");
			} else {
				outPut += "&order=ID";
			}
			console.log(outPut);
			findAll(outPut);
		}
	});

});
