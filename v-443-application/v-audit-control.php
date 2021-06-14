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
 *                          mailto:verisanat@outlook.com
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

namespace VTS;

Version\VersionCheck::dkontrol(__FILE__,'4.4.3');

/**
 * AppAudit - Denetim
 */
final class AppAudit{

    /**
     * array search - bul - key ler için adres yaz baska array, adresi dondur.
     * 
     * @var array $PROCESS
     */
    protected const PROCESS = array(
        '0' => 'verify',
        '1' => 'confirm',
        '2' => 'subs-cancellation-delete-my-data'
    );
    
    protected const PIT = array(
        '0' => 'VsIslemDestek,process_type',
        '1' => 'VsIslemDestek,process_type',
        '2' => 'VsIslemDestek,process_type'
    );

    /**
     * @var array $appAuditInformation
     */
    private const appAuditInformation = [
        'banned' => '200.061.IP address is banned for this API.',
        'silent' => '200.062.IP address is muted.',
        'unnecessary' => '200.063.Session based unnecessary process detected.',
        'fragile' => '200.064.Request is out of operation limits. Session closed.',
        'form' => '200.065.Please fill the form completely and as indicated.'
    ];

    /**
     * URL and URI common additional cleaner. Added for url-control.
     * URL ve URI için genel temizleyici. url-kontrol için eklendi.
     * 
     * @method uriHopper() 
     * @param string $part
     * @return null|string $p
     */
    public static function uriHopper(string $part = null): null|string
    {
        if (isset($part)){
        
            $part = trim($part);
            
            $part = urlencode($part);
            
            $ridOff = array(';','%26%2359');
            
            $change = array(null,null);
            
            return str_replace($ridOff,$change,$part);
        }

        return null;
    }
    
    /**
     * Process support function for auditing operations.
     * Returns package object from related db process.
     * 
     * Denetleyiciler için ek işlem kontrolu sağlar. Denetim onayı için eklendi. Sonuç paket objesi döndürür.
     * 
     * @method checkProcessSupport() 
     * @param string $work
     * @param string $uWorkId
     * @return object|bool $paket
     */
    public static function checkProcessSupport(string $work, $uWorkId = null): object|bool
    {
        if (in_array($work,self::PROCESS)){

            $k = array_search($work,self::PROCESS);

            $target = explode(',',self::PIT[$k]);

            if (isset($uWorkId)){

                $paket = \Model::factory($target[0])->filter('kodara',$uWorkId)->whereEqual($target[1],$k)->findOne();
            }else{

                $paket = \Model::factory($target[0])->whereEqual($target[1],$k)->findMany();
            }
        }else{
            
            $paket = false;
        }

        return $paket;
    }

    /**
     * creates a new record for VsLock table
     * 
     * @method ban()
     * @return void
     */
    public static function ban(): void
    {
        $yeniblock = \Model::factory('VsKilit')->create();
        
        $yeniblock->adres = $_SERVER['REMOTE_ADDR'];

        $yeniblock->kapalianahtar = 'erisim-banned';

        $yeniblock->save();

        session_destroy();

        die(self::appAuditInformation['banned']);
    }

    /**
     * Session request count independed illegal form action locker.
     * 
     * istek sayısından bağımsız formlar için aykırı durumda kilit kaydı alır. 90001 düzenle iki aynı isim
     * 
     * @method formban() 
     * @return void
     */
    public static function formBan(): void
    {
        $yeniblock = \Model::factory('VsKilit')->create();
        
        $yeniblock->adres = $_SERVER['REMOTE_ADDR'];

        $yeniblock->kapalianahtar = 'form-banned';

        $yeniblock->save();

        session_destroy();

        die(self::appAuditInformation['silent']);
    }

    /**
     * Session request count dependent blocker.
     * 
     * istek sayısına bağlı olarak kullanıcı IP sini ilgili işlemden yasaklar.
     * 
     * @method blockla() 
     * @return void
     */
    public static function block(): void
    {
        if ($_SESSION['request_count'] > 15){

            $ipadresi = explode('-', $_SESSION['sealed_key']);

            $yeniblock = \Model::factory('VsKilit')->create();

            $yeniblock->adres = $ipadresi[0];

            $yeniblock->kapalianahtar = $ipadresi[1];

            $yeniblock->save();

            $_SESSION['request_count'] = 1;
        }
    }

    /**
     * Aynı adresten 20 tanımsız isteği oturumda barındırır
     * sonrasında çalışmayı dururur.
     * 
     * @method lightBlock()
     * @return void
     */
    public static function lightBlock(): void
    {
        !isset($_SESSION['i_am_insistent']) ? $_SESSION['i_am_insistent'] = 0 : $_SESSION['i_am_insistent'] += 1;

        if ($_SESSION['i_am_insistent'] > 20){

            die(self::appAuditInformation['unnecessary']);
        }
    }

    /**
     * isteği ileten IP adresini kilit kayıtlarında kontrol eder.
     * bulursa google a gönderir. Yoksa istek sayısını kaydeder.
     * 
     * @method check() 
     * @param string $hop
     * @return void|redirect|exit
     */
    public static function check(string $hop = null): void
    {
        $kontrol = isset($hop) ? \Model::factory('VsKilit')->whereEqual('adres', $hop)->count() : \Model::factory('VsKilit')->whereEqual('adres', $_SESSION['client_address'])->count();

        if ($kontrol > 0){

            Http::dispatch('https://www.google.com');
        }

        if (isset($_SESSION['request_count'])){

            $_SESSION['request_count'] += 1;

        }else{

            session_destroy();

            die(self::appAuditInformation['fragile']);
        }
    }

    /**
     * @method formVarCheck()
     * @param array $bunlari
     * @param mixed|string|null $bunu olumsuzluk neticesinde uygulama bilgilendir metni.
     * @return bool $k
     */
    public static function formVarCheck(array $bunlari,?string $bunu = null): bool
    {
        foreach($bunlari as $t){

            if (empty($_POST[$t]) || $_POST[$t] === null){

                $bunu === null ? Http::inform('warn',self::appAuditInformation['form']) : Http::inform('warn',$bunu);

				return false;
            }
        }

        return true;
    }

    /**
     * Tipik Google Recaptcha v3 kontrol
     * g-recatpcha-response
     * 
     * @method googleCaptCheck()
     * @return bool $k
     */
    public static function googleCaptCheck(): bool
    {
        if (isset($_POST['g-recaptcha-response'])){
            
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
     * Özel Google recaptcha v3 kontrol
     * $ozelformhedefi
     * 
     * @method googleCaptSpecialCheck()
     * @param string $ozelFormDegeri
     * @param string $ozelFormHedefi
     * @return bool $k
     */
    public static function googleCaptSpecialCheck(string $ozelFormDegeri,string $ozelFormHedefi): bool
    {
        if (isset($_POST[$ozelFormDegeri])){
            
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
     * Google sabitleriyle birlikte google captcha v3 html script tagını döndürür.
     * "html elem id" => $formElemId
     * "action" => $actionName
     * 
     * @method getGoogleCaptSpecial()
     * @param string $formElemId html öğe id
     * @param string $actionName script action adı
     * @return string $gc
     */
    public static function getGoogleCaptSpecial(string $formElemId,string $actionName): string
    {
        $gc = '<script src="https://www.google.com/recaptcha/api.js?render=%s"></script> <script> grecaptcha.ready(function() { grecaptcha.execute("%s", {action: "%s"}).then(function(token) { document.getElementById("%s").value = token; }); }); </script>';

        return sprintf($gc,App::getProvider('googleReCAPTSite'),App::getProvider('googleReCAPTSite'),$actionName,$formElemId);
    }

    /**
     *  oturumu kontrol eder. Çerezi ve oturumu siler.
     * 
     * @method userSessionCheck()
     * @return bool
     */
    public static function userSessionCheck(): bool
    {
        $syok = false;

        if (isset($_SESSION['hesapno'])){

            $syok = false;
        }else{

            $cookie = new \Delight\Cookie\Cookie(UCOOKIE);

            $cookie->setValue(null);

            $cookie->setMaxAge(1);

            $cookie->setPath('/');

            $cookie->setDomain(DOMAIN);

            $cookie->setHttpOnly(true);

            $cookie->setSecureOnly(true);

            $cookie->setSameSiteRestriction('Strict');

            $cookie->delete();

            session_destroy();

            $syok = true;
        }

        return $syok;
    }

    /**
     * 8 - 20 karakter - Eşleşme kontrolu
     * 
     * @method userPassCheck()
     * @param string $dsif
     * @param string $dsifiki
     * @return bool $st
     */
    public static function userPassCheck(string $dsif,string $dsifiki): bool
    {
        if (preg_match("/((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,20})/", $dsif) === 1 && $dsif === $dsifiki){

            return true;
        }

        return false;
    }

    /**
     * email adres kontrolu
     * 
     * @method userNameCheck()
     * @param string $k
     * @return bool $kadi
     */
    public static function userNameCheck(string $k): bool
    {
        if (is_string(filter_var($k,FILTER_VALIDATE_EMAIL))){

            return true;
        }

        return false;
    }

    /**
     * @method getUserPageNumber()
     * @return mixed|string|null
     */
    public static function getUserPageNumber(): mixed
    {
        return $_SESSION['hesapno'] ?? null;
    }

    /**
     * @method getUserName()
     * @return mixed|string|null
     */
    public static function getUserName(): mixed
    {
        return $_SESSION['kullanici_adi_soyadi'] ?? null;
    }

    /**
     * @method checkOpenKey()
     * @return bool $erisim
     */
    public static function checkOpenKey(string $gelen): bool
    {
        $erisim = $_SESSION['public_key'] === $gelen ? true : false;

        return $erisim;
    }

    /**
     * @method checkSearch()
     * @param string $izin
     * @return bool $a
     */
    public static function checkSearch(string $izin): bool
    {
        if ($_SESSION['ARAMAIZNI'] === $izin){

            unset($_SESSION['ARAMAIZNI']);

            return true;
        }

        return false;
    }
}
?>