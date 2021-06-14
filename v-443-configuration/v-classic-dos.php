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

namespace VTS\System;

use VTS\Scribe;

final class VerisanatDosException extends \Exception{

}

/**
 * When extending Dos, you should use file names in the following format:
 * file-name.ext  /  word + dash + word + . + extension
 * 
 * @example $dos = new Dos;
 * 
 *          $dos->cd('folder-name)->f('file-name.ext')->read();
 * 
 * Dosya adları kelime + tire + kelime + .uzantı olarak verilmelidir.
 * Örn, bu-bir-dosya-adidir.php olarak verin.
 */

final class Dos{

    /**
     * @var bool $debugMode
     */
    private bool $debugMode = false;
    /**
     * @var string $icYapiKlasorTipi
     */
    private string $icYapiKlasorTipi = 'v4';
    /**
     * @var array $klasorYapisiHazir
     */
    private array $klasorYapisiHazir = [
        'yapilandir',
        'yonet',
        'user',
        'classic',
        'ftemp'
    ];
    /**
     * @var array $dosBilgi
     */
    private array $dosBilgi = [
        'd_yok' => 'Belirtilen klasorde dosya bulunamadı.'
    ];
    /**
     * File types can be read in Verisanat.
     * 443 OSS version does not contain this readability.
     * 
     * yazılımda çalışabilecek ve okunabilecek dosya tiplerini barındırır.
     * 
     * @var array $dosyatipleri
     */
    private $dosyatipleri = [
        'text/x-c' => 'c,cc,cxx,cpp,h,hh,dic',
        'text/x-java-source' => 'java',
        'application/javascript' => 'js',
        'application/java-archive' => 'jar',
        'application/json' => 'json',
        'application/octet-stream' => 'bin,dms,lrf,mar,so,dist,distz,pkg,bpk,dump,elc,deploy',
        'application/pdf' => 'pdf',
        'application/xml' => 'xml',
        'application/zip' => 'zip',
        'text/x-php' => 'php',
        'text/plain' => 'html',
        'text/plain' => 'css',
        'text/plain' => 'txt',
        'text/plain' => 'vsda',
        'text/plain' => 'vsdax',
        'text/plain' => 'vsdm',
        'image/gif' => 'gif',
        'image/png' => 'png',
        'image/jpeg' => 'jpg',
        'image/jpeg' => 'jpeg'
    ];
    /**
     * @var string $kayittipi
     */
    private $kayittipi;
    /**
     * işlem sonucu barındırır. hata durumu false, hatasız true.
     * 
     * @var bool $hata 
     */
    private bool $hata = false;
    /**
     * dosya uzantisi
     * 
     * @var string $uzanti 
     */
    private string $extension;
    /**
     * aktif kullanılan dosya adı
     * 
     * @var string $activeFileName
     */
    private string $activeFileName;
    /**
     * İşlem yapılacak dosyalar
     * 
     * @var array $dosyaDizi
     */
    private array $dosyaDizi;
    /**
     * aktif kullanılan klasor  - cd(klasor)
     * 
     * @var string $activeFolderName
     */
    private string $activeFolderName;
    /**
     * aktif dosya içeriği
     * 
     * @var string $activeFileData
     */
    private string|null $activeFileData;
    /**
     * Carbon fonksiyonlarına göre düzenlenmiştir.
     * 
     * @var array $zamanOlculer
     */
    private array $zamanOlculer = array(
        'older' => 'greaterThan',
        'younger' => 'lessThan',
        'same' => 'equalTo',
        'different' => 'notEqualTo'
    );

    /**
     * dosya tipini ($uzanti) döndürür.
     * 
     * @method getFileExtension()
     * @return string $uzanti
     */
    public function getFileExtension(): string
    {
        return $this->extension;
    }

    /**
     * dosya tipini uzanti ya atar
     * 
     * @method fileType()
     * @param string $a dosya uzantısı
     * @return Dos
     */
    public function fileType(string $a): Dos
    {
        $this->extension = $a;

        return $this;
    }

    /**
     * @method useFileTemplate()
     * @param string $a uzantı olmadan dosya adı
     * @return Dos
     */
    public function useFileTemplate(string $a): Dos
    {
        $this->extension = 'vsda';

        $this->activeFileData = file_get_contents(BASE . '/' . RELEASE . '-configuration' . '/' . 'file-templates' . '/' . $a . '.' . $this->extension);

        return $this;
    }

    /**
     * 
     * 
     * @method errorCheck() 
     * @return bool $hata
     */
    public function errorCheck(): bool
    {
        return $this->hata;
    }

    /**
     * @method folderHasAny()
     * @return bool
     */
    public function folderHasAny(): bool
    {
        $bak = new \FileSystemIterator($this->activeFolderName);

        return $bak->valid();
    }

    /**
     * içeriği döndürür
     * 
     * @method getData() 
     * @param bool $array içeriğe göre kontrol sağlar. True ise json decode edilir array e çevrilir.
     * @return mixed|object|array|string
     */
    public function getData(bool $array = false)
    {
        if ($this->extension === 'json'){

            return json_decode($this->activeFileData,$array);
        }else{

            return $this->activeFileData;
        }
    }

    /**
     * @method secureVsdaFile() vsda dosya içeriğindeki zararlılardan kurtulur
     * @param string $a
     * @return void
     */
    public function secureVsdaFile(string $a): void
    {
        $kurtul = [
            '<?php',
            '?>',
            '%',
            '<?'
        ];

        $degistir = [null];

        $this->activeFileData = str_replace($kurtul,$degistir,$a);
    }

    /**
     * vsda dosya içeriğindeki zararlılardan kurtulur
     * 
     * @method secureVsdmFile() 
     * @param string $a
     * @return void
     */
    public function secureVsdmFile(string $a): void
    {
        $kurtul = [
            '<?php',
            '?>',
            '<?',
            '<script',
            '</script'
        ];

        $degistir = [null];

        $this->activeFileData = str_replace($kurtul,$degistir,$a);
    }

    /**
     * sql dosya içeriğindeki zararlılardan kurtulur
     * @method secureSqlFile()
     * @param string $a
     * @return void
     */
    public function secureSqlFile(string $a): void
    {
        $kurtul = [
            '<?php',
            '?>',
            '<?',
            '{',
            '}'
        ];

        $degistir = [null];

        $this->activeFileData = str_replace($kurtul,$degistir,$a);
    }

    /**
     * içerik içindeki zararlılardan "kurtulmaya çalışır", büyük olasılıkla kurtulur da.
     * 
     * @method secureHtmlFile() 
     * @param string $a
     * @return Dos
     */
    public function secureHtmlFile(string $a): Dos
    {
        $kurtul = [
            ';',
            '%',
            '(',
            ')',
            "'",
            '<?php',
            '?>',
            '{',
            '}',
            ']',
            '[',
            '\\',
            '$',
            '<script',
            '</scri',
            '&#59;',
            '\u003B',
            '&#13;',
            '%3F'
        ];

        $degistir = array("noktalivirgul","&#37;","&#40;","&#41;","&apos;","tag10","tag15","&#123;","&#125;","&#93;","&#91;","&#92;&#92;","&#36;","tag20","tag25","noktalivirgul2","noktalivirgul3","htmlenter","&#63;");

        $this->activeFileData = str_replace($kurtul,$degistir,$a);

        return $this;
    }

    /**
     * dosyayı içeriğe atar - $this->activeFileData
     * 
     * @method read() 
     * @param string $fileType json - html - php - js - css - vsda
     * @return Dos
     */
    public function read(string $fileType = 'html'): Dos
    {
        switch($fileType):

            case 'html':

                $this->secureHtmlFile(trim(file_get_contents($this->activeFileName)));

                $this->extension = 'html';

            break;
            case 'vsda':

                $this->secureVsdaFile(trim(file_get_contents($this->activeFileName)));

                $this->extension = 'vsda';

            break;
            case 'vsdm':

                $this->secureVsdmFile(trim(file_get_contents($this->activeFileName)));

                $this->extension = 'vsdm';

            break;
            case 'json':

                $this->secureVsdaFile(trim(file_get_contents($this->activeFileName)));

                $this->extension = 'json';

            break;
            case 'jpg':

                    // exif contents filtered.

            break;
            case 'jpeg':

                    // exif contents filtered.
                    
            break;
            case 'sql':

                $this->secureSqlFile(trim(file_get_contents($this->activeFileName)));

                $this->extension = 'sql';

            break;
            case 'vsdax':

                $this->activeFileData = file_get_contents($this->activeFileName);

                $this->extension = 'vsdax';
            break;
            case 'vsdaxh':

                $this->activeFileData = file_get_contents($this->activeFileName);

                $this->extension = 'vsdaxh';
            break;
            case 'xml':

                $this->activeFileData = file_get_contents($this->activeFileName);

                $this->extension = 'xml';
                
            break;
        endswitch;

        return $this;
    }

    /**
     * verilen içeriği dosyaya yazar - f('falanca.html)->write($data,'arttir / yenile')
     * 
     * @method write() 
     * @param mixed $data yazılacak dosya içeriği - sablondan gelmediyse zorunlu - string - array(1) - stream
     * @param string $method varsayılan over, append - renew, log
     * @return Dos
     */
    public function write($data = null,string $method = 'over'): Dos
    {
        $data = $data ?: $this->activeFileData;

        try{

            switch($method):

                case 'over':

                    $this->extension === 'json' ? file_put_contents($this->activeFileName,json_encode($data)) : file_put_contents($this->activeFileName,$data);

                break;

                case 'append':

                    file_put_contents($this->activeFileName,$data,FILE_APPEND | LOCK_EX);

                break;

                case 'log':

                    $satir = \VTS\Audit::dateTime() . ',' . $data . PHP_EOL;

                    file_put_contents($this->activeFileName,$satir,FILE_APPEND | LOCK_EX);
                break;

            endswitch;

        }
        catch(\Exception $hata){

            \VTS\Scribe::appLog('File couldnt be written to disk: ' . $this->activeFileName . '|' . $hata->getMessage());

            $this->hata = true;
        }


        return $this;
    }

    /**
     * ilgili klasoru siler
     * 
     * @method deleteFolder 
     * @return Dos
     */
    public function deleteFolder(): Dos
    {
        $this->kayittipi = 'Folder - DOS - ' . $this->activeFolderName;

        try{

            if (isset($this->activeFolderName)){
                
                rmdir($this->activeFolderName);
            }
        }
        catch(\Exception $hata){

            \VTS\Scribe::appLog($this->kayittipi . ' : ' . $hata->getMessage());

            $this->hata = true;
        }

        return $this;
    }

    /**
     * ilgili dosyayı siler
     * 
     * @method deleteFile 
     * @return void
     */
    public function deleteFile(): void
    {
        $this->kayittipi = 'File - DOS - ' . $this->activeFileName;

        try{

            if (isset($this->activeFileName)){
                
                unlink($this->activeFileName);
            } 
        }
        catch(\Exception $hata){

            \VTS\Scribe::appLog($this->kayittipi . ' : ' . $hata->getMessage());

            $this->hata = true;
        }
    }

    /**
     * assign new file name - if write is true creates it empty
     * 
     * yeni dosya adını atar, $write verilirse dosyayı yaratır
     * tip json ise formatı yaratır {}
     * 
     * @method newFile() 
     * @param string $a dosya adı
     * @param bool $write
     * @return Dos
     */
    public function newFile(string $a = null,bool $write = false): Dos
    {
        isset($a) ? $this->activeFileName = $this->activeFolderName . '/' . $a : $this->activeFileName = null;

        if ($write){
            
            $this->getFileExtension() === 'json' ? file_put_contents($this->activeFileName,'{}') : file_put_contents($this->activeFileName,null);
        }

        return $this;
    }

    /**
     * attempts to set active file name
     * 
     * aktif kullanılacak dosyayı atar
     * 
     * @method f()
     * @param string $a file name - with extension
     * @return Dos
     */
    public function f(string $a = null): Dos
    {
        if (isset($a) && $this->fileExists($a)){
            
            $this->activeFileName = $this->activeFolderName . '/' . $a;
        }else{
            
            throw new VerisanatDosException($this->dosBilgi['d_yok']);
        }

        return $this;
    }

    /**
     * set file list as array to compare
     * 
     * @method files()
     * @param array $list  - dosya adlarından oluşan (2) basit list
     * @return Dos
     */
    public function files(array $list): Dos
    {
        if (count($list) === 2 && $this->fileExists($list[0]) && $this->fileExists($list[1])){
            
            $this->dosyaDizi = $list;
        }

        return $this;
    }

    /**
     * for testing / dev purposes, quick set file name without checking
     * 
     * seri dosya yaratımı ve yazma işlemleri için kullanılır.
     * genellikle test amaçlı kullanılır. kontrol yoktur.
     * (  newFile() ve fileType() da kullanilabilir ) 
     * 
     * @method quickFile()
     * @param string $a full file name
     * @param string $u ext
     * @return Dos 
     */
    public function quickFile(string $a,string $u = null): Dos
    {
        $this->activeFileName = $this->activeFolderName . '/' . $a;

        isset($u) ? $this->extension = $u : $this->extension = null;

		Scribe::sysLog('Dos - quickFile used, file name: ' . $a);

        return $this;
    }

    /**
     * aktif kullanılan klasoru dondurur
     * 
     * @method getFolder() 
     * @return string $klasor
     */
    public function getFolder(): string
    {
        return $this->activeFolderName;
    }

    /**
     * aktif kullanılan dosya adını dondurur
     * 
     * @method getFile()
     * @return string $dosya
     */
    public function getFile(): string
    {
        return $this->activeFileName;
    }

    /**
     * change directory - can be used to create also
     * 
     * aktif olarak kullanılacak klasor
     * 
     * @method cd()
     * @param string $yol ust-klasor/alt-klasor - klasor
     * @param bool $create
     * @return Dos
     */
    public function cd(string $path = null,$create = false): Dos
    {
        if ($create){

            isset($path) && !$this->folderExists($path) ? mkdir(BASE . '/' . $path,0755,true) : \VTS\Http::guide(ADDRESS,'bilgi','Process stopped. Folder already exists.');

            $this->activeFolderName = BASE . '/' . $path;
        }else{

            if (is_null($path)){

                $this->activeFolderName = BASE;

                return $this;
            }

            if (isset($path) && $this->folderExists($path)){
                
                $this->activeFolderName = BASE . '/' . $path;
            }
            
            if (isset($path) && !$this->folderExists($path)){

                $this->hata = true;
                
                $this->activeFolderName = BASE;

                $this->showMad('There is no such directory. Folder is set to BASE');
            }
        }

        return $this;
    }

    /**
     * glob pattern şeklinde verilmiş dosyalar array ini verir cd(klasor) dir(*.jpg)
     * 
     * @method dir() 
     * @param string $oz - *.bat - getData*.ini
     * @return array
     */
    public function dir(string $oz): array
    {
        return glob($this->activeFolderName . '/' . $oz);
    }

    /**
     * tüm klasor ağacında yer alan dosyaları verir. cd(klasor) dirtam(altklasor)
     * 
     * @method dirTree() 
     * @param string $oz - yol
     * @param string|null $altoz .jpg tüm ağaçtaki jpg leri verir. 
     * @return object|array $altoz belirtilmişse array, yoksa object. obje içinde tüm dosyalar, . ve .. gibi directory bilgileri de vardır.
     */
    public function dirTree(string $oz,string $altoz = null): Dos|array
    {
        $dosyalar = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->activeFolderName . '/' . $oz), \RecursiveIteratorIterator::SELF_FIRST);
        
        if (isset($altoz)){

            foreach($dosyalar as $tek){

                $her = $tek->getFileName();

                if ($her === '.' || $her === '..' || !is_int(strpos($her,$altoz))){
                    
                    continue;
                }

                $yeni[] = $tek->getPathName();
            }

            return $yeni;
        }

        return $dosyalar;
    }

    /**
     * $a klasörü __DIR__ ye bağlı olarak var mı bakar
     * 
     * @method folderExists() 
     * @param string $a ust-klasor/alt-klasor - klasor
     * @return bool
     */
    public function folderExists(string $a): bool
    {
        return is_dir(BASE . '/' . $a);
    }

    /**
     * hali hazırda yoksa tam yol ile DIR e bağlı klasör yaratır.
     * 
     * @method md() 
     * @param string $a yeni klasör adı
     * @return void
     */
    public function md(string $a): void
    {
        if (!is_dir($a)){

            mkdir($a,0755);
        }
    }

    /**
     * $a dosyası __DIR__ ye bağlı olarak var mı bakar
     * 
     * @method fileExists() 
     * @param string $a dosya-adi.html
     * @return bool
     */
    public function fileExists(string $a): bool
    {
        $this->ayikla($a);

        $d = file_exists($this->activeFolderName . '/' . $a);

        return $d;
    }

    /**
     * tipik mime tipli dosyaları (css,js vb) kontrol eder ve dosya tipini $uzantı ya atar
     * 
     * @method ayikla()
     * @param string $dosyaadi
     * @return Dos
     */
    public function ayikla(string $dosyaadi): Dos
    {
        $d = pathinfo($this->activeFolderName . '/' . $dosyaadi);

        $tipi = $d['extension'];

        /* $tip = null;

        foreach($this->dosyatipleri as $h => $v){

            if (mime_content_type($dosyaadi) === $h){

                $tip = $v;

                break;
            } 
        } */

        /* isset($tip) && $tip === $tipi[1] && !isset($tipi[2]) ? $this->fileType = $tip : $this->write(new KontrolYapi('Dos - ayikla',$this->activeFileName . '-' . 'dosya uzantısı dosya tipi ile eşleşmiyor.',8,5),'log'); */

        $this->fileType($tipi);

        return $this;
    }

    /**
     * @method folderDifferences()
     * @param string $firstFolder
     * @param string $secondFolder
     * @param bool $folderVersion
     * @return mixed|string|object $farklar
     */
    public function folderDifferences(string $firstFolder,string $secondFolder,bool $folderVersion = false,bool $getHtmlList = true)
    {
        $farklar = null;
        
        $a = 0;

        $this->cd($firstFolder); $birDosyalari = $this->dir('*.*'); $birDosyalari = array_map('basename',$birDosyalari);

        $this->cd($secondFolder); $ikiDosyalari = $this->dir('*.*'); $ikiDosyalari = array_map('basename',$ikiDosyalari);

        $this->distinctFiles = $folderVersion ? array_diff_assoc($birDosyalari,$ikiDosyalari) : array_diff($ikiDosyalari,$birDosyalari);

        if ($getHtmlList){

            foreach($this->distinctFiles as $t){

                $farklar .= $a . '. ' . $t . '<br>';

                $a++;
            }

            return $farklar;
        }else{

            return $this;
        }
    }

    /**
     * @method folderMatches()
     * @param string $firstFolder
     * @param string $secondFolder
     * @return mixed|string|object $esler
     */
    public function folderMatches(string $firstFolder,string $secondFolder,bool $getHtmlList = true)
    {
        $esler = null;
        
        $a = 0;

        $this->cd($firstFolder); $birDosyalari = $this->dir('*.*'); $birDosyalari = array_map('basename',$birDosyalari);

        $this->cd($secondFolder); $ikiDosyalari = $this->dir('*.*'); $ikiDosyalari = array_map('basename',$ikiDosyalari);

        $this->sameFiles = array_intersect($birDosyalari,$ikiDosyalari);

        if ($getHtmlList){

            foreach($this->sameFiles as $t){

                $esler .= $a . '. ' . $t . '<br>';
                
                $a++;
            }

            return $esler;
        }else{

            return $this;
        }
    }

    /**
     * @method compareFiles()
     * @param string $criteria type of comparison - time.
     * @param string $measure comparison measure - older - younger - same - different
     * @return bool
     */
    public function compareFiles(string $criteria,string $measure): bool
    {
        $sonuc = false;

        if (isset($this->dosyaDizi)){

            switch($criteria):

                case 'time':

                    require_once BASE . '/' . RELEASE . '-external-sources' . '/' . 'Carbon.php';

                    $birinciDosya = \Carbon\Carbon::parse(date('d-m-Y H:i:s',filemtime($this->activeFolderName . '/' . $this->dosyaDizi[0])));

                    $kiyaslanacakDosya = \Carbon\Carbon::parse(date('d-m-Y H:i:s',filemtime($this->activeFolderName . '/' . $this->dosyaDizi[1])));

                    if ($birinciDosya->{$this->zamanOlculer[$measure]}($kiyaslanacakDosya)){
                        
                        $sonuc = true;
                    }

                break;

            endswitch;
        }

        return $sonuc;
    }

    /**
     * @method hazirSablon()
     * @return Dos
     */
    private function hazirSablon(): Dos
    {
        $this->cd(RELEASE . '-configuration' . '/' . 'file-templates');

        return $this;
    }

    /**
     * @method hazirYapilandir()
     * @return Dos
     */
    private function hazirYapilandir(): Dos
    {   
        $this->cd(RELEASE . '-configuration');

        return $this;
    }

    /**
     * @method hazirYonet()
     * @return Dos
     */
    private function hazirYonet(): Dos
    {
        $this->cd(RELEASE . '-application' . '/' . $this->icYapiKlasorTipi . '-yonetici');

        return $this;
    }

    /**
     * @method hazirKullanici()
     * @return Dos
     */
    private function hazirKullanici(): Dos
    {
        $this->cd(RELEASE . '-application' . '/' . $this->icYapiKlasorTipi . '-user');

        return $this;
    }

    /**
     * @method hazirKlasik()
     * @return Dos
     */
    private function hazirKlasik(): Dos
    {
        $this->cd(RELEASE . '-application' . '/' . $this->icYapiKlasorTipi . '-internal-classics');

        return $this;
    }

    /**
     * @method const
     */
    public function __construct(?string $kl = null)
    {
        $this->icYapiKlasorTipi = substr(RELEASE,0,1) . substr(RELEASE,3,1);

        if (!is_null($kl) && in_array($kl,$this->klasorYapisiHazir)){

            match($kl){
                'yapilandir' => $this->hazirYapilandir(),
                'yonet' => $this->hazirYonet(),
                'user' => $this->hazirKullanici(),
                'classic' => $this->hazirKlasik(),
                'ftemp' => $this->hazirSablon()
            };
        }
    }

    /**
     * @method mad()
     * @return Dos
     */
    public function mad(): Dos
    {
        $this->debugMode = true;

        return $this;
    }

    /**
     * @method show()
     * @param string $e
     * @return void
     */
    private function showMad(string $e): void
    {
        if ($this->debugMode){

            throw new VerisanatDosException($e);
        }
    }
}
?>