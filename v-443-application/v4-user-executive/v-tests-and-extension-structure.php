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

final class TesKon002{

    // use SupperGazi;

    use Builder;

    private string $accessUrlString = 'change-to-your-secret-string';

    private array $bildirimler = [
        'TR' => [
			'yok' => 'test için gerekli dizi bulunamadı. Bi nevi yanlış kişi yanlış adres...'
		],
		'EN' => [
			'yok' => 'Wrong test access string.'
		]
	];

    private bool $zipOutputEnabled = true;

    private string $tesKonString;

    private string $tesKonGreet;

    private string|null $tesKonOps;

    private string $tesKonEnd;

    
    public function __construct($up = null,$suan = null,$teskon = null,$moduller = null)
    {
        $this->beginning($up,$suan);

        $this->operations();
           
        $this->ending();

        $this->sendScreen();
        
        exit;
    }
    
    /**
     * @method islem()
     * @return void
     */
    private function operations(): void
    {
        $this->tesKonOps = null;

        

        $this->see(extension_loaded('bz2'));

        $this->see($_SERVER['REMOTE_ADDR']);
    }

    /**
     * @method basla()
     * @param mixed $up
     * @param mixed $suan
     * @param mixed $teskon
     * @param mixed $moduller
     * @param string $tesKonGreet
     * @param string $kapanis
     * @return void
     */
    private function beginning(?array $up,string $suan): void
    {
        Warden::setSession();
        
        $this->setProc($up);

        if ($this->subProcess !== $this->accessUrlString){

            die($this->bildirimler[LANG]['yok']);
        }

        $this->tesKonGreet = $suan . Page::dotLine() . $_SESSION['client_address'] . 
        
        Page::dotLine() . $_SESSION['aktivite'] . Page::dotLine() . 
        
        'Begin Function Memory Usage: ' . round((memory_get_usage() / 1024),3,PHP_ROUND_HALF_UP) . ' KB' . Page::dotLine() . 
        
        'Start dump:<br><br>';
    }

    /**
     * @method kapat()
     * @return void
     */
    private function ending():void
    {
        $this->tesKonEnd = 'Ending Function Memory Usage: ' . round((memory_get_usage() / 1024),3,PHP_ROUND_HALF_UP) . ' KB' . 
        
        Page::dotLine() . 'Memory peak usage: ' . Audit::getLoad();
    }

    /**
     * @method sendScreen()
     * @return void
     */
    private function sendScreen(): void
    {
        $this->tesKonString = $this->tesKonGreet . $this->tesKonOps . $this->tesKonEnd;

        if ($this->zipOutputEnabled && ob_start('ob_gzhandler',0,PHP_OUTPUT_HANDLER_STDFLAGS)){

            echo $this->tesKonString;

            if (str_contains($_SERVER['SERVER_SOFTWARE'],'Development')){

                header('Content-Lenght: ' . ob_get_length());
            }

            $result = ob_end_flush();
        }else{

            echo $this->tesKonString;
        }
    }

    /**
     * @method see()
     * @param mixed $what
     * @return void
     */
    private function see(mixed $what): void
    {
        if ($this->zipOutputEnabled){

            $this->tesKonOps .= '<pre>' . gettype($what) . ' - ' . var_export($what,true) . '</pre>' . Page::dotLine();
        }else{

            Debug::see($what);
        }
    }

    /**
     * @method oldOperations()
     * @return void
     */
    private function oldOperations(): void
    {
        $this->tesKonOps = null;

        // Debug::see(KlasikKullanici::kullaniciAdresVer());

        

        // Debug::see(preg_match("/((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,20})/", '____!kusBo-Cek'));

        


        

        // $i = new MerhabaInstagram002([]);

        // $i->calistir('gonderi-yenile');

        // KlasikUrun::kategoriListesiCsv();

        
        // Debug::see(KlasikModulIslemleri::modulOzellikleriVer('urun'));

        

        /* $b = new VeritabaniIslemleri;

        $b->vt()->vta('verisanat')->tabloYarat('modul-destek'); */

        
        
        // $s = new KlasikSiteIslemleri;

        // $s->siteHaritasiVer(true);

        // $s->vitrinHaritasiVer();

    }
}


class KlasikHttpIslemleri{

    public static function postDebug(): void
    {
        // max_input_vars
        Debug::see(count($_POST)); Debug::see($_POST); exit;
    }

    public static function postVerisi(): string
    {
        $fkapsa = '<form enctype="multipart/form-data" accept-charset="utf-8" action="">%s</form>';

        $satirlar = null;
        for($a = 0; $a < 32; $a++){

                $satirlar .= '<input type="text" name="zurna'. $a .'" value="' . ($a + 5) * 2 . '">';
        }

        $form = sprintf($fkapsa,$satirlar);

        return $form;
    }
}

class KlasikLisanIslemleri{

    public function ceviriKontrol(): void
    {
        /* require_once RELEASE . '-application/dil-paketi/ingilizce.php';

        $anahtar = array(); $veri = array();
        
        $s = 0;
        foreach($translate as $t => $v){

            if (array_key_exists($t,$anahtar)){

                echo $t . ' var zaten'; exit;
            }

            $anahtar[] = $t;

            if (in_array($v,$veri)){

                echo $v . ' tanımı var zaten '; exit;
            }

            $veri[] = $v;

            $s++;
        }

        echo 'islem adedi: '; Debug::see($s);

        echo 'ingilizce ana adet: '; Debug::see(count($translate)); */


        /////////


        /* require_once RELEASE . '-application/dil-paketi/turkce.php';

        $anahtar = array(); $veri = array();
        
        $s = 0;
        foreach($ceviri as $t => $v){

            if (array_key_exists($t,$anahtar)){

                echo $t . ' var zaten'; exit;
            }

            $anahtar[] = $t;

            if (in_array($v,$veri)){

                echo $v . ' tanımı var zaten '; exit;
            }

            $veri[] = $v;

            $s++;
        }

        echo 'islem adedi: '; Debug::see($s);

        echo 'turkce ana adet: '; Debug::see(count($ceviri));

        $yeniTurkceDosya = null; $yeniIngilizceDosya = null;

        $var = 0;
        foreach($ceviri as $t => $v){

            if (array_key_exists($t,$translate)){

                $var++;

                $yeniTurkceDosya .= "'" . $t . "'" . " => " . "'" . $v . "'," . PHP_EOL;

                $yeniIngilizceDosya .= "'" . $t . "'" . " => " . "'" . $translate[$t] . "'," . PHP_EOL;
            }
        }

        // file_put_contents(RELEASE . '-application/dil-paketi/yeni-turkce.php',$yeniTurkceDosya);

        // file_put_contents(RELEASE . '-application/dil-paketi/yeni-ingilizce.php',$yeniIngilizceDosya);

        exit; */


        //////////

        $d = new Language('turkce');

        $g = 0;
        foreach($d->getLangPack() as $t => $v){

            Debug::see($v);

            if ($g === 5){

                exit;
            }

            /* if (isset($v[0]) && !isset($v[1])){

                echo 'eksik ceviri: ' . $v;
            } */

            $g++;
        }
    }
}


class KlasikModulIslemleri{

    public const modulIslemOgeler = array(
        0 => array(
            'adi' => 'versiyon',
            'okunur' => VER,
            'tipi' => 'text',
            'zorunlu' => false
        ),
        1 => array(
            'adi' => 'moduladi',
            'okunur' => 'Modül Adı',
            'tipi' => 'text',
            'zorunlu' => true
        ),
        2 => array(
            'adi' => 'adi',
            'okunur' => 'Görünen Adı',
            'tipi' => 'text',
            'zorunlu' => true
        ),
        3 => array(
            'adi' => 'processInterface',
            'okunur' => 'Arayuz Adı - /islem adı',
            'tipi' => 'text',
            'zorunlu' => true
        ),
        4 => array(
            'adi' => 'operationInterface',
            'okunur' => 'Yönetim Paneli için Tanımlayıcı İşlem Adı - /yeni-modul-islemler',
            'tipi' => 'text',
            'zorunlu' => true
        ),
        5 => array(
            'adi' => 'parcalar',
            'okunur' => 'Arayüzün alabileceği alt işlem adedi - 2 / 6',
            'tipi' => 'tamsayi',
            'zorunlu' => true
        ),
        6 => array(
            'adi' => 'dbTableName',
            'okunur' => 'Veritabanı kullanılıyorsa tablo adı - VsModulYenimodul',
            'tipi' => 'text',
            'zorunlu' => true
        ),
        7 => array(
            'adi' => 'veripaylasimi',
            'okunur' => 'Veritabanı kullanılıyorsa diğer moduller ile tablo paylaşımı',
            'tipi' => 'bool',
            'zorunlu' => false
        ),
        8 => array(
            'adi' => 'etkilesim',
            'okunur' => 'GELİŞTİRİLEN ÖZELLİK - Veritabanı kullanılıyorsa Etkileşime gireceği modül tabloları',
            'tipi' => 'text',
            'zorunlu' => false
        ),
        9 => array(
            'adi' => 'apcokluislemler',
            'okunur' => 'Yönetim paneli içinde çoklu işlem kabiliyeti tanınsın mı',
            'tipi' => 'bool',
            'zorunlu' => false
        ),
        10 => array(
            'adi' => 'fotocop',
            'okunur' => 'Yönetim paneli içinde hiçbir öğesine kayıtlı olmayan fotoğraflar ve belgeler silinebilsin mi',
            'tipi' => 'bool',
            'zorunlu' => false
        ),
        11 => array(
            'adi' => 'ogefoto',
            'okunur' => 'Öğeleri fotoğraf barındırıyor mu',
            'tipi' => 'bool',
            'zorunlu' => false
        ),
        12 => array(
            'adi' => 'ogekategori',
            'okunur' => 'Öğeleri uygulama kategorilerine dahil mi',
            'tipi' => 'bool',
            'zorunlu' => false
        ),
        13 => array(
            'adi' => 'apolustur',
            'okunur' => 'Yönetim paneli için Öğe Oluşturma isimleri - yenimodul,yeni-modul,Yeni Modül',
            'tipi' => 'virgul',
            'zorunlu' => true
        ),
        14 => array(
            'adi' => 'apyonet',
            'okunur' => 'Yönetim paneli için Öğe Yönetim isimleri - yenimodul,yenimodul-islemleri,Yeni Modül Yönetimi',
            'tipi' => 'virgul',
            'zorunlu' => true
        ),
        15 => array(
            'adi' => 'sinifadi',
            'okunur' => 'Modül Sınıf Adı, Belirleyici eşsiz karakter(ler) [a-z] - y / ym',
            'tipi' => 'text',
            'zorunlu' => true
        ),
        16 => array(
            'adi' => 'id',
            'okunur' => 'Modül Tanımlayıcı Fonksiyon Adı, Sınıf Adı + islem - yislem',
            'tipi' => 'text',
            'zorunlu' => true
        ),
        17 => array(
            'adi' => 'apgalanlari',
            'okunur' => 'Modül Öğeleri için veritabanından değiştirilebilir özellikler, tablo sutunlari ve nitelikleri - ARRAY',
            'tipi' => 'dizi',
            'zorunlu' => false
        ),
        18 => array(
            'adi' => 'apkalanlari',
            'okunur' => 'Modül Öğeleri için değiştirilemez eşsiz sabitler',
            'tipi' => 'virgul',
            'zorunlu' => false
        ),
        19 => array(
            'adi' => 'uniqueIdentifierProperty',
            'okunur' => 'Modül için öğeleri belirleyici eşsiz alan adı - varsayılan: gorunenadi / sayfano',
            'tipi' => 'text',
            'zorunlu' => false
        ),
        20 => array(
            'adi' => 'processUnit',
            'okunur' => 'Modül için uygulama katmanından işsiz belirleyiciyi alacağı yer - islem / ekislem / bir / iki. varsayılan: ekislem',
            'tipi' => 'text',
            'zorunlu' => false
        ),
        21 => array(
            'adi' => 'listeverisi',
            'okunur' => 'Yönetim paneli için listeleme kullanılacak tablo sütun adları. - ARRAY - adi,baslik,fiyati',
            'tipi' => 'dizi',
            'zorunlu' => false
        ),
        22 => array(
            'adi' => 'listebasliklari',
            'okunur' => 'Yönetim paneli için listeleme kullanılacak sütun adı okunur . - ARRAY - Adı,Başlık,Fiyatı',
            'tipi' => 'dizi',
            'zorunlu' => false
        ),
        23 => array(
            'adi' => 'veriadi',
            'okunur' => 'Diğer modüllere veri paylaşımı açıksa, modulVerisiAl() da kullanılacak belirleyici isim - Dergi için (tomar)',
            'tipi' => 'text',
            'zorunlu' => false
        ),
        24 => array(
            'adi' => 'yapidegistir',
            'okunur' => 'Hazır Özelliklerle (trait) gelen yapıya ait değişkenleri değiştirmek için verilen dizi - ARRAY',
            'tipi' => 'dizi',
            'zorunlu' => false
        ),
        25 => array(
            'adi' => 'cercevedegistir',
            'okunur' => 'Hazır Özelliklerle (trait) gelen çerçeveye ait değişkenleri değiştirmek için verilen dizi - ARRAY',
            'tipi' => 'dizi',
            'zorunlu' => false
        ),
        26 => array(
            'adi' => 'etkinarayuz',
            'okunur' => 'Modul arayuzu işlem değişkenleri (ekislem / bir / iki) olmadan faal olabilir yada olamaz.',
            'tipi' => 'bool',
            'zorunlu' => false
        )
    );

    public array $kaldirilanModulOzellikleri = [
        26 => array(
            'adi' => 'istemciyeozguekran',
            'okunur' => 'Masa üstü, telefon veya başka cihazlar için farklı ekran tipi verilecek mi',
            'tipi' => 'bool',
            'zorunlu' => false
        ),
    ];

    public static function modulOzellikleriVer(string $modulAdi): array
    {
        $d = new System\Dos;

        $urunModul = $d->cd(RELEASE . '-module' . '/' . 'module-configurations')->f('modul-islemler-' . $modulAdi . '.json')->read('json')->getData(true);

        unset($dos);

        return array_keys($urunModul[$modulAdi]);
    }
}

class KlasikSiteIslemleri{

    public string $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">%s</urlset>' . PHP_EOL;

    public string $url = '<url>
    <loc>%s</loc>
    <lastmod>%s</lastmod>
    <changefreq>weekly</changefreq>
    <priority>%s</priority>
    </url>' . PHP_EOL;

    public function siteHaritasiVer(bool $yeni = false): void
    {
        $hepsi = \Model::factory('VsModulUrun')->findMany();

        $urlListesi = null;
        foreach($hepsi as $t){

            $urlListesi .= sprintf($this->url,ADDRESS . '/' . 'urunler' . '/' . $t->gorunenadi,date('Y-m-d',strtotime('- 5 days')),'0.9');
        }

        $xml = sprintf($this->xml,$urlListesi);

        $d = new System\Dos;

        if ($yeni){

            $d->cd('lokal-klasor')->fileType('xml')->newFile('sitemap.xml',true)->write($xml);
        }else{

            $d->cd('lokal-klasor')->f('sitemap.xml')->write($xml);
        }
    }

    public function vitrinHaritasiVer(): void
    {
        $liste = array('yeni-urunler','giyim','aksesuar','taki','piercing','gozluk','aydinlatma','hediyelik','kirtasiye','canta-cuzdan');

        $vitrin= null;
        foreach($liste as $t){

            $vitrin .= sprintf($this->url,ADDRESS . '/' . 'vitrin' . '/' . $t,date('Y-m-d',strtotime('- 10 days')),'0.8');
        }

        echo $vitrin;
    }
}



class KlasikKripto{

    public static function anahtarYarat(): void
    {
        $privateKeyResource = openssl_pkey_new(
            [
                'config' => BASE . '/' . RELEASE . '-configuration/system-files/openssl.cnf'
            ]
        );
        
        openssl_pkey_export_to_file($privateKeyResource, BASE . '/' . 'private-key-resource.key',null,['config' => BASE . '/' . RELEASE . '-configuration/system-files/openssl.cnf']);
        
        $privateKeyDetailsArray = openssl_pkey_get_details($privateKeyResource);

        openssl_pkey_export($privateKeyResource,$anahtar,null,['config' => BASE . '/' . RELEASE . '-configuration/system-files/openssl.cnf']);

        file_put_contents(BASE . '/' . 'dosya.pem',$anahtar);
        
        file_put_contents(BASE . '/' . 'public-key.key', $privateKeyDetailsArray['key']);
    }
}

class KlasikKullanici{

    public static function getPass(string $s): string
	{

        return sodium_crypto_pwhash_str($s,SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE);
    }
}


class VeritabaniIslemleri{

    /**
     * $v = new VeritabaniIslemleri;
     * 
     * $v->vt()->vta('veritabani-adi')->tabloYarat('tablo-adi');
     * 
     */

    private string $veriTabaniTipi;

    private string $veriTabaniAdi;

    /**
     * Veritabanı Adı
     * 
     * @method vta()
     * @param string $adi
     * @return object
     */
    public function vta(string $adi): object
    {
        $this->veriTabaniAdi = $adi;

        return $this;
    }

    /**
     * Veritabanı Tipi - mysql
     * @method vt()
     * @param string $vtTipi
     * @return object
     */
    public function vt(string $vtTipi = 'mysql'): ?object
    {
        if (DATABASETYPE === $vtTipi){
            
            $this->veriTabaniTipi = $vtTipi;
        }else{

            die('uygulama için ' . $vtTipi . ' tanımlı değil.');
        }

        return $this;
    }

    public function tabloYarat(string $tabloAdi): object
    {
        $dos = new System\Dos;

        if ($dos->cd(RELEASE . '-configuration/veritabani')->fileExists('vs-vt-' . $this->veriTabaniTipi . '-' . $tabloAdi . '.sql')){
            
            $komutDosyasi = $dos->f('vs-vt-' . $this->veriTabaniTipi . '-' . $tabloAdi . '.sql')->read('sql')->getData();
        }else{

            die('SQL direktifi içeren dosya bulunamadı.');
        }

        unset($dos);

        $kd = str_replace('verisanat_db',$this->veriTabaniAdi,$komutDosyasi);

        try{

            \ORM::rawExecute($kd);
        }catch(\Exception $h){

            Scribe::sysLog('tablo yaratılamadı: ' . $h->getMessage());
        }

        return $this;
    }
}
?>