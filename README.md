# PHP Gimmie API Client

Ruby wrapper for the Gimmie API. Currently only sending events are supported.

## Installation

Include this code into your project and require with:

```php
require_once "containing_folder/library/GimmieClient.php"
```

Add initialization code in your application to set credentials with:

```php
GimmieClient::setup(API_ROOT, CLIENT_KEY, CLIENT_SECRET);
```

where the api root is in the form `"http://your-gimmie-instance.com"`

## Usage

See the example code for specifics, but basically:

```php
$client = new GimmieClient(array('uid' => 'JimmieBob'));
$response = $client->trigger('login', array('platform' => 'android'));
```

## Dependencies

This depends on the [oauth-php](https://code.google.com/archive/p/oauth-php/) library which has been included unmodified in this project under `vendor` for convenience.

## License

The gem is available as open source under the terms of the [MIT License](http://opensource.org/licenses/MIT).

