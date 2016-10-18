<?php

/**

 */

require_once dirname(__FILE__)."/../vendor/oauth-php/library/OAuthStore.php";
require_once dirname(__FILE__)."/../vendor/oauth-php/library/OAuthRequester.php";

require_once dirname(__FILE__)."/GimmieUser.php";

class GimmieClient
{
  public static $client_key;

  public static $client_secret;

  public static $api_root;

  protected $uid;

  protected $root_json;

  static function setup($api_root, $client_key, $client_secret)
  {
    self::$api_root = $api_root;
    self::$client_key = $client_key;
    self::$client_secret = $client_secret;
  }

  function __construct($options)
  {
    if(!isset($options['uid']))
    {
      throw new Exception('Must pass a uid.');
    }
    $this->uid = $options['uid'];
  }

  function trigger($event_name, $data = array())
  {
    $params = array('event_name' => $event_name, 'event_data' => json_encode($data));
    $response = $this->post($this->events_url(), $params);
    $body = json_decode($response['body']);
    return $body->{'_embedded'}->item;
  }

  function user()
  {
    return (new GimmieUser($this->user_url(), $this))->fetch();
  }

  function get($url)
  {
    return $this->do_request($url, 'GET');
  }

  function post($url, $params)
  {
    return $this->do_request($url, 'POST', $params);
  }

  private function do_request($url, $method, $params = array())
  {
    $params['oauth_token'] = $this->uid;
    OAuthStore::instance("2Leg", $this->credentials());
    $request = new OAuthRequester($url, $method, $params);
    return $request->doRequest();
  }

  private function events_url()
  {
    return $this->root()->{'_links'}->{'gm:trigger_event'}->href;
  }

  private function user_url()
  {
    return $this->root()->{'_links'}->{'gm:user'}->href;
  }

  private function root()
  {
    if(is_null($this->root_json)) {
      $resp = $this->get(self::$api_root . '/gm/');
      $this->root_json = json_decode($resp['body']);
    }
    return $this->root_json;
  }

  private function credentials()
  {
    return array('consumer_key' => self::$client_key, 'consumer_secret' => self::$client_secret, 'token_secret' => self::$client_secret);
  }

  private function assert_setup()
  {
    if(is_null(self::$client_key) || is_null(self::$client_secret) || is_null(self::$api_root)) {
      throw new Exception('Gimmie server settings missing! Please call setup prior to using the client.');
    }
  }
}

?>
