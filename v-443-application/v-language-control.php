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

Version\VersionCheck::dkontrol(__FILE__,'4.4.2');
/**
 * Language - LisanKontrol
 */
class Language{

    /**
     * @var string KLASOR
     */
    private const KLASOR = RELEASE . '-application' . '/' . 'language-packs';
    /**
     * @var string TURKCEKAYNAK
     */
    private const TURKCEKAYNAK = 'yeni-turkce.php';
    /**
     * @var string INGILIZCEKAYNAK
     */
    private const INGILIZCEKAYNAK = 'yeni-ingilizce.php';
    /**
     * @var string DILDOSYASI
     */
    private const DILDOSYASI = 'dilpaketi.json';
    /**
     * @var string DILDOSYASIMETIN
     */
    private const DILDOSYASIMETIN = 'dilpaketi-metinler.json';
	/**
	 * @var string DILDOSYASIURI
	 */
	private const DILDOSYASIURI = 'dilpaketi-uri-list.json';
    /**
     * @var array $availableLanguages
     */
    private array $availableLanguages = [
        0 => [
            'tam_adi' => 'turkce',
            'kisa_adi' => 'tr'
        ],
        1 => [
            'tam_adi' => 'ingilizce',
            'kisa_adi' => 'en'
        ]
    ];
    /**
     * @var array $baseLangControl
     */
    private array $baseLangControl = ['emptyVarString','turkce','ingilizce'];
    /**
     * @var object $languagePackage
     */
    public object $languagePackage;
    /**
     * @var object $languagePackageText
     */
    public object $languagePackageText;
	/**
	 * @var object $languagePackageUri
	 */
	private object $languagePackageUri;
    /**
     * @var bool $langChanged
     */
    private bool $langChanged = false;
    /**
     * @var int $previousLang
     */
    private int $previousLang;

    public function __construct(string $langName)
    {
        $this->loadLangPack();

        $this->setLang($langName);
    }

    /**
     * dil paketi dosyasını (json) yazar
     * 
     * @method createLanguagePack()
     * @param bool $isNew
     * @return void
     */
    private function createLanguagePack(bool $isNew = false): void
    {
        require_once BASE . '/' . self::KLASOR . '/' . self::TURKCEKAYNAK;

        require_once BASE . '/' . self::KLASOR . '/' . self::INGILIZCEKAYNAK;

        $kitaplik = array_merge_recursive($ceviri,$translate);

        $kitaplikMetinler = array_merge_recursive($text_ceviri,$text_translate);

		$kitaplikUriCeviri = array_merge_recursive($uri_ceviri,$uri_translate);

        $isNew ? $this->dos->f(self::DILDOSYASI)->write($kitaplik) : $this->dos->newFile(self::DILDOSYASI)->write($kitaplik);

        $isNew ? $this->dos->f(self::DILDOSYASIMETIN)->write($kitaplikMetinler) : $this->dos->newFile(self::DILDOSYASIMETIN)->write($kitaplikMetinler);

		$isNew ? $this->dos->f(self::DILDOSYASIURI)->write($kitaplikUriCeviri) : $this->dos->newFile(self::DILDOSYASIURI)->write($kitaplikUriCeviri);
    }

    /**
     * @method loadLangPack()
     * @return void
     */
    private function loadLangPack(): void
    {
        $this->dos = new System\Dos;

        if (!$this->dos->cd(self::KLASOR)->fileExists(self::DILDOSYASI) || !$this->dos->cd(self::KLASOR)->fileExists(self::DILDOSYASIMETIN)){ 

            $this->createLanguagePack();
        }

        if ($this->dos->files([self::TURKCEKAYNAK,self::DILDOSYASI])->compareFiles('time','younger')){

            $this->createLanguagePack(true);
        }
        
        $this->languagePackage = $this->dos->f(self::DILDOSYASI)->read('json')->getData();

        $this->languagePackageText = $this->dos->f(self::DILDOSYASIMETIN)->read('json')->getData();

		$this->languagePackageUri = $this->dos->f(self::DILDOSYASIURI)->read('json')->getData();

        unset($this->dos);
    }

    /**
     * @method setDefaults()
     * @return void
     */
    private function setDefaults(): void
    {
        if (SysLed::audit('effective_lang_number',0,'higher')){
                    
            $this->d = SysLed::get('effective_lang_number');
        }else{

            $this->d = 0;
        
            Sysled::set('effective_lang_number',0);
        }
    }

    /**
     * @method currentLanguage()
     * @return int $d
     */
    public function currentLanguage(): int
    {
        return $this->d;
    }

    /**
     * @method htmlLang()
     * @return string $availableLanguages[]
     */
    public function htmlLang(): string
    {
        return $this->availableLanguages[$this->d]['kisa_adi'];
    }

    /**
     * @method getLangPack()
     * @return object $languagePackage
     */
    public function getLangPack(): object
    {
        return $this->languagePackage;
    }

    /**
     * @method getLangPackText()
     * @return object $languagePackageText
     */
    public function getLangPackText(): object
    {
        return $this->languagePackageText;
    }

	/**
	 * @method getLangPackURI()
	 * @return object $languagePackageUri
	 */
	public function getLangPackURI(): object
	{
		return $this->languagePackageUri;
	}

    /**
     * @method isLangUri()
     * @param string $word
     * @param bool $get
     * @return string|bool
     */
    public function isLangUri(string $word,bool $get = false): string|bool
    {
        if (is_string($this->languagePackageUri->$word[$this->d])){

            if ($get){

                return match($this->d){

                    0 => $this->languagePackageUri->$word[1],

                    1 => $this->languagePackageUri->$word[0]
                }; 
            }
            
            return true;
        }else{

            return false;
        }
    }

    /**
     * @method getLangUri()
     * @param string $part
     * @param int $lang
     */
    public function getCrossLangUri(string $part,int $lang): string
    {
        return match($lang){

            0 => $this->languagePackageUri->$part[1],

            1 => $this->languagePackageUri->$part[0]
        };
    }

    /**
     * @method isLangChanged()
     * @return bool
     */
    public function langHasChanged(): bool
    {
        return $this->langChanged;
    }

    /**
     * @method getPreviousLang()
     * @return int
     */
    public function getPreviousLang(): int
    {
        return $this->previousLang;
    }

    /**
     * @method handleDifferentLanding()
     * @return void
     */
    public function handleDifferentLanding(): void
    {
        $this->setDefaults();
    }

    /**
     * @method setLang()
     * @param string|null $t
     * @return void
     */
    private function setLang(?string $t): void
    {
        if (strlen($t) > 1 && !in_array($t,$this->baseLangControl)){

            Scribe::appLog('Invalid language request from: ' . SysLed::get('user_client_address') . ' IP Address');

            Http::inform('warn',BASICWARN['gecersiz_talep']);
        }

        switch($t):

            case 'turkce':

                $this->d = 0;

                $this->langChanged = SysLed::get('effective_lang_number') !== 0 ? true : false;

                if ($this->langChanged){

                    $this->previousLang = SysLed::get('effective_lang_number');
                }
                
                Sysled::set('effective_lang_number',0);

            break;

            case 'ingilizce':

                $this->d = 1;

                $this->langChanged = SysLed::get('effective_lang_number') !== 1 ? true : false;

                if ($this->langChanged){

                    $this->previousLang = SysLed::get('effective_lang_number');
                }
                
                Sysled::set('effective_lang_number',1);

            break;

            default:

                $this->setDefaults();

            break;

        endswitch;
    }
}
?>