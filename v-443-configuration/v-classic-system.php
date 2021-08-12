<?php declare(strict_types = 1);
/**
 * 
 * Verisanat v.4
 * 
 * Object oriented, strongly typed, up to date software in modular structure for 
 * creating web applications. Designed and documented for developers.
 * 
 * Release VTS.443.222 - Open Source Package - MPL 2.0 Licensed.
 * 
 * https://onurgunescomtr@bitbucket.org/onurgunescomtr/verisanat-v.4.git
 * https://github.com/onurgunescomtr/verisanat
 * 
 * @package		Verisanat v.4.4.3 "Rembrandt"
 * @subpackage  VTS.443.222 [Tr]Verisanat Tam Sürüm - [En]Verisanat Full Version 
 * 
 * @author		Onur Güneş  https://www.facebook.com/onur.gunes.developer
 *                          https://www.twitter.com/onurgunescomtr
 *                          mailto:verisanat@outlook.com
 *                          https://www.verisanat.com/contact
 * 
 * @copyright	Copyright (c) 2012 - 2021 Onur Güneş
 *              https://www.verisanat.com
 *              https://www.onurgunes.com.tr
 *              [En]All Rights Reserved. [Tr]Tüm hakları saklıdır.
 * 
 * @license		Mozilla Public License 2.0
 *              https://choosealicense.com/licenses/mpl-2.0
 * 
 *              This Source Code Form is subject to the terms of the Mozilla Public
 *              License, v. 2.0. If a copy of the MPL was not distributed with this
 *              file, You can obtain one at https://mozilla.org/MPL/2.0/.
 * 
 * @link		https://www.verisanat.com
*/
namespace VTS;

/**
 * Package / Release constant
 */
define('RELEASE','v-443');

/**
 * Capital letters for locale to be used in application
 * 
 * - if you want to define new locales, grep LANG for class usages.
 */
define('LANG','TR');

/**
 * Long locale constant
 */
define('LANGL','tr_TR');

/**
 * Long language name constant
 */
define('LANGUAGE','turkish');

/**
 * Date time format to be used in application
 * - you can edit the way PHP accepts in IntlDateFormatter
 */
define('TIMEFORMAT','EEEE, dd MMMM YYYY');

/**
 * English basic warning messages.
 */
define('BASICWARN',[
    'phpyetersiz' => 'Insufficient PHP version for Verisanat '. RELEASE .' . At least 8.X is required.',
    'sifyetersiz' => 'Your PHP installation does not have necessary cryptography extension which provides ARGON2ID encryption. This is mandatory for the system check.',
    'sodiumyok' => 'Sodium Library PHP extension is not activated or not compiled with your installation.',
    'gerekli_http' => 'Due to one or more requirements is/are not met, Verisanat stopped.' . PHP_EOL,
    'close_get' => '200.009.Request contains unwanted character sets. Please check up your system for malware, trojan or other harmful software.',
    'gecersiz_talep' => '200.010.Invalid request.'
]);

define('BASE',dirname(dirname(__FILE__)));

ini_set('default_charset','UTF-8');

error_reporting(E_ALL); //  & ~E_NOTICE

ini_set('log_errors','on');

ini_set('date.timezone','Europe/Istanbul');

date_default_timezone_set('Europe/Istanbul');

setlocale(LC_TIME,LANGL . '.' . 'UTF-8',LANGL,strtolower(LANG),LANGUAGE);

ini_set('allow_url_fopen','on');

define('USERTIME',3600);
define('SUPERTIME',3600);

ini_set('session.cookie_lifetime',(string)USERTIME);
ini_set('session.cookie_secure','1');
ini_set('session.cookie_httponly','1');
ini_set('session.use_only_cookies','1');
ini_set('session.gc_maxlifetime',(string)USERTIME);
ini_set('session.cookie_samesite','Strict');
ini_set('session.hash_function','sha256');
ini_set('session.sid_bits_per_character','6');
ini_set('session.sid_lenght','128');
ini_set('session.use_trans_sid','0');
ini_set('session.use_strict_mode','1');
ini_set('session.cache_limiter','nocache');

define('VERISANATADRES','https://www.verisanat.com');

mb_detect_order('UTF-8');

mb_internal_encoding('UTF-8');

mb_regex_encoding('UTF-8');

require_once 'v-classic-system' . '-' . 'inspection.php';

require_once 'v-classic-system' . '-' . 'loader.php';

require_once 'v-classic-system' . '-' . 'user.php';
?>