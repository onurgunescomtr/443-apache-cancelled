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
 *                          mailto:verisanat@outlook.com
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

trait ModuleBuilder{

    private array $infoModuleBuilder = [
        'TR' => [
            'not_op' => 'Modül operatif özellikte olmadığından işlem dönüşü yapamaz.'
        ],
        'EN' => [
            'not_op' => 'Process information is prohibited due to not being an Operative Module'
        ]
    ];

    /**
     * @method getSubProccess()
     * @return string|null
     */
    public function getSubProcess(): ?string
    {
        return $this->subProcess;
    }

    /**
     * @method getProcess()
     * @return string|null
     */
    public function getProcess(): ?string
    {
        return MODULISLEMLER[$this->moduleName]['operativeInterface'] ? $this->process : $this->infoModuleBuilder[LANG['not_op']];
    }

    /**
     * @method getFirstQuery()
     * @return string|null
     */
    public function getFirstQuery(): ?string
    {
        return $this->one;
    }

    /**
     * @method getSecondQuery()
     * @return string|null
     */
    public function getSecondQuery(): ?string
    {
        return $this->two;
    }

    /**
     * @method getThirdQuery()
     * @return string|null
     */
    public function getThirdQuery(): ?string
    {
        return $this->three;
    }
}
?>