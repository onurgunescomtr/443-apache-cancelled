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
/**
 * ModuleBase - ModulYapi
 */
class ModuleBase{

    use CommonModuleElements;

    use AbilityModuleFrame;

    use AbilityModulePage;

    use AbilityModuleDatabase;

    use Builder;

	use Screen;

    /**
     * [EN] Determines if loaded module is sudo or not
     * [TR] Sudo modül değişkeni
     * 
     * @var bool $isSudoModule
     */
    public bool $isSudoModule;
    /**
     * @var string $mainModuleName
     */
    protected string|null $mainModuleName;
    /**
     * [TR] Head te bulunması gereken eklentileri array olarak barındırır
     * [EN] Additional frame elements for head / html, contained as an array
     * 
     * @var array $frameAdditions
     */
    private array|null $frameAdditions;
    /**
     * [TR] eklenebilecek html parçaları barındırır. ; () vb barındıramaz.
     * [EN] contains extra html screen parts. string can not include ; () etc characters.
     * 
     * @var array $screenAdditions
     */
    private array|null $screenAdditions;
    /**
     * [TR] Tamamlanmış tam html sayfa
     * [EN] Generated screen in html form
     * 
     * @var string $moduleScreen
     */
    private string|null $moduleScreen = null;
    /**
     * @var string $appModuleToastBox
     */
    private $appModuleToastBox;
    /**
     * [TR] Http::guide() yada Http::inform() ile yönlendirilmiş uyarı başarı metnini barındırır
     * [EN] contains redirected warning or error html formatted information to app from module.
     * 
     * @var string|null $appModuleReport
     */
    private string|null $appModuleReport;
    /**
     * [TR] modüle iletilen işlem adı
     * [EN] process that send from App to module
     * 
     * @var string $appModuleRequest 
     */
    public string|null $appModuleRequest;
    /**
     * [TR] islem gören nesne
     * [EN] Unit selected for module that ready to process
     * 
     * @var object $sn
     */
    public object $sn;
    /**
     * modüller arası iletilen html düzenlenmiş ileti
     * 
     * @var string $moduleMessages
     */
    public string|null $moduleMessages;
    /**
     * [EN] 443 simplified app module constants
     * [TR] 443 sadeleştirilmiş modul sabitleri
     * 
     * @var array $integrity
     */
    public array $integrity = [
        'modulesLoaded'
    ];
    /**
     * [TR] Temel modul değişkenleri
     * [EN] Essential module variables
     * 
     * @var array $essentialModuleElements
     */
    public array $essentialModuleElements = [
        'dbTableName',
        'sharedDataName',
        'modifyPageElement',
        'modifyFrameElement',
        'processInterface',
        'operativeInterface',
        'operationInterface',
        'processUnit',
        'uniqueIdentifierProperty'
    ];
    /**
     * @var array $moduleModifiableElements
     */
    public array $moduleModifiableElements = [
        'modifyPageElement',
        'modifyFrameElement'
    ];
    /**
     * [TR] Modül öğe tanımlayıcı tablo kolonu
     * [EN] unique db identifier column contains public string for module unit
     * 
     * @var string $publicIdentifierProperty
     */
    public string $publicIdentifierProperty = 'gorunenadi';
    /**
     * [TR] Modül kendi arayüzünde bir ana sayfa / kendi arayüzünü barındırabilir.
     * [EN] Determines if module can or cannot provide its own main page / main UI.
     * 
     * @var bool $operativeInterface
     */
    public bool $operativeInterface;
    /**
     * [TR] Module özel işleme alınacak öğe genel adı
     * [EN] Specific to module, a name globally indicates the type to be processed
     * 
     * @var string $processUnit
     */
    public string $processUnit;
    /**
     * [TR] Module özel eşsiz olarak kullanılacak tablo kolonu adı - essizalan
     * [EN] Specific to module, the database column name unique to each module unit
     * 
     * @var string $uniqueIdentifierProperty
     */
    public string $uniqueIdentifierProperty;
    /**
     * [TR] Uygulamada açık paketlerin tamamı
     * [EN] Every available module package name in the app
     * 
     * @var array $modulesLoaded
     */
    public array $modulesLoaded;
    /**
     * [TR] Modul veritabanı tablo adı
     * [EN] Module database table name
     * 
     * @var string $dbTableName
     */
    public string $dbTableName;
    /**
     * [TR] Modüle özgü sayfa değişkenleri dizisi
     * [EN] Page elements to be modified as array
     * 
     * @var array $modifyPageElement
     */
    public array|null $modifyPageElement;
    /**
     * [TR] Modüle özgü çerçeve değişkenleri dizisi
     * [EN] Frame elements to be modified as array
     * 
     * @var array $modifyFrameElement
     */
    public array|null $modifyFrameElement;
    /**
     * [TR] Modüle özgü işlem arayuzü adı
     * [EN] Specific to each module, interface name for a module
     * 
     * @var string $operationInterface
     */
    public string $operationInterface;
    /**
     * [TR] Modüle özgü modül öğe işlemi isteği
     * [EN] Request is for a module unit or general module interface
     * 
     * @var bool $moduleUnitProcessRequest
     */
    public bool $moduleUnitProcessRequest = false;
    /**
     * @var bool $responseAvailable
     */
    public bool $responseAvailable = false;
    /**
     * [TR] Uygulamaya dahil diğer moduller yapı  - adı => veritabanı tablosu
     * [EN] Other modules which currently not in running, as a name -> DB table name array
     * 
     * @var array $otherModules
     */
    public array $otherModules;
    /**
     * [TR] Modüllere özgü oturum bilgilerini barındırır.
     * [EN] Specific to a process, an array contains module session data
     * 
     * @since 4.4.3 - array at all releases
     * @var array $moduleSession
     */
    public array $moduleSession;
    /**
     * @var bool $invalidRequestResponse
     */
    public bool $invalidRequestResponse;
    /**
     * @var array $infoModuleError
     */
    public const infoModuleError = [
        'EN' => [
            'm_surum_az' => '500.002.Active module needs to be updated to application version.',
            'm_veri_yok' => '500.003.A necessary module configuration element is missing for the application.',
            'm_veri_eksik' => '500.004.Undefined module configuration variable.',
            'm_config_up' => '200.341.Verisanat v.4 application module is under maintenance, please check back later.'
        ],
        'TR' => [
            'm_surum_az' => '500.002.Aktif modül uygulama sürümüne yükseltilmelidir.',
            'm_veri_yok' => '500.003.Gerekli modül konfigurasyon elementi uygulama için eksik durumdadır.',
            'm_veri_eksik' => '500.004.Tanımsız modül konfigurasyon değişkeni.',
            'm_config_up' => '200.341.Bu Verisanat v.4 uygulaması modül bakım çalışması uygulamaktadır, lütfen daha sonra tekrar deneyiniz.'
        ]
    ];
    /**
     * @var array $infoModuleHttp
     */
    public array $infoModuleHttp = [
        'TR' => [
            'p_active' => 'modül aktif',
            'main_p_active' => 'modül ana sayfa aktif',
            'yok' => '200.097.API yetersiz işlem.',
            'yok_cg' => '200.099.API yetersiz işlem.Cevap yok.',
            'yetkisiz' => '200.098.API yetkisiz işlem.',
            'oge_yok_404' => '200.096.İstenilen öğe bulunamadı.',
            'oge_yok' => 'Linklerde bir problem oluşmuş yada eski bir kayıt istenmiş olabilir. <br> Bu veya benzer linklerin ısrarcı biçimde kullanımı uygulama üzerinde yasaklanmanıza yol açabilir.'
        ],
        'EN' => [
            'p_active' => 'module active',
            'main_p_active' => 'module main page active',
            'yok' => '200.097.API insufficient process request.',
            'yok_cg' => '200.099.API insufficient process.Response prohibited.',
            'yetkisiz' => '200.098.API unauthorized process.',
            'oge_yok_404' => '200.096.Requested module element couldnt be found.',
            'oge_yok' => 'There may be a modified link outside the app or this is an old unit request. <br> Insisting on using this kind of links may ban you for app.'
        ]
    ];

    /**
     * @method checkModuleConsistency()
     * @param string $response
     * @param string|null $extInfo
     * @return void
     */
    private function checkModuleConsistency(string $response,?string $extInfo = null): void
    {
        $response = isset($extInfo) ? self::infoModuleError[LANG][$response] . ' içerik: ' . $extInfo : self::infoModuleError[LANG][$response];

        if (LOKAL){
            
            die($response);
        }else{

            Scribe::appLog($response);

            die(self::infoModuleError[LANG]['m_config_up']);
        }
    }

    /**
     * @method checkModuleVersion()
     * @param string $mnGiven Module Name Given
     * @return void
     */
    public function checkModuleVersion(string &$mnGiven): bool
    {
        return version_compare(MODULISLEMLER[$mnGiven]['versiyon'],VER,'<');
    }

    /**
     * [TR] 443 Yapı sınıfını modulde oluşturur. 430 Çerçeve sınıfını modulde oluşturur.
     * [EN] 443 Creates main structure class in module. 430 Creates frame class in module.
     * @since 4.4.3 Other protocols removed in open source pack
     * @see startStructure_default()
     * 
     * @method startStructure()
     * @return void
     */
    public function startStructure(): void
    {
        Warden::setSession();

        if (!VSDEVMODE){

            Scribe::requestLog($this->process,$this->subProcess,$this->rawQuery);
        }

        Warden::setOpenKey();

        switch(PROTOKOL):
        
            case 'http':
            
                $this->frame = new Frame($this->setModuleLang('d','turkce'));

                $this->vui = new Page;

                $this->frame->moduleFrameProcess(get_called_class());

                $this->frame->frameSupport($this->process,$this->subProcess);

            break;
            
            default:

                // Console OS removed
            
            break;
        
        endswitch;
    }

    /**
     * [TR] uygulama sabitlerini atar.
     * [EN] sets application details, constants, variables.
     * 
     * @method setAppLedger()
     * @param array $s
     * @return void
     */
    protected function setAppLedger(array $s): void
    {
        foreach($this->integrity as $t){

            $this->$t = $s[$t];
        }
    }

    /**
     * @method setModuleHierarchy()
     * @return void
     */
    private function setModuleHierarchy(): void
    {
        $this->mainModuleName = array_shift($this->modulesLoaded);

        $this->isSudoModule = $this->mainModuleName === $this->moduleName ? true : false;
    }

    /**
     * @method setModuleSharedData()
     * @return void
     */
    private function setModuleSharedData(): void
    {
        foreach($this->modulesLoaded as $t){

            if (MODULISLEMLER[$t]['veripaylasimi']){

                $this->otherModules[MODULISLEMLER[$t]['sharedDataName']] = MODULISLEMLER[$t]['dbTableName'];
            }
        }
    }

    /**
     * [TR] Modüller arası iletiyi yazar
     * [EN] sets inter modular public report
     * 
     * @method getMessages()
     * @return mixed|null|string $moduleMessages
    */
    public function getMessages(): string|null
    {
        $this->moduleMessages = $_SESSION['public_info_container'] ?? null;

        unset($_SESSION['public_info_container']);

        return $this->moduleMessages;
    }

    /**
     * @method setModuleLang()
     * @param string $langValue
     * @param null $langDefault
     * @return string|null $langValue
     */
    public function setModuleLang(string $langValue,?string $langDefault): string|null
    {
        return Http::__gx($langValue,$langDefault);
    }

    /**
     * @method moduleLaunchControl()
     * @param string $moduleName
     * @return void
     */
    public function moduleLaunchControl(string $moduleName): void
    {
        if ($this->checkModuleVersion($moduleName)){

            die(self::infoModuleError[LANG]['m_surum_az']);
        }

        $insufficient = [];

        $missing = [];
        
        foreach($this->essentialModuleElements as $t){

            if (!array_key_exists($t,MODULISLEMLER[$moduleName])){

                $insufficient[] = $t;
            }elseif(is_null(MODULISLEMLER[$moduleName][$t]) && !in_array($t,$this->moduleModifiableElements,true)){
            
                $missing[] = $t;
            }else{

                $this->$t = MODULISLEMLER[$moduleName][$t];
            }
        }

        if (count($missing) > 0){

            $this->checkModuleConsistency('m_veri_eksik',implode(' - ',$missing));
        }

        if (count($insufficient) > 0){

            $this->checkModuleConsistency('m_veri_yok',implode(' - ',$insufficient));
        }
    }

    public function __construct(array $up,array $ledger = null)
    {
        $this->setProc($up);

        $this->invalidRequestResponse = App::getApp('invalidRequestResponse');

        if ($this->subProcess !== null || $this->one !== null || $this->two !== null){

            $this->moduleUnitProcessRequest = true;
        }

        $this->setAppLedger($ledger);

        $this->setModuleHierarchy();

        $this->setModuleSharedData();
    }

    /**
     * [EN] Auto module launcher, when there is no module handle functions defined (id's) enables app -> module -> request route.
     * [TR] Otomatik modül başlatıcı. Modül id fonksiyonu tanımlı olmadığında app -> modul -> istek yolunu yönetir.
     * 
     * @method verisanatClassic()
     * @return void
     */
    public function verisanatClassic(string $appRequest = null): void
    {
        $this->startStructure();
        
        $this->setAppModuleReport();

        $this->setAppRequest($appRequest);

        $this->moduleAutoHandler();
    }

    /**
     * [TR] 443 $appModuleRequest e göre modül çağrısını yönetir. 
     * [EN] 443 used when automatic module running, classic operations
     * 
     * @method moduleAutoHandler()
     * @return void
     */
    public function moduleAutoHandler(): void
    {
        $this->moduleSession[$this->moduleName]['benzersiz'] = Audit::randStrLight(12);

        $this->moduleSession[$this->moduleName]['dizi'] = [];

        $this->startModuleScreen();

        switch($this->appModuleRequest):

            case 'main-page':

                call_user_func([$this,'modulAnasayfa']);

            break;

            case null:

                call_user_func([$this,'interfaceInspection']);

                call_user_func([$this,'modulArayuz']);

            break;
            
        endswitch;

        $this->sendScreen();

        exit;
    }

    /**
     * modül den dönecek ekranı hazırlar.
     * 
     * @method createScreen()
     * @param string|null $bu
     * @return void
     */
    public function createScreen(?string $bu = null): void
    {
        $this->moduleScreen .= $bu;

        if (isset($this->appModuleReport)){
            
            $this->appModuleReport = null;
        }

        $this->setInterfaceResponse();
    }

    /**
     * @method setInterfaceResponse()
     * @return void
     */
    private function setInterfaceResponse(): void
    {
        if (!$this->responseAvailable){

            $this->responseAvailable = true;
        }
    }

    /**
	 * @method sendScreen()
     * @return string $moduleScreen
     */
    private function sendScreen()
    {
        if (PROTOKOL === 'http'){

            if ($this->responseAvailable){

                $this->createScreen($this->defaultPageJS);
                
                $this->moduleScreen .= match($this->appModuleRequest){

                    'main-page' => $this->showModuleProcessing($this->moduleName,true),

                    null => $this->showModuleProcessing($this->moduleName)
                };

                $this->createScreen($this->endHtmlPage());

                Http::respond($this->moduleScreen);
            }else{

                header('HTTP/1.1 404 Not Found',true,404);

                die($this->infoModuleHttp[LANG]['yok_cg']);
            }
        }

		// console - OS removed.
    }

    /**
     * [TR] Protokol http - display: none ile birlikte, çalışan modül adını verir
     * [EN] Shows processing module name in http protocol in css display:none in screen
     * 
     * @method showModuleProcessing() 
     * @param string $mName
     * @param bool $mPage
     * @return string $m
     */
    private function showModuleProcessing($mName = null,$mPage = false)
    {
        return $mPage ? sprintf($this->htmlModuleShowInterface,ucfirst($mName),$this->infoModuleHttp[LANG]['main_p_active']) : sprintf($this->htmlModuleShowInterface,ucfirst($mName),$this->infoModuleHttp[LANG]['p_active']);
    }

    /**
     * Modülün işlem öğesine yeni bir tanımlayıcı atar.
     * 
     * @method setProcessUnit()
     * @param string|int $tek
     * @return void
     */
    public function setProcessUnit(string|int $tek): void
    {
        $this->{$this->processUnit} = $tek;
    }

    /**
     * [TR] Ana işlem tarafından çağırılan her modül için geçerli temel kontrol fonksiyonu
     * [EN] Regulative check for the interface request, orginating from main process
     * 
     * @method interfaceInspection()
     * @return void
     */
    public function interfaceInspection(): void
    {
        if ($this->moduleUnitProcessRequest && $this->{$this->processUnit} === null && !$this->operativeInterface){

            if ($this->invalidRequestResponse){
                
                $this->setModuleToast($this->infoModuleHttp[LANG]['oge_yok']);

                Http::guide(ADDRESS,'error',$this->infoModuleHttp[LANG]['oge_yok_404']);
            }else{

                header('HTTP/1.1 404 Not Found',true,404);

                die($this->infoModuleHttp[LANG]['yok']);
            }
        }

        if (!$this->moduleUnitProcessRequest && !$this->operativeInterface){

            header('HTTP/1.1 404 Not Found',true,404);

            die($this->infoModuleHttp[LANG]['yetkisiz']);
        }
    }

    /**
     * [TR] Modül işlem öğesi isteği var mı kontrol eder.
     * [EN] Checks if there is a module unit request. Can be used in module development
     * 
     * @deprecated 4.4.1
     * @method isModuleUnitRequest()
     * @return bool
     */
    public function isModuleUnitRequest(): bool
    {
        if (!is_null($this->{$this->processUnit})){

            return true;
        }

        return false;
    }

    /**
     * [EN] Sets module variable and data to "module object"
     * [TR] modül objesine değişken ve değer atar.
     * 
     * @method setModuleSessionData()
     * @param string $variable
     * @param string|int|mixed $data
     * @return void
     */
    public function setModuleSessionData(string $variable,$data): void
    {
        $this->moduleSession[$this->moduleName][$variable] = $data;
    }

    /**
     * @method setAppRequest()
     * @param string $appProc  -> appModuleRequest
     * @return void
     */
    public function setAppRequest(string $appProc = null): void
    {
        $this->appModuleRequest = $appProc ?? null;
    }

    /**
     * @method moduleUnitUsage()
     */
    protected function moduleUnitUsage(): void
    {
        $this->sn->goruntulenme = (int)$this->sn->goruntulenme + (int)1;
        
        $this->sn->save();
    }

    /**
     * @method interactionModuleBridge()
     * @param string $iidPage Interaction ID Page
     * @param string $mName Module Name
     * @param string $unitPackage encrypted unit package
     * @param string $userPackage encrypted user package
     * @return void
     */
    public function interactionModuleBridge(string $iidPage,string $mName,string $unitPackage,string $userPackage): void
    {
        $d = \Model::factory('VsModulEtkilesim')->useIdColumn('sayfano')->findOne($iidPage);

        if (is_bool($d) && !$d){

            $d = \Model::factory('VsModulEtkilesim')->create();

            $d->sayfano = $iidPage;
            $d->durumu = 1;
            $d->app_module_name = $mName;
            $d->girisadedi = 1;
            $d->kayittarihi = date('d-m-Y H:i:s');
            $d->paket_bilgi = $unitPackage;
            $d->kullanici_bilgi = $userPackage;
            $d->ip_adresi = $_SERVER['REMOTE_ADDR'];
            
            if ($mName === 'magaza'){

                $d->modul_bilgi = serialize(json_encode(array('siparisNo' => Audit::randStrLight(32))));
            }

            if (isset($_SESSION['account_page_number'])){

                $d->kullanici_hesap_bilgi = $_SESSION['account_page_number'];
            }
        }else{

            $d->girisadedi = (int)$d->girisadedi + 1;
            $d->paket_bilgi = $unitPackage;
            $d->kullanici_bilgi = $userPackage;
        }
        
        $d->save();
    }

    /**
     * Tüm modüller için protokole göre aynı olan moduleScreen parçalarını hazırlar
     * 
     * @method startModuleScreen()
     * @return void
     */
    protected function startModuleScreen(): void
    {
        if (PROTOKOL === 'http'){

            if ($this->{$this->processUnit} !== null && $this->one === null && $this->uniqueIdentifierProperty === $this->publicIdentifierProperty){

                $this->setModuleUnit();
            }

            $this->moduleScreen = $this->frame->getHtmlHead($this->headEklentileri()) .
                
                $this->vui->startHtmlBody() .
                
                $this->appModuleToastBox .
                
                $this->getMessages() .

                $this->frame->getHtmlAppMenu();
        }
    }
}
?>