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
 *                          verisanat@outlook.com
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

trait AbilityModulePage{

    /**
     * Html dosya test fonksiyonu. Dos kullanmaz
     * 
     * @method htmlTest() istenen tam html dosyasını okur ve dondurur
     * @param string $dosya dosya adı ve uzantısı  test-dosyasi.html
     * @return string $testortami
     */
    public function htmlTest(string $dosya = null): string
    {
        $this->testortami = isset($dosya) && file_exists($this->testortamyolu . $dosya) ? file_get_contents($this->testortamyolu . $dosya) : null;

        return $this->testortami;
    }

    /**
     * HTML parçaları (body ve head içermeyen) Dos kullanarak okur ver içeriğini döndürür
     * 
     * @method htmlKullan()
     * @param string $dosyaadi dosya adı
     * @return string $parca
     */
    public function htmlKullan(string $dosyaadi = null): string
    {
        $dos = new System\Dos;

        if (isset($dosyaadi) && $dos->cd(RELEASE . '-publications'. '/' . 'html-units')->fileExists($dosyaadi)){

            $dadi = explode('.',$dosyaadi);

            $dadi = !isset($dadi[2]) ? $dadi[0] : 'gecersiz-islem';

            $this->ekranekleri[$dadi] = $dos->f($dosyaadi)->read()->getData();

            return $this->ekranekleri[$dadi];
        }

        unset($dos);

        throw new System\VerisanatDosException('Dosya bulunamadı: ' . $dosyaadi);
    }

    /**
     * göndeirlen array de bulunan sabit değişkenleri yeni içerikleriyle değiştirir.
     * 
     * @method yapiDegisimler()
     * @param array $bunlar array(0 => array('degiskenadi','icerik'))
     * @return void
     */
    public function yapiDegisimler(array $bunlar): void
    {
        foreach($bunlar as $tek){
            
            $this->vui->changePageUnit($tek[0],$tek[1]);
        }
    }

    /**
	 * Creates warning or info level messages reported from modules, internal apps.
	 * 
	 * - This is a public function just because of the verbosely written modules. Can be used in a module
	 * if module id function defined. Otherwise its been used auto by module controller.
	 * 
	 * - Some functions like this left in [TR] Turkish lang because they are almost invisible to a developer.
	 * 
	 * yönlendirmeden yada işlem sonucundan gelen uyarı yada iletileri yazdırır yönlendirir
	 * 
     * @method modulbilgiver()
     * @return void
     */
    public function modulBilgiVer(): void
    {
        if (isset($_SESSION['warning_type'])){

            $this->uyaritipi = $_SESSION['warning_type'];
            
            unset($_SESSION['warning_type']);

            $this->bilgi = $_SESSION['guide_information'];
            
            unset($_SESSION['guide_information']);

            $bir = '<div class="sticky-top uyarilar text-center alert alert-success alert-dismissible fade show" role="alert">
            <strong>Tamamlandı: </strong> %s
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="far fa-times-circle mobil-mt-1"></i></span></button>
            </div>';
            $iki = '<div class="sticky-top uyarilar text-center alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Uyarı: </strong> %s
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="far fa-times-circle mobil-mt-1"></i></span></button>
            </div>';

            $this->bilgiver = $this->uyaritipi == 'bilgi' ? sprintf($bir,$this->bilgi) : sprintf($iki,$this->bilgi);

            Http::forward($this->bilgiver);
        }

        $this->modulbilgikutulari = $_SESSION['modulbilgikutulari'] ?? null;
        
        unset($_SESSION['modulbilgikutulari']);
    }

    /**
	 * Creates toast message to page header from modules.
	 * 
	 * - Can be used in modules, both main page and interface functions.
	 * 
	 * toast iletiyi yazar
	 * 
     * @method modulbilgi()
     * @param string $bilgi
     * @param string $madi modul adı. İşlem başlığının yanına modul adını verir.
     * @return void
     */
    public function modulbilgi(string $bilgi,string $madi = null): void
    {
        if (isset($_SESSION['modulbilgikutulari'])){

            $_SESSION['modulbilgikutulari'] .= isset($madi) ? sprintf($this->ileti,' - ' . $madi,$bilgi) : sprintf($this->ileti,null,$bilgi);
        }else{

            $_SESSION['modulbilgikutulari'] = isset($madi) ? sprintf($this->ileti,' - ' . $madi,$bilgi) : sprintf($this->ileti,null,$bilgi);
        }
        
    }

    /**
     * oluşturulan sayfayı html olarak kaydeder.
     * 
     * @method ekranihtmlkaydet()
     * @param string $v oluşturulacak html dosya adı - onbellek1.html
	 * @return bool
     */
    private function onbellekolustur(string $v = null): void
    {
        // console - 443 openSource removed
    }

    /**
     * Standart form başlığını verir.
     * multipart/form
     * 
     * @method formBasligiVer()
     * @param string $hedef
     * @return string $fy
     */
    public function formBasligiVer(string $hedef): string
    {
        return sprintf($this->klasikFormBasligi,$hedef);
    }

    /**
     * GET form başlığı verir.
     * 
     * @method aramaFormBasligiVer()
     * @param string $hedef
     * @return string $baslik
     */
    public function aramaFormBasligiVer(string $hedef): string
    {
        return sprintf($this->aramaFormBasligi,$hedef);
    }
}
?>