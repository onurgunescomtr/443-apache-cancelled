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

use stdClass;
/**
 * Scribe - KontrolYapi
 */
class Scribe{

    /**
     * @var string $ozelkayitdosyasi
     */
    private const ozelkayitdosyasi = 'v4-ozelkayitlar.csv';
    /**
     * @var string $primaryLogFile
     */
    public const primaryLogFile = BASE . '/' . LOGFOLDER . '/' . 'common-application.log';
    /**
     * @var string $systemLevel
     */
    private $systemLevel;
    /**
     * @var object $logPattern
     * @param string tarihsaat
     * @param string type
     * @param string explain
     * @param string ipAddress
     * @param string reportLevel
     * @param string priority
     * @param string logtipi
     */
    private $logPattern;

    public function __construct(string $logType,string $whatHappened,$rs = null,$od = null)
    {
        $this->logPattern = new stdClass();

        $this->diagnose();

        $this->setLedger($logType,$whatHappened,$rs,$od);
    }

    /**
     * hata kalıbını oluşturur
     * 
     * @method setLedger()
     * @param $rl Report Level, default 8
     * @param $prior Priority Level, default 8
     * @return void
     */
    private function setLedger(string $logType,string $whatHappened,int $rl = 8,int $prior = 8): void
    {
        $this->logPattern->when = date('d-m-Y H:i:s');

        $this->logPattern->systemLevel = $this->systemLevel; // = date('d-m-Y H:i:s');

        $this->logPattern->type = $logType;

        $this->logPattern->explain = $whatHappened;

        $this->logPattern->ipAddress = $_SERVER['REMOTE_ADDR'];

        $this->logPattern->reportLevel = $rl;

        $this->logPattern->priority = $prior;
    }

    /**
     * @method getLedger
     * @return array $pack
     */
    public function getLedger(): array
    {
        $pack['file'] = self::primaryLogFile;
        
        $pack['csv'] = $this->logPattern->when . ',' .  $this->logPattern->systemLevel . ',' . $this->logPattern->type . ',' . $this->logPattern->explain . ',' . $this->logPattern->ipAddress . ',' . $this->logPattern->reportLevel . ',' . $this->logPattern->priority;

        $pack['time'] = $this->logPattern->when;
        
        return $pack;
    }

    /**
     * kontrol isteği tanımlayıcısı
     * 
     * @method diagnose()
     * @return void
     */
    private function diagnose(): void
    {
        switch(true):

            case SysLed::get('user_client_address'):

                $this->systemLevel = 'app-layer';

            break;
            default:

                $this->systemLevel = 'system-layer';

            break;
        endswitch;
    }

    /**
     * @method appLog()
     * @param string $whatHappened
     * @return void
     */
    public static function appLog(string $whatHappened): void
    {
        $dos = new System\Dos;

        $dos->cd(RELEASE . '-logs')->f(COMMONLOG)->write(get_called_class() . ': ' . $whatHappened,'log');

        unset($dos);
    }

    /**
     * @method sysLog()
     * @param string $whatHappened
     * @return void
     */
    public static function sysLog(string $whatHappened): void
    {
        $dos = new System\Dos;

        $dos->cd(RELEASE . '-configuration' . '/' . 'yapisal-kontrol' . '/' . 'kayitlar' . '/' . RELEASE . '-kur')->f('system.log')->write(get_called_class() . ': ' . $whatHappened,'log');

        unset($dos);
    }

    /**
     * writes requests to DB
     * 
     * @method requestLog() gelen istekleri kaydeder.
     * @param string $kayittipi
     * @param string $noldu
     * @param string|null $hno   hesap no
     * @param int $rseviye
     * @param int $oderece
     * @param string $is    islem
     * @param string $ekis  ekislem
     * @param string $sor   sorgu
     * @return void
     */
    public static function requestLog(?string $is = null,?string $ekis = null,?string $sor = null): void
    {
        if (!VSDEVMODE){

            $yaz = \Model::factory('VsLogsistekler')->create();

            $yaz->tarihsaat = date('d-m-Y H:i:s');

            $yaz->tanim = 'Request';

            $yaz->hesapno = SysLed::get('user_page_idstring');

            $yaz->ip = SysLed::get('user_client_address');

            $yaz->raporseviyesi = 8;

            $yaz->onemderecesi = 8;

            $yaz->islem = $is;

            $yaz->ekislem = $ekis;

            $yaz->sorgu = $sor;

            $yaz->yonlendiren = $_SERVER['HTTP_REFERER'] ?? null;

            $yaz->useragent = $_SERVER['HTTP_USER_AGENT'] ?? 'not-available';

            $yaz->save();
        }
    }

    /**
     * writes to db - 
     * records blocked requests
     * 
     * @method kilitkayit() Engellenmiş istekleri kaydedder.
     * @param string $ileti engel tanımı
     * @return void
     */
    public static function gateLog(string $ileti): void
    {
        $yaz = \Model::factory('VsLogskilit')->create();

        $yaz->tarihsaat = date('d-m-Y H:i:s');

        $yaz->tipi = 'Kilit Kaydı';

        $yaz->tanim = $_SERVER['HTTP_USER_AGENT'] ?? 'UA yok';

        $yaz->ip = $_SERVER['REMOTE_ADDR'];

        $yaz->uri = $_SERVER['REQUEST_URI'];

        $yaz->yonlendiren = $_SERVER['HTTP_REFERER'] ?? null;

        $yaz->iletim = $ileti;

        $yaz->save();
    }

    /**
     * @version 443 - hence there is no sudo GUIs available in this release
     * @todo 443 remove 
     *  
     * Sistem kayıtlarını veritabanına yazar.
     * 
     * @method systemLog() 
     * @param string $kayittipi
     * @param string $noldu
     * @param string $hno   varsa hesap no
     * @param int $rseviye   rapor seviyesi
     * @param int $oderece   önem derecesi
     * @return void
     */
    public static function systemLog(int $kayittipi, string $noldu, ?string $hno, int $rseviye, int $oderece): void
    {
        $yaz = \Model::factory('VsLogssistem')->create();

        $yaz->tarihsaat = date('d-m-Y H:i:s');
        
        $yaz->tipi = $kayittipi;

        $yaz->tanim = $noldu;

        $yaz->hesapno = $hno;

        $yaz->ip = SysLed::get('user_client_address');

        $yaz->raporseviyesi = $rseviye;

        $yaz->onemderecesi = $oderece;

        $yaz->save();
    }
}
?>