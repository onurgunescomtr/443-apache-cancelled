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

namespace VTS\System;
/**
 * System - KlasikKurulum
 */
final class System{

    /**
     * @var object $system
     */
    protected static object $system;
	/**
	 * System Property List -  VTS 443 OpenSource
	 * 
	 * @var array $systemProperties
	 */
	protected const systemProperties = [
		'dbConn','dbUser'
	];

    /**
     * @var array systemFiles
     */
    private const systemFiles = [
        'v-classic-debug.php',
        'v-classic-audit.php',
        'v-classic-http.php',
        'v-classic-registry.php',
        'v-classic-dos.php',
        'v-classic-setup.php',
        'v-classic-version.php',
        'v-classic-exception.php',
        'v-classic-app.php',
        'v-classic-system-session.php'
    ];

    /**
     * @var string $konfigurasyon
     */
    public const kon = RELEASE . '-configuration';

    /**
     * @method loadMain()
     * @return void
     */
    public static function loadMain(): void
    {
        foreach(self::systemFiles as $t){

            require_once self::kon . '/' . $t;
        }

        self::$system = SystemSetup::configure();
    }
	
	/**
	 * Possible lookup names:
	 * + dbUser | whether it is set and correct
	 * + dbConn | whether it is set and correct
	 * 
	 * usage:
	 * - VTS\System\System::getStatus('dbConn')
	 * 
	 * @method getStatus()
	 * @param string $spec
	 * @return mixed $result
	 */
	public static function getStatus(string $spec): mixed
	{
		if (in_array($spec,self::systemProperties)){

			return self::$system->{$spec};	
		}else{

			throw new \ErrorException('No such system property registered: ' . $spec);
		}		
	}
}
?>