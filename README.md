# PHP Gimmie API Client

Ruby wrapper for the Gimmie API. Currently only sending events and retrieving owned stamp cards are supported.

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

For retrieving owned stamp cards, do the following:

```php
$stamp_cards = $client->user()->owned_stamp_cards();
```

The stamp cards get returned as nested associative arrays, for example:

```
[{"name":"somename","provider_name":"provname","current_stamp_count":3,"stamp_image_url":"https:\/\/gimmie2016-staging-images.herokuapp.com\/view\/54\/eb\/4f\/b2\/99\/7b\/de\/7a\/62\/8e\/84\/2d\/73\/d1\/b7\/e2\/50x50%23\/8bit.png","logo_image_url":"https:\/\/gimmie2016-staging-images.herokuapp.com\/view\/f3\/95\/50\/dc\/55\/b3\/40\/27\/67\/ec\/95\/ac\/f7\/6c\/b4\/3a\/200x200%23\/Astrochicken.gif","max_stamps":10,"store_locations":"locationnn","expires_at":"2017-01-30T16:00:00.000Z","expires_in_days":500,"_links":{"curies":[{"name":"gm","href":"http:\/\/gimmie.lvh.me:3000\/doc\/{rel}","templated":true}]}}]
```

They generally correspond to the stamp card fields in the admin portal with the exception of `current_stamp_count` which is the number of stamps the current card has. The `_links` fields can be ignored. The images for stamps and the logo are resized to fit within 50x50px and 200x200px respectively.

## Dependencies

This depends on the [oauth-php](https://code.google.com/archive/p/oauth-php/) library which has been included unmodified in this project under `vendor` for convenience.

## License

The gem is available as open source under the terms of the [MIT License](http://opensource.org/licenses/MIT).

