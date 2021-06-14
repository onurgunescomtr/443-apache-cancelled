# verisanat
Open source package of Verisanat v.4. Object oriented, strongly typed, up to date software in modular structure for creating web applications. Designed and documented for developers.


* Setup and full translation (from TR to EN) in progress.

* This is a release to be used with Apache Web Server.
* Create an "index.php" file with the following:
```php

VTS\System\System::loadMain();

VTS\App::loadApp();

```
* If you like to test your PHP and Web installation to be checked for Verisanat,
you can use:
```php

new VTS\System\SystemInspect;

``` 