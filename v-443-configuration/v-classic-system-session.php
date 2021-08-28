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

use Exception;

Version\VersionCheck::dkontrol(__FILE__,'4.4.3');

/**
 *  set()
 *  get()
 *  getHistory()
 *  audit()
 *  modify()
 *  del()
 *  delMany()
 *  free()
 *  logIn()
 *  logOff()
 *  load()
 * 
 * -------------------
 * 
 *  setMod()
 *  getMod()
 *  delMod()
 *  delModMany()
 * 
 * -------------------
 * 
 *  setInter()
 */
final class SysLed{
    
    /**
     * @var array $infoSysLed
     */
    private const infoSysLed = [
        'TR' => [
            'kill_session' => 'Oturum sonlandırıldı.'
        ],
        'EN' => [
            'kill_session' => 'Session terminated.'
        ]
    ];
    /**
     * @var array $languages
     */
    private const languages = [
        'TR' => [
            'full_name' => 'turkce',
            'short_name' => 'tr',
            'number' => 0
        ],
        'EN' => [
            'full_name' => 'ingilizce',
            'short_name' => 'en',
            'number' => 1
        ]
    ];
    /**
     * @var array $internalVariables
     */
    private const internalVariables = [
        'user_verification_process',
        'user_process',
        'user_page_idstring_temp',
        'user_page_idstring',
        'user_cookie_idstring',
        'user_public_key',
        'user_sealed_key',
        'user_session_task_idstring',
        'user_session_task_time_cost',
        'sudo_facebook_connection_request',
        'sudo_user_facebook_name',
        'sudo_user_facebook_email',
        'sudo_user_facebook_idstring',
        'sudo_user_facebook_photo',
        'sudo_user_facebook_access_token',
        'sudo_user_facebook_page_access_token',
        'user_facebook_name',
        'user_facebook_email',
        'user_facebook_idstring',
        'user_facebook_photo',
        'user_facebook_access_token',
        'user_facebook_page_access_token',
        'user_simple_lock_idstring',
        'user_simple_lock_filename'
    ];
    /**
     * @var array $applicationVariables
     */
    private const applicationVariables = [
        'effective_lang_number',
        'user_phone',
        'user_city',
        'user_town',
        'user_post_code',
        'user_address',
        'user_email',
        'user_account_created',
        'user_last_login',
        'user_balance',
        'user_ebalance',
        'user_name_surname',
        'user_photo_file'
    ];
    /**
     * @var array $moduleVariables
     */
    public static array $moduleVariables = [
        'public_info_container',
        'app_module_toast_container',
        'search_data_string',
        'search_permit_string',
        'account_create_permit',
        'account_create_permit_string',
        'current_module_item'
    ];
    /**
     * @var array $systemVariables
     */
    private const systemVariables = [
        'user_activity_time',
        'user_client_address',
        'http_warning_type',
        'http_guide_information',
        'http_request_count',
        'http_request_count_light',
        'http_public_hash_uri'
    ];
    /**
     * @var array $varIsLoaded
     */
    private static array $varIsLoaded = [];
    /**
     * @var bool $archiveEnabled
     */
    private static bool $archiveEnabled = true;

    /**
     * @method set()
     * @param $v
     * @param $d
     * @return void
     */
    public static function set(string $v,mixed $d): void
    {
        self::setSessionData($v,$d);
    }

    /**
     * @method get()
     * @param string $vName
     * @param bool $once
     * @return mixed
     */
    public static function get(string $vName,bool $once = false): mixed
    {
        if (self::isLoaded($vName)){

            return self::getSessionData($vName,$once);
        }
        
        return false;
    }

    /**
     * @method getHistory()
     * @param string $vName
     * @return mixed
     */
    public static function getHistory(string $vName): mixed
    {
        return self::getSessionHistory($vName);
    }

    /**
     * @method modify()
     * @param string $v
     * @param string $type
     * @return void
     */
    public static function modify(string $vName,mixed $vData,string $type = 'new'): void
    {
        if (self::isLoaded($vName)){

            switch($type):

                case 'new':

                    if (self::$archiveEnabled){

                        $_SESSION[VSSESSION]['archive'][$vName][] = $_SESSION[VSSESSION][$vName];
                    }

                    $_SESSION[VSSESSION][$vName] = $vData;

                break;

                case 'join':

                    $_SESSION[VSSESSION][$vName] .= $vData;

                break;

                case 'counter':

                    $_SESSION[VSSESSION][$vName] += 1;

                break;

            endswitch;

        }else{

            throw new \ErrorException('Variable is not loaded.' . get_called_class());
        }
    }

    /**
     * @method audit()
     * @param $v
     * @param $exp
     * @param $type
     * @return bool
     */
    public static function audit(string $v,mixed $exp,string $type = null): bool
    {
        if (self::isLoaded($v)){

            switch ($type):

                case 'higher':

                    return self::getSessionData($v,false) > $exp ? true : false;

                break;

                case 'lower':

                    return self::getSessionData($v,false) < $exp ? true : false;

                break;

                default:

                    return self::getSessionData($v,false) === $exp ? true : false;

                break;

            endswitch;
        }

        return false;
    }

    /**
     * @method del()
     * @param string $v
     * @return void
     */
    public static function del(string $v): void
    {
        if (self::isLoaded($v)){

            $temp = array_flip(self::$varIsLoaded);

            unset($temp[$v]);

            self::$varIsLoaded = array_flip($temp);

            unset($_SESSION[VSSESSION][$v]);
        }else{

            throw new \ErrorException('Variable is not loaded to delete.' . get_called_class());
        }
    }

    /**
     * @method delMany()
     * @param array $v
     * @return void
     */
    public static function delMany(array $v): void
    {
        foreach($v as $vT){

            self::del($vT);
        }
    }

    /**
     * @method free()
     * @param string $v
     * @return void
     */
    public static function free(string $v): void
    {
        if (self::isLoaded($v)){

            $_SESSION[VSSESSION][$v] = null;
        }else{

            throw new \ErrorException('Variable is not loaded.' . get_called_class());
        }
    }

    /**
     * @method load()
     * @param int
     * @return void
     */
    public static function load(int $sType): void
    {
        if ($sType === 10){

            session_name('VS' . SUDOSESSION . 'YI');

            ini_set('session.cookie_lifetime',(string)SUPERTIME);
            ini_set('session.cookie_secure','1');
            ini_set('session.cookie_httponly','1');
            ini_set('session.use_only_cookies','1');
            ini_set('session.gc_maxlifetime',(string)SUPERTIME);
            ini_set('session.cookie_samesite','Strict');
            ini_set('session.hash_function','sha256');
            ini_set('session.sid_bits_per_character','6');
            ini_set('session.sid_lenght','128');
            ini_set('session.use_trans_sid','0');
            ini_set('session.use_strict_mode','1');
            ini_set('session.cache_limiter','nocache');
        }

        self::loadSession();
    }

    /**
     * @method logOff()
     * @return void
     */
    public static function logOff(): void
    {
        if (self::isLoaded('user_page_idstring')){
            
            self::deleteUserCookie();
        }

        self::killSession();
    }

    /**
     * @method logIn
     * @return void
     */
    public static function logIn(): void
    {
        self::writeUserCookie();

        self::del('user_public_key');
    }

    /**
     * @method setMod()
     * @param string $mName
     * @param array $mData
     * @return void
     */
    public static function setMod(string $mName,array $mData): void
    {
        self::setSessionModuleData($mName,$mData);
    }

    /**
     * @method getMod()
     * @param string $mName
     * @param string $mVar
     * @return string|int|bool
     */
    public static function getMod(string $mName,string $mVar,bool $once = false): string|int|bool
    {
        if (self::isLoadedMod($mName,$mVar)){

            return self::getSessionModuleData($mName,$mVar,$once);
        }

        return false;
    }

    /**
     * @method delMod()
     * @param string $mName
     * @param string $mVar
     * @return void
     */
    public static function delMod(string $mName,string $mVar): void
    {
        if (self::isLoadedMod($mName,$mVar)){

            $temp = array_flip(self::$varIsLoaded[$mName . '_operation']);

            unset($temp[$mVar]);

            self::$varIsLoaded[$mName . '_operation'] = array_flip($temp);

            unset($_SESSION[VSSESSION][$mName . '_operation'][$mVar]);
        }else{

            throw new \ErrorException('Variable is not loaded to delete.' . get_called_class());
        }
    }

    /**
     * @method delModMany()
     * @param string $mName
     * @param array $mVars
     * @return void
     */
    public static function delModMany(string $mName,array $mVars): void
    {
        foreach($mVars as $t){

            self::delMod($mName,$t);
        }
    }

    /**
     * @method setInter()
     * @param string $cName
     * @param string $vName
     * @param mixed $vData
     * @return void
     */
    public static function setInter(string $cName,string $vName,mixed $vData): void
    {
        self::setSessionData($vName,$vData);

        self::writeIntegrationCookie($cName,$vName,$vData);
    }

    /**
     * @method injectModuleVars()
     * @param array $varPack
     * @return bool
     */
    public static function injectModuleVars(array $varPack): bool
    {
        try{
            
            array_merge(self::$moduleVariables,$varPack);
        }catch(\Exception $e){

            Scribe::appLog('Module System Ledger Pack couldnt be registered: ' . $e->getMessage());

            return false;
        }

        return true;
    }

    /**
     * @method isLoaded()
     * @param string $var
     * @return bool
     */
    private static function isLoaded(string $var): bool
    {
        return array_key_exists($var,array_flip(self::$varIsLoaded)) ? true : false;
    }

    /**
     * @method isLoadedMod()
     * @param string $mName
     * @param string $mVar
     * @return bool
     */
    private static function isLoadedMod(string $mName,string $mVar): bool
    {
        return array_key_exists($mVar,array_flip(self::$varIsLoaded[$mName . '_operation'])) ? true : false;
    }

    /**
     * @method setSessionData()
     * @param string $vName
     * @return void
     */
    private static function setSessionData(string $vName,mixed $vData): void
    {
        self::$varIsLoaded[] = $vName;

        $_SESSION[VSSESSION][$vName] = $vData;
    }

    /**
     * @method getSessionData()
     * @param mixed $vNalue
     * @param bool $once
     * @return mixed
     */
    private static function getSessionData(string $vName,bool $once): mixed
    {
        if ($once){

            $temp = $_SESSION[VSSESSION][$vName];

            self::del($vName);

            return $temp;
        }
        
        return $_SESSION[VSSESSION][$vName];
    }

    /**
     * @method getSessionHistory()
     * @param string $v
     * @return array|bool
     */
    private static function getSessionHistory(string $vName): array|bool
    {
        if (self::isLoaded($vName) && self::$archiveEnabled){

            return $_SESSION[VSSESSION]['archive'][$vName];
        }else{

            return false;
        }
    }

    /**
     * @method setSessionModuleData()
     * @param string $mName
     * @param array $mData
     * @return void
     */
    private static function setSessionModuleData(string $mName,array $mData): void
    {
        foreach($mData as $mdV => $mdD){

            self::$varIsLoaded[$mName . '_operation'][] = $mdV;

            $_SESSION[VSSESSION][$mName . '_operation'][$mdV] = $mdD;
        }
    }

    /**
     * @method getSessionModuleData()
     * @param string $mName
     * @param bool $once
     * @return string|int|bool
     */
    private static function getSessionModuleData(string $mName,string $mvName,bool $once = false): string|int|bool
    {
        if ($once){

            $temp = $_SESSION[VSSESSION][$mName . '_operation'][$mvName];

            self::delMod($mName,$mvName);

            return $temp;
        }

        return $_SESSION[VSSESSION][$mName . '_operation'][$mvName];
    }

    /**
     * @method loadSession()
     * @return void
     */
    private static function loadSession(): void
    {
        session_start();

        if (array_key_exists(VSSESSION,$_SESSION)){

            foreach($_SESSION[VSSESSION] as $vN => $vD){

                self::$varIsLoaded[] = $vN;
            }
        }

        self::setSessionDefaults();
    }

    /**
     * @method setSessionDefaults()
     * @return void
     */
    private static function setSessionDefaults(): void
    {
        if (self::isLoaded('user_activity_time')){

            if ((time() - self::getSessionData('user_activity_time',false)) > USERTIME){

                session_unset();
                session_destroy();
                session_start();

                self::setSessionData('user_activity_time',time());
            }
        }else{

            self::setSessionData('user_activity_time',time());
        }

        if (!self::isLoaded('user_client_address')){

            self::setSessionData('user_client_address',$_SERVER['REMOTE_ADDR']);
        }

        if (!self::isLoaded('effective_lang_number')){

            self::set('effective_lang_number',self::languages[LANG]['number']);
        }

        if (!self::isLoaded('http_request_count')){

            self::set('http_request_count',0);
        }
    }

    /**
     * @method killSession()
     * @return void
     */
    private static function killSession(): void
    {
        setcookie(BCOOKIE,'',[
            'expires' => time() + 1,
            'path' => '/',
            'domain' => '.' . DOMAIN,
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);

        session_unset();

        session_destroy();
    }

    /**
     * @method killUserSession()
     * @return void
     */
    private static function deleteUserCookie(): void
    {
        setcookie(UCOOKIE,self::getSessionData('user_cookie_idstring',false),[
            'expires' => time() + 1,
            'path' => '/',
            'domain' => '.' . DOMAIN,
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
    }

    /**
     * @method writeUserCookie()
     * @return void
     */
    private static function writeUserCookie(): void
    {
        setcookie(UCOOKIE,self::getSessionData('user_cookie_idstring',false),[
            'expires' => time() + 604800,
            'path' => '/',
            'domain' => '.' . DOMAIN,
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
    }

    /**
     * @method writeIntegrationCookie()
     * @param string $name
     * @param string $vName
     * @param mixed $vData
     * @return void
     */
    private static function writeIntegrationCookie(string $name,string $vName,mixed $vData): void
    {
        setcookie($name,self::getSessionData($vName,false),[
            'expires' => time() + (60 * 3),
            'path' => '/',
            'domain' => '.' . DOMAIN,
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    }
}
?>