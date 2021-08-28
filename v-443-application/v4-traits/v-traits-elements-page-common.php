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
 *                          verisanat@outlook.com
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

Version\VersionCheck::dkontrol(__FILE__,'4.4.3');

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
            data-onlogin="window.location = \''. ADDRESS .'/' . 'hey-facebook\'"></div>
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
                        <form id="iletisimsayfasi" class="mx-auto mb-4 text-center" action="'. ADDRESS .'/' . '%s' . '" method="post" enctype="multipart/form-data">
                            <h5 class="mb-4 text-warning"> %s </h5>
                            <div class="form-group text-center">
                                <label class="fst-italic"> %s </label>
                                <input type="text" class="form-control" placeholder="" name="as" autocomplete="on" autofocus required>
                            </div>
                            <div class="form-group text-center">
                                <label class="fst-italic"> %s </label>
                                <input type="text" class="form-control" placeholder="" name="email" autocomplete="off" required>
                            </div>
                            <div class="form-group text-center">
                                <label class="fst-italic"> %s </label>
                                <input type="text" class="form-control" placeholder="" name="telefon" autocomplete="off" required>
                            </div>
                            <div class="form-group text-center">
                                <label class="fst-italic"> %s </label>
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
                                <p class=""> %s
                                <a class="text-primary fst-italic" href="'. ADDRESS . '/' . 'publications' . '/' . '%s' . '">%s</a> &#8212;
                                <a class="text-primary fst-italic" href="'. ADDRESS . '/' . 'publications' . '/' . '%s' . '">%s</a>
                            </div>
                    </div>
                    </form>
                    %s
                </div>
            </div>
        </div>
    ';
	/**
	 * @var string $classicRegisterElement
	 */
	public string $classicRegisterElement = '
		<div class="container text-center my-auto">
			<div class="col-auto modal-dialog-centered">
				<form id="kayitsayfasi" class="mx-auto mb-4 text-center" action="%s" method="post" enctype="multipart/form-data">
				<h5 class="mb-4">%s %s</h5>
				<div class="form-group text-center">
					<label class="fst-italic m-3">%s</label>
					<input type="name" class="form-control" placeholder="%s" name="i" autocomplete="on" autofocus required pattern="^[a-z0-9]\d{3,0}$">
				</div>
				%s
				<div class="form-group">
					<label class="fst-italic m-3">%s</label>
					<input type="password" class="form-control" name="s" placeholder="%s" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="%s" autocomplete="current-password">
					<input type="password" class="form-control mt-2" name="stekrar" placeholder="%s" required autocomplete="current-password">
					<p class="form-text text-muted pass-info">%s</p>
				</div>
				<input type="hidden" class="hidden" name="giris-istegi" value="%s">
				<div class="form-group mt-4">
					<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
					<input type="hidden" name="action" value="kayitsayfasi">
					<input type="hidden" name="yenikayit" value="tam-kullanici-kaydi">
				</div>
				<a href="'. ADDRESS . '/' . LOGINURI . '" class="btn btn-sm btn-outline-dark">%s</a>
				<button type="submit" class="btn btn-sm btn-outline-primary">%s</button>
				<div class="form-group mt-2">
					<p class=""> %s
					<a class="text-primary fst-italic" href="'. ADDRESS . '/' . 'publications' . '/' . '%s' . '">%s</a> &#8212;
					<a class="text-primary fst-italic" href="'. ADDRESS . '/' . 'publications' . '/' . '%s' . '">%s</a>
					</p>
				</div>
				%s
				</form>
			</div>
		</div>
	';
	/**
	 * @var string $formEmailElement
	 */
	public string $formEmailElement = '
		<div class="form-group text-center">
			<label class="fst-italic m-3">%s</label>
			<input type="email" class="form-control" placeholder="%s" name="postaadresi" autocomplete="on" required pattern="%s" title="Lütfen geçerli bir email adresi giriniz.">
		</div>
	';
	/**
	 * @var string $formEmailPattern
	 */
	public string $formEmailPattern = '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$';
	/**
	 * @var string $classicLoginElement
	 */
	public string $classicLoginElement = '
		<div class="container text-center vh-100">
			<div class="col-auto modal-dialog-centered">
				<form id="loginsayfasi" class="mx-auto mb-4 text-center" action="%s" method="post" enctype="multipart/form-data">
					<div class="form-group text-center">
						<label class="fst-italic m-2">%s</label>
						<input type="email" class="form-control" placeholder="%s" name="postaadresi" autocomplete="on" autofocus required>
					</div>
					<div class="form-group">
						<label class="fst-italic m-2">%s</label>
						<input type="password" class="form-control" name="s" autocomplete="on" placeholder="%s" required>
						<small class="form-text text-muted">%s</small>
					</div>
					<input type="hidden" class="hidden" name="giris-istegi" value="%s">
					<div class="form-group mt-4">
						<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
						<input type="hidden" name="action" value="loginsayfasi">
					</div>
					<a href="'. ADDRESS . '/' . '%s' . '/' . '%s" class="btn btn-sm btn-outline-dark">%s</a>
					<a href="'. ADDRESS . '/' . LOGINURI . '/' . '%s" class="btn btn-sm btn-outline-dark">%s</a>
					<button type="submit" class="btn btn-sm btn-outline-primary">%s</button>
					<div class="form-group mt-4">
			%s
					</div>
					<div class="form-group mt-2">
						<p class=""> %s
						<a class="text-primary fst-italic" href="'. ADDRESS . '/' . 'publications' . '/' . '%s' . '">%s</a> &#8212;
						<a class="text-primary fst-italic" href="'. ADDRESS . '/' . 'publications' . '/' . '%s' . '">%s</a>
						</p>
					</div>
			%s
				</form>
			</div>
		</div>
	';
    /**
     * @var string $classicChangePasswordElement
     */
    public string $classicRequestPasswordChangeElement = '
        <div class="container text-center my-auto">
            <div class="col-auto modal-dialog-centered mb-4">
                <form id="sifreislemsayfasi" class="mx-auto mb-4" action="' . ADDRESS . '/' . '%s'  . '/' . '%s" method="post" enctype="multipart/form-data">
                    <h5 class="mb-4">%s</h5>
                %s
                    <input type="hidden" class="hidden" name="giris-istegi" value="%s">
                    <input type="hidden" id="g-d-sifre-yenile" name="g-d-sifre-yenile" value="">
                    <div class="form-group mt-4 text-center">
                        <a href="'. ADDRESS . '/' . LOGINURI . '" class="btn btn-sm btn-outline-secondary mr-1">%s</a>
                        <button type="submit" class="btn btn-sm btn-outline-primary">%s</button> 
                    </div>
                    <div class="form-group mt-2">
                        <a href="'. ADDRESS . '" class="btn btn-sm btn-outline-info">%s</a>
                        <a href="'. ADDRESS . '/' . '%s" class="btn btn-sm btn-outline-danger">%s</a>
                    </div>
                </form>
                
            </div>
        </div>
    ';
    /**
     * @var string $classicSetNewPasswordElement
     */
    public string $classicSetNewPasswordElement = '
        <div class="col-auto modal-dialog-centered text-center">
            <div class="mx-auto mb-4">
                <h4 class="mb-4">%s</h4>
                <form id="sifreyenileislemsayfasi" class="mx-auto mb-4" action="' . ADDRESS . '/' . '%s' . '/' . '%s' . '" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="fst-italic">%s</label>
                        <input type="password" class="form-control" name="s" placeholder="%s" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="%s" autocomplete="current-password">
                        <input type="password" class="form-control mt-2" name="stekrar" placeholder="%s" required autocomplete="current-password">
                        <input type="hidden" class="hidden" name="giris-sifre-yenileme" value="dogru">
                    </div>
                    <button type="submit" class="btn btn-sm btn-outline-primary">%s</button>
                </form>
                <p class="text-center mb-4">%s</p>
            </div>
        </div>
    ';
    /**
     * @var string $classicDataDeletionRequestElement
     */
    public string $classicDataDeletionRequestElement = '
        <div class="text-center sticky-top">
            <p class="text-center mt-3">%s</p>
        <div class="list-group shadow-lg">
            <a href="'. ADDRESS . '/' .'%s" class="mt-2 list-group-item list-group-item-action list-group-item-dark">%s</a>
        </div>
        <div class="col-md-9 d-flex p-sol-yok p-sag-yok kucuk-ekran-yasla mt-2">
            <div class="col-md-12 modal-dialog-centered">
                <h4 class="mt-1 text-center">%s</h4>
                <p class="text-center">%s %s</p>
                <p class="text-center">%s</p>
                <p class="text-center">%s</p>
                <p class="text-center">'. DOMAIN .' %s</p>
            </div>
        </div>
    ';
    /**
     * @var string $htmlBasicContainer
     */
    public $htmlBasicContainer = '<div class="container"><div class="row mb-2">%s</div></div>';
    /**
     * [TR] link, fotograf, başlık, özet yazı
     * [EN] link, photo, title, summary text
     * 
    * @var string $htmlCardItem
    */
    public $htmlCardItem = '
		<a href="%s">
			<div class="card shadow border-secondary">
				<img src="%s" class="card-img-top">
				<div class="card-body">
					<h5 class="card-title">%s</h5>
					<strong class="d-inline-block mb-2 text-primary">%s</strong>
					<p class="card-text">%s</p>
				</div>
			</div>
		</a>
	';
    /**
     * [TR] fotograf, başlık
     * [EN] photo, title
     * 
    * @var string $htmlCategoryCardItem  
    */
    public $htmlCategoryCardItem = '
		<div class="card text-white">
			<img src="%s" class="card-img">
			<div class="card-img-overlay d-flex">
				<p class="card-title text-center align-self-center mx-auto my-auto golgever">%s</p>
			</div>
		</div>
	';
    /**
     * @var string $htmlFooterVerisanat
     */
    public string $htmlFooterVerisanat = '
        <footer class="footer mt-auto p-sm-1">
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
	 * @var string $documentEndHtml
	 */
	public string $documentEndHtml = '</body></html>';
    /**
     * @var string $htmlPageCardBlock
     */
    public string $htmlPageCardBlock = '<div class="card-columns col-md-12 p-sag-yok p-sol-yok">%s</div>';
	/**
	 * @var string $htmlPageSalutation
	 */
	public string $htmlPageSalutation = '<h4 class="mt-2 text-center font-weight-bold">%s</h4><p class="text-center mt-3">%s</p>';
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