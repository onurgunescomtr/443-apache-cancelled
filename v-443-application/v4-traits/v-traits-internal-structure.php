<?php declare(strict_types = 1);
/**
 * 
 * Verisanat v.4
 * 
 * Object oriented, strongly typed, up to date software in modular structure for 
 * creating web applications. Designed and documented for developers.
 * 
 * Release VTS.443.211 - Open Source Package - MPL 2.0 Licensed.
 * 
 * https://onurgunescomtr@bitbucket.org/onurgunescomtr/verisanat-v.4.git
 * https://github.com/onurgunescomtr/verisanat
 * 
 * @package		Verisanat v.4.4.3 "Rembrandt"
 * @subpackage  VTS.443.211 [Tr]Verisanat Tam Sürüm - [En]Verisanat Full Version 
 * 
 * @author		Onur Güneş  https://www.facebook.com/onur.gunes.developer
 *                          https://www.twitter.com/onurgunescomtr
 *                          verisanat@outlook.com
 *                          https://www.verisanat.com/iletisim
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

namespace VTS\Structure;

\VTS\Version\VersionCheck::dkontrol(__FILE__,'4.4.2');

trait InternalStructure{
    
    /**
     * Internal classes that each corresponds to API requests if available in app
     * 
     *  iç yapıda bulunan sınıfları ve kullanım karşılıklarını barındırır
	 * 
	 * - 443 - openSource.
     * 
     * @var array $internalClasses
     */
    private array $internalClasses = [
        'contact' => 'ContactUs',
        'about' => 'AboutThisApp'
    ];

    /**
     * TestAdresi TA
     * Admin Panel AP
     * 
     * @var array $superStructureClasses
     */
    private $superStructureClasses = [
        TA => 'TesKon002',
        AP => 'AdministrationPanel001'
	];

    /**
     * @var string $htmlDefaultScreen
     */
    private string $htmlDefaultScreen = 'main-page';
}
?>