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

trait AbilityModuleDatabase{

    /**
     * [TR] Diğer modüllerin veritabanı tablosundan parametrelere göre obje döndürür
     * [EN] Returns a module's data units. Throws error if false or empty
     * 
     * @method getModuleData() 
     * @param string $sharedDN Shared Data Name
     * @param int|null $knownID
     * @param array|null $whereEqual (Only one column)
     * @param array|null $selectColumns
     * @return object
     */
    public function getModuleData($sharedDN,?int $knownID = null,$whereEqual = null,$selectColumns = null): object
    {
        $o = \Model::factory($this->otherModules[$sharedDN])->useIdColumn($this->uniqueIdentifierProperty);

        if (is_array($selectColumns)){

            $o->selectMany($selectColumns);
        }

        if (is_array($whereEqual)){

            $o->whereEqual($whereEqual[0],$whereEqual[1]);
        }

        return isset($knownID) ? $o->findOne($knownID) : $o->findMany();
    }

    /**
     * [TR] Secili Nesne "sn" objesini alır
     * [EN] Grabs and sets "sn" object (Selected Unit)
     * 
     * @since 443 writes to appLog instead of systemLog
     * @method setModuleUnit() 
     * @param string $kategori - varsayılan modelno
     * @return void
     */
    private function setModuleUnit(string $kategori = 'modelno'): void
    {
        $requestUnit = null;

        try{
            
            $requestUnit = \Model::factory($this->dbTableName)->whereEqual($this->uniqueIdentifierProperty,$this->{$this->processUnit})->findOne();
        }catch(\Exception $snError){
            
            Scribe::appLog($this->frame->translate('module_request_unit_fail') . $this->processUnit .'-'. $_SERVER['REMOTE_ADDR'] . ': ' . $snError->getMessage());
        }

        if (is_bool($requestUnit) && !$requestUnit){

            if ($this->invalidRequestResponse){
                
                $this->setModuleToast($this->modulBilgiSatirlari['oge_yok']);

                Http::guide(ADDRESS,'error',$this->frame->translate('http_404_module_unit'));
            }else{

                header('HTTP/1.1 404 Not Found',true,404);

                die($this->translate('http_404_202'));
            }
        }

        if (isset($requestUnit)){

            if ($requestUnit->id !== null && is_string($requestUnit->id)){

                SysLed::set('current_module_item',$this->{$this->processUnit});
                
                $this->sn = $requestUnit; 
                
                $this->moduleUnitUsage();

                $this->frame->frameHtmlHeadSupport($this->sn->adi . ' - ' . $this->sn->$kategori . ' - ',
                    
                    htmlspecialchars_decode($this->sn->tanim),
                    
                    $this->sn->anahtarkelime,
                    
                    $this->sn->{$this->uniqueIdentifierProperty},
                    
                    $this->mikroVeriPaketle());
            }
        }
        
        if ($requestUnit === null){

            header('HTTP/1.1 404 Not Found',true,404);

            die($this->frame->translate('http_404_004'));
        }       
    }
}
?>