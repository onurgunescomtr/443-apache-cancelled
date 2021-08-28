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

final class TesKon002{

    use Builder;

    private string $accessUrlString = 'change-to-your-secret-string';

    private array $bildirimler = [
        'TR' => [
			'yok' => 'test için gerekli dizi bulunamadı. Bi nevi yanlış kişi yanlış adres...'
		],
		'EN' => [
			'yok' => 'Wrong test access string.'
		]
	];

    private bool $zipOutputEnabled = true;

    private string $tesKonString;

    private string $tesKonGreet;

    private string|null $tesKonOps;

    private string $tesKonEnd;

    
    public function __construct($up = null,$suan = null,$teskon = null,$moduller = null)
    {
        $this->beginning($up,$suan);

        $this->operations();
           
        $this->ending();

        $this->sendScreen();
        
        exit;
    }
    
    /**
     * @method islem()
     * @return void
     */
    private function operations(): void
    {
        $this->tesKonOps = null;

        $this->see($_SESSION);

        $this->see(PHP_VERSION . ' - ' . PHP_VERSION_ID);

        // $this->see(opcache_get_status());
    }

    /**
     * @method beginning()
     * @param mixed $up
     * @param mixed $suan
     * @param mixed $teskon
     * @param mixed $moduller
     * @param string $tesKonGreet
     * @param string $kapanis
     * @return void
     */
    private function beginning(?array $up,string $suan): void
    {
        $this->setProc($up);

        if ($this->subProcess !== $this->accessUrlString){

            die($this->bildirimler[LANG]['yok']);
        }

        $this->tesKonGreet = $suan . Page::dotLine() . $_SESSION['client_address'] . 
        
        Page::dotLine() . $_SESSION['aktivite'] . Page::dotLine() . 
        
        'Begin Function Memory Usage: ' . round((memory_get_usage() / 1024),3,PHP_ROUND_HALF_UP) . ' KB' . Page::dotLine() . 
        
        'Start dump:<br><br>';
    }

    /**
     * @method ending()
     * @return void
     */
    private function ending():void
    {
        $this->tesKonEnd = 'Ending Function Memory Usage: ' . round((memory_get_usage() / 1024),3,PHP_ROUND_HALF_UP) . ' KB' . 
        
        Page::dotLine() . 'Memory peak usage: ' . Audit::getLoad();
    }

    /**
     * @method sendScreen()
     * @return void
     */
    private function sendScreen(): void
    {
        $this->tesKonString = $this->tesKonGreet . $this->tesKonOps . $this->tesKonEnd;

        if ($this->zipOutputEnabled && ob_start('ob_gzhandler',0,PHP_OUTPUT_HANDLER_STDFLAGS)){

            echo $this->tesKonString;

            if (str_contains($_SERVER['SERVER_SOFTWARE'],'Development')){

                header('Content-Lenght: ' . ob_get_length());
            }

            $result = ob_end_flush();
        }else{

            echo $this->tesKonString;
        }
    }

    /**
     * @method see()
     * @param mixed $what
     * @return void
     */
    private function see(mixed $what): void
    {
        if ($this->zipOutputEnabled){

            $this->tesKonOps .= '<pre>' . gettype($what) . ' - ' . var_export($what,true) . '</pre>' . Page::dotLine();
        }else{

            Debug::see($what);
        }
    }

    /**
     * @method oldOperations()
     * @return void
     */
    private function oldOperations(): void
    {
        $this->tesKonOps = null;
    }
}
?>