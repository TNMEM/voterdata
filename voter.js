$(document).ready(function() {

	var rootURL = 'voter_php_crud_api.php';

	var dataTable = $('#voterdata').DataTable({
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
		// ... searchable to false since I'm handling search just in case...
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

	// get data
	//findAll('voter_php_crud_api.php/voters?order=id&page=1,5&transform=1');
	function findAll(search) {
		$.ajax({
			type: 'GET',
			url: search,
			dataType: 'json',
			success: function(response) {
				console.log('Success: ', response);
				dataTable.clear();
				dataTable.rows.add(response['voters']);
				dataTable.draw();
			},
			error: function(xhr, type) {
				console.log(xhr, type);
			}
		});
	}

	$("#voterdata_filter").css("display", "none"); // hiding normal global search box

	// when return key pressed in search box, get url in order and refresh dataTable.
	$('.search-input-text').on('keypress', function(ev) { // for text boxes
		if (ev.keyCode == 13) {
			var outPut = rootURL + "/voters?order=id&page=1,5000&transform=1";
			var n = $('#name').val().trim();
			var f = $('#first').val().trim();
			var a = $('#address').val().trim();
			var s = $('#street').val().trim();
			if (n !== "") {
				outPut += "&filter[]=name,sw," + n;
			}
			if (f !== "") {
				outPut += "&filter[]=first,sw," + f;
			}
			if (a !== "") {
				outPut += "&filter[]=address,sw," + a;
			}
			if (s !== "") {
				outPut += "&filter[]=street,sw," + s;
			}
			if ((n + f + a + s) !== "") {
				outPut += "&satisfy=all";
			}
			console.log(outPut);
			findAll(outPut);
		}
	});

});
