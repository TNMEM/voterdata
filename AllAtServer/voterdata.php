<?php
/* adapted from http://coderexample.com/datatable-demo-server-side-in-phpmysql-and-ajax/ */
// Always index db columns and avoid "like '%xxx%'" and use "like 'xxx%'" instead.
// Limit amount of return also makes it easier on db software.

/* Database connection start */
$servername = "awsmysql.cuuagsmfyvhg.us-east-1.rds.amazonaws.com";
$username = "LOUTEST";
$password = "LOUTEST";
$dbname = "LOUTEST";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'name', 
	1 =>'details',
	2=>'address',
	3=>'first',
	4=>'street'
);

// Table's primary key
$primaryKey = 'id';

// getting total number records without any search
$sql = "SELECT name, details, address, first, street ";
$sql.=" FROM voters";
$query=mysqli_query($conn, $sql) or die("voterdata.php: get voterdata");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT name, details, address, first, street ";
$sql.=" FROM voters WHERE 1 = 1";

// getting records as per search parameters
if( !empty($requestData['columns'][0]['search']['value']) ){
	$sql.=" AND name LIKE '".$requestData['columns'][0]['search']['value']."%' ";
}
if( !empty($requestData['columns'][2]['search']['value']) ){
	$sql.=" AND address LIKE '".$requestData['columns'][2]['search']['value']."%' ";
}
//if( !empty($requestData['columns'][3]['search']['value']) ){
//	$rangeArray = explode("-",$requestData['columns'][3]['search']['value']);
//	$minRange = $rangeArray[0];
//	$maxRange = $rangeArray[1];
//	$sql.=" AND ( first >= '".$minRange."' AND  first <= '".$maxRange."' ) ";
//}
if( !empty($requestData['columns'][3]['search']['value']) ){
	$sql.=" AND first LIKE '".$requestData['columns'][3]['search']['value']."%' ";
}
if( !empty($requestData['columns'][4]['search']['value']) ){
	$sql.=" AND street LIKE '".$requestData['columns'][4]['search']['value']."%' ";
}
// only return 200 records from a particular search...
$query=mysqli_query($conn, $sql." LIMIT 200") or die("voterdata.php: get voters");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result.
	
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  // adding length

$query=mysqli_query($conn, $sql) or die("voterdata.php: get voterdata");

	


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["name"];
	$nestedData[] = $row["details"];
	$nestedData[] = $row["address"];
	$nestedData[] = $row["first"];
	$nestedData[] = $row["street"];
	
	$data[] = $nestedData;
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
