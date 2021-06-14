<?php declare(strict_types = 1);
/**
* Verisanat v.4 https://onurgunescomtr@bitbucket.org/onurgunescomtr/verisanat-v.4.git
 * https://github.com/onurgunescomtr/verisanat
* facebook: https://www.facebook.com/onur.gunes.developer
* twitter: https://twitter.com/onurgunescomtr
* verisanat: https://www.verisanat.com/iletisim
* email: verisanat@outlook.com

* Tüm hakları saklıdır.

 * @package		Verisanat v.4.4.2
 * @author		Onur Güneş - https://www.facebook.com/onur.gunes.developer - https://www.twitter.com/onurgunescomtr
 * @copyright	Copyright (c) 2012 - 2021 Onur Güneş (https://www.verisanat.com, https://www.onurgunes.com.tr)
 * @license		Tüm hakları saklıdır. All Rights Reserved.
 * @link		https://www.verisanat.com
*/

VTS\Version\VersionCheck::dkontrol(__FILE__,'4.4.3');

class VsKilit extends \Model{}
class VsLogsistekler extends \Model{}
class VsLogskilit extends \Model{}
class VsIletisim extends \Model{}
class VsKategori extends \Model{

    public function adi(){

        return $this->adi;
    }
}
?>