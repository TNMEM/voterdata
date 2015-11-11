Memphis, TN, Voter Data
=========================================

DEMO: <a href="http://pica-pole.com/voterdata/voterindex.php">http://pica-pole.com/voterdata/voterindex.php</a>

jQjuery/datatables.net with a single file php-crud-api to 500,000-person voter database. The key here is that the search is via an ajax
to the mysql database to return a major json data grab (limited to 5,000 records), but datatable/jQuery handles all the paging and sorting ... fast and minimal
hit on the database server.

<a href="https://github.com/mevdschee/php-crud-api">https://github.com/mevdschee/php-crud-api</a>

RESTful api for crud to mysql or PostgreSQL or Microsoft SQL server.

this works ... like magic ... pay attention to transform output vs regular output.
  ... ?transform=1 does it at the server ... php_crud_api_transform.js does it at the client.


