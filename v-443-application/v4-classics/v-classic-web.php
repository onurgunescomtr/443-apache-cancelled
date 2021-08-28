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

final class ClassicWeb{

	/**
	 * @var string $contentData
	 */
	private string|null $contentData;
	/**
	 * @var array $infoClassicWeb
	 */
	public array $infoClassicWeb = [
		'TR' => [
			'nop' => 'İstenilen içerik bulunamadı.'
		],
		'EN' => [
			'nop' => 'Requested content couldnt be found.'
		]
	];
    /**
     * @var string $publicationFolder
     */
    public string $publicationFolder = RELEASE . '-publications';
	/**
	 * @var array $servingTypes
	 */
	public static array $servingModel = [
		'static' => [
			'terms-and-conditions' => [
				'name' => 'v-terms',
				'type' => 'html'
			],
			'privacy-policy' => [
				'name' => 'v-privacy',
				'type' => 'html'
			]
		],
		'generated' => [
            
        ],
		'data' => [],
		'feed' => []
	];
	/**
	 * @var array $servingTypes
	 */
	public static array $servingTypes = [
		'static','generated','data','feed'
	];
	/**
	 * @var string $publicationType
	 */
	private string $publicationType;

	public function __construct(string $type)
	{
		$this->getType($type);
	}

	/**
	 * @method getType()
	 * @return void
	 */
	private function getType(string $pubType): void
	{
		if (in_array($pubType,self::$servingTypes)){

			$this->publicationType = $pubType;
		}
	}

	/**
	 * @method requestContent()
	 * @param string $content
	 * @return string
	 */
	public function requestContent(string $content): string
	{
		switch($this->publicationType):

			case 'static':

				if (array_key_exists($content,self::$servingModel['static'])){

					match(self::$servingModel['static'][$content]['type']){

						'html' => $this->getStaticFile(self::$servingModel['static'][$content]['name'],'html')
					};
				}

			break;

		endswitch;

		return $this->contentData;
	}

	/**
	 * @method getStaticFile()
	 * @param string $name
	 * @param string $extension
	 * @return string $data
	 */
	private function getStaticFile($name,$extension): void
	{
		$dos = new System\Dos;

		if ($dos->cd($this->publicationFolder . '/' . 'html-units')->fileExists($name . '.' . $extension)){

            $this->contentData = $dos->f($name . '.' . $extension)->read($extension)->getData();
        }else{

            $this->contentData = $this->infoClassicWeb[LANG]['nop'];
        }

		unset($dos);
	}

	/**
	 * @method getContent()
	 * @return string
	 */
	public function getContent(): string
	{
		return $this->contentData;
	}
}
?>