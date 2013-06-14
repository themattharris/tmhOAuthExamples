# tmhOAuth-examples

A repository containing example uses of tmhOAuth.

## Dependencies

These examples require [tmhOAuth](https://github.com/themattharris/tmhOAuth) version 0.8.0 or higher. They have been
tested with PHP 5.3+.

The easiest way to install tmhOAuth is to use [composer](http://getcomposer.org). if you prefer to do things the manual way
make sure you `git clone` tmhOAuth into the main tmhOAuthExamples directory (the same one this file is in).

## Usage

Edit `tmhOAuthExample.php` and enter your application and user values for:
- 'consumer_key'
- 'consumer_secret'
- 'user_token'
- 'user_secret'
- 'bearer'

If you're just trying things out it's recommended you use a test account instead of your real one as some examples do things
like tweet or follow.

To create an application, visit [dev.twitter.com/apps](https://dev.twitter.com/apps)

For command line examples, go into the `cli` directory and execute any of the examples using `php <filename>.php`. Remember
some examples make POST actions, and will tweet or follow on your behalf.

For web based examples add tmhOAuthExamples to a location on your webserver that you access via a URL.

## Change History
### 0.1 - 14 June 2013
- switched all examples to Twitter API v1.1
- removed redundant/confusing examples
- centralised examples as children of a master example configuration script (`tmhOAuthExample.php`)

## Community

License: Apache 2 (see [included LICENSE file](https://github.com/themattharris/tmhOAuth/blob/master/LICENSE))

Follow [@tmhOAuth](https://twitter.com/intent/follow?screen_name=tmhOAuth) to receive updates on releases, or ask for support
Follow me on Twitter: [@themattharris](https://twitter.com/intent/follow?screen_name=themattharris)
Check out the Twitter Developer Resources: <https://dev.twitter.com>

## To Do

- More streaming api examples
- Control Streams examples
- More Web request examples