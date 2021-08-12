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

Version\VersionCheck::dkontrol(__FILE__,'4.4.2');
/**
 * Frame - Cerceve
 */
class Frame{

    use CommonFrameElements;

    /**
     * Interface header is active or not
     * 
     * uygulama arayüz headeri aktif, menü kapalı - Hesabınıza Giriş Yapın vb.
     * 
     * @var bool $activeIOHeader 
     */
    public bool $activeIOHeader = false;
    /**
     * @var bool $inputScreen uygulama arayüzü için giriş ekranı aktif mi
     */
    public bool $inputScreen = false;
    /**
     * current session has a logged in user or not
     * 
     * uygulamaya kullanıcı girişi yapılmış mı
     * 
     * @var bool $userAuthenticated
     */
    public bool $userAuthenticated = false;
    /**
     * A frame header title or other html element without menu
     * 
     * standart uygulama header karşılama yazısı, menü içermez
     * 
     * @var null|string $interfaceHeader 
     */
    public null|string $interfaceHeader;
    /**
     * standart uygulama header menü, col-2 col-8 col-2, mobil kısım dahil
     * 
     * @var null|string $htmlHeaderMenu 
     */
    public null|string $htmlHeaderMenu = null;
    /**
     * @var array $infoFrame
     */
    public const infoFrame = [
        'TR' => [
            'modulcer_ikiz' => 'Birden fazla çerçeve kullanıldığı zaman Ana Modül Kullan özelliği false olmalıdır.'
        ],
        'EN' => [
            'modulcer_ikiz' => 'When more than one Frames are in use, useMasterModule option needs to be set to false.'
        ]
    ];
    /**
     * toplanmış dil paketi objesi
     * 
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
     * the Language number selected in app
     * 
     * seçili dil numarası türkçe 0, ingilizce 1, almanca 2 vb.
     * 
     * @var int $langNumber
     */
    public int $langNumber;
    /**
     * dil değiştirmek için kullanılacak adres. Genel olarak menüde yer alır.
     * 
     * @var null|string $languageButton 
     */
    protected null|string $languageButton;
    /**
     * standart uygulama mobil tamamlanmış header kısım col-12
     * 
     * @var string $htmlHeaderMobile 
     */
    public string|null $htmlHeaderMobile;
    /**
     * Such as login - change lang etc.
     * 
     * standart uygulama header düğmeleri, header arka kısımda yer alır
     * 
     * @var string $htmlMenuUserLinks 
     */
    public string|null $htmlMenuUserLinks;
    /**
     * [EN] The unique string id of an object, a data unit currently supported by Frame
     * 
     * [TR] Herhangi bir öğe nin, yazının, ürünün, materyalin, dosyanin eşsiz adı
     * 
     * @var string $currentUniqueObjectID 
     */
    public string|null $currentUniqueObjectID;
    /**
     * @var array $microDataSupport
     */
    public array $microDataSupport = [];
    /**
     * @var array $modulmenu
     */
    private array $modulmenu = [];
    /**
     * Modül çerçeve işlemleri için ana kontrol değişkeni
     * 
     * @var bool $mcKontrol
     */
    private bool $mcKontrol = false;
    /**
     * Modül çerçeve objesi. modul adı - Cerceve
     * 
     * @var object $mcerceve
     */
    private object $mcerceve;
    /**
     * @var string $activeModule
     */
    protected string $activeModule;
    /**
     * @var string $headTitle 
     */
    private $headTitle;
    /**
     * @var string $headDescription 
     */
    private $headDescription;
    /**
     * @var string $headKeywords 
     */
    private $headKeywords;
    /**
     * @var string $webTitleAddition 
     */
    private $webTitleAddition;
    /**
     * @var string $webDescriptionAddition 
     */
    private $webDescriptionAddition;
    /**
     * @var string $webKeywordAddition
     */
    private $webKeywordAddition;
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
     * değiştirilecek değişken adı - yeni içerik, sprintf için %s içeren string yada array
     * 
     * @method changeFrameUnit()
     * @param string $degisken değiştirilecek tekil değişken adı
     * @param mixed $yeniicerik değiştirilecek tekil içerik
     * @return void
     */
    public function changeFrameUnit($degisken = null,$yeniicerik = null): void
    {
        $this->$degisken = $yeniicerik;
    }

    /**
     * Applies the module's frame units to the frame
     * 
     * Modül çerceve öğelerini cerceve değişkenlerine atar
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
     * @since 443 - renamed to 'translate'
     * Translates given word to app language state
     * 
     * aktif olan dil seçeneğine göre loadedLanguagePack objesinden string i döndürür
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
		return $this->loadedLanguagePackURI->$word[$this->langNumber] ?? null;
	}

    public function __construct($gx = null)
    {
        $this->appStaticMenu = App::getApp('staticMenu');

        $this->appModules = App::getModule('modules');

        $this->dil = new Language(Audit::__type($gx,'string'));

        $this->langNumber = $this->dil->currentLanguage();

        $this->lang = $this->dil->htmlLang();

        $this->loadedLanguagePack = $this->dil->getLangPack();

        $this->loadedLanguagePackText = $this->dil->getLangPackText();

		$this->loadedLanguagePackURI = $this->dil->getLangPackURI();
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

        $this->headiki = sprintf($this->headiki,$this->headDescription,$this->headTitle,$this->createUrl($this->process,$this->subProcess));

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
     * @return string $adres
     */
    public function createUrl($bir = null,$iki = null,$sorgu = null): string
    { 
        if (isset($sorgu)){

          $this->adres = ADDRESS . '/' . $bir . '/' . $iki . '?' . $sorgu;

        }elseif(isset($iki)){

          $this->adres = ADDRESS . '/' . $bir . '/' . $iki;

        }elseif(isset($bir)){

          $this->adres = ADDRESS . '/' . $bir;

        }else{

          $this->adres = ADDRESS;
        }

        return $this->adres;
    }

    /**
     * @since 443 frameHtmlHeadSupport  -  headBilgiAl
     * nitelikli obje içeren sayfalar için head i besler
     * 
     * @method frameHtmlHeadSupport() 
     * @param $b başlık eki
     * @param $t tanım eki
     * @param $k keyword eki
     * @param $nn nesne numarası
     * @param array $mikroVeri - head te yer alacak meta bilgileri - modul öğe bilgileri.
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
     * uygulama head kısmını oluşturur ve $head e string olarak atar
     * 
     * @method createHtmlHead()
     * @return void
     */
    public function createHtmlHead(): void
    {
        $this->headkontrol();

        $this->head = sprintf($this->doctype,$this->lang);

        $this->head .= $this->tdk;

        $this->head .= sprintf($this->headbir,App::getProvider('facebookAPPID'));

        $this->head .= $this->headiki;

        $this->applyHeadDataSupport();

        $this->applyHeadVisualElements();

        $this->head .= $this->htmlheadek;

        $this->head .= $this->digitalProviders;

        $this->head .= '</head>';
    }

    /**
     * @method jsarayuz()
     * @param string $adi
     * @return void
     */
    public function setFrameUserInterfaceName(string $adi = null): void
    {
        $this->userInterfaceName = $adi;
    }

    /**
     * İsteğe bağlı olarak vue yada react i head e ekler
     * 
     * @method headucekle()
     * @param string $adi
     * @return void
     */
    private function applyHeadVisualElements(): void
    {
        if (App::getApp('javaScriptUI') && isset($this->userInterfaceName)){

            switch($this->userInterfaceName):

                case 'vue':

                    $d = new System\Dos;

                    $ek = $d->cd($this->vuejseklentiler)->dir('vue-*.js');

                    foreach($ek as $t){

                        $this->head .= sprintf($this->jshead,'vue/extensions/',basename($t));
                    }

                    unset($dos);

                    $this->head .= $this->headCssJS . $this->vuejshead;

                break;

                case 'react':

                    $this->head .= $this->headCssJS . $this->reactjshead;

                break;

                default:

                    $this->head .= $this->headCssJS;

                break;

            endswitch;
        }else{

            $this->head .= $this->headCssJS;
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

            $microData = sprintf($this->headDort,$this->microDataSupport['marka_adi'],$this->microDataSupport['satis_durumu'],$this->microDataSupport['durumu'],$this->microDataSupport['fiyati'],'TRY',$this->microDataSupport['no']);

            $this->head .= $microData;
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
        $this->htmlheadek = $headeki ?? null;
    }

    /**
     * @method getHtmlHead()
     * @return string $head
     */
    public function getHtmlHead($ek = null): string
    {
        $this->addHtmlHead($ek);

        $this->createHtmlHead();

        return $this->head;
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
        $this->appStaticMenu ? $menuHolder = App::getModule('mainMenu') : $menuHolder = $this->modulmenu;

        $this->mcKontrol ? $menuHolder = $this->mcerceve->menuVer() : $menuHolder = App::getModule('mainMenu');

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

			$this->setUserLinks(),

			$this->languageButton
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
	 * @method createUserLinks()
	 * @return string
	 */
	private function setUserLinks(): string
	{
		return $this->htmlMenuUserLinks;
	}

    /**
     * @since 443 - name changed to frameSupport - cerceveDestek
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

            case 'account-operations':

                $this->interfaceHeader = sprintf($this->htmlHeaderInterfaceText,$this->translate('user_processes'));
                
                $this->activeIOHeader = true;

            break;

            case UUI:

                $this->interfaceHeader = sprintf($this->htmlHeaderInterfaceText,$this->translate('greet') .' '. AppAudit::getUserName());
                
                $this->activeIOHeader = true;

            break;

        endswitch;

        $this->setMenuUserLinks();

        $this->setLanguageButton();
    }

    /**
     * @method setLanguageButton
     * @return void
     */
    private function setLanguageButton(): void
    {
        if (App::getApp('languageOption')){

            $this->languageButton = match(true){

                $this->langNumber === 0 => sprintf($this->headerlink,'Language Selection',ADDRESS . '?d=ingilizce','English','Lang','language'),

                $this->langNumber === 1 => sprintf($this->headerlink,'Dil Seçeneği',ADDRESS . '?d=turkce','Türkçe','Dil','language')

            };
        }else{
            
            $this->languageButton = null;
        }
    }

	/**
	 * @method setMenuUserLinks()
	 * @return void
	 */
	private function setMenuUserLinks(): void
	{
		if (isset($_SESSION['account_page_number']) && App::getApp('applicationUsersEnabled')){

            $this->htmlMenuUserLinks = sprintf($this->htmlHeaderNavUserLink,ADDRESS . '/' . 'logout',$this->translate('logout'));

            if ($this->process !== UUI){
                
                $this->htmlMenuUserLinks .= sprintf($this->htmlHeaderButton,ADDRESS . '/' . UUI,$this->translate('mypage'));
            }
            
            $this->userAuthenticated = true;
            
        }elseif($this->inputScreen){

            $this->htmlMenuUserLinks = sprintf($this->htmlHeaderNavUserLink,ADDRESS . '/' . App::getApp('contactUri'),$this->translate('contact_us'));
        }else{

            $this->htmlMenuUserLinks = sprintf($this->htmlHeaderNavUserLink,ADDRESS . '/' . LOGINURI,$this->translate('signin'));
        }
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

                $this->mcerceve = new $cerceve;

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
     * @param string $cagiranSinif - moduladiYapi
     * @return void
     */
    public function moduleFrameProcess(string $modulAdi): void
    {
        $this->activeModule = strtolower(ClassicString::cropWord($modulAdi,'Yapi'));

        if ($this->moduleFrameControl()){

            if (isset($this->mcerceve->yeniCerceveOgeleri)){
                
                $this->applyModuleFrame($this->mcerceve->yeniCerceveOgeleri);
            }

            $this->modulmenu = $this->mcerceve->menuver();
        }
    }

    /**
     * [TR] Modüle ait çerçeve sınıfı olmadığı zaman modüler yapı için modüle ait menuyu dondurur
	 * [EN] Used when there is no module frame but a need to change menu for the module.
     * 
     * @method setModuleMenu()
     * @param array $menuList -> createMenuLink()
     * @return void
     */
    public function setModuleMenu(array $menuList = null): void
    {
        if (isset($menuList)){

            $this->modulmenu = $menuList;
        }
    }
}
?>