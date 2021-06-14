# verisanat
Open source package of Verisanat v.4. Object oriented, strongly typed, up to date software in modular structure for creating web applications. Designed and documented for developers.


* Setup and full translation (from TR to EN) in progress.

* This is a release to be used with Apache Web Server.
* System needs a main config and an application config file to run as intended. Those two files can be obtained from verisanat.com preconfigured with v.Account. Like most relational files they are Json. So you can use them in your Vue, React or Node bases.
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