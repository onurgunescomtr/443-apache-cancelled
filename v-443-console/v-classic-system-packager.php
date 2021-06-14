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

namespace VTS\System;

use DateTime;
use VTS\Audit;

/**
 * 412 443 - Standalone CLI package creator. Has its own loader.
 * 
 * - usage: $z = \VTS\System\Packager::createPackage()->autoSetup('openSource');
 * 
 * - i am including this in openSource version too to get a glimpse about how
 * verisanat account works under the hood for user operations.
 * 
 * @version 4.4.3
 */
class Packager{

    public const TYPES = [
        'appExtension',
        'configExtension',
        'standalone',
        'control'
    ];

    public const extensionList = [];

    public const interfaces = [];

    public const languagePack = [
        'folderName' => 'language-packs',
        'type' => 'appExtension',
        'fileList' => [
            'yeni-turkce',
            'yeni-ingilizce'
        ]
    ];

    private const apache_one = '<FilesMatch "\.(vsda|vsdm|json)$">
    Require local
    </FilesMatch>';

    private const apache_two = 'Options All -Indexes +FollowSymLinks -MultiViews
        IndexIgnore *
        FileETag MTime Size
        <FilesMatch "\.(ico|pdf|flv|jpg|jpeg|png|gif|js|css)$">
        Header unset Last-Modified
        </FilesMatch>
        <FilesMatch "\.(ico|pdf|flv|jpg|jpeg|png|gif|js|css)$">
        Header set X-Content-Type-Options nosniff
        </FilesMatch>
        <FilesMatch "\.(json)$">
        Require local
        </FilesMatch>
        #Header set Access-Control-Allow-Origin "https://www.verisanat.com/"
        RewriteEngine On

        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_URI} !.*\.(ico|gif|jpg|jpeg|png|js|css)

        RewriteRule ^(.*)$ /index.php [L,QSA]

        AddDefaultCharset UTF-8
    ';

    private const systemFiles = [
        'restricted-ip-address-ranges.json',
        'restricted-ip-addresses.json'
    ];

    public const openSource = [
        'configuration' => [
            'traits' => [],
            'apps' => [],
            'templates' => [],
            'folderName' => 'configuration',
            'isClassic' => true,
            'type' => 'standalone',
            'fileList' => [
                'app',
                'debug',
                'dos',
                'exception',
                'http',
                'registry',
                'setup',
                'system-inspection',
                'system-loader',
                'system-user',
                'system',
                'version'
            ]
        ],
        'application' => [
            'traits' => [
                'ability-module-db',
                'ability-module-frame',
                'ability-module-page',
                'elements-frame-common',
                'elements-module-common',
                'elements-page-common',
                'internal-builder',
                'internal-screen',
                'internal-structure-os',
                'internal-user'
            ],
            'internal-classics' => [
                'screen',
                'string'
            ],
            'internal-apps' => [
                'contact',
                'about',
                'static-responses'
            ],
            'templates' => [],
            'folderName' => 'application',
            'isClassic' => false,
            'type' => 'control',
            'fileList' => [
                'audit',
                'frame',
                'interface',
                'language',
                'launch',
                'module',
                'network-audit',
                'page',
                'url'
            ],
            'extension' => [
                'languagePack'
            ]
        ],
        'module' => [
            'structure' => [],
            'traits' => [],
            'configurations' => [],
            'fileList' => [
                'gelistir',
                'journal'
            ]
        ],
        'launcher' => [
            'type' => 'apache',
            'file' => 'index.php'
        ]
    ];

    public const openSourceFolderName = 'v-open-source-package';

    public const cliPackFolderName = 'v-cli-package';

    private const autoPackages = [
        0 => 'configuration',
        1 => 'application',
        2 => 'module'
    ];

    private string $target;

    public function __construct(

        private string $source = BASE . '/' . RELEASE . '-'
    )
    {
        set_error_handler([__CLASS__,'expandErrorHandling'],E_WARNING);   
    }

    public static function createPackage(): Packager
    {
        if (is_dir(dirname(BASE) . '/' . self::openSourceFolderName) || is_dir(dirname(BASE) . '/' . self::cliPackFolderName)){

            die('A package is created already.');
        }

        echo 'Package creation started: ' . date('d m Y, H:i:s') . PHP_EOL;

        return new self;
    }

    public function autoSetup(string $package): void
    {
        match($package){

            'openSource' => $this->buildOpenSource(),

            default => $this->cancelOp()
        };
        
    }

    public function buildOpenSource(array $types = self::autoPackages): void
    {
        if (mkdir(dirname(BASE) . '/' . self::openSourceFolderName,0750)){

            $this->writeConfig($types);

            $this->writeApplication($types);

        }else{

            die('Couldnt create package folder. Exiting...');
        }
    }

    private function writeConfig(array $types): void
    {
        mkdir(dirname(BASE) . '/' . self::openSourceFolderName . '/' . RELEASE . '-' . self::openSource[$types[0]]['folderName'],0750);

        $a = 0;
        foreach(self::openSource[$types[0]]['fileList'] as $t){

            $filename = match(true){

                self::openSource[$types[0]]['isClassic'] => 'v-classic-' . $t . '.php',

                default => $t . '.php'
            };

            $this->writer(self::openSource[$types[0]]['folderName'],$filename);

            $a++;
        }

        $this->giveOutInfo($a,$types[0],$types[1]);
    }

    private function writeApplication(array $types): void
    {
        mkdir(dirname(BASE) . '/' . self::openSourceFolderName . '/' . RELEASE . '-' . self::openSource[$types[1]]['folderName'],0750);

        $this->applicationTraits($types[1]);

        $a = 0;
        foreach(self::openSource[$types[1]]['fileList'] as $t){

            $filename = 'v-' . $t . '-' . self::openSource[$types[1]]['type'] . '.php';

            $this->writer(self::openSource[$types[1]]['folderName'],$filename);

            $a++;
        }

        $this->giveOutInfo($a,$types[1],$types[2]);
    }

    private function applicationTraits(string $traitType): void
    {
        if (count(self::openSource[$traitType]['traits']) > 0){

            $traitFolder = RELEASE . '-' . self::openSource[$traitType]['folderName'] . '/' . 'v4-traits';

            mkdir(dirname(BASE) . '/' . self::openSourceFolderName . '/' . $traitFolder,0750);

            $b = 0;
            foreach(self::openSource[$traitType]['traits'] as $t){

                $fn = 'v-traits-' . $t . '.php';

                $this->internalWriter($traitFolder,$fn);

                $b++;
            }

            echo 'Done copying ' . $b . ' ' . $traitType . ' traits.' . PHP_EOL;
        }else{

            echo "\t" . 'There is no traits to copy for ' . $traitType . '.' . PHP_EOL;
        }
    }

    private function applicationInternals(): void
    {
        /* $internalFolderID = 'v4-internal-';

        foreach(self::openSource['application']['classics'] as $t){

            
        } */
    }

    /**
     * For source, folder name starts after BASE / 
     * For target, folder name starts after PARENTDIR / NEWDIR / 
     * 
     * @method internalWriter()
     * @param string $folderName
     * @param string $rawFileName
     * @return void
     */
    private function internalWriter(string $folderName,string $rawFileName): void
    {
        try{

            copy(
                BASE . '/' . $folderName . '/' . $rawFileName,
                
                dirname(BASE) . '/' . self::openSourceFolderName . '/' . $folderName . '/' . $rawFileName
            );
        }catch(\Exception $e){

            $this->setupLog($rawFileName,$e->getMessage());
        }
    }

    /**
     * + for source folder name starts after $this->source BASE / RELEASE '-'.
     * + for target folder name starts after PARENTDIR / NEWDIR / RELEASE '-'.
     * 
     * @method writer()
     * @param string $folderName
     * @param string $rawFileName
     * @return void
     */
    private function writer(string $folderName,string $rawFileName): void
    {
        try{

            copy(
                $this->source . $folderName . '/' . $rawFileName,
                
                dirname(BASE) . '/' . self::openSourceFolderName . '/' . RELEASE . '-' . $folderName . '/' . $rawFileName
            );
        }catch(\Exception $e){

            $this->setupLog($rawFileName,$e->getMessage());
        }
    }

    private function cancelOp(): void
    {
        die('There is no operation for this value given.');
    }

    private function expandErrorHandling(int $errorCode,string $errorInfo): void
    {
        throw new \Exception($errorInfo,$errorCode);
    }

    private function setupLog(string $what,string $message): void
    {
        file_put_contents(

                dirname(BASE) . '/' . 'v-443-setup-log.log',

                'cannot copy file: ' . $what . ' | error captured: ' . $message . PHP_EOL,

                FILE_APPEND | LOCK_EX
        );
    }

    private function giveOutInfo(int $number,string $current,string $next): void
    {
        echo 'Done copying ' . $number . ' ' . $current . ' files.' . PHP_EOL . PHP_EOL;

        echo 'Starting to copy ' . $next . ' files at ' . date('d m Y, H:i:s') . PHP_EOL;
    }
}
?>