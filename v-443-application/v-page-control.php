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

use stdClass;

Version\VersionCheck::dkontrol(__FILE__,'4.4.2');
/**
 * Page - SayfaYapi
 */
class Page{

    use CommonPageElements;

    /**
     * @var string $countryCitiesFile
     */
    public const countryCitiesFile = 'app-' . LANG . '-cities.json';
    /**
     * @var string $countryCitiesData
     */
    public const countryCitiesData = 'app-' . LANG . '-city-data.json';
    /**
     * @var string $countryCities
     */
    public const countryCities = LANG . '-city-list.json';
    /**
     * 
     * COL-9 flex content area
     * 
     * yanbar ile kullanılabilecek ekran ogesi, col-9
     * 
     * @var string $biroge
     * @param string $title öğe adı (başlık)
     * @param string $p fotoğraf (dosya adı)
     * @param string $cont öğe içeriği (yazı)
     * @param string $extras sayfa eki - yorumlar - facebook eklentisi vb.
     */
    public const contentArea = '
        <div class="col-md-9 d-flex p-sol-yok p-sag-duzenle kucuk-ekran-yasla mt-2">
            <h3 class="mb-4 mx-auto mobil-yazi">%s</h3>
            <img class="img-fluid align-self-center mx-auto mb-2" src="%s">
            <div class="text-justify secimyok mobil-yazi yazi yazi-sayfalar">
                %s
            </div>
            %s
        </div>
    ';
    public const formInput = '<input type="text" name"%s" id="%s" value="">';

    public const formLabel = '<label for="%s">%s</label>';

    public const inputCheckBox = '<input type="checkbox" name="kendimIcin" class="custom-control-input" value="1" id="customSwitch1">';

    public const form = '
        <form enctype="multipart/form-data" accept-charset="UTF-8" method="post" action="%s" validate>
            %s
            <button type="submit" class="">Send</button>
        </form>
    ';

    /**
     * @var array $infoPage
     */
    public const infoPage = [
        'veri_yok' => 'there is no page data to show'
    ];
    /**
     * @var int $unitsToShow
     */
    public int $unitsToShow = 20;
    /**
     * html formatted category string
     * 
     * @var string $categoryHtmlView 
     */
    public string $categoryHtmlView;
    /**
     * @var string $cerceveMenuCss
     */
    public string $cerceveMenuCss = 'sayfa-butunlugu';

    /**
     * değiştirilecek değişken adı - yeni içerik, sprintf için %s içeren string yada array
     * 
     * @method changePageUnit()
     * @param string $degisken
     * @param string $yeniicerik
     * @return void 
     */
    public function changePageUnit(string $degisken,string $yeniicerik): void
    {
        $this->$degisken = $yeniicerik;
    }

    /**
     * @method pageConsistencyCss
     * @return void
     */
    public function pageConsistencyCss($sinif = null): void
    {
        $this->cerceveMenuCss = $sinif ?? 'sayfa-butunlugu';
    }

    /**
     * html düzenlenmiş footer verir
     * 
     * @method endHtmlPage()
     * @return string $ak
     */
    public function endHtmlPage(): string
    {
        return sprintf($this->genelfooter,$this->cerceveMenuCss,App::getApp('applicationName'),date('Y'),'Sunucu yükü: ' . Audit::getLoad());
    }

    /**
     * uygulama adını aktifse modul adını ve tarihi html düzenlenmiş olarak verir
     * 
     * @method getSalutation()
     * @return string $gb
     */
    public function getSalutation(): string
    {
        return '<h4 class="mt-2 text-center text-danger font-weight-bold">'. App::getApp('applicationName') .'</h4><p class="text-center mt-3">'. Audit::dateTime() .'</p>';
    }

    /**
     * @method isLoading()
     * @param string $topic
     * @return string $ys
     */
    public function isLoading(string $topic): string
    {
        return sprintf($this->gettingReady,$topic);
    }

    /**
     * yapışkan yan menu verir
     * 
     * @method yanmenuver() 
     * @param string $icerik yan menü içeriği, genellikle linklerden oluşur
     * @return string $ym
     */
    public function yanmenuver(string $icerik): string
    {
        return sprintf($this->yanmenukapsayici,$icerik);
    }

    /**
     * facebook açık durumdaysa like butonunu döndürür
     * 
     * @method getFacebookLikes()
     * @param string $url
     * @return mixed|string|null $z
     */
    public function getFacebookLikes(string $url): ?string
    {
        if (App::getApp('facebookIsOn')){

            return sprintf($this->facebookLikes,$url);
        }

        return '';
    }
    /**
     * facebook açık durumdaysa like applet ini ve yorumlar applet ini döndürür
     * 
     * @method getFacebookComments()
     * @param string $url
     * @return string $z
     */
    public function getFacebookComments(string $url): string
    {
        if (App::getApp('facebookIsOn')){

            return sprintf($this->facebookCommentsApplet,App::getProvider('facebookAPIVersion'),App::getProvider('facebookAPPID'),$url);
        }

        return '';
    }

    /**
     * @method getFacebookLogin()
     * @return string
     */
    public function getFacebookLogin(): string
    {
        if (App::getApp('facebookIsOn')){

            return sprintf($this->facebookLogin,App::getProvider('facebookAPPID'),App::getProvider('facebookAPIVersion'));
        }else{

            return sprintf($this->theNonString,'Facebook');
        }
    }

    /**
     * modallinkli / modallinksiz çeşit - adı(html id, Audit::makeUri() ile birlikte) - başlık - içerik - varsa link - varsa linkadı
     * 
     * @method modalyap()
     * @param string $cesit - modallinkli - modallinksiz
     * @param string $adi
     * @param string $baslik
     * @param string $icerik
     * @param mixed|string|null $link
     * @param mixed|string|null $linkadi
     * @return string $m
     */
    public function modalyap(string $cesit,string $adi,string $baslik,string $icerik,?string $link = null,?string $linkadi = null): string
    {
        return sprintf($this->$cesit,$adi,$baslik,$icerik,$link,$linkadi);
    }

    /**
     * modal hedefi data-target, buton adı
     * 
     * @method modalbutonyap()
     * @param string $adi
     * @param mixed|string|int $butonadi - İncele
     * @return string $mb 
     */
    public function modalbutonyap(string $adi,?string $butonadi = 'İncele'): string
    {
        return sprintf($this->modalbuton,Audit::makeUri($adi),$butonadi);
    }

    /**
     * google tag manager body kısmını döndürür
     * 
     * @method getGoogleTagMan()
     * @return string $googletagmanbody
     */
    public function getGoogleTagMan(): string
    {
        if (App::getApp('googleIsOn')){

            return sprintf($this->googleTagManBody,App::getProvider('googleTagManagerID'));
        }
        
        return '';
    }

    /**
     * html body tagını ve varsa öncü sosyal eklentileri verir
     * google ve facebook açık durumdaysa script lerini ekler
     * 
     * @method startHtmlBody() 
     * @param string $govdeid body javascript id si
     * @param string $govdesinif body class i
     * @return string $body
     */
    public function startHtmlBody(?string $govdeid = null,?string $govdesinif = null): string
    {
        if (isset($govdeid) || isset($govdesinif)){

            $bodytipi = '<body id="%s" class="%s">';

            $body = sprintf($bodytipi,$govdeid,$govdesinif);
        }else{

            $body = '<body>';
        }
    
        $body .= $this->getGoogleTagMan();
    
        return $body;
    }

    /**
     * normal sayfa kapsayıcısı - container
     * 
     * @method cover()
     * @param string $icerik
     * @return string $ic
     */
    public function cover(string $icerik): string
    {
        return sprintf($this->temelkapsayici,$icerik);
    }

    /**
     * mobil görünüm için kaydıkça header menuye yapısan başlık verir
     * 
     * @method pageHeadingMobile() 
     * @param string $mobilyapiskanbaslik
     */
    public function pageHeadingMobile(string $adi): string
    {
        return sprintf($this->mobilyapiskanbaslik,$adi);
    }
    /**
     * float left buton görünümlü başlık verir
     * 
     * @method pageHeading() 
     * @param string $normalsayfabasligi
     */
    public function pageHeading(string $adi): string
    {
        return sprintf($this->normalsayfabasligi,$adi);
    }
    /**
     * pageHeadingMobile() ve pageHeading() döndürür
     * 
     * @method getHtmlHeading()
     * @param string $adi
     * @return string $b
     */
    public function getHtmlHeading(string $adi): string
    {
        return $this->pageHeadingMobile($adi) . $this->pageHeading($adi);
    }

    /**
     * @var array $catList
     */
    public static array $catList;
    /**
     * @var int $catCount
     */
    public static int $catCount;
    /**
     * @var object $catData
     */
    public static object $catData;
    /**
     * @var string $dataModule
     */
    public static string $dataModule = 'dergi'; 
    /**
     * @var mixed $pageData
     */
    public object|bool|null $pageData;

    /**
     * Page object starter with category data / count / list prepared.
     * 
     * @method category()
     * @return Page
     */
    public static function category(): Page
    {
		if (defined('DATABASETYPE')){

			self::$catData = \Model::factory('VsKategori')->useIdColumn('katno')->findMany();

			self::$catCount = self::$catData->count();
	
			foreach(self::$catData as $tek){
	
				self::$catList[$tek->katno] = $tek->adi;
			}
	
			return new self;
		}else{

			self::$catData = new stdClass;

			self::$catCount = 0;

			self::$catList = [];

			return new self;
		}
    }

    /**
     * @method setDataModule()
     * @param string $mName
     * @return void
     */
    public static function setDataModule(string $mName = 'dergi'): void
    {
        self::$dataModule = $mName;
    }

    public function __construct()
    {
		if (defined('DATABASETYPE')){

			$this->pageData = \Model::factory(MODULISLEMLER[self::$dataModule]['dbTableName'])->findMany();
		}else{

			$this->pageData = null;
		}
    }

    /**
     * returns categories html formatted.
     * 
     * @method getCategoryHtml()
     * @return string $categoryHtmlView
     */
    public function getCategoryHtml(): string
    {
        for($k = 0; $k < self::$catCount; $k++){

            $this->categoryHtmlView .= sprintf($this->catCard,self::$catData[$k]->katfoto,self::$catData[$k]->katozeti);
        }

        return $this->categoryHtmlView;
    }

    /**
     * öğelerde kayıtlı katno ların gerçek adlarını verir
     * 
     * @method getCategoryName() 
     * @param string $catIDs öğelere kayıtlı kategori numaraları
     * @return string $kler virgülle ayrılmış kategori adları
     */
    private function getCategoryName($catIDs = null): ?string
    {
        $kler = null;

        if (isset($catIDs)){

            if (is_int(strpos($catIDs,','))){

                $ndizi = explode(',',$catIDs);

                foreach($ndizi as $t){

                    if (isset(self::$catList[$t])){

                        $katadi[] = self::$catList[$t];
                    }else{

                        continue;
                    }
                }

                $kler = implode(', ',$katadi);

            }else{

                $kler = self::$catList[$catIDs] ?? null;
            }
        }

        return $kler;
    }

    /**
     * @var bool $sortingFromLast
     */
    private bool $sortingFromLast = false;

    /**
     * @method orderBy()
     * @param string $point - first / last
     * @return void
     */
    public function orderBy(string $point): void
    {
        match($point){

            'first' => $this->sortingFromLast = true,
            'last' => $this->sortingFromLast = false
        };
    }

    /**
     * @method getCards()
     * @param int|null $n
     * @return string $kartblok
     */
    public function getCards(?int $n = null): string
    {
        $this->checkPageData();

        isset($n) ? $adet = $n : $adet = $this->unitsToShow;

        $kartlar = null;

        if ($this->sortingFromLast){

            $this->pageData->set_results(array_reverse($this->pageData->get_results()));
        }

        for($toplam = 0; $toplam < $adet; $toplam++){

            $kartlar .= sprintf($this->kartlar,

                ADDRESS . '/' . MODULISLEMLER[self::$dataModule]['processInterface'] . '/' . $this->pageData[$toplam]->gorunenadi,

                ADDRESS . '/' . RELEASE . '-local-image' . '/' . 'kullanici' .'/' . $this->pageData[$toplam]->foto,

                $this->pageData[$toplam]->adi,

                $this->getCategoryName($this->pageData[$toplam]->katno),

                $this->pageData[$toplam]->baslik
            );
        }

        $kartblok = sprintf($this->sayfaKartBlogu,$kartlar);

        return $kartblok;
    }

    /**
	 * 443 - openSource update for no database, in a future...
	 * 
	 * 442 - throw if none.
	 * 
     * @method checkPageData()
     * @return void
     */
    private function checkPageData(): void
    {
        match(true){

            is_null($this->pageData) || is_bool($this->pageData) => throw new VerisanatPageException(self::infoPage['veri_yok']),

            is_object($this->pageData) && $this->pageData->count() > 0 => $this->unitsToShow = $this->pageData->count()
        };
    }

    /**
	 * Debug and test purpose page component
	 * 
     * @method dotLine()
     * @return string
     */
    public static function dotLine(): string
    {
        return '<br>..........................................................<br>';
    }

    /**
     * @method getFormCities()
     * @return string $sFormSelect
     */
    public static function getFormCities(): string
    {
        $dos = new System\Dos;

        if (!$dos->cd(RELEASE . '-application' . '/' . 'app-config')->fileExists(self::countryCitiesFile)){

            $s = $dos->f(self::countryCities)->read('json')->getData(true);

            for($a = 0; $a < count($s); $a++){
                
                $sDeger[] = 'SI' . Audit::randStrLight(4);
            }

            $sdizi = array_combine($sDeger,$s);
            
            $sFormSelect = null;
            
            $sVeri = [];

            foreach($sdizi as $d => $v){

                $sFormSelect .= '<option value="' . $d . '">' . $v . '</option>';

                $sVeri[$d] = $v;
            }

            $dos->newFile(self::countryCitiesFile)->write(['sehirler' => $sFormSelect]);
            
            $dos->newFile(self::countryCitiesData)->write($sVeri);
        }else{

            $icerik = $dos->f(self::countryCitiesFile)->read('json')->getData(true);

            $sFormSelect = $icerik['sehirler'];
        }

        unset($dos);
        
        return $sFormSelect;
    }

    /**
     * 
     * @method getCitiesData()
     * @return array $vSehirler
     */
    public static function getCitiesData(): array
    {
        $dos = new System\Dos;

        $vSehirler = $dos->cd(RELEASE . '-application' . '/' . 'app-config')->f(self::countryCitiesData)->read('json')->getData(true);

        unset($dos);

        return $vSehirler;
    }

    /**
     * @method getPage()
     * @return string
     */
    public static function getPage(string $title,string $p,string $cont,?string $extras = null): string
    {
        $photo = ADDRESS . '/' . RELEASE . '-local-image' . '/' . 'kullanici' . '/' .  $p;

        return sprintf(self::contentArea,$title,$photo,$cont,$extras);
    }
}
?>