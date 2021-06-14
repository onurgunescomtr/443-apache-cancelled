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
 * InterfaceControl - ArayuzKontrol
 */
class InterfaceControl{
    
    use Structure\InternalStructure;

    /* v.4.0.21 ile dahil edildi 04.03.2020 */
    /**
     * defaultScreen işlemini barındırır
     * 
     * @var string $defaultScreen 
     */
    private string $defaultScreen;
    /**
     * özel işlem dosya yollarının bulunduğu array.
     * 
     * @var array $ozelislemler 
     */
    private $ozelislemler;
    /**
     * işlem adresini yada dizisini barındırır
     * 
     * @var mixed|string|array|int $processRequest 
     */
    private string|array|int $processRequest;
    /**
     * özel birim arayuzu, testler - admin panel vb.
     * 
     * @var bool $upperStructureInterface 
     */
    private bool $upperStructureInterface = false;
    /**
     * içyapı işlemi mi değil mi
     * 
     * @var bool $internalStructInterface 
     */
    private bool $internalStructInterface = false;
    /**
     *  Modül arayuzu mü değil mi
     * 
     * @var bool $modularayuzu
     */
    private bool $moduleInterface = false;
    /**
     * Modül yada Sistem işlemi geçerli yada geçersiz
     * 
     * @var bool $validInterface 
     */
    private bool $validInterface = false;
    /**
     * @var bool $kontrolSon
     */
    private bool $kontrolSonlandir = false;
    /**
     * Modül yada Sistem işlem / arayüz adı.
     * 
     * @var string $aa 
     */
    private $aa;
    /**
     * özel birimler için geçerli arayuz adı, parçası, html i
     * 
     * @var array $ob 
     */
    private $ob = OZELBIRIMLER;
    /**
     * modüller için geçerli iç yapı harici işlem adları,parçaları,html,id 9002
     * 
     * @var array $mi 
     */
    private $mi = MODULISLEMLER;
    /**
     * @var bool $invalidRequestResponse
     */
    private bool $invalidRequestResponse;

    /**
     * modül arayuzu kayıtlı mı değil mi denetler
     * 
     * @method denetle() 
     * @param string $islem
     * @return bool
     */
    private function denetle(string $islem): bool
    {
        foreach($this->mi as $modul => $icerik){

            if ($icerik['processInterface'] === $islem && in_array($modul,App::getModule('modules'))){

                $this->aa = $modul;
                
                $this->validInterface = true; 
                
                $this->moduleInterface = true;
            }
        }

        return $this->moduleInterface;
    }

    /**
     * içyapı arayuzu kayıtlı mı değil mi denetler
     * 
     * @method icYapiDenetle() 
     * @param string $d
     * @return void
     */
    private function icYapiDenetle(string $d): void
    {
        if (array_key_exists($d,$this->internalClasses)){

            $this->aa = $d;
            
            $this->validInterface = true;
            
            $this->internalStructInterface = true;
        }
    }

    /**
     * Özel birim denetler
     * 
     * @method obDenetle() 
     * @param string $islem
     * @return void
     */
    private function obDenetle(string $islem): void
    {
        $this->upperStructureInterface = false;

        if (array_key_exists($islem,$this->ob)){

            $this->aa = $islem;
            
            $this->validInterface = true;
            
            $this->upperStructureInterface = true;
        }

        $this->kontrolSonlandir = true;
    }

    private array $denetimler = array('denetle','icYapiDenetle','obDenetle');

    public function __construct(?string $x)
    {
        $this->setDefaults();

        if ($x !== null){

            $f = 0;

            do{
                call_user_func(array($this,$this->denetimler[$f]),$x);

                $f++;

            }while($this->kontrolSonlandir === false);

            if ($this->validInterface){
                
                $this->id($x);
            }else{

                if ($this->invalidRequestResponse){

                    $this->processRequest = $this->defaultScreen;
                }else{

                    $this->processRequest = 404;
                }
            }
        }else{

            $this->processRequest = $this->defaultScreen;
        }
    }

    /**
     * v.4.4.3 no return - registers processRequest
     * 
     * v.4.4.2 işlem modulunu yada adını atar (artık döndürmüyor)
     * v.4.0 - v.4.1 işlem belitecini / dosyasını verir
     * 
     * @method id() 
     * @return void
     */
    private function id($i = null): void
    {
        $this->processRequest = match(true){

            $this->internalStructInterface => $i,

            $this->upperStructureInterface => 'special-unit-' . $i,

            $this->moduleInterface => $this->mi[$this->aa]
        };
    }

    /**
     * @method setDefaults()
     * @return void
     */
    private function setDefaults(): void
    {
        $this->defaultScreen = match(SERVER){

            'apache' => $this->htmlDefaultScreen,
            
            'verisanat' => $this->htmlDefaultScreen
        };

        // the reason i put this as a variable inside the class is... i dont remember.. 
        // lets see
        
        $this->invalidRequestResponse = App::getApp('invalidRequestResponse');
    }

    /**
     * Uygulama temel arayuz başlatıcısı. v.4.0 - v.4.1 arayuzgecerli (bool) donduruyordu - işlem adını yada array i döndürür
     * 
     * @method getProcess()
     * @return mixed|string|array|int $processRequest
     */
    public function getProcess(): string|array|int
    {
        return $this->processRequest;
    }
}
?>