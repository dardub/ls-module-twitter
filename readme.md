# ls-module-twitter
Provides basic integration with Twitter for your store.

## Installation
1. Download [Twitter](https://github.com/limewheel/ls-module-twitter/zipball/master).
1. Create a folder named `twitter` in the `modules` directory.
1. Extract all files into the `modules/twitter` directory (`modules/twitter/readme.md` should exist).
1. Done!

## Usage
Add this code to your page (and change the username parameter). 

```php
<?
$twitter = Twitter_Account::create(array('username' => 'myusername', 'count' => 10));

$tweets = $twitter->get_tweets();
?>

<? foreach($tweets as $tweet): ?>
	<h3><?= $tweet['content'] ?></h3>
	<p class="date"><?= $tweet['date'] ?></p>
<? endforeach ?>
```

Same example with user references converted to links:

```php
<?
$twitter = Twitter_Account::create(array('username' => 'myusername', 'count' => 10));

$tweets = $twitter->get_tweets();

$rexProtocol = '(https?://)?';
$rexDomain   = '((?:[-a-zA-Z0-9]{1,63}\.)+[-a-zA-Z0-9]{2,63}|(?:[0-9]{1,3}\.){3}[0-9]{1,3})';
$rexPort     = '(:[0-9]{1,5})?';
$rexPath     = '(/[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]*?)?';
$rexQuery    = '(\?[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';
$rexFragment = '(#[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';

if(!function_exists('convert_text_to_anchor')) {
  function convert_text_to_anchor($match) {
    // Prepend http:// if no protocol specified
    $completeUrl = $match[1] ? $match[0] : "http://{$match[0]}";

    return '<a href="' . $completeUrl . '">' . $completeUrl . '</a>';
  }
}
?>

<? foreach($tweets as $tweet): ?>
	<h3><?= preg_replace_callback("&\\b$rexProtocol$rexDomain$rexPort$rexPath$rexQuery$rexFragment(?=[?.!,;:\"]?(\s|$))&",
'convert_text_to_anchor', htmlspecialchars(utf8_encode($tweet['content']))); ?></h3>
	<p class="date"><?= $tweet['date'] ?></p>
<? endforeach ?>

```