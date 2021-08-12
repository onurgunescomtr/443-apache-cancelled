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

namespace VTS\Version;
/**
 * VersionCheck - VersiyonKontrol
 */
class VersionCheck{

    /**
     * @var array infoVersionWarn
     */
    public const infoVersionWarn = [
        'dev_feat' => 'This feature is getting developed for future releases.',
        'non_feat' => 'This feature is not supported for this release.',
        'not_feat' => 'This version you use does not support this feature.',
        'unknown' => 'There is an undocumented version problem.'
    ];
    /**
     * @var array $fileVersions
     */
    private static array $fileVersions = [];
    /**
     * @var string $currentHead
     */
    private string $currentHead;

    public function __construct(string $v)
    {
        $this->currentHead = $v;
    }

    /**
     * dosya versiyonlarını array olarak $fileVersions na ekler - d. adı => d. versiyonu
     * 
     * @method dkontrol() 
     * @param string $v versiyon
     * @param string $f dosya adı
     * @return void|array $liste
     */
    public static function dkontrol(string $f,string $v,bool $tam = false)
    {
        self::$fileVersions[basename($f)] = $v;

        if ($tam){

            return self::$fileVersions;
        }
    }

    /**
     * dosya ve versiyonlardan oluşan array i verir
     * 
     * @method getList()
     * @return array
     */
    public function getList(): array
    {
        return $this->fileVersions;
    }

    /**
     * @method warn()
     * @param string $wType
     * @return string $cevap
     */
    public static function warn(string $wType = null): string
    {
        return self::infoVersionWarn[$wType] ?? self::infoVersionWarn['unknown'];
    }
}
?>