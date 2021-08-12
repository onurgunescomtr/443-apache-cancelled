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
 * @copyright	Copyright (c) 2012 - 2021, Onur Güneş
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
/**
 * App - UygulamaAyarlari
 */
class App{

    /**
     * @var array $changedFiles
     */
    private const changedFiles = [
        '4.4.2' => [
            'dosyalar' => [
                'v-ozellik-genel-modul-ogeler.php',
                'v-ozellik-genel-cerceve.php',
                'v-ozellik-url-yapisi.php'
            ],
            'yontem' => 'sil'
        ]
    ];
    /**
     * @var string $appConfDevFile
     */
    private const appConfDevFile = 'application-configuration' . '-0.json';
    /**
     * @var string $appConfFile
     */
    private const appConfFile = 'application-configuration' . '.json';
    /**
     * @var string $appConfDirectory
     */
    private const appConfDirectory = 'application' . '/' . 'app-config';
    /**
     * @var bool $surumAcilGuncelle
     */
    private bool $surumAcilGuncelle;
    /**
     * @var string $surumEtkiTipi
     */
    private string $surumEtkiTipi;
    /**
     * @var array $infoAppConfig
     */
    private const infoAppConfig = [
        'EN' => [
            'no_acdf' => 'Please login to your Verisanat account to obtain / modify your App Config File (ACF)',
            'no_acdf_live' => 'This app is getting ready to rock! under maintenance, check back later.',
            'read_error' => 'App Config File couldnt be read. Please verify that file is a valid json.',
            'gm' => 'App known exit. Check logs for detailed information' . PHP_EOL
        ],
        'TR' => [
            'no_acdf' => 'Lütfen Verisanat hesabınıza giriş yaparak Uygulama Ayarlar Dosyanızı (ACF) alınız / düzenleyiniz.',
            'no_acdf_live' => 'Uygulama harikalar yaratmak için hazırlanıyor! Şuan bakım aşamasında, tekrar deneyin.',
            'read_error' => 'Uygulama Ayarlar Dosyası (ACF) okunamadı. Lütfen geçerli bir json dosyası olduğunu doğrulayın.',
            'gm' => 'Uygulama durduruldu. Detaylı bilgi için kayıt dosyanızı kontol edin.' . PHP_EOL
        ]
    ];
    /**
     * @var array $applicationProperties
     */
    private const applicationProperties = [
        'applicationName',
        'javaScriptUI',
        'webKeywords',
        'webDescription',
        'webTitle',
        'googleIsOn',
        'facebookIsOn',
        'staticMenu',
        'invalidRequestResponse',
        'applicationUsersEnabled',
        'languageOption',
        'POSpaymentProcessor',
        'mailSenderName',
        'compressedPages',
		'useFullAppSearch',
        'contactUri',
        'aboutUri'
    ];
    /**
     * @var array $moduleProperties
     */
    private const moduleProperties = [
        'mainMenu',
        'useModules',
        'modules',
        'mainPageModule',
        'useMasterModule',
        'useModuleFrames',
        'moduleSpecificUniqueProperty'
    ];
    /**
     * @var array $providerProperties
     */
    private const providerProperties = [
        'googleAnalyticsID',
        'googleOptimizeID',
        'googleTagManagerID',
        'googleAdSenseID',
        'googleReCAPTSite',
        'googleReCAPTKey',
        'facebookAPIVersion',
        'facebookAPPID',
        'facebookAPPKey',
        'facebookAPPDefaultKey',
        'facebookPageToken',
        'facebookPixelID'
    ];
    /**
     * @var array $internalLoad
     */
    private const internalLoad = [
        'internal-apps',
        'internal-extensions',
        'internal-classics'
    ];
    /**
     * @var array $microApps
     */
    protected const microApps = [
        'user' => [
            'release' => 'v-443',
            'interface' => [
                'user'
            ],
            'traits' => [
                'common',
                'form-structure'
            ],
            'files' => [
                'classic-user',
                'user-control',
                'user-structure'
            ]
        ]
    ];
    /**
     * where app provider properties such as Google and Facebook properties resides
     * 
     * @var array $proProp
     */
    protected static array $proProp;
    /**
     * where application properties resides such as app name
     * 
     * @var array $appProp
     */
    protected static array $appProp;
    /**
     * where application module properties resides such as they are available or list of them (as array)
     * 
     * @var array $moduleProp
     */
    protected static array $moduleProp;
    /**
     * where everything resides
     * 
     * @var object $app
     */
    protected static object $app;

    /**
     * @method getProvider()
     * @param string $prop
     * @return string|null
     */
    public static function getProvider(string $prop): string|null
    {
        return self::$proProp[$prop];
    }

    /**
     * @method getApp()
     * @param string $prop
     * @return string|bool|null
     */
    public static function getApp(string $prop): string|null|bool
    {
        return self::$appProp[$prop];
    }

    /**
     * @method getModule()
     * @param string $prop
     * @return bool|array|string
     */
    public static function getModule(string $prop): bool|array|string
    {
        return self::$moduleProp[$prop];
    }

    /**
     * @method setProperties()
     * @param array $genelAyar
     * @return void
     */
    private static function setProperties(array $genelAyar): void
    {
        foreach(self::providerProperties as $t){

            self::$proProp[$t] = $genelAyar[$t];
        }

        foreach(self::applicationProperties as $t){

            self::$appProp[$t] = $genelAyar[$t];
        }

        foreach(self::moduleProperties as $t){

            self::$moduleProp[$t] = $genelAyar[$t];
        }
    }

    /**
     * [EN] Prepares and loads the needed files depending on the application type and launches
     * [TR] Uygulama tipine göre ihtiyaç duyulan dosyalari hazirlar ve başlatır
     * 
     * @method loadApp() 
     * @return void
     */
    public static function loadApp(): void
    {
        $ta = new \VTS\System\Dos;

        self::getSpecs($ta);

        self::loadAppTraits($ta);

        self::loadModuleConfig($ta);        

        self::loadBaseApplication($ta);

        self::loadInternalLibrary($ta);

        unset($ta);

        self::$app = new \VTS\Start(new \VTS\Network\NetControl(new \VTS\PathWays));

        exit;
    }

    /**
     * v.4.4.3 application specifications
     * 
     * @method getSpecs()
     * @param object $dos
     * @return void
     */
    private static function getSpecs(\VTS\System\Dos $dos): void
    {
        if (VSDEVMODE){
            
            if ($dos->cd()->fileExists(self::appConfDevFile)){
                
                try{

                    $gA = $dos->f(self::appConfDevFile)->read('json')->getData(true);

                }catch(\VTS\VerisanatAppException $e){

                    \VTS\Scribe::appLog(self::infoAppConfig[LANG]['read_error'] . $e->getMessage());

                    die(self::infoAppConfig[LANG]['gm'] . self::infoAppConfig[LANG]['read_error']);
                }

                self::setProperties($gA);
                
            }else{

                die(self::infoAppConfig[LANG]['no_acdf']);
            }
        }else{
            
            if ($dos->cd(RELEASE . '-' . self::appConfDirectory)->fileExists(self::appConfFile)){

                self::setProperties($dos->f(self::appConfFile)->read('json')->getData(true));
                
            }else{

                die(self::infoAppConfig[LANG]['no_acdf_live']);
            }
        }
    }

    /**
     * @method loadAppTraits()
     * @param object $dos
     * @return void
     */
    private static function loadAppTraits(\VTS\System\Dos $dos): void
    {
        $o = $dos->cd(RELEASE . '-application/v4-traits')->dir('v-traits-*.php');

        foreach($o as $t){

            if (self::releaseSpecControl($t)){

                continue;
            }else{

                require_once $t;
            }
        }
    }

    /**
     * @method releaseSpecControl()
     * @param string $tekDosya
     * @return bool
     */
    private static function releaseSpecControl(string $tekDosya): bool
    {
        if (array_key_exists(VER,self::changedFiles)){

            $dosyalar = self::changedFiles[VER]['dosyalar'];

            $yontem = self::changedFiles[VER]['yontem'];

            if (in_array(basename($tekDosya),$dosyalar,true)){

                switch($yontem):

                    case 'sil':

                        if (is_file($tekDosya)){

                            unlink($tekDosya);
                        }

                    break;

                endswitch;

                return true;
            }else{

                return false;
            }
        }

        return false;
    }

    /**
     * @method loadBaseApplication()
     * @param object $dos
     * @return void
     */
    private static function loadBaseApplication(\VTS\System\Dos $dos): void
    {
        $d = $dos->cd(RELEASE . '-application')->dir('v-*-control.php');

        foreach($d as $t){

            require_once $t;
        }
    }

    /**
     * [TR] Modül özelliklerini MODULISLEMLER sabitinde toplar. htaccess yaratır
     * 
     * @method loadModuleConfig()
     * @param object $dos
     * @return void
     */
    private static function loadModuleConfig(\VTS\System\Dos $dos): void
    {
        if (!($dos->cd(RELEASE . '-module' . '/' . 'modular-structure')->folderHasAny())){

            $d = $dos->cd(RELEASE . '-module' . '/' . 'module-configurations')->dir('m-config-*.json');

            foreach($d as $t){

                $topla[] = json_decode(file_get_contents($t),true);
            }

            foreach($topla as $ust){

                foreach($ust as $alt => $deger){

                    $modulislemler[$alt] = $deger;
                }
            }

            if (!($dos->cd(RELEASE . '-module' . '/' . 'modular-structure')->newFile('modul-islemler.json')->write($modulislemler)->errorCheck())){

                if (SERVER === 'apache'){

                    $dos->newFile('.htaccess')->useFileTemplate('htaccess-json-yasakla')->write();
                }

                define('MODULISLEMLER',$modulislemler);
            }
        }else{

            define('MODULISLEMLER',$dos->f('modul-islemler.json')->read('json')->getData(true));
        }
    }

    /**
     * @method loadInternalLibrary()
     * @param object $dos
     * @return void
     */
    private static function loadInternalLibrary(\VTS\System\Dos $dos): void
    {
        foreach(self::internalLoad as $f){

            $d = $dos->cd(RELEASE . '-application' . '/' . substr(RELEASE,0,1) . substr(RELEASE,3,1) . '-' . $f)->dir('v-*.php');

            foreach($d as $t){

                require_once $t;
            }
        }
    }

    /**
     * @method microLoad()
     * @param string $cesit
     * @return void
     */
    public static function microLoad(string $cesit): void
    {
        foreach(self::microApps[$cesit]['interface'] as $t){
        
            require_once BASE . '/' . RELEASE . '-application' . '/' . 'interfaces' . '/' . 'v-interface-' . $t . '.php';
        }

        foreach(self::microApps[$cesit]['traits'] as $t){

            require_once BASE . '/' . RELEASE . '-application' . '/' . substr(RELEASE,0,1) . substr(RELEASE,3,1) . '-' . $cesit . '/' . 'v-traits-' . $cesit . '-' . $t . '.php';
        }

        foreach(self::microApps[$cesit]['files'] as $t){

            require_once BASE . '/' . RELEASE . '-application' . '/' . substr(RELEASE,0,1) . substr(RELEASE,3,1) . '-' . $cesit . '/' . 'v-' . $t . '.php';
        }
    }

    /**
     * @method versionBridge()
     * @param string $baslatdosya
     * @param string $version
     * @return void
     */
    public static function versionBridge(string $baslatdosya, string $versiyon): void
    {
        if (VSDEVMODE){

            $dos = new \VTS\System\Dos;

            $dos->cd(RELEASE . '-configuration' . '/' . 'system-files')->newFile('system-file-versions.json')->fileType('json')->write(\VTS\Version\VersionCheck::dkontrol($baslatdosya,$versiyon,true));

            unset($dos);
        }

        ${VERISANATKURESELKONTROL} = null;
    }
}
?>