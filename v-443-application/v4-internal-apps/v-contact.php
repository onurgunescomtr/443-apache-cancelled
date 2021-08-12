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

\VTS\Version\VersionCheck::dkontrol(__FILE__,'4.4.3');

final class ContactUs{

    use Builder;

    use Screen;

    /**
     * @var array $infoContactUs
     */
    public const infoContactUs = [
        'TR' => [
            'google' => 'Google reCAPTCHA v3 başarısız. <br> Tarayıcıyı yada sekmeyi kapatıp tekrar açarak tekrar deneyiniz. <br>Kullandığınız tarayıcıyı (Chrome, Edge, Firefox vb.) güncellemenizi öneririz. <br>Sorun devam ederse '. SUPPORT .' adresinden bilgi alabilirsiniz.',
            'form_bos' => 'Lütfen iletişim formunu doldurunuz.',
            'yazilmadi' => 'Lütfen iletinizi sosyal kanallardan ulaştırınız. Teşekkür ederiz.',
            'yazildi' => 'İletiniz bize ulaşmıştır. Teşekkür ederiz.'
        ],
        'EN' => [
            'google' => 'Google reCAPTCHA v3 failed. <br> Please restart your browser or open a new tab to try again. <br> Use modern updated browsers (Chrome, Firefox, Edge .) for your privacy and safety online. <br> If problem persists you can reach out by '. SUPPORT .' email address.',
            'form_bos' => 'Please fill the contact form completely.',
            'yazilmadi' => 'Sorry... There is a problem which is worked on right now. Please use our social channels to deliver your message.',
            'yazildi' => 'Thank you ! We got your message and react to it ASAP!'
        ]
    ];

    public function __construct($up = null)
    {
        $this->setProc($up);

        Warden::setSession();

        Warden::setOpenKey();
        
        Scribe::requestLog($this->process,$this->subProcess,$this->rawQuery);

        $this->frame = new Frame(Http::__gx('d'));

        $this->frame->frameSupport($this->process,$this->subProcess);

        $this->vui = new Page;

        Warden::setSealedKey();

        $this->getMessage();

        $this->createScreen();

        Http::respond($this->rawScreen);
        
        exit;
    }

    /**
     * @method createScreen()
     * @return void
     */
    private function createScreen(): void
    {
        $this->rawScreen = $this->startHtmlPage();

        switch($this->subProcess):

            case null:

                $this->rawScreen .= sprintf($this->vui->classicContactUsElement,
                    
                    Http::report(),

                    App::getApp('contactUri'),

                    $this->frame->translate('writetous'),

                    $this->frame->translate('namesurname'),

                    $this->frame->translate('email_address'),

                    $this->frame->translate('telephone_no'),

                    $this->frame->translate('your_message'),

                    $_SESSION['public_key'],

                    $this->frame->translate('send'),
                
                    $this->vui->getFacebookLogin(),

                    $this->frame->translate('contact_acceptance'),

                    $this->frame->translateUri('terms-and-conditions'), $this->frame->translate('term_conditions'),

                    $this->frame->translateUri('privacy-policy'), $this->frame->translate('privacy_policy'),

                    AppAudit::getGoogleCaptSpecial('g-recaptcha-response','iletisimsayfasi')
                );
                
            break;

        endswitch;

        $this->rawScreen .= $this->endHtmlPage();
    }

    /**
     * @var array $contactFormVars
     */
    private array $contactFormVars = [
        'email','telefon','as','action'
    ];

    /**
     * @method getMessage()
     * @return void
     */
    private function getMessage(): void
    {
        if (isset($_POST['giris-istegi']) && $_SESSION['public_key'] === Http::__px('giris-istegi') && isset($_POST['g-recaptcha-response'])){
            
            AppAudit::check();
            
            AppAudit::block();

            if (!AppAudit::formVarCheck($this->contactFormVars,self::infoContactUs[LANG]['form_bos'])){

                Http::dispatch(ADDRESS . '/' . App::getApp('contactUri'));
            }
            
            if (AppAudit::googleCaptSpecialCheck('g-recaptcha-response','iletisimsayfasi')){

                $this->iletisimKaydiAl();
            }else{

                Http::guide(ADDRESS . '/' . App::getApp('contactUri'),'error',self::infoContactUs[LANG]['google']);
            }
        }
    }

    /**
     * @method iletisimKaydiAl()
     * @return void
     */
    private function iletisimKaydiAl(): void
    {
        try{

            $y = \Model::factory('VsIletisim')->create();

            $y->adi_soyadi = Http::__px('as','string','Geçersiz İsim');
            $y->kullanici_hesap_no = AppAudit::getUserPageNumber();
            $y->tid = Audit::randStrLight(32);
            $y->did = 1;
            $y->date = date('d-m-Y H:i:s');
            $y->email = Http::__px('email','string','Geçersiz Email');
            $y->telefon = Http::__px('telefon','string','Geçersiz Telefon');
            $y->message = Http::__px('ileti','string','Geçersiz İleti');
            $y->ip = $_SESSION['istemciadresi'];

            $y->save();
        }catch(\Exception $h){

            Scribe::appLog('iletişim formu yazılamadı.' . $h->getMessage());

            Http::guide(ADDRESS,'warn',self::infoContactUs[LANG]['yazilmadi']);
        }

        Http::guide(ADDRESS . '/' . App::getApp('contactUri'),'warn',self::infoContactUs[LANG]['yazildi']);
    }
}
?>