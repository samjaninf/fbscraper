<?php
	
	include("Facebook/autoload.php");
	
	$app_id="1628647974125358";
	/***Facebook App Secret****/
	$app_secret="3a918e56430fc0badc54bfcaf5e533e9";

	$fb = new Facebook\Facebook([
		  'app_id' => '1628647974125358', // Replace {app-id} with your app id
		  'app_secret' => '3a918e56430fc0badc54bfcaf5e533e9',
		  'default_graph_version' => 'v2.2',
	]);

		$helper = $fb->getRedirectLoginHelper();

		$permissions = ['email']; // Optional permissions
		$loginUrl = $helper->getLoginUrl('http://webprogrammings.net', $permissions);
		echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';


	



 ?>