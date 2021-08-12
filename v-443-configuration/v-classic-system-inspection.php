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
 * SystemInspect - KlasikKurulum
 */
final class SystemInspect{

    private bool $phpInstalled;

    private const requiredVersion = '8.0.0';

    private string $phpVersion;
    /**
     * @var bool $sodiumAvailable
     */
    private bool $sodiumAvailable;
    /**
     * @var string $testdizgesi
     */
    private const testdizgesi = 'onur';
    /**
     * @var string $testSifreliDeger
     */
    private string $testSifreliDeger;
    /**
     * @var bool $aes256gcm
     */
    private bool $aes256gcm;
    /**
     * @var bool $encResult
     */
    private bool $encResult;

    private const argonName = 'argon2i';
    /**
     * @var bool $useArgon
     */
    private bool $useArgon;
    /**
     * @var array $extensionList
     */
    private array $extensionList = [];
    /**
     * @var string $kullanicino
     */
    public static $kullanicino;

    /**
     * System Check Class
     *
     * @method __construct()
     */
    public function __construct()
    {
        $this->phpVersionCheck();

        $this->extensionCheck();

        $this->getResult();
    }

    /**
     * Checks if required encryption tools available
     * 
     * @method encryptionCheck() 
     * @return void
     */
    private function encryptionCheck(): void
    {
        $this->testSifreliDeger = sodium_crypto_pwhash_str(self::testdizgesi,SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE);

        $this->encResult = sodium_crypto_pwhash_str_verify($this->testSifreliDeger,self::testdizgesi);

        $this->useArgon = substr($this->testSifreliDeger,1,7) === self::argonName && $this->encResult ? true : false;

        $this->aes256gcm = sodium_crypto_aead_aes256gcm_is_available();
    }

    /**
     * @method extensionCheck()
     * @return void
     */
    private function extensionCheck(): void
    {
        function_exists('get_loaded_extensions') ? $this->extensionList = get_loaded_extensions() : $this->extensionList[] = 'extension list is not available';

        $this->sodiumAvailable = extension_loaded('sodium');

        if ($this->sodiumAvailable){

            $this->encryptionCheck();
        }
    }

    /**
     * @method getResult() 
     * @return void
     */
    private function getResult(): void
    {
        switch(false):

            case $this->phpInstalled:

                die(BASICWARN['gerekli_http'] . BASICWARN['phpyetersiz']);

            break;

            case $this->useArgon:

                die(BASICWARN['gerekli_http'] . BASICWARN['sifyetersiz']);

            break;

            case $this->sodiumAvailable:

                die(BASICWARN['gerekli_http'] . BASICWARN['sodiumyok']);

            break;
        endswitch;

        echo 'Ready.';

        exit;
    }

    /**
     * @method phpVersionCheck()
     * @return void
     */
    private function phpVersionCheck(): void
    {
        $this->phpVersion = PHP_VERSION;

        $this->phpInstalled = version_compare($this->phpVersion,self::requiredVersion,'>') ? true : false;
    }
}
?>