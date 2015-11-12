<!DOCTYPE html>
<!-- datatables.net jquery plugin code ... datatable doesn't fetch server data. -->
<!-- uses ajax to search database and create array, but paging/sorting local datatable. -->
<!-- ... also check out the slimcars project at cloud9 for more on crud interfaces ... -->

<!-- Cloud9 Note: $ rsync -avz --delete -e "ssh" --rsync-path="sudo rsync" . ubuntu@52.6.182.253:/opt/lampp/htdocs/apps/pica-pole/voterdata/ -->

<html>
<head>
	<title>Voter Data</title>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css" />

	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>

	<script type="text/javascript" src="php_crud_api_transform.js"></script>
	<script type="text/javascript" src="voter_config.js"></script>
	<script type="text/javascript" src="voter.js"></script>

	<style>
		.container {
			margin: 0 auto;
			max-width: 100%;
		}
		
		.header {
			margin: 100px auto;
			line-height: 30px;
			max-width: 100%;
		}
		
		body {
			background: #ffffff;
			color: #686868;
			font: 70%/1.45em "Helvetica Neue", HelveticaNeue, Verdana, Arial, Helvetica, sans-serif;
		}
	</style>
</head>

<body>
	<!-- <div class="header"><h1>DataTable (Server side) Custom Column Search </h1></div> -->
	<div class="container">
		<table id="voterdata" cellpadding="0" cellspacing="0" border="0" class="cell-border hover" width="100%">
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
						Last&nbsp;Name:
						<br>
						<input type="text" id="name" class="search-input-text">
						<br> First&nbsp;Name:
						<br>
						<input type="text" id="first" class="search-input-text">
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
						Street&nbsp;Number:
						<br>
						<input type="text" id="address" class="search-input-text">
						<br> Street&nbsp;Name:
						<br>
						<input type="text" id="street" class="search-input-text">
					</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
		</table>
	</div>
</body>
</html>
