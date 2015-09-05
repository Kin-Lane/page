<?php
$route = '/page/';
$app->get($route, function ()  use ($app){

	$ReturnObject = array();

	if(isset($_REQUEST['query'])){ $query = $_REQUEST['query']; } else { $query = '';}

	// Pull from MySQL
	if($query=='')
		{
		$Query = "SELECT * FROM page WHERE title LIKE '%" . $query . "%'";
		}
	else {
		$Query = "SELECT * FROM page";
	}
	$Query .= " ORDER BY title ASC";
	//echo $Query . "<br />";

	$PressResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($Press = mysql_fetch_assoc($PressResult))
		{

		$page_id = $Press['page_id'];
		$title = $Press['title'];
		$body = $Press['body'];

		// manipulation zone

		$host = $_SERVER['HTTP_HOST'];
		$page_id = prepareIdOut($page_id,$host);		

		$F = array();
		$F['page_id'] = $page_id;
		$F['title'] = $title;
		$F['body'] = $body;

		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>
