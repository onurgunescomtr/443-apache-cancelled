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

class StaticResponse001{

    use Builder;

    private string $workingFolder = 'local-folder';

    private string $siteMap;

    private string $responseHeaderType = 'Content-type: text/html';

    private string $feedBack;

    private string $xmlSiteMapNonString = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">NOT_SET</urlset>';

    private string $xmlNonString = '<?xml version="1.0" encoding="UTF-8"?><none>empty</none>';

    public function __construct($up = null)
    {
        $this->setProc($up);

        Scribe::requestLog($this->process,$this->subProcess,$this->rawQuery);

        $this->manageProcess();

        $this->sendAnswer();
    }

    /**
     * @method manageProcess()
     * @return void
     */
    private function manageProcess(): void
    {
        switch($this->subProcess):

            case null:

                Scribe::appLog('Request that cannot be answered received from: ' . $_SERVER['REMOTE_ADDR']);

                die('200.401.API Uncovered Request.');

            break;
            case 'site-map':

                $this->responseHeaderType = 'Content-type: text/xml';

                $this->feedBack = $this->getSiteMap();

            break;
        endswitch;
    }

    /**
     * @method sendAnswer()
     * @return void
     */
    private function sendAnswer(): void
    {
        header($this->responseHeaderType);

        Http::respond($this->feedBack);

        exit;
    }

    /**
     * @method getSiteMap()
     * @return string
     */
    private function getSiteMap(): string
    {
        $this->d = new System\Dos;

        $this->siteMap = strtolower(App::getApp('applicationName')) . '-site-map' . '.xml';

        if ($this->d->cd($this->workingFolder)->fileExists($this->siteMap)){

            $harita = $this->d->f($this->siteMap)->read('xml')->getData();
        }else{

            $harita = $this->xmlSiteMapNonString;
        }

        return $harita;
    }
}
?>