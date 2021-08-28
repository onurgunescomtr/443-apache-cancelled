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

class Frame{

    use CommonFrameElements;

    /**
     * @var array $infoFrame
     */
    public const infoFrame = [
        'TR' => [
            'modulcer_ikiz' => 'Birden fazla çerçeve kullanıldığı zaman Ana Modül Kullan özelliği false olmalıdır.',
            'browser_back' => 'Dil seçeneğiniz uygulama varsayılan dile çevrilmiştir.<br> Problem yaşamanız durumunda lütfen iletişime geçiniz.',
            'unwanted_request' => '200.041.İstenmeyen talep.Geçersiz URI'
        ],
        'EN' => [
            'modulcer_ikiz' => 'When more than one Frames are in use, useMasterModule option needs to be set to false.',
            'browser_back' => 'App language is set to the default language.<br> If you are experiencing any problems please use the contact form.',
            'unwanted_request' => '200.041.Unwanted request.Invalid URI'
        ]
    ];
    /**
     * @var bool $activeIOHeader 
     */
    public bool $activeIOHeader = false;
    /**
     * @var bool $inputScreen
     */
    public bool $inputScreen = false;
    /**
     * @var bool $operationScreen
     */
    public bool $operationScreen = false;
    /**
     * @var string|null $activeLangUri
     */
    public null|string $activeLangUri;
    /**
     * @var bool $userAuthenticated
     */
    public bool $userAuthenticated = false;
    /**
     * @var null|string $interfaceHeader 
     */
    public null|string $interfaceHeader;
    /**
     * @var null|string $htmlHeaderMenu 
     */
    public null|string $htmlHeaderMenu = null;
    /**
     * @var object $loadedLanguagePack 
     */
    public object $loadedLanguagePack;
    /**
     * @var object $loadedLanguagePackText
     */
    public object $loadedLanguagePackText;
	/**
	 * @var object $loadedLanguagePackURI
	 */
	private object $loadedLanguagePackURI;
    /**
     * @var int $langNumber
     */
    public int $langNumber;
    /**
     * @var null|string $languageButton 
     */
    protected null|string $languageButton;
    /**
     * @var string $htmlMenuUserLinks 
     */
    public string|null $htmlMenuUserLinks;
    /**
     * [EN] The unique string id of an object, a data unit currently supported by Frame
     * [TR] Herhangi pro öğe nin, yazının, ürünün, materyalin, dosyanin eşsiz adı
     * 
     * @var string $currentUniqueObjectID 
     */
    public string|null $currentUniqueObjectID;
    /**
     * @var array $microDataSupport
     */
    public array $microDataSupport = [];
    /**
     * @var array $moduleFrameMenu
     */
    private array $moduleFrameMenu = [];
    /**
     * @var bool $mcKontrol
     */
    private bool $mcKontrol = false;
    /**
     * @var object $moduleFrame
     */
    private object $moduleFrame;
    /**
     * @var string $activeModule
     */
    protected string $activeModule;
    /**
     * @var string $headTitle 
     */
    private string $headTitle;
    /**
     * @var string $headDescription 
     */
    private string|null $headDescription;
    /**
     * @var string $headKeywords 
     */
    private string|null $headKeywords;
    /**
     * @var string $webTitleAddition 
     */
    private string|null $webTitleAddition;
    /**
     * @var string $webDescriptionAddition 
     */
    private string|null $webDescriptionAddition;
    /**
     * @var string $webKeywordAddition
     */
    private string|null $webKeywordAddition;
	/**
	 * @var string $htmlAppMenuLinks
	 */
	private string|null $htmlAppMenuLinks = null;
    /**
     * @var array $appModules
     */
    private array $appModules;
    /**
     * @var string|null $process
     */
    private string|null $process;
    /**
     * @var string|null $subProcess
     */
    private string|null $subProcess;
    /**
     * @var string $generatedURL
     */
    private string $generatedURL = ADDRESS;
    /**
     * @var bool $uriLangSupport
     */
    private bool $uriLangSupport = false;

    /**
     * [EN] Sets frame elements to module's own.
     * [TR] Modullerin kendi çerçeve öğelerini atar.
     * 
     * @method changeFrameUnit()
     * @param string $degisken
     * @param mixed $yeniicerik
     * @return void
     */
    public function changeFrameUnit($degisken,$yeniicerik): void
    {
        $this->$degisken = $yeniicerik;
    }

    /**
     * [EN] Applies the module's frame units to the frame
     * [TR] Modül çerceve öğelerini cerceve değişkenlerine atar
     * 
     * @method applyModuleFrame()
     * @param array $mogeleri
     * @return void
     */
    private function applyModuleFrame(array $mogeleri): void
    {
        foreach($mogeleri as $t => $d){

            $this->$t = (string)$d;
        }
    }

    /**
     * [EN] Translates given word to app language state
     * [TR] Aktif olan dil seçeneğine göre loadedLanguagePack objesinden string i döndürür
     * 
     * @method translate()
     * @param string $kelime
     * @return string $k
     */
    public function translate(string $kelime): string|null
    {
        return $this->loadedLanguagePack->$kelime[$this->langNumber] ?? null;
    }

    /**
     * @method translateText()
     * @param string $kelime
     * @return string $text
     */
    public function translateText(string $kelime): string|null
    {
        return $this->loadedLanguagePackText->$kelime[$this->langNumber] ?? null;
    }

	/**
	 * Translates the URI part to app language state
	 * 
	 * @since 443.2 New Feature
	 * @method translateUri()
	 * @param string $word
	 * @return string $uriPart
	 */
	public function translateUri(string $word): string|null
	{
        if (is_string($this->loadedLanguagePackURI->$word[$this->langNumber])){

            return $this->loadedLanguagePackURI->$word[$this->langNumber];
        }else{

            return $this->translateUriSupport();
        } 
	}

    /**
     * @method getAvailableLang()
     * @return int
     */
    private function getAvailableLang(): int
    {
        return $this->langNumber === 0 ? 1 : 0;
    }

    /**
     * @method translateUriLangSupport()
     * @return string|null
     */
    private function translateUriLangSupport(): string|null
    {
        if (isset($this->subProcess)){

            if (!$this->uriLangSupport){

                return $this->subProcess;
            }

            $this->activeLangUri = $this->getRootUriName($this->subProcess);

            return $this->dil->getCrossLangUri($this->activeLangUri,$this->langNumber);
        }

        return null;
    }

    /**
     * @method translateUriSupport()
     * @return string
     */
    private function translateUriSupport(): string|null
    {
        if (is_string($this->subProcess)){

            $uriSupported = $this->dil->isLangUri($this->subProcess,true);

            if (is_string($uriSupported)){

                $this->dil->handleDifferentLanding();

                return $uriSupported;
            }else{

                return $this->subProcess;
            }
        }

        return null;
    }

    /**
     * @method getRootUriName()
     * @param string $fName
     * @return string
     */
    public function getRootUriName(string $fName): string
    {
        foreach((array)$this->loadedLanguagePackURI as $t){

            $currentPack[] = $t[$this->langNumber];

            $otherPack[] = $t[$this->getAvailableLang()];
        }

        $f = array_flip(array_combine(array_keys((array)$this->loadedLanguagePackURI),$currentPack));

        $h = array_flip(array_combine(array_keys((array)$this->loadedLanguagePackURI),$otherPack));

        if (!array_key_exists($fName,$f)){

            if (!array_key_exists($fName,$h)){

                AppAudit::manageRequestCount();

                Http::manageRedundantRequest(403,self::infoFrame[LANG]['unwanted_request']);
            }

            Http::guide(ADDRESS,'warn',self::infoFrame[LANG]['browser_back']);
        }

        return $f[$fName];
    }

    public function __construct($gx = null,$struct = 1000)
    {
        $this->appStaticMenu = App::getApp('staticMenu');

        $this->appModules = App::getModule('modules');

        $this->manageFrameCall($struct);

        $this->dil = new Language(Audit::__type($gx,'string'));

        $this->langNumber = $this->dil->currentLanguage();

        $this->lang = $this->dil->htmlLang();

        $this->loadedLanguagePack = $this->dil->getLangPack();

        $this->loadedLanguagePackText = $this->dil->getLangPackText();

		$this->loadedLanguagePackURI = $this->dil->getLangPackURI();
    }

    /**
     * @method manageFrameCall()
     * @param int $struct
     * @return void
     */
    private function manageFrameCall(int $struct): void
    {
        $this->uriLangSupport = $struct <= 1000 ? true : false;
    }

    /**
     * uygulama html head kontrollerini gerçekleştirir
     * 
     * @method headkontrol() 
     * @return void
     */
    private function headkontrol(): void
    {
        $this->headTitle = isset($this->webTitleAddition) ? $this->webTitleAddition . App::getApp('applicationName') : App::getApp('webTitle');

        $this->headDescription = isset($this->webDescriptionAddition) ? $this->webDescriptionAddition : App::getApp('webDescription');

        $this->headKeywords = isset($this->webKeywordAddition) ? $this->webKeywordAddition : App::getApp('webKeywords');

        $this->tdk = sprintf($this->tdk,$this->headTitle,$this->headDescription,$this->headKeywords);

        $this->htmlHeadMetaTwo = sprintf($this->htmlHeadMetaTwo,$this->headDescription,$this->headTitle,$this->getCurrentURL());

        $this->addSocialElements();
    }

    /**
     * adds application social provider head elements
     * 
     * @method addSocialElements() 
     * @return void
     */
    private function addSocialElements(): void
    {
        if ($this->process !== UUI){

            if (!is_null(App::getProvider('googleAnalyticsID')) && App::getApp('googleIsOn')){

                $this->digitalProviders .= $this->getGoogleAnalytics();
            }

            if (!is_null(App::getProvider('googleTagManagerID')) && App::getApp('googleIsOn')){

                $this->digitalProviders .= $this->getGoogleTagManager();
            }

            if (!is_null(App::getProvider('googleAdSenseID')) && App::getApp('googleIsOn')){

                $this->digitalProviders .= $this->getGoogleAdSense();
            }

            if (!is_null(App::getProvider('facebookPixelID')) && App::getApp('facebookIsOn')){

                $this->digitalProviders .= $this->getFacebookPixel();
            }
        }
    }
    
    /**
     * @method getFacebookPixel() 
     * @return string
     */
    private function getFacebookPixel(): string
    {
        return sprintf($this->facebookPixel,App::getProvider('facebookPixelID'),App::getProvider('facebookPixelID'));
    }

    /**
     * @method getGoogleAdSense() 
     * @return string
     */
    private function getGoogleAdSense(): string
    {
        return sprintf($this->googleAdSense,App::getProvider('googleAdSenseID'));
    }

    /**
     * @method getGoogleTagManager()
     * @return string
     */
    private function getGoogleTagManager(): string
    {
        return sprintf($this->googleTagMan,App::getProvider('googleTagManagerID'));
    }

    /**
     * @method getGoogleAnalytics()
     * @return string
     */
    private function getGoogleAnalytics(): string
    {
        return sprintf($this->googleTagManHead,App::getProvider('googleAnalyticsID')) . sprintf($this->googleAnalytics,App::getProvider('googleAnalyticsID'),App::getProvider('googleOptimizeID'));
    }

    /**
     * @method createUrl()
     * @return string $generatedURL
     */
    public function createUrl($pro = null,$subPro = null,$que = null): string
    {
        if (isset($que)){

          $this->generatedURL .= '/' . $pro . '/' . $subPro . '?' . $que;

        }elseif(isset($subPro)){

          $this->generatedURL .= '/' . $pro . '/' . $subPro;

        }elseif(isset($pro)){

          $this->generatedURL .= '/' . $pro;

        }

        return $this->generatedURL;
    }

    /**
     * @method getCurrentURL()
     * @return string
     */
    public function getCurrentURL(): string
    {
        return is_null($this->subProcess) ? ADDRESS . '/' . $this->process : ADDRESS . '/' . $this->process . '/' . $this->subProcess;
    }

    /**
     * @method frameHtmlHeadSupport() 
     * @param $b başlık eki
     * @param $t tanım eki
     * @param $k keyword eki
     * @param $nn nesne numarası
     * @param array $mikroVeri
     * @return void
     */
    public function frameHtmlHeadSupport($b = null,$t = null,$k = null,$nn = null,array $mikroVeri = []): void
    {
        $this->webTitleAddition = $b;

        $this->webDescriptionAddition = $t;

        $this->webKeywordAddition = $k;

        $this->currentUniqueObjectID = $nn;

        $this->microDataSupport = $mikroVeri;
    }

    /**
     * @method createHtmlHead()
     * @return void
     */
    public function createHtmlHead(): void
    {
        $this->headkontrol();

        $this->htmlHead = sprintf($this->docType,$this->lang);

        $this->htmlHead .= $this->tdk;

        $this->htmlHead .= sprintf($this->htmlHeadMetaOne,App::getProvider('facebookAPPID'));

        $this->htmlHead .= $this->htmlHeadMetaTwo;

        $this->applyHeadDataSupport();

        $this->applyHeadVisualElements();

        $this->htmlHead .= $this->htmlHeadAdditions;

        $this->htmlHead .= $this->digitalProviders;

        $this->htmlHead .= '</head>';
    }

    /**
     * @method jsarayuz()
     * @param string $jsFrameName
     * @return void
     */
    public function setFrameUserInterfaceName(string $jsFrameName = null): void
    {
        $this->userInterfaceName = $jsFrameName;
    }

    /**
     * @method applyHeadVisualElements()
     * @return void
     */
    private function applyHeadVisualElements(): void
    {
        if (App::getApp('javaScriptUI') && isset($this->userInterfaceName)){

            switch($this->userInterfaceName):

                case 'vue':

                    $d = new System\Dos;

                    $ek = $d->cd($this->vueJsExtensions)->dir('vue-*.js');

                    foreach($ek as $t){

                        $this->htmlHead .= sprintf($this->jsExternalHtmlHead,'vue' . '/' . 'extensions' . '/',basename($t));
                    }

                    unset($dos);

                    $this->htmlHead .= $this->headCssJS . $this->vueJsHtmlHead;

                break;

                case 'react':

                    $this->htmlHead .= $this->headCssJS . $this->reactJsHtmlHead;

                break;

                default:

                    $this->htmlHead .= $this->headCssJS;

                break;

            endswitch;
        }else{

            $this->htmlHead .= $this->headCssJS;
        }
    }

    /**
     * [EN] If applicable adds the micro data support to HTML head tag
	 * [TR] HEAD için meta data verisi varsa işler.
     * 
     * @method applyHeadDataSupport()
     * @return void
     */
    private function applyHeadDataSupport(): void
    {
        if (isset($this->microDataSupport) && isset($this->microDataSupport['no'])){

            $this->htmlHead .= sprintf($this->htmlHeadMetaThree,$this->microDataSupport['marka_adi'],$this->microDataSupport['satis_durumu'],$this->microDataSupport['durumu'],$this->microDataSupport['fiyati'],'TRY',$this->microDataSupport['no']);
        }
    }

    /**
     * [EN] Add strings directly to HTML HEAD
     * [TR] Uygulama head ine eklenecek satirlar string
     * 
     * @method addHtmlHead()
     * @return void
     */
    private function addHtmlHead($headeki = null): void
    {
        $this->htmlHeadAdditions = $headeki ?? null;
    }

    /**
     * @method getHtmlHead()
     * @return string $head
     */
    public function getHtmlHead($ek = null): string
    {
        $this->addHtmlHead($ek);

        $this->createHtmlHead();

        return $this->htmlHead;
    }

    /**
     * @method createMenuLink() 
     * @param string $t title
     * @param string $i href
	 * @param string $lt Translate string
     * @param string $li Link Image <img>
	 * @param string $d Default Text - <a>TEXT</a>
	 * @param string $lh Link HTML string <h> <p> <div> <a>
     * @return array
     */
    private function createMenuLink(string $t,string $i,string $lt,string $li,string $d,string $lh): array
    {
        return [
            'title' => $t,
            'href' => $i,
            'langText' => $lt,
			'linkImage' => $li,
            'defaultText' => $d,
			'linkHtml' => $lh
        ];
    }

	/**
	 * @method createMenuLinks()
	 * @return string
	 */
    public function createMenuLinks(): string
    {
        $this->appStaticMenu ? $menuHolder = App::getModule('mainMenu') : $menuHolder = $this->moduleFrameMenu;

        $this->mcKontrol ? $menuHolder = $this->moduleFrame->menuVer() : $menuHolder = App::getModule('mainMenu');

		$this->htmlAppMenuLinks = sprintf($this->htmlHeaderNavLink,
	
			ADDRESS,

			App::getApp('applicationName'),

			$this->translate('home')
		);

        if (count($menuHolder) > 0){

            foreach($menuHolder as $l){

                $linkName = App::getApp('languageOption') ? $this->translate($l['langText']) : $l['defaultText'];

				switch(true):

					case isset($l['linkImage']) && isset($l['linkHtml']):
						
						$this->htmlAppMenuLinks .= sprintf($this->htmlHeaderNavLink,
						
							ADDRESS . '/' . $l['href'],

							$l['title'],

							sprintf($this->htmlHeaderLinkHtmlExtra,
							
								$l['linkImage'],

								$l['defaultText'],

								$l['linkHtml']
							)

						);
						
					break;

					case isset($l['linkImage']) && is_null($l['linkHtml']):

						$this->htmlAppMenuLinks .= sprintf($this->htmlHeaderNavLink,
					
							ADDRESS . '/' . $l['href'],

							$l['title'],

							sprintf($this->htmlHeaderLinkHtml,
							
								$l['linkImage'],

								$l['defaultText'],

								$linkName
							)
						);

					break;

					default:

						$this->htmlAppMenuLinks .= sprintf($this->htmlHeaderNavLink,
					
							ADDRESS . '/' . $l['href'],

							$l['title'],

							$linkName
						);

					break;

				endswitch;
			}
        }

        $this->htmlAppMenuLinks .= sprintf($this->htmlHeaderNavLink,
        
            ADDRESS . '/' . App::getApp('contactUri'),

            $this->translate('app_contact_title'),

            $this->translate('app_contact_name')
    
        );

        $this->htmlAppMenuLinks .= sprintf($this->htmlHeaderNavLink,
        
            ADDRESS . '/' . App::getApp('aboutUri'),

            $this->translate('app_about_title'),

            $this->translate('app_about_name')

        );

		return $this->htmlAppMenuLinks;
    }

    /**
     * @method getHtmlAppMenu()
     * @return string $htmlHeaderMenu
     */
    public function getHtmlAppMenu(): string
    {
        $this->createHtmlMenu();

        return $this->htmlHeaderMenu;
    }

    /**
     * @method createHtmlMenu()
     * @return void
     */
    protected function createHtmlMenu(): void
    {
        $this->htmlHeaderMenu = sprintf($this->htmlHeaderContainer443,

			ADDRESS,

			PREFIX,
	
			$this->createMenuLinks(),

			$this->createHeaderBar(),

			$this->getUserLinks()
		);
    }

	/**
	 * @method createSearchBar()
	 * @return string
	 */
	private function createHeaderBar(): string
	{
		return match(true){

			App::getApp('useFullAppSearch') && !$this->activeIOHeader => $this->createSearchBar(),

			$this->activeIOHeader => $this->interfaceHeader,

			!$this->activeIOHeader => ''
		};
	}

	/**
	 * @method createSearchBar()
	 * @return string
	 */
	private function createSearchBar(): string
	{
		return '';
	}

	/**
	 * @method getUserLinks()
	 * @return string
	 */
	private function getUserLinks(): string
	{
		return $this->htmlMenuUserLinks;
	}

    /**
     * [TR] Diğer katmanlar ile - genellikle modüller ile - çerçevenin etkileşimini sağlar.
	 * [EN] Provides interaction with frame and internals / modules
     * 
     * @method frameSupport()
     * @param $proc
     * @param $sproc
     * @return void
     */
    public function frameSupport($proc = null,$sproc = null): void
    {
        $this->process = $proc ?? null;

        $this->subProcess = $sproc ?? null;

        switch ($this->process):

            case LOGINURI:

                $this->interfaceHeader = isset($this->subProcess) ? sprintf($this->htmlHeaderInterfaceText,$this->translate('create_new_account')) : sprintf($this->htmlHeaderInterfaceText,$this->translate('login_to_your_account'));
                
                $this->activeIOHeader = true;
                
                $this->inputScreen = true;

            break;

            case App::getApp('accOperationUri'):

                $this->interfaceHeader = sprintf($this->htmlHeaderInterfaceText,$this->translate('user_processes'));

                $this->operationScreen = true;
                
                $this->activeIOHeader = true;

            break;

            case UUI:

                $this->interfaceHeader = sprintf($this->htmlHeaderInterfaceText,$this->translate('greet') .' '. SysLed::get('user_name_surname'));
                
                $this->activeIOHeader = true;

            break;

        endswitch;

        $this->setLanguageButton();

        $this->setMenuUserLinks();
    }

    /**
     * @method setLanguageButton
     * @return void
     */
    private function setLanguageButton(): void
    {
        if (App::getApp('languageOption')){

            $this->languageButton = match(true){

                $this->langNumber === 0 => sprintf($this->htmlHeaderNavUserLink,$this->createUrl($this->process,$this->translateUriLangSupport()) . '?d=ingilizce','Language Selection','English'),

                $this->langNumber === 1 => sprintf($this->htmlHeaderNavUserLink,$this->createUrl($this->process,$this->translateUriLangSupport()) . '?d=turkce','Dil Seçeneği','Türkçe')

            };
        }else{
            
            $this->languageButton = sprintf($this->htmlHeaderNavUserLink,'#',$this->translate('language_button_non',LANG));
        }
    }

	/**
	 * @method setMenuUserLinks()
	 * @return void
	 */
	private function setMenuUserLinks(): void
	{
		if (!is_bool(SysLed::get('account_page_number')) && App::getApp('applicationUsersEnabled')){

            $this->htmlMenuUserLinks = sprintf($this->htmlHeaderNavUserLink,ADDRESS . '/' . 'logout','',$this->translate('logout'));

            if ($this->process !== UUI){
                
                $this->htmlMenuUserLinks .= sprintf($this->htmlHeaderButton,ADDRESS . '/' . UUI,'',$this->translate('mypage'));
            }
            
            $this->userAuthenticated = true;
            
        }elseif($this->inputScreen){

            $this->htmlMenuUserLinks = sprintf($this->htmlHeaderNavUserLink,ADDRESS . '/' . App::getApp('contactUri'),'',$this->translate('contact_us'));
        }else{

            $this->htmlMenuUserLinks = sprintf($this->htmlHeaderNavUserLink,ADDRESS . '/' . LOGINURI,'',$this->translate('signin'));
        }

        $this->htmlMenuUserLinks .= $this->languageButton;
	}

    /**
     * [TR] Modul Çerçeve Kontrol
	 * [EN] Module Frame Controller
     
	 * @method moduleFrameControl()
     * @return bool $mKontrol
     */
    private function moduleFrameControl(): bool
    {
        if (App::getModule('useModuleFrames')){

            try{

                $cerceve = match(true){

                    App::getModule('useMasterModule') && class_exists(ucfirst($this->appModules[0]) . 'Cerceve') => ucfirst($this->appModules[0]) . 'Cerceve',
                    
                    class_exists(ucfirst($this->activeModule) . 'Cerceve') => ucfirst($this->activeModule) . 'Cerceve',

                    default => null
                };
            }catch(\UnhandledMatchError $hata){

                throw new VerisanatFrameException(self::infoFrame[LANG]['modulcer_ikiz'] . ' : ' . $hata->getMessage());
            }

            if (is_string($cerceve)){

                $this->moduleFrame = new $cerceve;

                $this->mcKontrol = true;
            }
        }

        return $this->mcKontrol;
    }

    /**
     * [TR] Modul ÇErçeve İşlem - modül çerçeve objelerini uygulama çerçevesine uygular
	 * [EN] Module Frame Process - applies module frame objects to app frame
     * 
     * @method moduleFrameProcess()
     * @param string $moduleName
     * @return void
     */
    public function moduleFrameProcess(string $modulName): void
    {
        $this->activeModule = strtolower(ClassicString::cropWord($modulName,'Yapi'));

        if ($this->moduleFrameControl()){

            if (isset($this->moduleFrame->yeniCerceveOgeleri)){
                
                $this->applyModuleFrame($this->moduleFrame->yeniCerceveOgeleri);
            }

            $this->moduleFrameMenu = $this->moduleFrame->menuver();
        }
    }

    /**
     * [TR] Modüle ait çerçeve sınıfı olmadığı zaman modüler yapı için modüle ait menuyu dondurur
	 * [EN] Used when there is no module frame but a need to change menu for the module.
     * 
     * @method setModuleMenu()
     * @param array $menuList
     * @return void
     */
    public function setModuleMenu(array $menuList = null): void
    {
        if (isset($menuList)){

            $this->moduleFrameMenu = $menuList;
        }
    }
}
?>