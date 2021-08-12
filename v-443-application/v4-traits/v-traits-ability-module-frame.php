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
 *                          verisanat@outlook.com
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

trait AbilityModuleFrame{

    /**
     * @method mikroVeriPaketle()
     * @return array $mvp
     */
    private function mikroVeriPaketle(): array
    {
        if (isset($this->sn->foto)){

            str_contains($this->sn->foto,',') ? $foto = explode(',',$this->sn->foto) : $foto = $this->sn->foto;

            is_array($foto) ? $satir = $foto[0] : $satir = $foto;
        }else{

            $foto = null;
        }

        $fotoDosyaAdi = $satir ?? $foto;

        if (isset($this->sn->ifiyati) && (string)$this->sn->ifiyati !== '0.00'){

            $fiyat = $this->sn->ifiyati;
        }else{

            $fiyat = $this->sn->fiyati;
        }

        $this->sn->durumu === (string)1 ? $durum = 'in stock' : $durum = 'out of stock';

        str_contains($this->sn->adi,',') ? $ogeAdi = str_replace(',',' - ',$this->sn->adi) : $ogeAdi = $this->sn->adi;
        
        str_contains($this->sn->baslik,',') ? $ogeTanim = str_replace(',',' - ',$this->sn->baslik) : $ogeTanim = $this->sn->adi;
        
        return array(
            'no' => $this->sn->modelno,
            'baslik' => $ogeAdi,
            'tanim' => $ogeTanim,
            'satis_durumu' => $durum,
            'stok' => $this->sn->toplamadet,
            'durumu' => 'new',
            'fiyati' => $fiyat,
            'baglanti' => ADDRESS . '/' . MODULISLEMLER[$this->moduleName]['processInterface'] . '/' . $this->sn->{$this->uniqueIdentifierProperty},
            'foto_baglanti' => ADDRESS . '/' . 'lokal-gorsel' . '/' . 'm-' . $this->moduleName . '-foto' . '/' . $fotoDosyaAdi,
            'marka_adi' => App::getApp('applicationName')
        );
    }

    /**
     * $frameAdditions dizisine dahil edilecek satırları alır
     * 
     * @method headEkle()
     * @param $yeni yeni dosya adı, yada klasoru ile birlikte adı
     * @return void
     */
    public function headEkle(string $yeni = null): void
    {
        $dos = new System\Dos;
        
        $altklasor = false;

        if (isset($yeni)){

            $css = $dos->cd('external-resources')->fileExists($yeni);

            $yenitipCss = $dos->cd(RELEASE . '-css')->fileExists($yeni);

            if (strpos($yeni,'/') !== false){

                $yoldosya = explode('/',$yeni);
                
                $altklasor = true;
            }
            
            $altklasor ? $js = $dos->cd('external-resources' . '/' . $yoldosya[0])->fileExists($yoldosya[1]) : $js = $dos->cd('external-resources')->fileExists($yeni);

            if ($js || $css || $yenitipCss){

                switch ($dos->getFileExtension()):

                    case 'js':

                        $this->frameAdditions[] = sprintf($this->jsdosyasiDis,$yeni);

                    break;
                    case 'css':

                        $yenitipCss ? $this->frameAdditions[] = sprintf($this->headCssFileInternal,$yeni) :$this->frameAdditions[] = sprintf($this->cssdosyasi,$yeni);

                    break;

                endswitch;
            }
        }

        unset($dos);
    }

    /**
     * $headekleyi oluşturur. tamamlanmış head e eklenecek string döndürür
     * 
     * @method headEklentileri()
     * @return mixed|string|null $headekle
     */
    private function headEklentileri()
    {
        $this->headekle = null;

        if (isset($this->frameAdditions)){

            foreach($this->frameAdditions as $t){

                $this->headekle .= $t;
            }
        }

        return $this->headekle;
    }

    /**
     * göndeirlen array de bulunan sabit değişkenleri yeni içerikleriyle değiştirir.
     * 
     * @method cerceveDegisimler()
     * @param array $bunlar array(0 => array('degiskenadi','icerik'))
     * @return void
     */
    public function cerceveDegisimler(array $bunlar): void
    {
        foreach($bunlar as $tek){

            $this->frame->changeFrameUnit($tek[0],$tek[1]);
        }
    }

    /**
     * @method useJavascriptUI()
	 * @param string $JSname
	 * @return void
     */
    public function useJavascriptUI(string $JSname): void
    {
        $this->frame->setFrameUserInterfaceName($JSname);
    }
}
?>