<?php

/**

 */

class GimmieUser
{
  protected $client;

  protected $user_url;

  protected $user_json;

  function __construct($user_url, $client)
  {
    $this->client = $client;
    $this->user_url = $user_url;
  }

  function fetch()
  {
    $resp = $this->client->get($this->user_url);
    $this->user_json = json_decode($resp['body'], true);
    return $this;
  }
}


?>
