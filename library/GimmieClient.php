<?php

/**

 */

require_once dirname(__FILE__)."/../vendor/oauth-php/library/OAuthStore.php";
require_once dirname(__FILE__)."/../vendor/oauth-php/library/OAuthRequester.php";

class GimmieClient
{
  public static $client_key;

  public static $client_secret;

  public static $api_root;

  protected $uid;

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
    OAuthStore::instance("2Leg", $this->credentials());

    $params = array('oauth_token' => $this->uid, 'event_name' => $event_name, 'event_data' => json_encode($data));
    $request = new OAuthRequester(self::$api_root . '/gm/events', 'POST', $params);
    return $request->doRequest();
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
