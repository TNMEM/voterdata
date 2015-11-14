$(document).ready(function() {

	// where is the crud api?
	var rootURL = 'voter_php_crud_api.php';

	// using "scroller" datatables extension...
	var dataTable = $('#voterdata').DataTable({
		"scroller": true, // use the scroller
		"scrollY": 400, // depth of scroller row area
		"scrollCollapse": true, // if not enough rows, then shrink row area
		"lengthChange": false, // hide the page item/length control top left
		"searching": false, // hide built-in search box top right
		"deferRender": true, // only process rows that will show now
		"columns": [{
			"data": "ID"
		}, {
			"data": "Name"
		}, {
			"data": "Details"
		}, {
			"data": "Address"
		}, {
			"data": "First"
		}, {
			"data": "Street"
		}],
		// what to do with each column...
		// ... searchable to false since I'm handling search...
		"columnDefs": [{ // id
			"targets": [0],
			"visible": false,
			"searchable": false
		}, { // name
			"targets": [1],
			"visible": true,
			"searchable": false
		}, { // details
			"targets": [2],
			"visible": true,
			"searchable": false
		}, { // address
			"targets": [3],
			"visible": true,
			"searchable": false
		}, { // first
			"targets": [4],
			"visible": false,
			"searchable": false
		}, { // street
			"targets": [5],
			"visible": false,
			"searchable": false
		}]
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
			var outPut = rootURL + "/voters?page=1,5000";
			var n = $('#name').val().trim();
			var f = $('#first').val().trim();
			var a = $('#address').val().trim();
			var s = $('#street').val().trim();
			// collect filters and get ready to set order...
			if (n !== "") {
				outPut += "&filter[]=name,sw," + n;
				n = "name";
			}
			if (f !== "") {
				outPut += "&filter[]=first,sw," + f;
				f = "first";
			}
			if (a !== "") {
				outPut += "&filter[]=address,sw," + a;
				a = "address";
			}
			if (s !== "") {
				outPut += "&filter[]=street,sw," + s;
				s = "street";
			}
			if ((n + f + a + s) !== "") {
				outPut += "&satisfy=all";
				// simple way to only join non-empty strings...
				outPut += "&order=" + $.grep([n, f, a, s], Boolean).join(",");
			} else {
				outPut += "&order=id";
			}
			console.log(outPut);
			findAll(outPut);
		}
	});

});
