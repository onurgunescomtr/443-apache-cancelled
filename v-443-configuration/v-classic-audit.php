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
 * Audit - KlasikDenetim
 */
class Audit{

    public const uriCharacterList = [
        'TR' => ['Ü' => 'u','ü' => 'u','Ç' => 'c','ç' => 'c','Ö' => 'o','ö' => 'o','Ş' => 's','ş' => 's','Ğ' => 'g','ğ' => 'g','I' => 'i','ı' => 'i','İ' => 'i']
    ];

    /**
     * Classic light impact random string.
     * Missing characters are dropped consciously
     * 
     * @method randStrLight()
     * @param int $l
     * @return string $r
     */
    public static function randStrLight(int $l = 10): string
    {
        $m = intval(round((rand(5,20) * 0.5), 0, PHP_ROUND_HALF_UP));
        
        return substr(str_shuffle('0kT8pQV951h2m3AwBzCaF4b516GcTHY78KSWQL9PMXZ0deiO'),$m,($m + $l));
    }

    /**
     * Classic random string.
     * 
     * @method randStr()
     * @param int $l
     * @return string $r
     */
    public static function randStr(int $l): string
    {
        $m = intval(round((rand(1,$l) * 0.5),0,PHP_ROUND_HALF_UP));
        
        return substr(str_shuffle(str_repeat('xgEj0kT8pQVf9s51h2m3AwBzCaF4b516GcTHjY78KSWnQ0L9PMXZ0deiOz',$l)),$m,($m + $l));
    }

    /**
     * Classic random session identifier string.
     * 
     * @method randStrAuth()
     * @param int $l
     * @return string $r
     */
    public static function randStrAuth(int $l): string
    {
        return base64_encode(substr(str_shuffle(str_repeat('01jKRMAS473jsq91ovlM7380W23AB4k8751CcP103574Oa963PZ46iNzm794108b6541qJ98753F9f4b56GTHY7u8KSWQ1HL9PMXZdei', $l)), 12, $l));
    }

    /**
     * Classic array shuffle
     * Returns given number of key value pairs
     * 
     * @method randArray()
     * @param array $dizi
     * @param int $num
     * @return array $r
     */
    public static function randArray(array $dizi,int $num = 1): array
    {
        $keys = array_keys($dizi);

        shuffle($keys);

        $r = [];

        for ($i = 0; $i < $num; $i++){

            $r[$keys[$i]] = $dizi[$keys[$i]];
        }

        return $r;
    }

    /**
     * Classic variable type checking
     * 
     * @method typeCheck()
     * @param string $type
     * @param mixed $deger
     * @return bool
     */
    public static function typeCheck(string $type,mixed $deger): bool
    {
        return match($type){

            'int' => is_int($deger),

            'float' => is_float($deger),

            'string' => is_string($deger),

            'bool' => is_bool($deger),

            'array' => is_array($deger),

            'object' => is_object($deger)
        };
    }

    /**
     * Classic type setter. Does not exchange it.
     * 
     * @method __type()
     * @param $dtipi
     * @param $d
     */
    public static function __type($d,string $dtipi)
    {
        if (is_float($d) && $dtipi === 'int'){

            $d = round($d,1,PHP_ROUND_HALF_UP);
        }
        
        settype($d,$dtipi);

        return $d;
    }

    /**
     * v4 preg author -> github/jaywilliams http://gist.github.com/119517
     * Classic http unnecessary thingies cleaner
     * 
     * @method fairHtml()
     * @param string $deger
     * @return string $degerYeni
     */
    public static function fairHtml(string $deger): string
    {
        $deger = htmlspecialchars(trim($deger),ENT_QUOTES,'UTF-8');

        $deger = preg_replace("/[^\x01-\x7F]/",'',$deger);

        $kurtul = array('%','(',')',"'",'"','<','>','{','}',']','[','\\','$');

        $degistir = array("&#37;","&#40;","&#41;","&apos;","&quot;","&lt;","&gt;","&#123;","&#125;","&#93;","&#91;","&#92;&#92;","&#36;");

        return stripslashes(str_replace($kurtul,$degistir,$deger));
    }

    /**
     * 443 its nice to have a seperate function for this. should be inside ClassicString i am not sure.
     * 
     * @method fairString()
     * @param string $w
     * @return string
     */
    public static function fairString(string $w): string
    {
        $bt = ['<','>','?','$','_'];

        $non = [null];

        return str_replace($bt,$non,preg_replace("/[^\x01-\x7F]/",'',stripslashes(trim($w))));
    }

    /**
     * Classic text to uri part converter
     * 
     * @method makeUri()
     * @param string $text
     * @return string
     */
    public static function makeUri(string $text): string
    {
        $new = mb_convert_case(strtr($text,self::uriCharacterList[LANG]),MB_CASE_LOWER,"UTF-8");

        str_contains($new,' ') ? $k = implode('-',explode(' ',$new)) : $k = $new;

        return $k;
    }

    /**
     * Classic date time in TIMEFORMAT format. Standalone, without Carbon
     * 
     * @method dateTime()
     * @return string $text
     */
    public static function dateTime(): string
    {
        $df = new \IntlDateFormatter(LANGL, \IntlDateFormatter::NONE, \IntlDateFormatter::LONG, NULL, \IntlDateFormatter::GREGORIAN, TIMEFORMAT);

        return $df->format(new \DateTime()) . ', ' . date('H:i:s');
    }

    /**
     * Classic memory peak usage in MB.
     * 
     * @method getLoad()
     * @return string $l
     */
    public static function getLoad(): string
    {
        return round(memory_get_peak_usage() / 1048576,2,PHP_ROUND_HALF_UP) . ' MB';
    }
}
?>