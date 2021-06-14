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
            'moduleFrame_double' => 'Birden fazla çerçeve kullanıldığı zaman Ana Modül Kullan özelliği false olmalıdır.'
        ],
        'EN' => [
            'moduleFrame_double' => 'When more than one Frames are in use, useMasterModule option needs to be set to false.'
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
     * standart uygulama mobil header linkleri
     * 
     * @var string|null $htmlHeaderLinksMobile 
     */
    public string|null $htmlHeaderLinksMobile = null;
    /**
     * Such as login - change lang etc.
     * 
     * standart uygulama header düğmeleri, header arka kısımda yer alır
     * 
     * @var string $htmlHeaderAppButtons 
     */
    public string|null $htmlHeaderAppButtons;
    /**
     * The unique string id of an object, a data unit currently supported by Frame
     * 
     * herhangi bir öğe nin, yazının, ürünün, materyalin, dosyanin eşsiz adı
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
     * head title ı ifade eder
     * 
     * @var string $headTitle 
     */
    private $headTitle;
    /**
     * head description ı ifade eder
     * 
     * @var string $headDescription 
     */
    private $headDescription;
    /**
     * head keyword u ifade eder
     * 
     * @var string $headKeywords 
     */
    private $headKeywords;
    /**
     * title a SEO eklentisi
     * 
     * @var string $webTitleAddition 
     */
    private $webTitleAddition;
    /**
     * description a SEO eklentisi
     * 
     * @var string $webDescriptionAddition 
     */
    private $webDescriptionAddition;
    /**
     *  keyword a SEO eklentisi
     * 
     * @var string $webKeywordAddition
     */
    private $webKeywordAddition;

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

    public function __construct($gx = null)
    {
        $this->appStaticMenu = App::getApp('staticMenu');

        $this->appModules = App::getModule('modules');

        $this->dil = new Language(Audit::__type($gx,'string'));

        $this->langNumber = $this->dil->currentLanguage();

        $this->lang = $this->dil->htmlLang();

        $this->loadedLanguagePack = $this->dil->getLangPack();

        $this->loadedLanguagePackText = $this->dil->getLangPackText();
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

        $this->headDortEkle();

        $this->headucekle();

        $this->head .= $this->htmlheadek;

        $this->head .= $this->digitalProviders;

        $this->head .= '</head>';
    }

    /**
     * @method jsarayuz()
     * @param string $adi
     * @return void
     */
    public function jsarayuz(string $adi = null): void
    {
        $this->arayuzadi = $adi;
    }

    /**
     * İsteğe bağlı olarak vue yada react i head e ekler
     * 
     * @method headucekle()
     * @param string $adi
     * @return void
     */
    private function headucekle(): void
    {
        if (App::getApp('javaScriptUI') && isset($this->arayuzadi)){

            switch($this->arayuzadi):

                case 'vue':

                    $d = new System\Dos;

                    $ek = $d->cd($this->vuejseklentiler)->dir('vue-*.js');

                    foreach($ek as $t){

                        $this->head .= sprintf($this->jshead,'vue/extensions/',basename($t));
                    }

                    unset($dos);

                    $this->head .= $this->headuc . $this->vuejshead;

                break;

                case 'react':

                    $this->head .= $this->headuc . $this->reactjshead;

                break;

                default:

                    $this->head .= $this->headuc;

                break;

            endswitch;
        }else{

            $this->head .= $this->headuc;
        }
    }

    /**
     * v.4.4.2 Karınca v.1
     * head te yer alacak mikro veri yi head e ekler
     * 
     * @method headDortEkle()
     * @return void
     */
    private function headDortEkle(): void
    {
        if (isset($this->microDataSupport) && isset($this->microDataSupport['no'])){

            $microData = sprintf($this->headDort,$this->microDataSupport['marka_adi'],$this->microDataSupport['satis_durumu'],$this->microDataSupport['durumu'],$this->microDataSupport['fiyati'],'TRY',$this->microDataSupport['no']);

            $this->head .= $microData;
        }
    }

    /**
     * add strings directly to HTML HEAD
     * 
     * uygulama head ine eklenecek satirlar string
     * 
     * @method addHtmlHead()
     * @return void
     */
    private function addHtmlHead($headeki = null): void
    {
        $this->htmlheadek = $headeki ?? null;
    }

    /**
     * uygulama html head i dondurur
     * 
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
     * @method yanmenu() standart yan menu yazar ve dondurur. array linkler, sticky-top ve inceliste opsiyonel
     * @param array $linkler yanmenude bulunacak linkler - href / adi
     * @param string $o yanmenü nün sayfa sırası html class olarak - order-2, order-3 vb.
     * @param string $s yanmenü varsayılan üst öğeye yapışkandır sticky-top
     * @param string $i yanmenü öğelerinin yani link butonlarının kalınlığı - inceliste varsayılan
     * @return string $yanmenubir
     */
    public function yanmenu(array $linkler = null,string $o = 'order-2',string $s = 'sticky-top',string $i = 'inceliste'): string
    {
        $l = null;

        if (isset($linkler)){

            foreach($linkler as $tek){

                $l .= sprintf($this->yanmenulink,$tek['href'],$tek['adi']);
            }
        }

        $ust = sprintf($this->yanmenuust,$o,$s,$i);
        
        $this->yanmenubir = $ust . $l . $this->yanmenualt;
        
        $this->yanmenukullan = true;
        
        return $this->yanmenubir;
    }

    /**
     * bir title - bir link - bir link adı array i yaratır
     * 
     * @method menulinkolustur() 
     * @param string $t başlık
     * @param string $i href
     * @param string $a adı
     * @return array $bu
     */
    private function menulinkolustur(string $t,string $i,string $a): array
    {
        return [
            'title' => $t,
            'href' => $i,
            'adi' => $a,
            'dyazi' => null,
            'bilgi' => null
        ];
    }

    public function menulink(): void
    {
        $this->appStaticMenu ? $menuHolder = App::getModule('mainMenu') : $menuHolder = $this->modulmenu;

        $this->mcKontrol ? $menuHolder = $this->mcerceve->menuVer() : $menuHolder = App::getModule('mainMenu');

        $this->headerorta[1] = null;

        if (count($menuHolder) > 0){

            foreach($menuHolder as $l){

                if (App::getApp('languageOption')){

                    $this->headerorta[1] .= sprintf($this->headerlink,$l['title'],ADDRESS . '/' . $l['href'],$this->translate($l['dyazi']),$l['bilgi']);
                }else{

                    $this->headerorta[1] .= sprintf($this->headerlink,$l['title'],ADDRESS . '/' . $l['href'],$l['yazi'],$l['bilgi']);
                }
            }

            $this->headerorta[1] .= $this->languageButton;

            ksort($this->headerorta);
        }

        $this->headeron[1] = sprintf($this->headerlogo,ADDRESS,ADDRESS . '/' . RELEASE . '-local-image' . '/' . 'uygulama' . '/' . PREFIX);

        ksort($this->headeron);
    }

    /**
     * sabit menü kullanımdaysa mobilde görünecek linkleri oluşturur.
     * 
     * @method mobillink() 
     * @return void
     */
    public function mobillink(): void
    {
        if ($this->appStaticMenu){

            foreach(App::getModule('mobileMainMenu') as $l){

                $this->htmlHeaderLinksMobile .= sprintf($this->mlink,$l['title'],ADDRESS . '/' . $l['href'],$l['yazi']);
            }

            $this->htmlHeaderLinksMobile .= $this->languageButton;
        }

        if ($this->mcKontrol){

            foreach($this->mcerceve->mobilMenuVer() as $l){

                $this->htmlHeaderLinksMobile .= sprintf($this->headerLinkMobil,$l['title'],ADDRESS . '/' . $l['href'],$l['yazi'],$l['bilgi']);
            }

            $this->htmlHeaderLinksMobile .= $this->languageButton;
        }
    }

    /**
     * mobil cihazlarda görüntülenecek menuyü yazar.
     * 
     * @method htmlHeaderMobile() 
     * @param string|null $headersinifi tercihe bağlı header css sinifi
     * @return void
     */
    public function htmlHeaderMobile($headersinifi = 'degistirme'): void
    {
        $this->mobillink();

        $this->htmlHeaderMobile = sprintf($this->headermobilyapi,$headersinifi,ADDRESS,ADDRESS . '/' . RELEASE . '-local-image' . '/' . 'uygulama' . '/' . PREFIX,$this->htmlHeaderLinksMobile);
    }

    /**
     * @method createHtmlMenu()
     * @param mixed $headersinifi
     * @return void
     */
    protected function createHtmlMenu(?string $headersinifi = null): void
    {
        $this->menulink();

        $this->htmlHeaderMobile($headersinifi);

        $this->htmlHeaderMenu .= sprintf($this->headermenuust,$headersinifi);

        foreach($this->headeron as $ho){
            
            $this->htmlHeaderMenu .= $ho;
        }

        if ($this->activeIOHeader){
            
            $this->htmlHeaderMenu .= $this->interfaceHeader;
        }else{
            
            foreach($this->headerorta as $ho){
            
                $this->htmlHeaderMenu .= $ho;
            }
        }

        foreach($this->headerarka as $ha){
            
            $this->htmlHeaderMenu .= $ha;
        }

        $this->htmlHeaderMenu .= $this->headermenualt;

        $this->htmlHeaderMenu .= $this->htmlHeaderMobile;
    }

    /**
     * @since 443 - name changed to frameSupport - cerceveDestek
     * Diğer katmanlar ile - genellikle modüller ile - çerçevenin etkileşimini sağlar.
     * 
     * @method frameSupport()
     * @param $islem
     * @param $ekislem
     * @return void
     */
    public function frameSupport($islem = null,$ekislem = null): void
    {
        $this->process = $islem ?? null;

        $this->subProcess = $ekislem ?? null;

        switch ($islem):

            case 'merhaba':

                isset($ekislem) ? $this->interfaceHeader = '<h4 class="text-center mx-auto mt-2">'. $this->loadedLanguagePack->create_new_account[$this->langNumber] .'</h4>' : $this->interfaceHeader = '<h4 class="text-center mx-auto mt-2">'. $this->loadedLanguagePack->login_to_your_account[$this->langNumber] .'</h4>';
                
                $this->activeIOHeader = true;
                
                $this->inputScreen = true;

            break;

            case 'kullanici-islemleri':

                $this->interfaceHeader = '<h4 class="text-center mx-auto mt-2">'. $this->loadedLanguagePack->user_processes[$this->langNumber] .'</h4>';
                
                $this->activeIOHeader = true;

            break;

            case UUI:

                $this->interfaceHeader = '<h6 class="text-center mx-auto mt-2">'. $this->loadedLanguagePack->greet[$this->langNumber] .' '. AppAudit::getUserName() .'</h6>';
                
                $this->activeIOHeader = true;

            break;

        endswitch;

        if (isset($_SESSION['hesapno'])){

            $this->htmlHeaderAppButtons = sprintf($this->headerbutontipi,ADDRESS . '/' . 'oturum-kapatiliyor',$this->loadedLanguagePack->logout[$this->langNumber]);

            if ($islem !== UUI){
                
                $this->htmlHeaderAppButtons .= sprintf($this->headerbutontipiiki,ADDRESS . '/' . UUI,$this->loadedLanguagePack->mypage[$this->langNumber]);
                
            }
            
            $this->userAuthenticated = true;
            
        }elseif($this->inputScreen){

            $this->htmlHeaderAppButtons = sprintf($this->headerbutontipi,ADDRESS . '/' . 'iletisim',$this->loadedLanguagePack->contact_us[$this->langNumber]);
        }else{

            $this->htmlHeaderAppButtons = sprintf($this->headerbutontipi,ADDRESS . '/' . 'merhaba',$this->loadedLanguagePack->signin[$this->langNumber]);
        }

        if (App::getApp('applicationUsersEnabled')){

            $this->headerarka[1] = $this->htmlHeaderAppButtons;
        }

        ksort($this->headerarka);

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
     * modüler yapı genel ana menuyu döndürür. sayfa ustunde fixed top özelliğindedir.
     * 
     * @method getHtmlAppMenu() 
     * @param string $headersinifi isteğe bağlı ana menu için css class
     * @return string $htmlHeaderMenu
     */
    public function getHtmlAppMenu($headersinifi = null): string
    {
        $this->createHtmlMenu($headersinifi);

        return $this->htmlHeaderMenu;
    }

    /**
     * @var array $appModules
     */
    private array $appModules;

    /**
     * Modul Çerçeve Kontrol
     * 
     * - Uygulama ayarlarında modul cerceve true ise
     * - Ana modul kullan true ise
     * -> ana modulün çerçeve ayarları (menuler vs) uygulama için varsayılan olarak kullanılır.
     * 
     * @method cerceveKontrol()
     * @return bool $mKontrol
     */
    private function cerceveKontrol(): bool
    {
        if (App::getModule('useModuleFrames')){

            try{

                $cerceve = match(true){

                    App::getModule('useMasterModule') && class_exists(ucfirst($this->appModules[0]) . 'Cerceve') => ucfirst($this->appModules[0]) . 'Cerceve',
                    
                    class_exists(ucfirst($this->activeModule) . 'Cerceve') => ucfirst($this->activeModule) . 'Cerceve',

                    default => null
                };
            }catch(\UnhandledMatchError $hata){

                throw new VerisanatFrameException(self::infoFrame[LANG]['moduleFrame_double'] . ' : ' . $hata->getMessage());
            }

            if (is_string($cerceve)){

                $this->mcerceve = new $cerceve;

                $this->mcKontrol = true;
            }
        }

        return $this->mcKontrol;
    }

    /**
     * Modul ÇErçeve İşlem
     * 
     * @method mCerceveIslem()
     * @param string $cagiranSinif - moduladiYapi
     * @return void
     */
    public function mCerceveIslem(string $modulAdi): void
    {
        $this->activeModule = strtolower(ClassicString::cropWord($modulAdi,'Yapi'));

        if ($this->cerceveKontrol()){

            if (isset($this->mcerceve->yeniCerceveOgeleri)){
                
                $this->applyModuleFrame($this->mcerceve->yeniCerceveOgeleri);
            }

            $this->modulmenu = $this->mcerceve->menuver();
        }
    }

    /**
     * Modüle ait çerçeve sınıfı olmadığı zaman modüler yapı için modüle ait menuyu dondurur
     * 
     * @method modulmenu()
     * @param array $linkler menü öğesi - başlık - href - yazı
     * @return void
     */
    public function modulmenu($linkler = null): void
    {
        if (isset($linkler)){

            $this->modulmenu = $linkler;
        }
    }
}
?>