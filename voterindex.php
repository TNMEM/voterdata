<!DOCTYPE html>
<!-- datatables.net jquery plugin code ... datatable doesn't fetch server data. -->
<!-- uses ajax to search database and create array, but paging/sorting local from array. -->
<!-- ... also check out the slimcars project at cloud9 for more on crud interfaces ... -->

<!-- Cloud9 Note: $ rsync -avz --delete -e "ssh" --rsync-path="sudo rsync" . ubuntu@52.6.182.253:/opt/lampp/htdocs/apps/pica-pole/voterdata/ -->

<html>
	<head>
	  <title>Voter Data</title>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css"/>
 
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
		
    <script type="text/javascript" src="voter_config.js"></script>
    
		<script type="text/javascript" language="javascript" >
			$(document).ready(function() {
				
				var rootURL = 'voter_php_crud_api.php';
				
				var dataTable = $('#voterdata').DataTable( {
					"columns": [
          	{ "data": "ID" },
          	{ "data": "Name" },
            { "data": "Details" },
            { "data": "Address" },
            { "data": "First" },
            { "data": "Street" }
        	],
					// what to do with each column...
          // ... searchable to false since I'm handling search just in case...
          "columnDefs": [ 
            { // id
              "targets": [ 0 ],
              "visible": false,
              "searchable": false
            },
            { // name
              "targets": [ 1 ],
              "visible": true,
              "searchable": false
            },
            { // details
              "targets": [ 2 ],
              "visible": true,
              "searchable": false
            },
            { // address
              "targets": [ 3 ],
              "visible": true,
              "searchable": false
            },
            { // first
              "targets": [ 4 ],
              "visible": false,
              "searchable": false
            },
            { // street
              "targets": [ 5 ],
              "visible": false,
              "searchable": false
            }
          ]
				} );

				// get data
				//findAll('voter_php_crud_api.php/voters?order=id&page=1,5&transform=1');
				function findAll(search) {
					$.ajax({
						type: 'GET',
						url: search,
						dataType: 'json',
						success: function(response){
							console.log('Success: ', response);
							dataTable.clear();
							dataTable.rows.add(response['voters']);
							dataTable.draw();
						},
						error: function(xhr, type){
						   console.log(xhr, type);
						}
					});
				}

				$("#voterdata_filter").css("display","none");  // hiding normal global search box
        
        // when return key pressed in search box, get url in order and refresh dataTable.
				$('.search-input-text').on( 'keypress', function (ev) {   // for text boxes
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
						if ((n+f+a+s) !== "") {
							outPut += "&satisfy=all";
						}
						console.log(outPut);
						findAll(outPut);
					}
				} );
        
			} );
		</script>
		<style>
			div.container {
			    margin: 0 auto;
			    max-width:100%;
			}
			div.header {
			    margin: 100px auto;
			    line-height:30px;
			    max-width:100%;
			}
			body {
			    background: #ffffff;
			    color: #686868;
			    font: 70%/1.45em "Helvetica Neue",HelveticaNeue,Verdana,Arial,Helvetica,sans-serif;
			}
		</style>
	</head>
	<body>
		<!-- <div class="header"><h1>DataTable (Server side) Custom Column Search </h1></div> -->
		<div class="container">
			<table id="voterdata"  cellpadding="0" cellspacing="0" border="0" class="cell-border hover" width="100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Details</th>
							<th>Address</th>
							<th>First</th>
							<th>Street</th>
						</tr>
					</thead>
					<thead>
						<tr>
							<th>
              Last&nbsp;Name:<br>
              <input type="text" id="name"  class="search-input-text"><br>
							First&nbsp;Name:<br>
              <input type="text" id="first"  class="search-input-text">
              </th>
							<th>(Enter Search Terms, Press Enter)</th>
<!--
							<th>
								<select id="address"  class="search-input-select">
									<option value="">(Select a range)</option>
									<option value="19-30">19 - 30</option>
									<option value="31-66">31 - 66</option>
								</select>
							</th>
-->
							<th>
              Street&nbsp;Number:<br>
              <input type="text" id="address"  class="search-input-text"><br>
							Street&nbsp;Name:<br>
              <input type="text" id="street"  class="search-input-text">
              </th>
              <th></th>
              <th></th>
						</tr>
					</thead>
			</table>
		</div>
	</body>
</html>
