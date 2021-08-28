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
/**
 * Http
 */
class Http{

    /**
     * @var array $netInfo
     */
    private const netInfo = [
        'nop' => '200.401.hmm... no such thing exits.',
        'illegal_tek' => '200.331.illegal activity address. IP address is blocked.',
        'illegal_blok' => '200.330.illegal activity address. IP address range is blocked.',
        'vekil_sunucu' => '200.316.proxy server detected.',
        'gecersiz_istek' => '200.311.invalid request.',
        'zaman_asimi' => '200.312.timeout.maybe its overloaded.',
        'yasakli_dosya' => '200.313.request is outside of application scope.you cant direct request files from Verisanat APIs.',
        'gereksiz_tarayici' => '200.314.unnecessary runtime.',
        'izinsiz_bot' => '200.315.unauthorized bot - crawler - bs.',
        null => '200.316.charateristic access blocker.'
    ];
    /**
     * @var array httpInfo
     */
    private const httpInfo = [
        'htmlResponseBox' => '
            <div class="sticky-top uyarilar text-center alert alert-success alert-dismissible fade show" role="alert">
                <strong>%s : </strong> %s
                <button type="button" class="close" data-bs-dismiss="alert">
                    <i class="bi bi-x-circle"></i></span>
                </button>
            </div>',
        'htmlResponseBoxFail' => 
            '<div class="sticky-top uyarilar text-center alert alert-danger alert-dismissible fade show" role="alert">
                <strong>%s : </strong> %s
                <button type="button" class="close" data-bs-dismiss="alert">
                    <i class="bi bi-x-circle"></i></span>
                </button>
            </div>'
    ];
    /**
     * @var array htmlResponseLang
     */
    private const htmlResponseLang = [
        'done' => [
            'TR' => 'Tamamlandı',
            'EN' => 'Completed'
        ],
        'fail' => [
            'TR' => 'Başarısız',
            'EN' => 'Failed'
        ]
    ];
    /**
     * @method guide()
     * @param string $where
     * @param string $type
     * @param string $message
     * @return void
     */
    public static function guide(string $where,string $type = 'error',string $message = null): void
    {
        SysLed::set('http_warning_type',$type);

        SysLed::set('http_guide_information',$message);

        header('Location: ' . $where);

        exit;
    }

    /**
     * @method inform
     * @param string $type - warn / error
     * @param string $message
     * @return void
     */
    public static function inform(string $type,string $message): void
    {
        SysLed::set('http_warning_type',$type);

        SysLed::set('http_guide_information',$message);
    }

    /**
     * @method forward()
     * @param string $message
     * @return void
     */
    public static function forward(string $message): void
    {
        SysLed::set('public_info_container',$message);
    }

    /**
     * @method dispatch()
     * @param string $where
     * @return void
     */
    public static function dispatch(string $where): void
    {
        header('Location: ' . $where);

        exit;
    }

    /**
     * @method report()
     * @return string
     */
    public static function report(): null|string
    {
        $httpReportText = match(SysLed::get('http_warning_type')){

            'warn' => sprintf(self::httpInfo['htmlResponseBox'],self::htmlResponseLang['done'][LANG],SysLed::get('http_guide_information',true)),

            'error' => sprintf(self::httpInfo['htmlResponseBoxFail'],self::htmlResponseLang['fail'][LANG],SysLed::get('http_guide_information',true)),

            false => null
        };

        $fromModules = SysLed::get('public_info_container',true);

        if (is_string($fromModules)){

            $httpReportText .= $fromModules;
        }

        if (is_string($httpReportText)){

            return $httpReportText;
        }else{

            return null;
        }
    }

    /**
     * Classic HTTP Get - $_GET[]
     * 
     * @method __gx()
     * @param string $deger
     * @param string $default
     * @return string $v
     */
    public static function __gx(string $deger,string $default = null): string
    {
        if (preg_match('~[^\x20-\x7E]~',trim($deger)) > 0 || strpos($deger, "\0") !== false){

            die(BASICWARN['close_get']);
        }

        if (!isset($_GET[$deger])){

            return $default ?? 'emptyVarString';
        }else{

            return Audit::__type(Audit::fairHtml(strip_tags($_GET[$deger])),'string');
        }
    }

    /**
     * @method __px()
     * @param string $postVariable
     * @param mixed|null $type
     * @param mixed|null $default
     * @return mixed|null|void|string|int
     */
    public static function __px(string $postVariable,?string $type = null,?string $default = null)
    {
        $form = false;

        if (isset($_SERVER['CONTENT_TYPE'])){

            if (!$_SERVER['CONTENT_TYPE'] === 'application/x-www-form-urlencoded' && !stristr($_SERVER['CONTENT_TYPE'],'multipart')){
                
                $form = true;
            }

            if (preg_match('~[^\x20-\x7E\t\r\n]~', $postVariable) > 0 || strpos($postVariable, "\0") !== false || $form){

                AppAudit::manageRequestCount($_SERVER['REMOTE_ADDR']);
                
                AppAudit::ban();
            }

            if (!isset($_POST[$postVariable])){

                return $default;
            }else{

                if (isset($type)){

                    $r = Audit::fairHtml(strip_tags($_POST[$postVariable]));

                    settype($r,$type);

                    return $r;
                }else{

                    return Audit::fairHtml(strip_tags($_POST[$postVariable]));
                }
            }
        }
    }
    
    /**
     * @deprecated  4.4.3 - 04052021
     * @method closeConForbidden()
     * @return void
     */
    public static function closeConForbidden(string $bildir): void
    {
        header('HTTP/1.1 403 Forbidden',true,403);

        die(self::netInfo[$bildir]);
    }

    /**
     * @deprecated 4.4.3 - 04052021
     * @method closeConTimeout()
     * @return void
     */
    public static function closeConTimeout(string $bildir): void
    {
        header('HTTP/1.1 408 Request Timeout',true,408);

        die(self::netInfo[$bildir]);
    }

    /**
	 * Handle redundant response.
	 * 
	 * @method manageRedundantRequest()
     * @param int $launchKey
     * @param string|null $so
     * @return void
     */
    public static function manageRedundantRequest(int $launchKey = 404,?string $so = null): void
    {
        switch($launchKey):

            case 404:

                header('HTTP/1.1 404 Not Found',true,404);

                die(self::netInfo['nop']);

            break;
            case 408:

                header('HTTP/1.1 408 Request Timeout',true,408);

                die(self::netInfo['zaman_asimi']);
            break;
            case 403:

                header('HTTP/1.1 403 Forbidden',true,403);

                die($so);
            break;
            case 1001:

                die('WTF!');
            break;

        endswitch;
    }

    /**
	 * Server type verisanat | apache common response function with 'exit'
	 * 
	 * 443 - openSource edition
	 * 
     * @method respond()
     * @param string $screen
     * @return void
     */
    public static function respond(string $screen): void
    {
        if (App::getApp('compressedPages') && ob_start('ob_gzhandler',0,PHP_OUTPUT_HANDLER_STDFLAGS)){

            echo $screen;

            if (str_contains($_SERVER['SERVER_SOFTWARE'],'Development')){

                header('Content-Lenght: ' . ob_get_length());
            }

            $result = ob_end_flush();
        }else{

            echo $screen;
        }

        exit;
    }
}
?>