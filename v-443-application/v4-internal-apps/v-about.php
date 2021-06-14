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

Version\VersionCheck::dkontrol(__FILE__,'4.4.2');

final class AboutThisApp{

    use Builder;

    use Screen;

    /**
     * @var string $infoAboutThisApp
     */
    public const infoAboutThisApp = [
        'TR' => [
            'no_static_html' => 'Bu uygulamanın henüz bir <strong>Hakkında</strong> öğesi bulunmuyor.'
        ],
        'EN' => [
            'no_static_html' => 'There is no <strong>About Us</strong> page is provided for this app.'
        ]
    ];

    /**
     * @var string $htmlPage
     */
    private string $htmlPage = '';

    /**
     * @var string $aboutPageStaticFile
     */
    private string $aboutPageStaticFile = 'v-about.html';

    public function __construct($up = null){

        $this->setProc($up);

        Warden::setSession();

        $this->frame = new Frame(Http::__gx('d'));
        
        $this->vui =  new Page;

        $this->frame->frameSupport($this->process,$this->subProcess);

        Scribe::requestLog($this->process,$this->subProcess,$this->rawQuery);

        $dos = new System\Dos;

        if ($dos->cd(RELEASE . '-publications' . '/' . 'html-units')->fileExists($this->aboutPageStaticFile)){

            $this->htmlPage = $dos->f($this->aboutPageStaticFile)->read()->getData();
        }else{

            $this->htmlPage = self::infoAboutThisApp[LANG]['no_static_html'];
        }

        unset($dos);
        
        $this->rawScreen = $this->startHtmlPage();

        $this->rawScreen .= $this->vui->cover($this->htmlPage);

        $this->rawScreen .= $this->vui->endHtmlPage();

        Http::respond($this->rawScreen);

        exit;
    }
}
?>