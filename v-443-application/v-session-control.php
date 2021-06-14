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
 * Warden - Yapi
 */
final class Warden{

    

    /**
     * v.3 - v.4 işlem destekleme kontrol etme fonksiyonu.
     * 
     * @method setProcessSupport() 
     * @param string $kno
     * @param string $istipi
     * @param string $kkodu
     * @return void
     */
    public static function setProcessSupport(string $kno,int $istipi,string $kkodu): void
    {
        $ydestek = \Model::factory('VsIslemdestek')->create();

        $ydestek->kullaniciid = $kno; // islem icin tekil belirtici no - kullanıcı no - islem no

        $ydestek->process_type = $istipi;

        $ydestek->gercekkod = $kkodu;

        $ydestek->tarihsaat = date('d-m-Y H:i:s');

        $ydestek->save();
    }

    /**
     * @method setSession()
     * @return void
     */
    public static function setSession(): void
    {
        session_start();

        if (isset($_SESSION['aktivite']) && ((time() - $_SESSION['aktivite']) > USERTIME)){

            session_unset();
            session_destroy();
            session_start();
        }else{

            $_SESSION['aktivite'] = time();
        }

        if (!isset($_SESSION['client_address'])){

            $_SESSION['client_address'] = $_SERVER['REMOTE_ADDR'];
        }
    }

    /**
     * oturum açık kaydını (anahtarını) oluşturur.
     * 
     * @method setOpenKey() 
     * @return void
     */
    public static function setOpenKey(): void
    {
        if (!isset($_SESSION['public_key'])){

            $_SESSION['public_key'] = base64_encode(Audit::randStr(64));
        }
    }

    /**
     * @method getOpenKey()
     * @return string $acikA
     */
    public static function getOpenKey(): string
    {
        return $_SESSION['public_key'];
    }

    /**
     * Creates the session off key for user processes.
     * 
     * kullanıcı işlemleri için oturum anahtarı yaratır.
     * 
     * @method setSealedKey()
     * @return void
     */
    public static function setSealedKey(): void
    {
        if (!isset($_SESSION['sealed_key'])){

            $_SESSION['sealed_key'] = $_SERVER['REMOTE_ADDR'] .'-'. Audit::randStrAuth(32);

            $_SESSION['request_count'] = 0;
        }
    }

    /**
     * AppAudit::checkSearch
     * 
     * @method authSearch()
     * @return string $aramaIzni
     */
    public static function authSearch(): string
    {
        if (!isset($_SESSION['ARAMAIZNI'])){

            $_SESSION['ARAMAIZNI'] = Audit::randStrLight(32);
        }

        return $_SESSION['ARAMAIZNI'];
    }

    /**
     * kullanıcı isteği ile oturum kapatılır.
     * 
     * @method logOut() 
     * @return void
     */
    public static function logOut(): void
    {
        $cookie = new \Delight\Cookie\Cookie(BCOOKIE);

        $cookie->setValue($_SESSION['account_cookie_vs']);

        $cookie->setMaxAge(1);

        $cookie->setPath('/');

        $cookie->setDomain(DOMAIN);

        $cookie->setHttpOnly(true);

        $cookie->setSecureOnly(true);

        $cookie->setSameSiteRestriction('Strict');

        $cookie->delete();

        session_destroy();

        Http::guide(ADDRESS, 'bilgi', 'Çıkış başarılı. Mutlu günler!');
    }

    /**
     * @method kullaniciKukiYaz()
     * @return void
     */
    public static function kullaniciKukiYaz(): void
    {
        $cookie = new \Delight\Cookie\Cookie(UCOOKIE);

        $cookie->setValue($_SESSION['account_cookie_vs']);

        $cookie->setMaxAge(60 * 60 * 24 * 30);

        $cookie->setPath('/');

        $cookie->setDomain(DOMAIN);

        $cookie->setHttpOnly(true);

        $cookie->setSecureOnly(true);

        $cookie->setSameSiteRestriction('Strict');

        $cookie->save();
        
        unset($_SESSION['public_key']);
    }

    /**
     * @method kullaniciKukiKontrol()
     * @return bool $n
     */
    public static function kullaniciKukiKontrol(): bool
    {
        $n = false;

        if (\Delight\Cookie\Cookie::exists(UCOOKIE)){

            $n = true;
        }

        return $n;
    }

    /**
     * @method kullaniciKukiOku()
     * @return string
     */
    public static function kullaniciKukiOku(): string
    {
        return \Delight\Cookie\Cookie::get(UCOOKIE);
    }
}
?>