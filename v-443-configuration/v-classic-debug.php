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
 * Debug - KlasikDebug
 */
class Debug{

    /**
     * 443 - open source version
     * Classic browser html dump function
     * 
     * uses echo, cannot be staggered
     * 
     * @method see()
     * @param string $what
     * @return void
     */
    public static function see(mixed $what): void
    {
        echo '<br>..............................................................<br><pre>Dump from VTS\Debug: ';

        var_dump($what);

        echo '</pre><br>..............................................................<br>';
    }

    /**
     * 443 - open source version
     * Classic exit with session destroy
     * 
     * @method shut()
     * @return void
     */
    public static function shut(): void
    {
        session_destroy();

        die('Session gone. Reload');
    }

    /**
     * 443 - open source version
     * 
     * @method incoming()
     * @param string $inputVariable
     * @param string $inputType
     * @return mixed|void
     */
    public static function incoming(string $inputVariable): mixed
    {
        return Debug::see(Http::__px($inputVariable,'bool','bad broken nullshit'));
    }

    /**
     * 443 - helpful addition from CLI package.
     * 
     * @method whereAmI()
     * @return void
     */
    public static function whereAmI(): string
    {
        return PHP_EOL . dirname(__FILE__) . PHP_EOL . "\n";
    }
}
?>