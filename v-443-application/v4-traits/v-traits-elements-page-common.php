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
 *                          verisanat@outlook.com
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

Version\VersionCheck::dkontrol(__FILE__,'4.4.2');

trait CommonPageElements{

    private string $theNonString = '<div class="d-none">%s is not available right now.</div>';
    /**
     * @var string $facebookLogin
     */
    private string $facebookLogin = '
        <div class="form-group mt-4">
            <h5>Facebook Hesabınızla Kayıt Olun</h5>
            <script>
            window.fbAsyncInit = function() {
                FB.init({
                appId            : %s,
                autoLogAppEvents : true,
                xfbml            : true,
                cookie           : true,
                version          : "%s"
                });
            };
            (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                js.src = "https://connect.facebook.net/tr_TR/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, "script", "facebook-jssdk"));
            </script>
            <div class="fb-login-button" data-width="100" data-size="medium" data-button-type="continue_with" data-auto-logout-link="true" data-use-continue-as="true"
            data-onlogin="window.location = \''. ADDRESS .'/merhaba-facebook\'"></div>
            <small class="form-text text-muted">Hiçbir koşul altında adınıza paylaşım yapılmayacaktır.</small>
            <small class="form-text text-muted">Fotoğraf ve isim Facebook tarafından sağlanmaktadır.</small>
        </div>
    ';
    private string $googleTagManBody = '
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=%s"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    ';
    private string $facebookCommentsApplet = '
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/tr_TR/sdk.js#xfbml=1&version=%s&appId=%s&autoLogAppEvents=1"></script>
        <div class="fb-comments" data-href="%s" data-width="auto" data-numposts="20"></div>
    ';
    private string $facebookLikes = '
        <div class="list-group mt-2">
            <div class="fb-like" data-href="%s" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true" data-size="small" data-colorscheme="dark"></div>
        </div>
    ';
    /**
     * @var string $classicContactUsElement
     */
    public string $classicContactUsElement = '
        <div class="container">
            <div class="row mt-2">
                <div class="col-md-6 text-center mx-auto">
                    <div class="col-auto">
                        %s
                        <form id="iletisimsayfasi" class="mx-auto mb-4 text-center" action="'. ADDRESS .'/iletisim" method="post" enctype="multipart/form-data">
                            <h5 class="mb-4 text-warning"> %s </h5>
                            <div class="form-group text-center">
                                <label class="font-italic"> %s </label>
                                <input type="text" class="form-control" placeholder="" name="as" autocomplete="on" autofocus required>
                            </div>
                            <div class="form-group text-center">
                                <label class="font-italic"> %s </label>
                                <input type="text" class="form-control" placeholder="" name="email" autocomplete="off" required>
                            </div>
                            <div class="form-group text-center">
                                <label class="font-italic"> %s </label>
                                <input type="text" class="form-control" placeholder="" name="telefon" autocomplete="off" required>
                            </div>
                            <div class="form-group text-center">
                                <label class="font-italic"> %s </label>
                                <textarea type="text" class="form-control" placeholder="" name="ileti" autocomplete="off" required></textarea>
                            </div>
                            <input type="hidden" class="hidden" name="giris-istegi" value="%s">
                            <div class="form-group mt-4">
                                <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                                <input type="hidden" name="action" value="iletisimsayfasi">
                            </div>
                            <button type="submit" class="btn btn-sm btn-outline-dark"> %s </button>
                            %s
                            <div class="form-group mt-2">
                                <p class="" id="sartlar-gizlilik">Kullanıcı girişi yaparak
                                    <a class="text-info font-italic" href="'. ADDRESS . '/' . RELEASE . '-publications' . '/' . 'kullanim-ve-sozlesmeler/kullanim-sartlari.html">Kullanım Şartları</a> ve <br>
                                    <a class="text-info font-italic" href="'. ADDRESS . '/' . RELEASE . '-publications' . '/' . 'kullanim-ve-sozlesmeler/gizlilik-politikasi.html">Gizlilik Politikası</a> &apos;nı kabul etmiş sayılırsınız.
                                </p>
                            </div>
                    </div>
                    </form>
                    %s
                </div>
            </div>
        </div>
    ';
    /**
     * container arayuz-sabit
     * 
     * @var string $temelkapsayici
     */
    public $temelkapsayici = '<div class="container arayuz-sabit"><div class="row arayuz-sabit mb-2">%s</div></div>';
    /**
     * @var string $kartlartamam
     */
    public $kartlartamam = '<div class="card-columns col-md-9 p-sol-yok p-sag-duzenle">%s</div>';
    /**
     * link, fotograf, başlık, özet yazı
     * 
    * @var string $kartlar
    */
    public $kartlar = '<a href="%s">
        <div class="card shadow border-secondary">
            <img src="%s" class="card-img-top">
            <div class="card-body">
                <h5 class="card-title">%s</h5>
                <strong class="d-inline-block mb-2 text-primary">%s</strong>
                <p class="card-text">%s</p>
            </div>
        </div>
        </a>';
    /**
     * fotograf, başlık
     * 
    * @var string $catCard  
    */
    public $catCard = '<div class="card text-white">
    <img src="%s" class="card-img">
    <div class="card-img-overlay d-flex">
      <p class="card-title text-center align-self-center mx-auto my-auto golgever">%s</p>
    </div>
    </div>';
    /**
     * modal id - h5 modal başlığı - div modal içeriği - href link  - buton adı
     * 
     * @var string $modallinkli  
     */
    public $modallinkli = '<div class="modal fade" id="%s" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">%s</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Kapat"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
        %s
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
          <a href="%s" class="btn btn-sm btn-warning">%s</a>
        </div>
      </div>
    </div>
    </div>';
    /**
     * modal id (verisanat-modal-X) - h5 modal başlığı - div modal içeriği
     * 
     * @var string $modallinksiz 
     */
    public $modallinksiz = '<div class="modal fade" id="%s" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">%s</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Kapat"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
        %s
        </div>
        <div class="modal-footer"></div>
      </div>
    </div>
    </div>';
    /**
     * modal data-target  -  buton adı
     * 
     * @var string $modalbuton  
     */
    public $modalbuton = '<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#%s">%s</button>';
    /**
     * standart uygulama mt-4 div'li img-fluid rounded fotograf kapsayıcısı, img adresi.
     * 
     * @var string $tekfotograflink
     */
    public $tekfotograflink = '<div class="mt-4"><img src="%s" class="img-fluid rounded"></div>';
    /**
     * standart uygulama yan list menu linkleri, href - adı.
     * 
     * @var string $yanbarlink
     */
    public $yanbarlink = '<a href="%s" class="list-group-item list-group-item-action list-group-item-dark bg-verisanat-kapali">%s</a>';
    
    /**
     * standart uygulama footer
     * 
     * @var string $genelfooter
     */
    public $genelfooter = '
        <footer class="footer mt-auto p-sm-1 arka-plan-bilgi %s">
            <div class="container">
                <div class="row m-2">
                    <div class="col-md-12 px-0 text-center">
                        <p class="my-2 text-muted">%s &copy; Tüm İçerik ve Yazılım Hakları Saklıdır.</p>
                        <p class="mt-2 text-muted"><a href="https://www.verisanat.com">Verisanat v.4 </a> ile oluşturuldu. &copy; 2012 - %s. %s</p>
                    </div>
                </div>
            </div>
        </footer>
    ';
    /**
     * sayfa içinde başlık yapısı
     * 
     * @var string $normalsayfabasligi 
     */
    public $normalsayfabasligi = '
        <div class="col-md-12 p-sol-yok d-none d-md-block d-lg-block">
            <h5>
                <span class="bg-verisanat-acik rounded p-1 mx-auto">%s</span>
            </h5>
        </div>
    ';
    /**
     * mobilde header mobil menüye kaydıkça sabitlenen ana sayfadan başlıklar
     * 
     * @var string $mobilyapiskanbaslik
     */
    public $mobilyapiskanbaslik = '
        <div class="d-md-none d-lg-none d-sm-block mt-1 bg-verisanat-acik sticky-top mobil-ortala rounded-lg mobil-yapiskan-baslik">
            <h5 class="mt-1 text-center">%s</h5>
        </div>
    ';
    /**
     * yanbar ile kullanılabilecek ekran ogesi, col-9
     * 
     * @var string $biroge
     * @param string %s öğe adı (başlık)
     * @param string %s fotoğraf (dosya adı)
     * @param string %s öğe içeriği (yazı)
     * @param string %s sayfa eki - yorumlar - facebook eklentisi vb.
     */
    public $biroge = '
        <div class="col-md-9 d-flex p-sol-yok p-sag-duzenle kucuk-ekran-yasla mt-2">
            <h3 class="mb-4 mx-auto mobil-yazi">%s</h3>
            <img class="img-fluid align-self-center mx-auto mb-2" src="%s">
            <div class="text-justify secimyok mobil-yazi yazi">%s</div>
            %s
        </div>
    ';
    /**
     * tam ekran ogesi, col-12
     * 
     * @var string $birogetam
     * @param string %s öğe adı (başlık)
     * @param string %s fotoğraf (dosya adı)
     * @param string %s öğe içeriği (yazı)
     * @param string %s sayfa eki - yorumlar - facebook eklentisi vb.
     */
    public $birogetam = '
        <div class="col-md-12 d-flex p-sol-yok p-sag-duzenle kucuk-ekran-yasla mt-2">
            <h3 class="mb-4 mx-auto mobil-yazi">%s</h3>
            <img class="img-fluid align-self-center mx-auto mb-2" src="%s">
            <div class="text-justify secimyok mobil-yazi yazi">%s</div>
            %s
        </div>
    ';
    /**
     * @var string $yanmenukapsayici
     */
    public $yanmenukapsayici = '<div class="text-center sticky-top menu-acaip rounded d-none d-lg-block p-sag-yok p-sol-yok">%s</div>';
    /**
     * @var string $anasayfablogu
     */
    public $anasayfablogu = '<div class="col-md-9 d-flex order-1 p-sol-yok p-sag-yok kucuk-ekran-yasla">%s</div>';
    /**
     * @var string $anasayfabloguiki
     */
    public $anasayfabloguiki = '<div class="col-md-9 d-flex order-5 p-sol-yok p-sag-yok kucuk-ekran-yasla">%s</div>';
    /**
     * @var string $anasayfakartblogu
     */
    public $anasayfakartblogu = '<div class="card-columns order-6 col-md-9 p-sol-yok p-sag-duzenle">%s</div>';
    /**
     * @var string $anasayfakartblogu
     */
    public $sayfaKartBlogu = '<div class="card-columns col-md-12 p-sag-yok p-sol-yok">%s</div>';
    /**
     * @var string $gettingReady
     */
    private string $gettingReady = '
        <div class="container-fluid arayuz-sabit arka-plan-bilgi vh-100">
            <div class="row arayuz-sabit">
                <div class="col-md-12">
                    <h5 class="text-center text-success mt-4">%s is loading / getting ready. Please check back later</h5>
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" role="status"></div>
                    </div>
                </div>
            </div>
        </div>
    ';
}
?>