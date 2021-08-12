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

namespace VTS\Network;

use VTS\Builder;
use VTS\Http;
use VTS\PathWays;

\VTS\Version\VersionCheck::dkontrol(__FILE__,'4.4.2');
/**
 * NetControl - AgKontrol
 */
final class NetControl extends Http{

    use Builder;

    /**
     * @var array $browsericerikleri user agent detayları
     */
    private array $browsericerikleri = [
        'requests',
        'phyton',
        'python',
        'provider',
        'scan',
        'spider',
        'go-http',
        'wap',
        'java',
        'node-fetch',
        'ruby',
        'okhttp'
    ];
    /**
     * @var array $dosyatipleri  dosya uzantıları
     */
    private array $dosyatipleri = [
        '.php',
        '.json',
        '.txt',
        '.env',
        '.cs',
        '.ts',
        '.xml',
        '.vsda',
        'vsdax',
        'vsdm',
        'phpmyadmin',
        'phpMyAdmin',
        'script'
    ];
    /**
     * the subject
     * 
     * namı diğer vatandaş (< 443) - isteği ileten makina bilgileri
     * 
     * @var array $subject
     */
    private array $subject = [];
    /**
     * @var string IAAD ip adresi aralıkları dosyası
     */
    private const IAAD = BASE . '/' . RELEASE . '-configuration' . '/' . 'system-files' . '/' . 'restricted-ip-address-ranges.json';
    /**
     * @var string IAD ip adresleri dosyası
     */
    private const IAD = BASE . '/' . RELEASE . '-configuration' . '/' . 'system-files' . '/' . 'restricted-ip-addresses.json';
    /**
     * @var array $ipler yasakli ip adresleri
     */
    private array $ipler = [];
    /**
     * @var array $iparaliklari yasaklı IP aralıkları
     */
    private array $iparaliklari = [];
    /**
     * @var array $proksiDeg
     */
    private array $proksiDeg = [
        'HTTP_X_FORWARDED_FOR',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'X_FORWARDED_FOR',
        'VIA',
        'HTTP_VIA',
        'HTTP_CLIENT_IP',
        'FORWARDED_FOR_IP',
        'HTTP_PROXY_CONNECTION',
        'X_FORWARDED_HOST'
    ];
    /**
     * @var array $izinliBotlar
     */
    private array $izinliBotlar = [
        'google' => [
            0 => [
                '66.249.64.0',
                '66.249.95.255'
            ]
        ],
        'apple' => [
            0 => [
                '17.0.0.0',
                '17.255.255.255'
            ]
        ],
        'bing' => [
            0 => [
                '157.54.0.0',
                '157.60.255.255'
            ]
        ],
        'yandex' => [
            0 => [
                '77.88.9.0',
                '77.88.9.127'
            ]
        ]
    ];
    /**
     * @var bool $kayitliBot
     */
    private bool $kayitliBot = false;
    /**
     * @var bool $botTaramaIstegi
     */
    private bool $botTaramaIstegi = false;
    
    public function __construct(PathWays $pw)
    {
        $this->setProc($this->getPack($pw));

        $this->suan = time();

        $this->loadRegistry();

        $this->examine();

        $this->diagnose();
    }

    /**
     * loads ip addresses and ip address ranges from json files (yeah... each fucking time when using v.Tam apache package... read PHP file cache for FPM, cmon people!)
     * 
     * gerekli kontrol dosyalarını yükler
     * 
     * @method loadRegistry() 
     */
    private function loadRegistry(): void
    {
        file_exists(self::IAD) ? $this->ipler = json_decode(file_get_contents(self::IAD),true) : $this->ipler = null;

        file_exists(self::IAAD) ? $this->iparaliklari = json_decode(file_get_contents(self::IAAD),true) : $this->iparaliklari = null;
    }

    /**
     * @method yaz() $turune gore gerekli json dosyasını oluşturur
     * @param string $turu - blok-ip
     */
    public static function yaz($turu = null,$icerik = null){

        switch($turu):
            case 'blok-ip':

                $ipler = json_decode(file_get_contents(self::IAD),true);

                $ipler[] = $icerik;

                file_put_contents(self::IAD,json_encode($ipler));

            break;
            case 'blok-aralik':

                $adi = $icerik['yer'];

                $aralik = $icerik['ipler'];

                file_exists(self::IAAD) ? $iparaligi = json_decode(file_get_contents(self::IAAD),true) : $iparaligi = array();

                $iparaligi[$adi]['ipler'][] = $aralik;

                file_put_contents(self::IAAD,json_encode($iparaligi));

            break;

        endswitch;

    }

    /**
     * Gerekli kontrolleri yapar
     * 
     * @method diagnose()
     * @return void
     */
    private function diagnose(): void
    {
        if (isset($this->ipler)){

            if (in_array($this->subject['ip'],$this->ipler)){

                \VTS\Scribe::gateLog('bloklu');
                
                self::closeConForbidden('illegal_tek');
            }
        }

        if (isset($this->iparaliklari)){

            foreach($this->iparaliklari as $t){

                foreach($t['ipler'] as $k){

                    $tek = explode(',',$k);

                    if (ip2long($tek[0]) <= ip2long($this->subject['ip']) && ip2long($tek[1]) >= ip2long($this->subject['ip'])){

                        \VTS\Scribe::gateLog('bloklu');
                        
                        self::closeConForbidden('illegal_blok');
                    }
                }
            }
        }

        foreach($this->subject['proksi'] as $t){

            if (isset($t)){

                \VTS\Scribe::gateLog('vekil sunucu');
                
                self::closeConForbidden('vekil_sunucu');
            }
        }

        if ($this->subject['istekmetodu'] === 'PUT' || $this->subject['istekmetodu'] === 'HEAD' || $this->subject['istekmetodu'] === 'OPTIONS' || $this->subject['istekmetodu'] === 'DELETE'){

            \VTS\Scribe::gateLog('geçersiz istek');
            
            self::closeConForbidden('gecersiz_istek');
        }

        if (($this->subject['istekzamani'] + (int)5000) < (int)$this->suan){

           \VTS\Scribe::gateLog('süre aşımı.yogunluk.');
           
           self::manageRedundantRequest(408);
        }

        $this->fileRequestSearch();

        foreach($this->browsericerikleri as $t){

            if (is_int(strpos(strtolower($this->subject['browser']),$t))){

                \VTS\Scribe::gateLog('gereksiz tipler.');
                
                self::closeConForbidden('gereksiz_tarayici');
            }
        }

        if ($this->botKontrol()){

            \VTS\Scribe::gateLog('bot gereksiz');
            
            self::closeConForbidden('izinsiz_bot');
        }
    }

    /**
     * @method fileRequestSearch()
     * @return void
     */
    private function fileRequestSearch(): void
    {
        if (isset($this->process)){

            $mandal = $this->process . $this->subProcess . $this->subject['sorgu'];

            foreach($this->dosyatipleri as $t){

                if (str_contains($mandal,$t)){

                    \VTS\Scribe::gateLog('dosya talebi');
                    
                    self::closeConForbidden('yasakli_dosya');
                }
            }
        }
    }

    /**
     * @method botKontrol()
     * @return bool $sonuc
     */
    private function botKontrol(): bool
    {
        if (str_contains($this->subject['browser'],'bot')){

            $this->botTaramaIstegi = true;

            foreach($this->izinliBotlar as $t){

                foreach($t as $tek){

                    if (ip2long($tek[0]) <= ip2long($this->subject['ip']) && ip2long($tek[1]) >= ip2long($this->subject['ip'])){

                        $this->kayitliBot = true;
                    }
                }
            }

            if ($this->botTaramaIstegi && $this->kayitliBot){

                return false;
            }

            if ($this->botTaramaIstegi && !$this->kayitliBot){

                return true;
            }
        }

        return false;
    }

    /**
     * @method proxyCheck()
     * @return void
     */
    private function proxyCheck(): void
    {
        foreach($this->proksiDeg as $t){

            $this->subject['proksi'][] = $_SERVER[$t] ?? null;
        }
    }

    /**
     * @method examine()
     * @return void
     */
    private function examine(): void
    {
        $this->subject['ip'] = $_SERVER['REMOTE_ADDR'];

        $this->proxyCheck();

        $this->subject['istekmetodu'] = $_SERVER['REQUEST_METHOD'];
        $this->subject['istekzamani'] = $_SERVER['REQUEST_TIME'];
        $this->subject['sorgu'] = $_SERVER['QUERY_STRING'] ?? null;
        $this->subject['browser'] = $_SERVER['HTTP_USER_AGENT'] ?? null;
    }

    public function testBir(): array
    {
        foreach($this->iparaliklari as $t){

            foreach($t['ipler'] as $k){

                $i[] = $k;
            }
        }

        return $i;
    }

    public function testIki(string $adres): void
    {
        \VTS\Debug::see($this->subject['ip']);

        if (isset($this->iparaliklari)){

            foreach($this->iparaliklari as $t){

                foreach($t['ipler'] as $k){

                    $k = explode(',',$k);

                    if (ip2long($k[0]) <= ip2long($adres) && ip2long($k[1]) >= ip2long($adres)){

                        \VTS\Scribe::gateLog('bloklu'); die('IP adres blogu engellenmiştir.');

                    }
                }
            }
        }
    }
}
?>