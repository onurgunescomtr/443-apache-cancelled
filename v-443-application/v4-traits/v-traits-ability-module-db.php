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

trait AbilityModuleDatabase{

    /**
     * diğer modüllerin veritabanı tablosundan parametrelere göre obje döndürür
     * 
     * @method modulVerisiAl() 
     * @param string $yapi ilgili modül yapı adı $this->otherModules['urun']
     * @param string|null $tek modulden beklenen sonuç niceliği, tek bir no yada çoklu arama.
     * @param array|null $sutun belirlenmiş sutun adları - array('id','foto')
     * @param array|null $belirli where_equal için ( array('sutun','aranacak str/int') ) dizisi
     * @return object
     */
    public function modulVerisiAl($yapi,$tek = null,$belirli = null,$sutun = null): object
    {
        $o = \Model::factory($this->otherModules[$yapi])->useIdColumn($this->uniqueIdentifierProperty);

        if (is_array($sutun)){

            $o->selectMany($sutun);
        }

        if (is_array($belirli)){

            $o->whereEqual($belirli[0],$belirli[1]);
        }

        isset($tek) ? $o = $o->findOne($tek) : $o = $o->findMany();

        return $o;
    }

    /**
     * @since 443 writes to appLog instead of systemLog
     * 
     * secilinesne "sn" objesini alır
     * 
     * @method nesnebul() 
     * @param string $kategori - varsayılan modelno
     * @return void
     */
    private function nesnebul(string $kategori = 'modelno'): void
    {
        $kayit = null;

        try{
            
            $kayit = \Model::factory($this->dbTableName)->whereEqual($this->uniqueIdentifierProperty,$this->{$this->processUnit})->findOne();
        }catch(\Exception $hata){
            
            Scribe::appLog('Var olmayan nesne talebi: '. $this->processUnit .'-'. $_SERVER['REMOTE_ADDR'] . ': ' . $hata->getMessage());
        }

        if (is_bool($kayit) && !$kayit){

            if ($this->invalidRequestResponse){
                
                $this->modulbilgi($this->modulBilgiSatirlari['oge_yok']);

                Http::guide(ADDRESS,'error','İstenilen öğe bulunamadı');
            }else{

                header('HTTP/1.1 404 Not Found',true,404);

                die('404.002.Yok.');
            }
        }

        // mysql veritabanı ndan gelen id string olarak objede

        if (isset($kayit)){

            if ($kayit->id !== null && is_string($kayit->id)){

                $_SESSION['sn'] = $this->{$this->processUnit};

                $this->sn = $kayit; 
                
                $this->goruntulenme();

                $this->frame->frameHtmlHeadSupport($this->sn->adi . ' - ' . $this->sn->$kategori . ' - ',htmlspecialchars_decode($this->sn->tanim),$this->sn->anahtarkelime,$this->sn->{$this->uniqueIdentifierProperty},$this->mikroVeriPaketle());
            }
        }
        
        if ($kayit === null){

            header('HTTP/1.1 404 Not Found',true,404);

            die('404.004.Modül veri alanı tanımsız.');
        }       
    }
}
?>