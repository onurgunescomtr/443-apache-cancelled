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

Version\VersionCheck::dkontrol(__FILE__,'4.4.3');
/**
 * PathWays - Yollar
 */
class PathWays{

    /**
     * @var array $figure
     */
    private const figures = [
        '0' => 'first','1' => 'second','2' => 'third','3' => 'fouth','4' => 'fifth','5' => 'sixth'
    ];
    /**
     * @var string $process
     */
    private string|null $process = null;
    /**
     * @var string $subProcess
     */
    private string|null $subProcess = null;
    /**
     * @var int processLayer
     */
    private int $processLayer = 0;
    /**
     * @var int $permittedProcessLayer
     */
    private int $permittedProcessLayer = 5;
    /**
     * @var mixed|null|string $rawQuery
     */
    private string|null $rawQuery;
    /**
     * @var array $listQuery
     */
    private array $listQuery = [];
    /**
     * @var array $refinedQuery
     */
    private array $refinedQuery;
    /**
     * @var array infoPathWays
     */
    public const infoPathWays = [
        'path_fail' => '200.001.Request failed due to path conflict',
        'limit_fail' => '404.005.API Sorgu sınırı.'
    ];
    
    /**
     * @method urlCleanser
     */
    protected function urlCleanser(string $incoming = null)
    {
        $ridoff = ['%','(',')',"'",'"','<','>','{','}',']','[','\\','$',';','&#36;'];

        $change = [null];

        return str_replace($ridoff,$change,trim($incoming));
    }

    /**
     * @method pathControl()
     * @param string $u
     * @return array $listQuery
     */
    protected function pathControl(string $u): array
    {
        $a = parse_url($this->urlCleanser(ADDRESS . $_SERVER['REQUEST_URI']));

        $istekDizisi = parse_url($u);

        if ($this->urlCleanser($istekDizisi['host']) !== $a['host']){

            die(self::infoPathWays['path_fail']);
        }

        return array_map(array($this,'urlCleanser'),$istekDizisi);
    }

    /**
     * // PHP_URL_QUERY    PHP_URL_FRAGMENT    PHP_URL_PATH    parse_url($url, PHP_URL_PATH)
     * 
     * @method segment()
     * @param string $alan
     * @return mixed|array|string|null $parca
     */
    protected function segment(string $alan)
    {
        $url = $this->pathControl("https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

        $parca = $url[$alan] ?? null;
        
        return $parca;
    }

    public function __construct()
    {
        $this->createProcess();

        $this->createQuery();
    }

    /**
     * v.4.4.2
     * Sadece 2 işlem katmanı - 
     * 
     * v.4.4.3 createProcess - Open Source supports only 2 layers of a process
     * subProcess links must be at least 4,
     * process links must be at least 2 characters long.
     * 
     * @method createProcess()
     * @return void
     */
    private function createProcess(): void
    {
        $procExplorer = explode('/',$this->segment('path'));

        $ik = count($procExplorer);

        if ($ik === 3){

            strlen($procExplorer[2]) >= 4 ? $this->subProcess = $procExplorer[2] : $this->subProcess = 'invalid-sub-process-value';

            strlen($procExplorer[1]) >= 2 ? $this->process = $procExplorer[1] : $this->process = 'invalid-interface-name';

            $this->processLayer = 2;

        }elseif($ik === 2){

            strlen($procExplorer[1]) < 1 ? $this->process = null : $this->process = $procExplorer[1];
            
            $this->subProcess = null;

            $this->processLayer = 1;
        }
    }

    /**
     * v.4.4.2
     * 
     * @method createQuery()
     * @return void
     */
    private function createQuery(): void
    {
        $sorgu = $this->eraseFBClidStuff($this->segment('query'));

        $sorgu = $this->eraseUtmStuff($sorgu);

        if (is_string($sorgu)){
            
            $this->rawQuery = $this->urlCleanser(urldecode(implode('&',explode('%26amp%3B',AppAudit::uriHopper($sorgu)))));

            parse_str($this->rawQuery,$this->listQuery);

            $s = 0;
            foreach(array_values($this->listQuery) as $al){

                if ($s > $this->permittedProcessLayer){

                    header('HTTP/1.1 404 Not Found',true,404);

                    die(self::infoPathWays['limit_fail']);
                }
            
                $this->refinedQuery[self::figures[$s]] =  $al; // $this->refinedQuery['first']
            
                $s++;
            }
        }else{

            $this->rawQuery = null;

            $this->refinedQuery = [];
        }
    }

    /**
     * v.4.4.2.73
     * 
     * @method eraseFBClidStuff()
     * @param string|null $rawQuery
     * @return string|null
     */
    private function eraseFBClidStuff(?string $rawQuery = null): string|null
    {
        if (isset($rawQuery)){

            if (str_contains($rawQuery,'fbclid')){

                $rawQuery = null;
            }
        }

        return $rawQuery;
    }

    /**
     * v.4.4.2.77
     * 
     * @method eraseUtmStuff()
     * @param string|null $rawQuery
     * @return string|null
     */
    private function eraseUtmStuff(?string $rawQuery): string|null
    {
        if (isset($rawQuery)){

            if (str_contains($rawQuery,'utm_source') || str_contains($rawQuery,'utm_')){

                $rawQuery = null;
            }
        }

        return $rawQuery;
    }

    /**
     * 443 private function as construct return
     * v.4.4.2
     * 
     * $urlpaketi ni oluşturup döndürür
     * 
     * @method aktar() 
     * @return array $urlPaketi
     */
    public function transfer(): array
    {
        return [
            'process' => $this->process,
            'subprocess' => $this->subProcess,
            'query' => $this->refinedQuery,
            'rawquery' => $this->rawQuery,
            'processlayer' => $this->processLayer
        ];
    }
}
?>