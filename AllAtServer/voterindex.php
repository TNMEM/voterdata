<!DOCTYPE html>
<!-- /* adapted from http://coderexample.com/datatable-demo-server-side-in-phpmysql-and-ajax/ */ -->
<!-- https://code.jquery.com/ui/ has the themeroller cdn like "smoothness" -->
<!-- https://www.datatables.net/download/ has the datatables download builder ... use jQueryUI, but no style file. -->
<html>
	<head>
	  <title>Voter Data</title>

    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/dataTables.jqueryui.css"/>
 
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/dataTables.jqueryui.js"></script>
    
		<script type="text/javascript" language="javascript" >
			$(document).ready(function() {
				var dataTable = $('#voterdata').DataTable( {
					"processing": true,
					"serverSide": true,
          // tell it how many in whole database table...
          "deferLoading": 542641,
					"ajax":{
						url :"voterdata.php", // json datasource
						type: "POST",  // method  , by default get
						error: function(){  // error handling
							$(".voterdata-error").html("");
							$("#voterdata").append('<tbody class="voterdata-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
							$("#voterdata_processing").css("display","none");
						}
					},
          // what to do with each column...
          // ... searchable to false since I'm handling search just in case...
          "columnDefs": [ 
            { // name
              "targets": [ 0 ],
              "visible": true,
              "searchable": false
            },
            { // details
              "targets": [ 1 ],
              "visible": true,
              "searchable": false
            },
            { // address
              "targets": [ 2 ],
              "visible": true,
              "searchable": false
            },
            { // first
              "targets": [ 3 ],
              "visible": false,
              "searchable": false
            },
            { // street
              "targets": [ 4 ],
              "visible": false,
              "searchable": false
            }
          ]
				} );
        
				$("#voterdata_filter").css("display","none");  // hiding normal global search box
        
        // when a custom search box loses focus as user moves to next search box, search to capture value but don't draw table.
				$('.search-input-text').on( 'blur keypress', function (ev) {   // for text boxes
					var i =$(this).attr('data-column');  // getting column index
					var v =$(this).val();  // getting search input value
          //console.log('Full event name: ' + ev.type + '.' + ev.keyCode);
					if (ev.keyCode == 13) {
					  //search(i, v);
            // actually hit the database on an enter key...
            dataTable.columns(i).search(v).draw();
            //console.log('draw');
          } else if (ev.type == 'blur') {
            // this doesn't hit database moving box to box... as far as I can tell viewing browser debugger...
            dataTable.columns(i).search(v);
            //console.log('no draw');
          }
				} );
        
				$('.search-input-select').on( 'change', function () {   // for select boxes
					var i =$(this).attr('data-column');  
					var v =$(this).val();  
					//search(i, v);
          dataTable.columns(i).search(v).draw;
				} );
        
				// special function to delay firing of draw() so that every event doesn't fire SQL...
        //var search = $.fn.dataTable.util.throttle(
        // function ( i, v ) {
        //  dataTable.columns(i).search(v).draw();
        // },
        // // time to delay in ms...
        // 10000
       //);
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
			<table id="voterdata"  cellpadding="0" cellspacing="0" border="0" class="compact hover cell-border" width="100%">
					<thead>
						<tr>
							<th>Name</th>
							<th>Details</th>
							<th>Address</th>
							<th>first</th>
							<th>Street</th>
						</tr>
					</thead>
					<thead>
						<tr>
							<th>
              Last&nbsp;Name:<br>
              <input type="text" data-column="0"  class="search-input-text"><br>
							First&nbsp;Name:<br>
              <input type="text" data-column="3"  class="search-input-text">
              </th>
							<th>(Enter Search Terms, Press Enter)</th>
<!--
							<th>
								<select data-column="2"  class="search-input-select">
									<option value="">(Select a range)</option>
									<option value="19-30">19 - 30</option>
									<option value="31-66">31 - 66</option>
								</select>
							</th>
-->
							<th>
              Street&nbsp;Number:<br>
              <input type="text" data-column="2"  class="search-input-text"><br>
							Street&nbsp;Name:<br>
              <input type="text" data-column="4"  class="search-input-text">
              </th>
              <th></th>
              <th></th>
						</tr>
					</thead>
			</table>
		</div>
	</body>
</html>
