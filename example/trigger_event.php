<?php

/**

Example demonstrating how to send event triggers using GimmieClient.

You must set the constants to match your environment.

The code below will send a:

"login" event
for uid="JimmieBob"
including the event data of "platform"=>"android"

Server errors are caught by OAuthException2

 */

define("CLIENT_KEY", "SET THIS");
define("CLIENT_SECRET", "SET THIS");
define("API_ROOT", "SET THIS"); // eg: "http://example.com"

include_once "../library/GimmieClient.php";

GimmieClient::setup(API_ROOT, CLIENT_KEY, CLIENT_SECRET);

$client = new GimmieClient(array('uid' => 'JimmieBob'));

try
{
  $response = $client->trigger('login', array('platform' => 'android'));
  echo "Success\n";
}
catch(OAuthException2 $e)
{
  echo "Server Exception: " . $e->getMessage() . "\n";
}

?>
