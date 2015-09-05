<?php
$route = '/page/';
$app->post($route, function () use ($app){

	$Add = 1;
	$ReturnObject = array();

 	$request = $app->request();
 	$params = $request->params();

	if(isset($params['title'])){ $title = $params['title']; } else { $title = 'No Title'; }
	if(isset($params['body'])){ $body = $params['body']; } else { $body = ''; }

  	$PageQuery = "SELECT * FROM page WHERE title = '" . $title . "'";
	//echo $PageQuery . "<br />";
	$PageResult = mysql_query($PageQuery) or die('Query failed: ' . mysql_error());

	if($PageResult && mysql_num_rows($PageResult))
		{
		$Page = mysql_fetch_assoc($PageResult);
		$page_id = $Page['page_id'];
		}
	else
		{
		$query = "INSERT INTO page(title,body) VALUES('" . mysql_real_escape_string($title) . "','" . mysql_real_escape_string($body) . "')";
		//echo $query . "<br />";
		mysql_query($query) or die('Query failed: ' . mysql_error());
		$page_id = mysql_insert_id();
		}

	$host = $_SERVER['HTTP_HOST'];
	$page_id = prepareIdOut($page_id,$host);

	$ReturnObject['page_id'] = $page_id;

	$app->response()->header("Content-Type", "application/json");
	echo format_json(json_encode($ReturnObject));

	});
?>
