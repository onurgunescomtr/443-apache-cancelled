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

use VTS\Network\NetControl;

Version\VersionCheck::dkontrol(__FILE__,'4.4.3');
/**
 * Start - Baslat
 */
class Start{

    use Structure\InternalStructure;

    use Builder;

    /**
     * @var object $launchRequest
     */
    private object $launchRequest;
    /**
     *  __NAMESPACE__
     * 
     * @var string $scope
     */
    private $scope;
    /**
     * test ve kontrol verisi - debug için gerekli olan AP ye ve teskon a aktarılan array
     * 
     * @var array $teskon
     */
    private $teskon;
    /**
     *  özel birim iç yapı öğesi, testler ve AP gibi
     * 
     * @var object $internalAppSudo
     */
    private object $internalAppSudo;
    /**
     * İç yapı sınıflarının yüklendiği kapsayıcı
     * 
     * @var object $internalApp
     */
    private $internalApp;
    /**
     *  birincil modul adi
     * 
     * @var string $mainModule
     */
    private $mainModule;
    /**
     * eğer modüller açıksa seçili olanların adlarını barındırır
     * 
     * @var array|null $modulesLoaded
     */
    public array|null $modulesLoaded;
    /**
     *  modüller için geçerli iç yapı harici işlem adları 9002
     * 
     * @var array $mi
     */
    public array|null $mi = MODULISLEMLER;
    /**
     * @var bool $deployModules
     */
    protected bool $deployModules;
    /**
     * @var bool $useMainModule
     */
    protected bool $useMainModule;
    /**
     * @var string|null $mainPageModule
     */
    protected string|null $mainPageModule;
    /**
     * @var array $modulesCharged
     */
    protected array $modulesCharged;
    /**
     * @var string|int $launchKey
     */
    private string|int $launchKey;
    /**
     * @var bool $preLoadModuleFrames
     */
    private bool $preLoadModuleFrames = false;

    /**
     * 443 - losing its place version to version
     * 
     * now returns the constant modules
     * 
     * v.3 v.4.1 v.4.3
     * modullere sağlanacak sabitleri ve diğer değerleri oluşturur
     * 
     * @method moduleIntegrity()
     * @return array
     */
    private function moduleIntegrity(): array
    {
        return [
            'modulesLoaded' => $this->modulesCharged
        ];
    }

    public function __construct(NetControl $ncp)
    {
        $this->setProc($this->cycleProc($ncp));

        $this->deployModules = App::getModule('useModules');

        $this->modulesCharged = App::getModule('modules');

        $this->mainPageModule = App::getModule('mainPageModule');

        $this->useMainModule = App::getModule('useMasterModule');

        $this->launchRequest = new InterfaceControl($this->process); // v.4.4.2

        $this->loadRegisterModules();

        $this->injectDefaultClasses();

        SysLed::load($this->launchRequest->getSessionType());

        is_array($this->launchRequest->getProcess()) ? $this->runModule($this->launchRequest->getProcess()) : $this->run($this->launchRequest->getProcess());

        exit;
    }

    /**
     * 443 - renewing loader for open source package 15052021
     * 
     * v.4.4.2 modulleri yukler, ana işlem dosyalarını başlatır, gerekli iletişimlerini tamamlatır.
     * 
     * @method loadRegisterModules()
     * @return void
     */
    private function loadRegisterModules(): void
    {
        $this->modulesLoaded = $this->deployModules ? $this->modulesCharged : null;

        if (isset($this->modulesLoaded)){

            foreach($this->modulesLoaded as $moduleName){

                $this->loadModuleTrait($moduleName);

                require_once BASE . '/' . RELEASE . '-module' . '/' . 'v-modul-' . $moduleName . '-yapi.php';

                $loaderScope = __NAMESPACE__ === 'VerisanatPratikSurum' ? 'VerisanatPratikSurum\\' : null;

                $bir = $loaderScope . ucfirst($moduleName) . 'Yapi';

                $this->{$this->mi[$moduleName]['sinifadi'] . 'yapi'} = new $bir($this->urlPackage,$this->moduleIntegrity());

                if ($this->{$this->mi[$moduleName]['sinifadi'] . 'yapi'}->isSudoModule){
                    
                    $this->mainModule = $moduleName;
                }
                
                if (App::getModule('useModuleFrames') && $this->preLoadModuleFrames){

                    $iki = ucfirst($moduleName) . 'Cerceve';

                    $this->{$this->mi[$moduleName]['sinifadi'] . 'cer'}  = new $iki;
                }
            }
        }
    }
    
    /**
     * runs the internal, special or default operation
     * 
     * @method run()
     * @return void
     */
    public function run(int|string $k): void
    {
        $this->scope = __NAMESPACE__ === 'VerisanatPratikSurum' ? 'VerisanatPratikSurum\\' : 'VTS\\';

        $this->launchKey = $k;

        match(true){

            is_string($this->launchKey) && $this->launchKey === $this->htmlDefaultScreen => $this->mainOperation(),

            is_string($this->launchKey) && substr($this->launchKey,0,13) === 'special-unit-' => $this->specialOperation(),

            is_string($this->launchKey) && array_key_exists($this->launchKey,$this->internalClasses) => $this->internalOperation(),

            is_int($this->launchKey) => Http::manageRedundantRequest(),

            default => Http::manageRedundantRequest(1001)
        };

        exit;
    }

    /**
     * launches module id or classic id
     * 
     * @method runModule()
     * @param array $moduleStructure
     * @return void
     */
    private function runModule(array $moduleStructure): void
    {
        call_user_func([$this->{$moduleStructure['sinifadi'] . 'yapi'},'moduleLaunchControl'],$moduleStructure['moduleName']);

        if (method_exists(ucfirst($moduleStructure['moduleName']) . 'Yapi',$moduleStructure['id'])){

            call_user_func([$this->{$moduleStructure['sinifadi'] . 'yapi'},$moduleStructure['id']]);
        }else{

            call_user_func([$this->{$moduleStructure['sinifadi'] . 'yapi'},'verisanatClassic']);
        }
        
        exit;
    }

    /**
     * @method ozelislemdosyalari() 
     * @return void
     */
    private function ozelKutukDosyalari(): void
    {
        $this->ozelislemler = glob('v4-yonetici/v-*.php');

        

        require_once 'v4-yonetici/v-testler-ve-kontroller-yapi.php';
        require_once 'v4-yonetici/v-yonetim-yapi.php';
    }

    /**
     * v.4.4.2 varsa module ait traitleri barındıran dosyayı işleme alır
     * 
     * @method loadModuleTrait()
     * @param string $modulAdi
     * @return void
     */
    private function loadModuleTrait(string $adi): void
    {
        $ozellikDosyasi = BASE . '/' . RELEASE . '-module'. '/' . 'module-traits' . '/' . 'v-modul-' . $adi . '-trait.php';

        if (file_exists($ozellikDosyasi)){

            try{

                require_once $ozellikDosyasi;
            }catch(\Exception $hata){

                Scribe::appLog($hata->getMessage());
            }
        }
    }

    /**
     * @method getClassicPage()
     * @return void
     */
    public function getClassicPage(): void
    {
        new ClassicScreen;

        exit;
    }

    /**
     * useMainModule > mainPageModule -> superior
	 * 
	 * - if mainPageModule is set and there is no modules to load throws Uncaught Type Error (there is nothing to call).
     * 
     * @method mainOperation()
     * @return void
     */
    private function mainOperation(): void
    {
        if ($this->useMainModule){

            call_user_func([$this->{$this->mi[$this->mainModule]['sinifadi'] . 'yapi'},'moduleLaunchControl'],$this->mainModule);

            if (method_exists(ucfirst($this->mi[$this->mainModule]['sinifadi']) . 'Yapi',$this->mi[$this->mainModule]['id'])){

                call_user_func([$this->{$this->mi[$this->mainModule]['sinifadi'] . 'yapi'},$this->mi[$this->mainModule]['id']],$this->launchKey);
            }else{

                call_user_func([$this->{$this->mi[$this->mainModule]['sinifadi'] . 'yapi'},'verisanatClassic'],$this->launchKey);
            }
        }elseif(is_string($this->mainPageModule)){

            call_user_func([$this->{$this->mi[$this->mainPageModule]['sinifadi'] . 'yapi'},'moduleLaunchControl'],$this->mainPageModule);

            if (method_exists(ucfirst($this->mi[$this->mainPageModule]['sinifadi']) . 'Yapi',$this->mi[$this->mainPageModule]['id'])){

                call_user_func([$this->{$this->mi[$this->mainPageModule]['sinifadi'] . 'yapi'},$this->mi[$this->mainPageModule]['id']],$this->launchKey);
            }else{

                call_user_func([$this->{$this->mi[$this->mainPageModule]['sinifadi'] . 'yapi'},'verisanatClassic'],$this->launchKey);
            }
        }else{
                
            $this->getClassicPage();
        }

        exit;
    }

    /**
     * @method specialOperation()
     * @return void
     */
    private function specialOperation(): void
    {
        App::sudoLoad();
        
        $icyapiozelsinif = $this->scope . $this->superStructureClasses[substr($this->launchKey,13)];

        $this->internalAppSudo = new $icyapiozelsinif($this->urlPackage,Audit::dateTime(),$this->teskon,$this->modulesLoaded);

        exit;
    }

    /**
     * @method internalOperation()
     * @return void
     */
    private function internalOperation(): void
    {
        $icsinif = $this->scope . $this->internalClasses[$this->launchKey];

        $this->internalApp = new $icsinif($this->urlPackage);

        exit;
    }
}
?>