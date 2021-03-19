<?php

//index.php

//Include Configuration File
include('config.php');

$login_button = '';

//This $_GET["code"] variable value received after user has login into their Google Account redirct to PHP script then this variable value has been received
if(isset($_GET["code"]))
{
 //It will Attempt to exchange a code for an valid authentication token.
 $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

 //This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
 if(!isset($token['error']))
 {
  //Set the access token used for requests
  $google_client->setAccessToken($token['access_token']);

  //Store "access_token" value in $_SESSION variable for future use.
  $_SESSION['access_token'] = $token['access_token'];

  //Create Object of Google Service OAuth 2 class
  $google_service = new Google_Service_Oauth2($google_client);

  //Get user profile data from google
  $data = $google_service->userinfo->get();

  //Below you can find Get profile data and store into $_SESSION variable
  if(!empty($data['given_name']))
  {
   $_SESSION['user_first_name'] = $data['given_name'];
  }

  if(!empty($data['family_name']))
  {
   $_SESSION['user_last_name'] = $data['family_name'];
  }

  if(!empty($data['email']))
  {
   $_SESSION['user_email_address'] = $data['email'];
  }

  if(!empty($data['gender']))
  {
   $_SESSION['user_gender'] = $data['gender'];
  }

  if(!empty($data['picture']))
  {
   $_SESSION['user_image'] = $data['picture'];
  }
 }
}

//This is for check user has login into system by using Google account, if User not login into system then it will execute if block of code and make code for display Login link for Login using Google account.
if(!isset($_SESSION['access_token']))
{
 //Create a URL to obtain user authorization
 $login_button = '<a href="'.$google_client->createAuthUrl().'"><img src="data:image/png;base64,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" /></a>';
}

?>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>PHP Login using Google Account</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
  
 </head>
 <body>
  <div class="container">
   <br />
   <h2 align="center">PHP Login using Google Account</h2>
   <br />
   <div class="panel panel-default">
   <?php
   if($login_button == '')
   {
    echo '<div class="panel-heading">Welcome User</div><div class="panel-body">';
    echo '<img src="'.$_SESSION["user_image"].'" class="img-responsive img-circle img-thumbnail" />';
    echo '<h3><b>Name :</b> '.$_SESSION['user_first_name'].' '.$_SESSION['user_last_name'].'</h3>';
    echo '<h3><b>Email :</b> '.$_SESSION['user_email_address'].'</h3>';
    echo '<h3><a href="logout.php">Logout</h3></div>';
   }
   else
   {
    echo '<div align="center">'.$login_button . '</div>';
   }
   ?>
   </div>
  </div>
 </body>
</html>