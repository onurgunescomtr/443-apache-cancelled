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
 * ModuleBase - ModulYapi
 */
class ModuleBase{

    use CommonModuleElements;

    use AbilityModuleFrame;

    use AbilityModulePage;

    use AbilityModuleDatabase;

    use Builder;

    /**
     * @var bool $benim ana modul bu mu değil mi
     */
    public bool $benim;
    /**
     * @var string $anamodul uygulama çerçeve yapısı ve değişiklikleri
     */
    protected string|null $anamodul;
    /**
     * Head te bulunması gereken eklentileri array olarak barındırır
     * @var array $headekleri
     */
    private array|null $headekleri;
    /**
     * ekranolustur a eklenebilecek html parçaları barındırır.
     * @var array $ekranekleri
     */
    private array|null $ekranekleri;
    /**
     * @var string $ekran tamamlanmış tam html sayfa
     */
    private string|null $ekran = null;
    /**
     * @var string $modulbilgikutulari yazılmış toast iletiler
     */
    private $modulbilgikutulari;
    /**
     * @var string $bilgiver Http::guide() yada Http::inform() ile yönlendirilmiş uyarı başarı metnini barındırır
     */
    private string|null $bilgiver;
    /**
     * @var string $testortami tam html okunmuş dosya
     */
    private string|null $testortami;
    /**
     * @var string $istek modüle iletilen işlem adı
     */
    public string|null $istek;
    /**
     * @var object $sn islem gören nesne
     */
    public object $sn;
    /**
     * modüller arası iletilen html düzenlenmiş ileti
     * 
     * @var string $moduleMessages
     */
    public string|null $moduleMessages;
    /**
     * 443 - simplified - sadeleştirildi
     * temel modul sabitleri
     * 
     * @var array $integrity
     */
    public array $integrity = [
        'modulesLoaded'
    ];
    /**
     * temel modul değişkenleri
     * @var array $essentialModuleElements
     */
    public array $essentialModuleElements = [
        'dbTableName',
        'veriadi',
        'yapidegistir',
        'cercevedegistir',
        'processInterface',
        'etkinarayuz',
        'operationInterface',
        'processUnit',
        'uniqueIdentifierProperty'
    ];
    /**
     * @var array $modulDegistirilebilirOgeler
     */
    public array $modulDegistirilebilirOgeler = [
        'yapidegistir',
        'cercevedegistir'
    ];
    /**
     * Modül öğe tanımlayıcı varsayılan - gorunenadi - tablo kolonu
     * 
     * @var string $publicIdentifierProperty
     */
    public string $publicIdentifierProperty = 'gorunenadi';
    /**
     * modul arayüzü
     * 
     * @var string $arayuz
     */
    public string $arayuz;
    /**
     * @var bool $etkinarayuz
     */
    public bool $etkinarayuz;
    /**
     * module özel işleme alınacak öğe genel adı
     * 
     * @var string $processUnit
     */
    public string $processUnit;
    /**
     * module özel eşsiz olarak kullanılacak tablo kolonu adı - essizalan 
     * 
     * @var string $uniqueIdentifierProperty
     */
    public string $uniqueIdentifierProperty;
    /**
     * uygulamada açık paketlerin tamamı
     * 
     * @var array $modulesLoaded
     */
    public array $modulesLoaded;
    /**
     * modul veritabanı tablo adı
     * 
     * @var string $dbTableName
     */
    public string $dbTableName;
    /**
     * modüle özgü yapı değişkenleri array i
     * 
     * @var array $yapidegistir
     */
    public array|null $yapidegistir;
    /**
     * modüle özgü çerçeve değişkenleri array i
     * 
     * @var array $cercevedegistir
     */
    public array|null $cercevedegistir;
    /**
     * @var string $operationInterface modüle özgü işlem arayuzü adı
     */
    public string $operationInterface;
    /**
     * @var bool $processRequest
     */
    public bool $processRequest = false;
    /**
     * @var bool $responseAvailable
     */
    public bool $responseAvailable = false;
    /**
     * @var array $otherModules uygulamaya dahil diğer moduller yapı  - adı => veritabanı tablosu
     */
    public array $otherModules;
    /**
     * 443 - array at all releases
     * 
     * v.Tam object
     * v.Pratik array
     * @var array $moduleSession modüllere özgü oturum bilgilerini barındırır.
     */
    public array $moduleSession;
    /**
     * @var bool $invalidRequestResponse
     */
    public bool $invalidRequestResponse;
    /**
     * @var array $infoModuleError
     */
    public const infoModuleError = array(
        'm_surum_az' => '500.002.Active module needs to be updated to application version.',
        'm_veri_yok' => '500.003.A necessary module configuration element is missing for the application.',
        'm_veri_eksik' => '500.004.Undefined module configuration variable.',
        'm_config_up' => '200.341.Verisanat v.4 application module is under maintenance, please check back later.'
    );
    /**
     * @var array $modulBilgiSatirlari
     */
    public array $modulBilgiSatirlari = array(
        'yok' => '200.097.API yetersiz işlem.',
        'yok_cg' => '200.099.API yetersiz işlem.Cevap yok.',
        'yetkisiz' => '200.098.API yetkisiz işlem.',
        'oge_yok' => 'Linklerde bir problem oluşmuş yada eski bir kayıt istenmiş olabilir. <br> Bu veya benzer linklerin ısrarcı biçimde kullanımı uygulama üzerinde yasaklanmanıza yol açabilir.'
    );

    /**
     * @method checkModuleConsistency()
     * @param string $cevap
     * @param string|null $ekBilgi
     * @return void
     */
    private function checkModuleConsistency(string $cevap,?string $ekBilgi = null): void
    {
        $cevap = isset($ekBilgi) ? self::infoModuleError[$cevap] . ' içerik: ' . $ekBilgi : self::infoModuleError[$cevap];

        if (LOKAL){
            
            die($cevap);
        }else{

            Scribe::appLog($cevap);

            die(self::infoModuleError['m_config_up']);
        }
    }

    /**
     * @method checkModuleVersion()
     * @param string $moduladi
     * @return void
     */
    public function checkModuleVersion(string &$moduladi): bool
    {
        return version_compare(MODULISLEMLER[$moduladi]['versiyon'],VER,'<');
    }

    /**
     * Yapı sınıfını modulde oluşturur.
     * @since 4.3.0 [EN]Instantiate Frame and Page in module [TR]Çerçeve sınıfını modulde oluşturur.
     * 
     * @method yapiBaslat()
     * @return void
     */
    public function yapiBaslat(): void
    {
        Warden::setSession();

        if (!VSDEVMODE){

            Scribe::requestLog($this->process,$this->subProcess,$this->rawQuery);
        }

        Warden::setOpenKey();

        switch(PROTOKOL):
        
            case 'http':
            
                $this->frame = new Frame($this->moduldil('d',null));

                $this->vui = new Page;

                $this->frame->mCerceveIslem(get_called_class());

                $this->frame->frameSupport($this->process,$this->subProcess);

            break;
        default:

            // console - $this->frame = new AgCerceve;
        
        break;
        
        endswitch;
    }

    /**
     * uygulama sabitlerini atar
     * 
     * @method sabitAl()
     * @param array $integrity
     * @return void
     */
    public function sabitAl(array $s): void
    {
        foreach($this->integrity as $t){

            $this->$t = $s[$t];
        }
    }

    /**
     * Ana modulu alır, modulun ana modul olup olmadığını kontrol eder
     * 
     * @method aktifModuller()
     * @return void
     */
    public function aktifModuller(): void
    {
        $this->anamodul = array_shift($this->modulesLoaded);

        $this->benim = $this->anamodul === $this->moduladi ? true : false;
    }

    /**
     * diğer modüllerin izin verilen verisini $otherModules e (array) atar. (yapı adı => veritabanı tablosu)
     * 
     * @method paylasilanVeri()
     * @return void
     */
    public function paylasilanVeri(): void
    {
        foreach($this->modulesLoaded as $t){

            if (MODULISLEMLER[$t]['veripaylasimi']){

                $this->otherModules[MODULISLEMLER[$t]['veriadi']] = MODULISLEMLER[$t]['dbTableName'];
            }
        }
    }

    /**
     * modüller arası iletiyi yazar
     * 
     * @method getModuleReport()
     * @return mixed|null|string $moduleMessages
    */
    public function getModuleReport()
    {
        $this->moduleMessages = $_SESSION['public_info_container'] ?? null;

        unset($_SESSION['public_info_container']);

        return $this->moduleMessages;
    }

    /**
     * modüller için dil seçeneğini çerçeve için alır.
     * 
     * @method moduldil()
     * @param string $deger dil degeri
     * @param null $varsayilan
     * @return string|null $deger
     */
    public function moduldil(string $deger,?string $varsayilan): string|null
    {
        return Http::__gx($deger,$varsayilan);
    }

    /**
     * modul sabitlerini atar
     * 
     * @method temelYapi()
     * @param string $moduladi geçerli modul adı
     * @return void
     */
    public function temelYapi(string $moduladi): void
    {
        if ($this->checkModuleVersion($moduladi)){

            die(self::infoModuleError['m_surum_az']);
        }

        $yetersiz = [];

        $eksik = [];
        
        foreach($this->essentialModuleElements as $t){

            if (!array_key_exists($t,MODULISLEMLER[$moduladi])){

                $yetersiz[] = $t;
            }elseif(is_null(MODULISLEMLER[$moduladi][$t]) && !in_array($t,$this->modulDegistirilebilirOgeler,true)){
            
                $eksik[] = $t;
            }else{

                $this->$t = MODULISLEMLER[$moduladi][$t];
            }
        }

        if (count($eksik) > 0){

            $this->checkModuleConsistency('m_veri_eksik',implode(' - ',$eksik));
        }

        if (count($yetersiz) > 0){

            $this->checkModuleConsistency('m_veri_yok',implode(' - ',$yetersiz));
        }
    }

    public function __construct(array $up,array $sabit = null)
    {
        $this->setProc($up);

        $this->invalidRequestResponse = App::getApp('invalidRequestResponse');

        if ($this->subProcess !== null || $this->one !== null || $this->two !== null){

            $this->processRequest = true;
        }

        $this->sabital($sabit);

        $this->aktifmoduller();

        $this->paylasilanveri();
    }

    /**
     * @method verisanatClassic()
     * @return void
     */
    public function verisanatClassic(string $appRequest = null): void
    {
        $this->yapiBaslat();
        
        $this->modulBilgiVer();

        $this->istekIsle($appRequest);

        $this->anaIslem();
    }

    /**
     * $istek e göre modül çağrısını yönetir
     * 
     * @method anaIslem()
     * @return void
     */
    public function anaIslem(): void
    {
        $this->moduleSession[$this->moduladi]['benzersiz'] = Audit::randStrLight(12);

        $this->moduleSession[$this->moduladi]['dizi'] = [];

        switch($this->istek):
            case 'main-page':

                call_user_func([$this,'modulAnasayfa']);

            break;
            case null:

                call_user_func([$this,'arayuzTemelKontrol']);

                call_user_func([$this,'modulArayuz']);

            break;
        endswitch;

        $this->ekranver();

        exit;
    }

    /**
     * modül den dönecek ekranı hazırlar.
     * 
     * @method ekranOlustur()
     * @param string|null $bu
     * @return void
     */
    public function ekranOlustur(?string $bu = null): void
    {
        $this->ekran .= $bu;

        if (isset($this->bilgiver)){
            
            $this->bilgiver = null;
        }

        $this->arayuzCevapKontrol();
    }

    /**
     * @method arayuzCevapKontrol()
     * @return void
     */
    private function arayuzCevapKontrol(): void
    {
        if (!$this->responseAvailable){

            $this->responseAvailable = true;
        }
    }

    /**
	 * 443 handles screen response.
	 * 
     * ekranı gönderir
     * 
     * @method ekranver()
     * @return string $ekran
     */
    private function ekranver()
    {
        if (PROTOKOL === 'http'){

            if ($this->responseAvailable){

                $this->ekranOlustur($this->vui->endHtmlPage());

                $this->ekranOlustur($this->sayfascriptleri);

                $this->ekran .= match($this->istek){

                    'main-page' => $this->modulgoster($this->moduladi,'main-page'),

                    null => $this->modulgoster($this->moduladi)
                };

                $this->ekranOlustur($this->sayfasonu);

                Http::respond($this->ekran);
            }else{

                header('HTTP/1.1 404 Not Found',true,404);

                die($this->modulBilgiSatirlari['yok_cg']);
            }
        }

		// console - 443 server types openSource removed.
    }

    /**
     * Protokol http - display: none ile birlikte, çalışan modül adını verir
     * 
     * @method modulgoster() 
     * @param string $adi
     * @return string $m
     */
    private function modulgoster($adi = null,$as = null)
    {
        return isset($as) ? sprintf($this->anasayfagosterhtml,ucfirst($adi)) : sprintf($this->modulgosterhtml,ucfirst($adi));
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
     * Ana işlem tarafından çağırılan her modül için geçerli temel kontrol fonksiyonu
     * 
     * @method arayuzTemelKontrol()
     * @return void
     */
    public function arayuzTemelKontrol(): void
    {
        if ($this->processRequest && $this->{$this->processUnit} === null && !$this->etkinarayuz){

            if ($this->invalidRequestResponse){
                
                $this->modulbilgi($this->modulBilgiSatirlari['oge_yok']);

                Http::guide(ADDRESS,'error','İstenilen öğe bulunamadı');
            }else{

                header('HTTP/1.1 404 Not Found',true,404);

                die($this->modulBilgiSatirlari['yok']);
            }
        }

        if (!$this->processRequest && !$this->etkinarayuz){

            header('HTTP/1.1 404 Not Found',true,404);

            die($this->modulBilgiSatirlari['yetkisiz']);
        }
    }

    /**
     * v.4.4.1 modül işlem öğesi isteği var mı kontrol eder.
     * 
     * @method modulOgesiTalep()
     * @return bool
     */
    public function modulOgesiTalep(): bool
    {
        if (!is_null($this->{$this->processUnit})){

            return true;
        }

        return false;
    }

    /**
     * v.Tam
     * Modüllere özgü oturum bilgilerini alır. moduloturum objesinde moduladi objesine ekler
     * Tüm modüller için string moduladi->benzersiz ve array moduladi->dizi bulunur.
     * 
     * v.Pratik
     * Modüllere özgü oturum bilgilerini alır. moduloturum array inda moduladi array ina veri ekler
     * Tüm modüller için string moduladi[benzersiz] ve array moduladi[dizi] bulunur.
     * @method oturumVeri()
     * @param string $deger
     * @param string|int|mixed $veri
     * @return void
     */
    public function oturumveri(string $deger,$veri): void
    {
        $this->moduleSession[$this->moduladi]->dizi[$deger] = $veri;
    }

    /**
     * modüle iletilen isteği $istek e atar
     * 
     * @method istekIsle()
     * @param string $i modüle iletilen istek
     * @return void
     */
    public function istekIsle(string $i = null): void
    {
        $this->istek = $i ?? null;
    }

    /**
     * @method goruntulenme()
     */
    protected function goruntulenme(): void
    {
        $this->sn->goruntulenme = (int)$this->sn->goruntulenme + (int)1;
        
        $this->sn->save();
    }

    /**
     * @method etkilesimModulKopru()
     * @param string $etkilesimNo
     * @param string $madi
     * @param string $mb şifreli
     * @param string $kb şifreli
     * @return void
     */
    public function etkilesimModulKopru(string $etkilesimNo,string $madi,string $mb,string $kb): void
    {
        $d = \Model::factory('VsModulEtkilesim')->useIdColumn('sayfano')->findOne($etkilesimNo);

        if (is_bool($d) && !$d){

            $d = \Model::factory('VsModulEtkilesim')->create();

            $d->sayfano = $etkilesimNo;
            $d->durumu = 1;
            $d->moduladi = $madi;
            $d->girisadedi = 1;
            $d->kayittarihi = date('d-m-Y H:i:s');
            $d->paket_bilgi = $mb;
            $d->kullanici_bilgi = $kb;
            $d->ip_adresi = $_SERVER['REMOTE_ADDR'];
            
            if ($madi === 'magaza'){

                $d->modul_bilgi = serialize(json_encode(array('siparisNo' => Audit::randStrLight(32))));
            }

            if (isset($_SESSION['hesapno'])){

                $d->kullanici_hesap_bilgi = $_SESSION['hesapno'];
            }
        }else{

            $d->girisadedi = (int)$d->girisadedi + 1;
            $d->paket_bilgi = $mb;
            $d->kullanici_bilgi = $kb;
        }
        
        $d->save();
    }

    /**
     * Tüm modüller için protokole göre aynı olan ekran parçalarını hazırlar
     * 
     * @method onTanimliEkran()
     * @param string $bodyid
     * @param string $bodysinif
     * @return void
     */
    public function onTanimliEkran(?string $bodyid = null,?string $bodysinif = null): void
    {
        if (PROTOKOL === 'http'){

            if ($this->{$this->processUnit} !== null && $this->one === null && $this->uniqueIdentifierProperty === $this->publicIdentifierProperty){

                $this->nesnebul();
            }

            $this->ekran = $this->frame->getHtmlHead($this->headEklentileri()) . $this->vui->startHtmlBody($bodyid,$bodysinif) . $this->modulbilgikutulari . $this->getModuleReport();
        }
    }
}
?>