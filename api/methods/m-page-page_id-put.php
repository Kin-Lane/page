<?php
$route = '/page/:page_id/';
$app->put($route, function ($page_id) use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$page_id = prepareIdIn($page_id,$host);

	$ReturnObject = array();

 	$request = $app->request();
 	$params = $request->params();

	if(isset($params['title'])){ $title = mysql_real_escape_string($params['title']); } else { $title = ''; }
	if(isset($params['body'])){ $body = mysql_real_escape_string($params['body']); } else { $body = ''; }

  $LinkQuery = "SELECT * FROM page WHERE page_id = '" . $page_id . "'";
	//echo $LinkQuery . "<br />";
	$LinkResult = mysql_query($LinkQuery) or die('Query failed: ' . mysql_error());

	if($LinkResult && mysql_num_rows($LinkResult))
		{
		$query = "UPDATE page SET Filler = 1";
		if(isset($params['title'])){ $query .= ",title = '" . mysql_real_escape_string($title) . "'"; }
		if(isset($params['body'])){ $query .= ",body = '" . mysql_real_escape_string($body) . "'"; }

		$query .= "WHERE page_id = '" . $page_id . "'";

		//echo $query . "<br />";
		mysql_query($query) or die('Query failed: ' . mysql_error());
		}

	});

?>
