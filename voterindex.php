<!DOCTYPE html>
<!-- datatables.net jquery plugin code ... datatable doesn't fetch server data. -->
<!-- uses ajax to search database and create array, but paging/sorting local datatable. -->
<!-- ... also check out the slimcars project at cloud9 for more on crud interfaces ... -->

<!-- Cloud9 Note: $ rsync -avz --delete -e "ssh" --rsync-path="sudo rsync" . ubuntu@52.6.182.253:/opt/lampp/htdocs/apps/pica-pole/voterdata/ -->

<html>
<head>
	<title>Voter Data</title>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.0/css/buttons.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/scroller/1.4.0/css/scroller.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.1.0/css/select.dataTables.min.css"/>
 
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.0/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/scroller/1.4.0/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.1.0/js/dataTables.select.min.js"></script>

	<script type="text/javascript" src="php_crud_api_transform.js"></script>
	<script type="text/javascript" src="voter_config.js"></script>
	<script type="text/javascript" src="voter.js"></script>

	<style>
		body {
			background: #ffffff;
			color: #686868;
			font: 70%/1.45em "Helvetica Neue", HelveticaNeue, Verdana, Arial, Helvetica, sans-serif;
		}

		.header {
			margin: 10px auto;
			line-height: 30px;
			max-width: 100%;
		}
		
		.container {
			margin: 0 auto;
			max-width: 100%;
		}
	</style>
</head>

<body>
	<div class="header"><h3>December 12, 2014</h3></div>
	<div class="container">
		<table id="voterdata" cellpadding="0" cellspacing="0" border="0" class="cell-border hover" width="100%">
			<thead>
				<tr>
					<th>Name</th>
					<th>Details</th>
					<th>Address</th>
				</tr>
			</thead>
			<thead>
				<tr>
					<th>
						Last&nbsp;Name:
						<br>
						<input type="text" id="Name" class="search-input-text">
						<br> First&nbsp;Name:
						<br>
						<input type="text" id="First" class="search-input-text">
					</th>
					<th>
						(Enter Search Terms, Press Enter)
					</th>
					<th>
						Street&nbsp;Number:
						<br>
						<input type="text" id="Address" class="search-input-text">
						<br> Street&nbsp;Name:
						<br>
						<input type="text" id="Street" class="search-input-text">
					</th>
				</tr>
			</thead>
		</table>
	</div>
</body>
</html>
