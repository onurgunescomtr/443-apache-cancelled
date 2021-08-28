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

use VTS\Network\NetControl;

trait Builder{

    /**
     * @var null|string $process
     */
    private null|string $process;
    /**
     * @var null|string $subProcess
     */
    private null|string $subProcess;
    /**
     * @var null|string $one
     */
    private null|string $one;
    /**
     * @var null|string $two
     */
    private null|string $two;
    /**
     * @var null|string $three
     */
    private null|string $three;
    /**
     * @var null|string $rawQuery
     */
    private null|string $rawQuery;
    /**
     * @var null|int $processLayer 
     */
    private null|int $processLayer;
    /**
     * @var array $urlPackage
     */
    public array $urlPackage;

    /**
     * @method setProc() setProcess
     * @param array $paket
     * @return void
     */
    private function setProc(array $paket): void
    {
        $this->process = $paket['process'] ?? null; // islem

        $this->subProcess = $paket['subprocess'] ?? null; // ekislem

        $this->one = $paket['query']['first'] ?? null; // bir

        $this->two = $paket['query']['second'] ?? null;

        $this->three = $paket['query']['third'] ?? null;

        $this->rawQuery = $paket['rawquery'] ?? null;

        $this->processLayer = $paket['processlayer'] ?? null;

        $this->urlPackage = $paket;
    }

    /**
     * @method cycleProc()
     * @param NetControl $p
     * @return array $urlPackage
     */
    public function cycleProc(NetControl $p): array
    {
        return $p->urlPackage;
    }

    /**
     * @method getPack()
     * @param PathWays $p
     * @return array
     */
    private function getPack(PathWays $p): array
    {
        return $p->transfer();
    }
}