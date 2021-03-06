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

trait AbilityModulePage{

    /**
     * [TR] HTML parçaları (body ve head içermeyen) Dos kullanarak okur ve içeriğini döndürür
     * [EN] reads and returns HTML (except body and head) strings using Dos class
     * 
     * @method useHtmlFile()
     * @param string $fileName
     * @return string
     */
    public function useHtmlFile(string $fileName = null): string
    {
        $dos = new System\Dos;

        if (isset($fileName) && $dos->cd(RELEASE . '-publications'. '/' . 'html-units')->fileExists($fileName)){

            $tempFileName = explode('.',$fileName);

            $tempFileName = !isset($tempFileName[2]) ? $tempFileName[0] : 'gecersiz-islem';

            $this->screenAdditions[$tempFileName] = $dos->f($fileName)->read()->getData();

            return $this->screenAdditions[$tempFileName];
        }

        unset($dos);

        throw new System\VerisanatDosException('Dosya bulunamadı: ' . $fileName);
    }

    /**
     * [TR] Gönderilen array de bulunan sabit değişkenleri yeni içerikleriyle değiştirir.
     * [EN] Changes exact page element with array html key value contents
     * 
     * array(0 => array('variableName','stringData'))
     * 
     * @method modifyPageElement()
     * @param array $modItems
     * @return void
     */
    public function modifyPageElement(array $modItems): void
    {
        foreach($modItems as $tek){
            
            $this->vui->changePageUnit($tek[0],$tek[1]);
        }
    }

    /**
	 * @method setAppModuleReport()
     * @return void
     */
    public function setAppModuleReport(): void
    {
        $rType = SysLed::get('http_warning_type',true);

        if (is_string($rType)){

            $this->reportType = $rType;

            $this->reportInfo = SysLed::get('http_guide_information',true);

            $this->appModuleReport = $this->reportType === 'warn' ? 
            
                sprintf($this->htmlModuleAppReportWarn,

                    $this->frame->translate('warning_report'),
                    
                    $this->reportInfo
                    
                ) : sprintf($this->htmlModuleAppReportError,
                    
                    $this->frame->translate('error_report'),
                    
                    $this->reportInfo
            );

            Http::forward($this->appModuleReport);
        }

        $appToast = SysLed::get('app_module_toast_container',true);

        if (is_string($appToast)){

            $this->appModuleToastBox = $appToast ?? null;
        }
    }

    /**
	 * [EN] Creates toast message to page header from modules. Can be used in modules, both main page and interface functions.
	 * [TR] Modül bilgi kutusuna verilen bilgiyi yazar.
	 * 
     * @method setModuleToast()
     * @param string $information
     * @param string $moduleName
     * @return void
     */
    public function setModuleToast(string $information): void
    {
        $toastBox = SysLed::get('app_module_toast_container');

        if (is_string($toastBox)){

            SysLed::modify('app_module_toast_container',sprintf($this->htmlModuleToast,' - ' . $this->moduleName,$information),'join');
        }else{

            SysLed::set('app_module_toast_container',sprintf($this->htmlModuleToast,' - ' . $this->moduleName,$information));
        }
    }

    /**
     * @method createCachedPage()
     * @param string $v
	 * @return bool
     */
    private function createCachedPage(string $v): void
    {
        // console - OS removed
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
        return sprintf($this->classicFormHead,$hedef);
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
        return sprintf($this->searchFormHead,$hedef);
    }
}
?>