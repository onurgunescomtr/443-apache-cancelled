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

namespace VTS\System;
/**
 * SystemSetup - TemelAyarlar
 */
final class SystemSetup{

    /**
     * Tam Sürüm temel ayarları barındırır
     * 
     * @var object $setup
     */
    private object $setup;
    /**
     * Tam sürüm lokal makina
     * 
     * @var bool $local
     */
    private bool $local;
    /**
     * @var string $logFolder
     */
    private string $logFolder = BASE . '/' . RELEASE . '-logs';
    /**
     * @var string $logFolderSystem
     */
    private string $logFolderSystem = BASE . '/' . RELEASE . '-configuration' . '/' . 'setup-update' . '/' . 'logs' . '/' . RELEASE . '-setup';
    /**
     * @var string $systemFilesFolder
     */
    private string $systemFilesFolder = RELEASE . '-configuration' . '/' . 'system-files';
    /**
     * @var string $systemSetupUpdateFolder
     */
    private string $systemSetupUpdateFolder = BASE . '/' . RELEASE . '-configuration' . '/' . 'setup-update';
	/**
	 * @var string $configDatabaseFolder
	 */
	private string $configDatabaseFolder = BASE . '/' . RELEASE . '-configuration' . '/' . 'database';
    /**
     * @var string $systemLogFile
     */
    private string $systemLogFile = 'system.log';
    /**
     * @var string $setupLogFile
     */
    private string $setupLogFile = 'setup-update.log';
    /**
     * @var string $errorLogFile
     */
    private string $errorLogFile = 'version4-error.log';
    /**
     * @var string $applicationLogFile
     */
    private string $applicationLogFile = 'version4-application.log';
    /**
     * @var string $mainConfigurationFile
     */
    private string $mainConfigurationFile = 'main-config.json';
    /**
     * @var array $mainConfigInfo
     */
    private array $mainConfigInfo = array(
        'tad_yok' => '200.501.Main configuration file couldnt be found.',
		'db_mysql_problem' => '200.502.Setup is configured to use a Mysql/Maria DB but there are problems. Verisanat stopped.',
		'db_mysql_pdo' => '200.503.Your PHP installation does not contain Mysql/Maria PDO driver. Verisanat stopped.'
    );
	/**
	 * @var string $connStart
	 */
	private string $connStart;
	/**
	 * @var bool $dbConn
	 */
	public bool $dbConn;
	/**
	 * @var bool $dbUser
	 */
	public bool $dbUser;

    public function __construct()
    {
        $this->getConfig();
        
        $this->setLogging();

        $this->setEnvironment();

        $this->setDevProd();
        
        $this->setMail();
        
        $this->setManagement();

        $this->setDatabase();

        $this->applicationDataType();
    }

    /**
     * 443 grab system setup loader
     * 
     * @method configure()
     * @return void
     */
    public static function configure(): SystemSetup
    {
        return new self;
    }

    /**
     * @method getConfig()
     * @return void
     */
    private function getConfig(): void
    {
        str_contains($_SERVER['HTTP_HOST'],'local') || $_SERVER['HTTP_HOST'] === 'localhost' || str_contains($_SERVER['SERVER_NAME'],'local') ? $this->local = true : $this->local = false;

        define('LOKAL',$this->local);

        $ta = new Dos;

        if ($this->local){

            $ta->cd()->fileExists($this->mainConfigurationFile) ? $this->setup = $ta->f($this->mainConfigurationFile)->read('json')->getData() : die($this->mainConfigInfo['tad_yok']);
        }else{

            $ta->cd($this->systemFilesFolder)->fileExists($this->mainConfigurationFile) ? $this->setup = $ta->f($this->mainConfigurationFile)->read('json')->getData() : die($this->mainConfigInfo['tad-yok']);
        }

        unset($ta);

        define('VER',$this->setup->version);

        define('FREL','v' . substr(VER,0,1));

        if (isset($this->setup->logFolder)){

            define('LOGFOLDER',$this->setup->logFolder);
        }else{

            define('LOGFOLDER',$this->logFolder);
        }

        define('COMMONLOG',$this->applicationLogFile);
    }

    /**
     * sahibinden başkası okuyup yazamasın
     * chmod("/birdizin/birdosya", 0600);
     * 
     * Sahibi okuyup yazsın başka herkes sadece okuyabilsin
     * chmod("/birdizin/birdosya", 0644);
     * Sahibi herşeyi yapsın, başka herkes okuyup çalıştırabilsin
     * chmod("/birdizin/birdosya", 0755);
     * Sahibi herşeyi yapsın, grup üyeleri okuyup çalıştırabilsin, diğerleri hiçbir şey yapamasın
     * chmod("/birdizin/birdosya", 0750);
	 * 
     * - bu üstteki notu bir yerden aldım ama hatırlamıyorum. yazan arkadaş bana ulaşsın iliştirelim adını sanını.
     * 
     * Log dosyalarını tanımlar yaratır
     * 
     * @method setLogging()
     * @return void
     */
    private function setLogging(): void
    {
        if (!is_dir($this->logFolderSystem)){
            
            mkdir($this->logFolderSystem,0750,true);

            file_put_contents($this->logFolderSystem . '/' . $this->systemLogFile,null);

            file_put_contents($this->logFolderSystem . '/' . $this->setupLogFile,null);
        }

        if ($this->logFolder !== LOGFOLDER && !is_dir(BASE . '/' . $this->setup->logFolder)){
            
            mkdir(BASE . '/' . $this->setup->logFolder,0750);

            if ($this->setup->server === 'apache'){

                file_put_contents(BASE . '/' . $this->setup->logFolder . '/' . '.htaccess',
                
                    file_get_contents(BASE . '/' . RELEASE . '-configuration' . '/' . 'file-templates' . '/' . 'htaccess-log-yasakla.vsda')
                );
            }
        }

        if (!is_dir($this->logFolder)){
            
            mkdir($this->logFolder,0750);
        }

        if (!is_file($this->logFolder . '/' . COMMONLOG)){

            file_put_contents($this->logFolder . '/' . COMMONLOG,null);

            if ($this->setup->server === 'apache'){

                file_put_contents($this->logFolder . '/' . '.htaccess',
                
                    file_get_contents(BASE . '/' . RELEASE . '-configuration' . '/' . 'file-templates' . '/' . 'htaccess-log-yasakla.vsda')
                );
            }
        }

        if (isset($this->setup->logFolder)){

            ini_set('error_log',BASE . '/' . $this->setup->logFolder . '/' . $this->errorLogFile);
        }else{

            ini_set('error_log',$this->logFolder . '/' . $this->errorLogFile);
        }
    }

    /**
     * Temel ayarlardan gelen setEnvironment direktifleri kontrol eder ve işler
     * DOMAINNAME, DOMAINTLD, Küresel...
     * 
     * @method setEnvironment() 
     * @return void
     */
    private function setEnvironment(): void
    {   
        if (!is_file(BASE . '/' . '.htaccess') && $this->setup->protocol === 'http' && $this->setup->server === 'apache'){

            file_put_contents(BASE . '/' . '.htaccess',
            
                file_get_contents(BASE . '/' . RELEASE . '-configuration' . '/' . 'file-templates' . '/' . 'htaccess-hosting-kurulum.vsda')
            );
        }

        define('SERVER',$this->setup->server);

        define('PROTOKOL',$this->setup->protocol);

        define('VERISANATKURESELKONTROL','GLOBALS');

        define('DOMAINNAME',$this->setup->domainName);
        define('DOMAINTLD',$this->setup->domainTLD);
        
        define('CONTACTNAME',$this->setup->contactName);

        define('SMTPPASSWORD',$this->setup->smtpPass);
    }

    /**
     * Geliştir modulu açıksa localhost için duzenlemeleri yapar
     * 
     * @method setDevProd()
     * @return void
     */
    private function setDevProd(): void
    {
        if ($this->setup->develop){

            header("Pragma: no-cache");

            header("Cache-Control: no-cache, must-revalidate");

            clearstatcache();

            // console - linux tests

            define('ADDRESS','http://localhost');

            define('DOMAIN','localhost');

            ini_set('session.cookie_domain', DOMAIN);

            $dos = new Dos;

            if ($dos->cd(RELEASE . '-module' . '/' . 'modular-structure')->folderHasAny()){

                if ($this->setup->server === 'apache'){

					try{

						$dos->f('.htaccess')->deleteFile();
					}catch(VerisanatDosException $e){

						\VTS\Debug::see($e->getMessage());

						die('Server changed. Please renew current page.');
					}
                }

                $dos->f('modul-islemler.json')->deleteFile();
            }

            unset($dos);

            define('BCOOKIE',mb_strtoupper(DOMAINNAME,'UTF-8'));

            define('VSDEVMODE',true);

            ini_set('display_errors','on');

        }else{

            header("Cache-Control: public,max-age=1200,stale-while-revalidate=3600");

            define('ADDRESS','https://www.' . DOMAINNAME . '.' . DOMAINTLD);
            define('DOMAIN',DOMAINNAME . '.' . DOMAINTLD);

            ini_set('session.cookie_domain', '.' . DOMAIN);

            define('BCOOKIE',mb_strtoupper(DOMAINNAME,'UTF-8') . mb_strtoupper(DOMAINTLD,'UTF-8'));

            define('VSDEVMODE',false);

            ini_set('display_errors','off');
        }

        define('UCOOKIE',mb_strtoupper(DOMAINNAME . 'V4','UTF-8'));

        define('MCOOKIE',mb_strtoupper(DOMAINNAME . 'V4M','UTF-8'));
    }

    /**
     * email için gerekli bilgileri ve direktifleri atar
     * 
     * @method setMail() 
     * @return void
     */
    private function setMail(): void
    {
        define('PREFIX',DOMAINNAME . DOMAINTLD);
        define('MAILHOST','mail.' . DOMAIN);
        define('MAILSENDER',CONTACTNAME . '@' . DOMAIN);
        define('MAILSENDERPASS',SMTPPASSWORD);
        define('SUPPORT','support@' . DOMAIN);
        define('CONTACT',CONTACTNAME . '@' . DOMAIN);
        define('DKIMSUPPORT',0);
    }

    /**
	 * [EN] Defines user and login related address URIs. Regulates session functionality.
     * [TR] Yönetim panelin işlem adresini atar. Oturum işlevini düzenler.
     * 
     * @method setManagement() 
     * @return void
     */
    private function setManagement(): void
    {
        define('AP', $this->setup->ap);

        define('APLOGINURI', $this->setup->apLoginURI);

        define('TA',$this->setup->ta);

        define('UUI',$this->setup->uui);

		define('LOGINURI',$this->setup->loginURI);

		define('UVURI',$this->setup->accountVerificationURI);

        $tx = '00'; $yx = '00';

        // console session rumble

        $sn = 'VS62' . (string)$tx . '43' . (string)$yx;

        session_name($sn);

        define('VSSESSION',$this->setup->vSession);

        define('SUDOSESSION',$this->setup->suSessionName);
    }

    /**
     * @method setDatabase()
     * @return void
     */
    private function setDatabase(): void
    {
        if ($this->setup->database){

            define('DATABASETYPE',match($this->setup->dbtype){

                'mysql' => $this->launchMysqlSetup(),
                'postgresql' => $this->launchPsqlSetup(),
                'sqlite' => $this->launchLiteSetup()
            });
        }else{

			require_once $this->configDatabaseFolder . '/' . 'v-base-unavailable-control.php';
		}
    }

    /**
     * @method launchMysqlSetup()
     * @return void
     */
    private function launchMysqlSetup(): void
    {
		if (!in_array('mysql',\PDO::getAvailableDrivers(),true)){

			die($this->mainConfigInfo['db_mysql_pdo']);
		}

		if (!$this->testConnection()){

			die($this->mainConfigInfo['db_mysql_problem']);
		}else{

			require_once RELEASE . '-external-sources' . '/' . 'idiorm.php';
			require_once RELEASE . '-external-sources' . '/' . 'paris.php';
	
			require_once RELEASE . '-configuration' . '/' . 'database' . '/' . 'v-base-' . 'mysql' . '-control.php';
	
			\ORM::configure($this->connStart);

			if ($this->setup->server === 'verisanat'){

				\ORM::configure('driver_options',array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',\PDO::ATTR_PERSISTENT => true));
			}else{

				\ORM::configure('driver_options',array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
			}
	
			\ORM::configure('username',$this->setup->dbuser);
	
			\ORM::configure('password',$this->setup->dbpass);
	
			\ORM::configure('return_result_sets',true);
	
			\ORM::configure('logging',true);
	
			\ORM::configure('caching',true);
	
			\ORM::configure('caching_auto_clear',true);
	
			// console - multi db
		}
    }

    /**
     * @method launchPsqlSetup()
     * @return void
     */
    private function launchPsqlSetup(): void
    {
        // console - postGre
    }

    /**
     * @method launchLiteSetup()
     * @return void
     */
    private function launchLiteSetup(): void
    {
        // console - sqLite
    }

	/**
	 * New test function for VTS 443 OpenSource - mysql only
	 * 
	 * @method testConnection()
	 * @return bool $dbConn
	 */
	private function testConnection(): bool
	{
		$this->connStart = 'mysql:host=' . $this->setup->dbhost . ';' . 'dbname=' . $this->setup->dbname . ';';

		$this->dbConn = true;

		$this->dbUser = true;

		try{

			$testDb = new \PDO($this->connStart,$this->setup->dbuser,$this->setup->dbpass);
		}catch(\Exception $e){

			$this->dbConn = false;

			if (str_contains($e->getMessage(),'such file or directory')){

				$report = 'Database host or the database schema couldnt be found.';
			}else{

				$report = 'Database found but there are errors.';

				$this->dbUser = false;
			}

			\VTS\Debug::see($report . PHP_EOL . $e->getMessage());
		}

		unset($testDb);
		
		return $this->dbConn;
	}

    /**
     * Sürüme göre uygulama temel gereksinimleri yükler
     * 
     * @method applicationDataType()
     * @return void
     */
    private function applicationDataType(): void
    {
        // console - vsdatatype

        define('OZELBIRIMLER',[
            $this->setup->ap => [
                'processInterface' => $this->setup->ap,
                'parcalar' => (int)5,
                'html' => null
            ],
            $this->setup->ta => [
                'processInterface' => $this->setup->ta,
                'parcalar' => (int)1,
                'html' => null
            ]
        ]);
    }
}
?>