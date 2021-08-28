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

Version\VersionCheck::dkontrol(__FILE__,'4.4.3');

final class AppAudit{

    protected const PROCESS = array(
        '0' => 'verify',
        '1' => 'confirm',
        '2' => 'subs-cancellation-delete-my-data'
    );

    private const appAuditInformation = [
		'TR' => [
			'banned' => '200.061.IP address is banned for this API.',
			'silent' => '200.062.IP address is muted.',
			'unnecessary' => '200.063.Session based unnecessary process detected.',
			'fragile' => '200.064.Request is out of operation limits. Session closed.',
			'form' => '200.065.Please fill the form completely and as indicated.',
			'google_api_off' => '<div class="d-none">Google API kullanım dışıdır.</div>'
		],
		'EN' => [
			'banned' => '200.061.IP address is banned for this API.',
			'silent' => '200.062.IP address is muted.',
			'unnecessary' => '200.063.Session based unnecessary process detected.',
			'fragile' => '200.064.Request is out of operation limits. Session closed.',
			'form' => '200.065.Please fill the form completely and as indicated.',
			'google_api_off' => '<div class="d-none">Google API is disabled for this app.</div>'
		]
    ];
    
    /**
     * Process support function for validation. Returns package object from related db process.
     * 
     * @method checkProcessSupport() 
     * @param string $work
     * @param string $uWorkId
     * @return object|bool $paket
     */
    public static function checkProcessSupport(string $work,$uWorkId = null): object|bool
    {
        if (in_array($work,self::PROCESS)){

            $k = array_search($work,self::PROCESS);

            if (isset($uWorkId)){

                $paket = \Model::factory('VsIslemdestek')->useIdColumn('gercekkod')->whereEqual('islemtipi',$k)->findOne($uWorkId);
            }else{

                $paket = \Model::factory('VsIslemdestek')->whereEqual('islemtipi',$k)->findMany();
            }
        }else{
            
            $paket = false;
        }

        return $paket;
    }

    /**
     * @method setProcessSupport() 
     * @param string $kno
     * @param string $istipi
     * @param string $kkodu
     * @return void
     */
    public static function setProcessSupport(string $kno,int $istipi,string $kkodu): void
    {
        $ydestek = \Model::factory('VsIslemdestek')->create();

        $ydestek->kullaniciid = $kno;

        $ydestek->islemtipi = $istipi;

        $ydestek->gercekkod = $kkodu;

        $ydestek->tarihsaat = date('d-m-Y H:i:s');

        $ydestek->save();
    }

    /**
     * @method ban()
     * @return void
     */
    public static function ban(): void
    {
        $yeniblock = \Model::factory('VsKilit')->create();
        
        $yeniblock->adres = $_SERVER['REMOTE_ADDR'];

        $yeniblock->kapalianahtar = get_called_class();

        $yeniblock->save();

        session_destroy();

        die(self::appAuditInformation[LANG]['banned']);
    }

    /**
     * @method lightBlock()
     * @return void
     */
    public static function lightBlock(): void
    {
        if (is_int(Sysled::get('http_request_count_light'))){

            Sysled::modify('http_request_count_light',null,'counter');
        }else{

            SysLed::set('http_request_count_light',1);
        }

        if (Sysled::get('http_request_count_light') > 25){

            die(self::appAuditInformation[LANG]['unnecessary']);
        }
    }

    /**
     * @method manageRequestCount() 
     * @param string $hop
     * @return void|redirect|exit
     */
    public static function manageRequestCount(): void
    {
        $db = \Model::factory('VsKilit');

        if ($db->whereEqual('adres',Sysled::get('user_client_address'))->count() > 0){

            Sysled::logOff();

            die(self::appAuditInformation[LANG]['banned']);
        }

        Sysled::modify('http_request_count',null,'counter');

        if (SysLed::get('http_request_count') > 15){

            $who = explode('-',Sysled::get('user_sealed_key'));

            $new = $db->create();

            $new->adres = $who[0];

            $new->kapalianahtar = $who[1];

            $new->save();

            Sysled::modify('http_request_count',1);
        }
        
    }

    /**
     * @method checkPostVars()
     * @param array $toValidate
     * @param mixed|string|null $bunu
     * @return bool $k
     */
    public static function checkPostVars(array $toValidate): bool
    {
        $z = 0;
        foreach($toValidate as $t){

            if (isset($_POST[$t])){

                if (is_string(Http::__px($t)) || is_int(Http::__px($t))){

                    $z++;
                }                
            }
        }

        return $z === count($toValidate) ? true : false;
    }

    /**
     * @method checkGoogleCapt()
     * @return bool $k
     */
    public static function checkGoogleCapt(): bool
    {
        if (isset($_POST['g-recaptcha-response']) && App::getApp('googleIsOn')){
            
            $googlekeyreturn = Http::__px('g-recaptcha-response');
            
            require_once RELEASE . '-external-sources' . '/' . 'googlerecap' . '/' . 'autoload.php';
            
            $recaptcha = new \ReCaptcha\ReCaptcha(App::getProvider('googleReCAPTKey'), new \ReCaptcha\RequestMethod\CurlPost());
            
            $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])->setExpectedAction('loginsayfasi')->setScoreThreshold(0.5)->verify($googlekeyreturn, $_SERVER['REMOTE_ADDR']);

            if ($resp->isSuccess()){
                
                return true;
            }
        }
        
        return false;
    }

    /**
     * @method checkGoogleCaptSpecial()
     * @param string $ozelFormDegeri
     * @param string $ozelFormHedefi
     * @return bool $k
     */
    public static function checkGoogleCaptSpecial(string $ozelFormDegeri,string $ozelFormHedefi): bool
    {
        if (isset($_POST[$ozelFormDegeri]) && App::getApp('googleIsOn')){
            
            $googlekeyreturn = Http::__px($ozelFormDegeri);
            
            require_once RELEASE . '-external-sources' . '/' . 'googlerecap' . '/'. 'autoload.php';
            
            $recaptcha = new \ReCaptcha\ReCaptcha(App::getProvider('googleReCAPTKey'), new \ReCaptcha\RequestMethod\CurlPost());
            
            $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])->setExpectedAction($ozelFormHedefi)->setScoreThreshold(0.5)->verify($googlekeyreturn, $_SERVER['REMOTE_ADDR']);

            if ($resp->isSuccess()){
                
                return true;
            }
        }
        
        return false;
    }

    /**
     * @method getGoogleCaptSpecial()
     * @param string $formElemId html öğe id
     * @param string $actionName script action adı
     * @return string $gc
     */
    public static function getGoogleCaptSpecial(string $formElemId,string $actionName): string
    {
        $gc = '<script src="https://www.google.com/recaptcha/api.js?render=%s"></script> <script> grecaptcha.ready(function() { grecaptcha.execute("%s", {action: "%s"}).then(function(token) { document.getElementById("%s").value = token; }); }); </script>';

		if (App::getApp('googleIsOn')){

			return sprintf($gc,App::getProvider('googleReCAPTSite'),App::getProvider('googleReCAPTSite'),$actionName,$formElemId);
		}else{

			return self::appAuditInformation[LANG]['google_api_off'];
		}
    }

    /**
     * @method checkUserSession()
     * @return bool
     */
    public static function checkUserSession(): bool
    {
        if (is_string(SysLed::get('user_page_idstring'))){

            return false;
        }else{

            SysLed::logOff();

            return true;
        }
    }

    /**
     * 8 - 20 karakter - Eşleşme kontrolu
     * 
     * @method checkUserPass()
     * @param string $dsif
     * @param string $dsifiki
     * @return bool $st
     */
    public static function checkUserPass(string $dsif,string $dsifiki): bool
    {
        if (preg_match("/((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,20})/", $dsif) === 1 && $dsif === $dsifiki){

            return true;
        }

        return false;
    }

    /**
     * email adres kontrolu
     * 
     * @method checkUserName()
     * @param string $k
     * @return bool $kadi
     */
    public static function checkUserName(string $k): bool
    {
        if (is_string(filter_var($k,FILTER_VALIDATE_EMAIL))){

            return true;
        }

        return false;
    }

    /**
     * @method checkOpenKey()
     * @return bool
     */
    public static function checkOpenKey(string $toValidate): bool
    {
        return SysLed::audit('user_public_key',$toValidate);
    }

    /**
     * @method checkUserKeys()
     * @return bool
     */
    public static function checkUserKeys(): bool
    {
        return is_string(SysLed::get('user_public_key')) && is_string(SysLed::get('user_sealed_key'));
    }

    /**
     * @method checkSearch()
     * @param string $izin
     * @return bool $a
     */
    public static function checkSearch(string $toValidate): bool
    {
        if (SysLed::audit('search_permit_string',$toValidate)){

            SysLed::del('search_permit_string');

            return true;
        }

        return false;
    }

    /**
     * @method setOpenKey() 
     * @return void
     */
    public static function setOpenKey(): void
    {
        if (is_bool(SysLed::get('user_public_key'))){

            SysLed::set('user_public_key',base64_encode(Audit::randStr(64)));
        }
    }

    /**
     * @method getOpenKey()
     * @return string $acikA
     */
    public static function getOpenKey(): string
    {
        return Sysled::get('user_public_key');
    }

    /**
	 * @method setSealedKey()
     * @return void
     */
    public static function setSealedKey(): void
    {
        if (is_bool(SysLed::get('user_sealed_key'))){

            SysLed::set('user_sealed_key',$_SERVER['REMOTE_ADDR'] .'-'. Audit::randStrAuth(32));

            SysLed::set('http_request_count',1);
        }
    }

    /**
	 * @method createSessionUri()
	 * @return string
	 */
	public static function createSessionUri(): string
	{
		if (is_bool(SysLed::get('http_public_hash_uri'))){

            SysLed::set('http_public_hash_uri',hash('sha256',SysLed::get('user_open_key') . SysLed::get('user_sealed_key')));
		}

		return SysLed::get('http_public_hash_uri');
	}

    /**
	 * @method getSessionUri()
	 * @return void
	 */
	public static function getSessionUri(): string
	{
		$tempUri = SysLed::get('http_public_hash_uri');

        SysLed::delMany([
            'http_public_hash_uri',
            'http_public_key'
        ]);

		return $tempUri;
	}

    /**
     * @method authSearch()
     * @return string $aramaIzni
     */
    public static function authSearch(): string
    {
        return SysLed::get('search_permit_string',true);
    }

    /**
     * @method setSearch()
     * @return void
     */
    public static function setSearch(): void
    {
        SysLed::set('search_permit_string',Audit::randStrLight(32));
    }

    /**
     * [EN] Obfuscater
     * [TR] Karıştırıcı
     * 
     * @method setSimpleLock()
     * @param string $bData
     * @return void
     */
    public static function setSimpleLock(string $bData): bool
    {
        if (is_bool(SysLed::get('user_simple_lock_idstring'))){

            $startKey = Audit::randStrLight(16);

            $endKey = Audit::randStrLight(12);

            $fName = Audit::randStrLight(24);

            if (strlen($bData) > 16){

                $generatedData = [

                    $startKey . substr($bData,0,10),
                    $endKey . substr($bData,10)
                ];

                Sysled::set('user_simple_lock_filename',$fName);

                file_put_contents(BASE . '/' . 'local-folder' . '/' . $fName . '-locker.vssl',
                    serialize([
                        'len_s' => strlen($startKey),
                        'len_e' => strlen($endKey)
                    ])
                );

                SysLed::set('user_simple_lock_idstring',serialize($generatedData));

                return true;
            }else{

                return false;
            }
        }

        return false;
    }

    /**
     * @method openSimpleLock()
     * @return string
     */
    public static function openSimpleLock(): string|null
    {
        $generatedData = SysLed::get('user_simple_lock_idstring',true);

        $keyFile = BASE . '/' . 'local-folder' . '/' . SysLed::get('user_simple_lock_filename',true) . '-locker.vssl';

        if (is_string($generatedData)){

            $nums = unserialize(file_get_contents($keyFile)); unlink($keyFile);

            $arrD = unserialize($generatedData);

            return substr($arrD[0],$nums['len_s'],10) . substr($arrD[1],$nums['len_e']);
        }else{

            return null;
        }
    }
}
?>