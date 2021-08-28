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

final class Publication001{

	use Builder;

	use Screen;

	public function __construct($up = null)
	{
		$this->setProc($up);

		$this->frame = new Frame(Http::__gx('d'));
        
        $this->vui = new Page;

        $this->frame->frameSupport($this->process,$this->subProcess);

        Scribe::requestLog($this->process,$this->subProcess,$this->rawQuery);

		$this->rawScreen = $this->startHtmlPage();

		$this->createScreen();

		$this->rawScreen .= $this->endHtmlPage();

        Http::respond($this->rawScreen);

        exit;
	}

	/**
	 * @method createScreen()
	 * @return void
	 */
	private function createScreen(): void
	{
        switch($this->subProcess):

			case $this->frame->translateUri('terms-and-conditions'):

				$c = new ClassicWeb('static');

				$this->rawScreen .= $this->vui->cover($c->requestContent('terms-and-conditions'));

			break;

			case $this->frame->translateUri('privacy-policy'):

				$c = new ClassicWeb('static');

				$this->rawScreen .= $this->vui->cover($c->requestContent('privacy-policy'));
				
			break;

            default:

                $this->rawScreen .= $this->vui->cover(sprintf($this->vui->htmlPageSalutation,
                        'App Language mismatch',
                        'You have probably landed a publication page where URL you have used is not set to your app preference.<br>
                        Please use the user menu (upper right corner of screen) to set your language.'
                ));
            break;

		endswitch;
	}
}
?>