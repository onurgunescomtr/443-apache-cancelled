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

Version\VersionCheck::dkontrol(__FILE__,'4.4.2');

trait CommonFrameElements{

    /**
     * @var string $digitalProviders
     */
    private string $digitalProviders = '';
    /**
     * @var string $googleTagMan
     */
    private string $googleTagMan = "<!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src= 'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer','%s');</script>
    <!-- End Google Tag Manager -->";
    /**
     * @var string $googleTagManHead
     */
    private string $googleTagManHead = '<!-- Global site tag gtag.js - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=%s"></script>';
    /**
     * @var string $googleanalytics
     */
    private string $googleAnalytics = "<script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '%s', { 'optimize_id': '%s'});
    </script>";
    /**
     * @var string $googleAdSense
     */
    private string $googleAdSense = '<script data-ad-client="%s" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';
    /**
     * @var string $fbpiksel;
     */
    private string $facebookPixel = "<!-- Facebook Pixel Code -->
    <script> !function(f,b,e,v,n,t,s) {if(f.fbq)return;n=f.fbq=function(){n.callMethod? n.callMethod.apply(n,arguments):n.queue.push(arguments)}; if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0'; n.queue=[];t=b.createElement(e);t.async=!0; t.src=v;s=b.getElementsByTagName(e)[0]; s.parentNode.insertBefore(t,s)}(window, document,'script', 'https://connect.facebook.net/en_US/fbevents.js'); fbq('init', '%s'); fbq('track', 'PageView'); </script> <noscript><img height=\"1\" width=\"1\" style=\"display:none\" src=\"https://www.facebook.com/tr?id=%s&ev=PageView&noscript=1\" /></noscript>
    <!-- End Facebook Pixel Code -->";
    
    /**
     * @var string $tdk head - başlık tanım anahtar kelime sabiti
     */
    private string $tdk = '<title>%s</title>
    <meta name="description" content="%s">
    <meta name="keywords" content="%s">';
    /**
     * @var string $headbir
     */
    private string $headbir = '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="robots" content="archive,index,follow,translate">
    <meta property="fb:app_id" content="%s">
    <meta property="og:locale" content="'. LANGL .'">
    <meta property="og:email" content="'. CONTACT .'">
    <meta property="og:country-name" content="' . LANG . '">
    <meta property="og:site_name" content="'. DOMAIN .'">
    <meta property="og:image" content="'. ADDRESS . '/' . 'lokal-gorsel' . '/' . 'uygulama' . '/' . PREFIX. '-temel-logo.png">
    <link rel="shortcut icon" href="'. ADDRESS . '/' . 'lokal-gorsel' . '/' . 'uygulama' . '/' . PREFIX . '-web-mobile-icon.png">';
    /**
     * @var string $headiki
     */
    private string $headiki = '<meta property="og:description" content="%s">
    <meta property="og:title" content="%s">
    <meta property="og:url" content="%s">
    <meta name="generator" content="Verisanat v.'. VER .'">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">';
    /**
     * @var string $headDort
     */
    private string $headDort = '<meta property="product:brand" content="%s">
    <meta property="product:availability" content="%s">
    <meta property="product:condition" content="%s">
    <meta property="product:price:amount" content="%s">
    <meta property="product:price:currency" content="%s">
    <meta property="product:retailer_item_id" content="%s">';
    /**
     * @var string $headüc
     */
    private string $headEskiUc = '<script src="'. ADDRESS . '/' . 'external-resources' . '/' . 'jquery' . '/' . 'jquery.351.js"></script>
    <link rel="stylesheet" href="'. ADDRESS . '/' . 'external-resources' . '/' . 'BS450' . '/' . 'bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="'. ADDRESS . '/' . 'external-resources' . '/' . 'fontawesome' . '/' . 'fawesome-582.min.css" type="text/css">
    <link rel="stylesheet" href="'. ADDRESS . '/' . 'external-resources' . '/' . 'animate.css" type="text/css">
    <link rel="stylesheet" href="'. ADDRESS . '/' . RELEASE . '-css' . '/' . 'css-duzenlemeler.css" type="text/css">
    <script src="'. ADDRESS .'/' . 'external-resources' . '/' . 'BS450' . '/' . 'bootstrap.bundle.min.js"></script>
    <script src="'. ADDRESS .'/' . 'external-resources' . '/' . 'fontawesome' . '/' . 'fontawesome.min.js"></script>
    <script type="text/javascript" src="'. ADDRESS .'/' . 'external-resources' . '/' . 'slick' . '/' . 'slick.min.js"></script>
    <link rel="stylesheet" href="'. ADDRESS . '/' . 'external-resources' . '/' . 'slick' . '/' . 'slick.css" type="text/css">
    <link rel="stylesheet" href="'. ADDRESS . '/' . 'external-resources' . '/' . 'slick' . '/' . 'slick-theme.css" type="text/css">';
    /**
     * @var string $headcopyright
     */
    private string $headcopyright = '<meta name="copyright" content="Onur Güneş https://onurgunescomtr@bitbucket.org/onurgunescomtr">
    <meta name="author" content="Onur Güneş, https://www.facebook.com/onur.gunes.developer">
    <meta name="designer" content="Onur Güneş, Twitter Bootstrap, https://www.facebook.com/onur.gunes.developer">
    <meta name="owner" content="Onur Güneş, https://www.onurgunes.com.tr">';
    /**
     * @var string $vuejshead
     */
    private string $vuejshead = '<script src="'. ADDRESS .'/' . 'external-resources' . '/' . 'vue' . '/' . '2.6.11' . '/' . 'vue-prod.js"></script>';
    /**
     * @var string $vuejseklentiler
     */
    private string $vuejseklentiler = 'external-resources' . '/' . 'vue' . '/' . 'extensions';
    /**
     * @var string $jshead
     */
    private string $jshead = '<script src="'. ADDRESS .'/' . 'external-resources' . '/' . '%s' . '/' . '%s"></script>';
    /**
     * @var string $reactjshead
     */
    private string $reactjshead = '<script src="https://unpkg.com/react@16/umd/react.production.min.js" crossorigin></script><script src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js" crossorigin></script>';
    /**
     * uygulamaya eklenecek head te yer alması gereken kısımlar
     * 
     * @var string $htmlheadek 
     */
    public string|null $htmlheadek;
    /**
     * HTML head part
     * 
     * @var string $head 
     */
    private string $head;
    /**
	 * HTML document declaration
	 * 
     * @var string $doctype
     */
    private string $doctype = '<!doctype html><html lang="%s"><head><meta charset="utf-8">';
        /**
     * href - imghref - sabit (-web-mobile-icon.png) standart uygulama header logo tipi, header ön kısımda yer alır
     * 
     * @var string $headerlogo 
     */
    public string $headerlogo = '<a title="Ana Sayfa" href="%s" class="animated fadeInRight mb-4"><img class="logo-yuvarla logo-header-boyutu shadow" src="%s-web-mobile-icon.png"></a>';
    /**
     * title - href - link adı 9002 - pratik sürüm $genelhlink
     * 
     * @var string $headerlink 
     */
    public string $headerlink = '<a class="p-2" title="%s" href="%s">%s</a>';
	/**
	 * @var string $userInterfaceName
	 */
	public string|null $userInterfaceName = null;
	/**
	 * @var string $headCssJs
	 */
	private string $headCssJS = '
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
		<link rel="stylesheet" href="'. ADDRESS . '/' . RELEASE . '-css' . '/' . 'css-' . '443' . '-default.css" type="text/css">
	';
	/**
	 * @var string $newHeader
	 */
	private string $htmlHeaderContainer443 = '
		<header class="py-3 mb-1 border-bottom">
			<div class="container-fluid d-grid align-items-center header-443">
				<div class="dropdown">
					<a href="%s" class="d-flex align-items-center mb-sm-0 mb-lg-0 fs-4 dropdown-toggle" id="dropdownNavLink" data-bs-toggle="dropdown">
						<img class="logo shadow" src="' . ADDRESS . '/' . RELEASE . '-local-images' . '/' . '%s-web-mobile-icon.png">
					</a>
					<ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownNavLink">
						%s
					</ul>
				</div>
				<div class="d-flex align-items-center">
					%s
				</div>
				<div class="d-flex flex-row-reverse dropdown">
						<a href="#" class="d-block link-dark text-decoration-none fs-4 rounded dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown">
						<i class="bi bi-person-square header-user-icon"></i>
						</a>
						<ul class="dropdown-menu text-small shadow">
							%s
						</ul>
						%s
				</div>
			</div>
		</header>
	';
	/**
	 * @var string $htmlHeaderUserImage
	 */
	private string $htmlHeaderUserImage = '<img src="userImage" alt="mdo" width="40" height="40" class="rounded-circle">';
	/**
	 * @var string $htmlHeaderUserStart
	 */
	private string $htmlHeaderUserStart = '<i class="bi bi-person-square header-user-icon"></i>';
	/**
	 * @var string $htmlHeaderNavigation
	 */
	private string $htmlHeaderNavigation = '<ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownNavLink">%s</ul>';
	/**
	 * @var string $htmlHeaderNavLink
	 */
	private string $htmlHeaderNavLink = '<li><a class="dropdown-item" href="%s" title="%s">%s</a></li>';
	/**
	 * @var string $htmlHeaderNavLinkDivider
	 */
	private string $htmlHeaderNavLinkDivider = '<li><hr class="dropdown-divider"></li>';
	/**
	 * @var string $htmlHeaderNavUserLinks
	 */
	private string $htmlHeaderNavUserLink = '<li><a class="dropdown-item" href="%s" title="">%s</a></li>';
	/**
	 * @var string $htmlHeaderLinkHtml
	 */
	private string $htmlHeaderLinkHtml = '
		<div class="card">
			<img src="%s" class="card-img-top" alt="%s">
			<div class="card-body">
				<p class="card-text">%s</p>
			</div>
		</div>
  	';
	/**
	 * @var string $htmlHeaderLinkHtmlExtra
	 */
	private string $htmlHeaderLinkHtmlExtra = '
		<div class="card">
			<img src="%s" class="card-img" alt="%s">
			<div class="card-img-overlay">
				%s
			</div>
		</div>
	';
	/**
	 * @var string $htmlHeaderSearchBar
	 */
	private string $htmlHeaderSearchBar = '
		<form class="w-100">
			<input type="search" class="form-control" placeholder="Search..." aria-label="Search">
		</form>
	';
	/**
	 * @var string $htmlHeaderInterfaceText
	 */
	private string $htmlHeaderInterfaceText = '<h4 class="text-center mx-auto mt-2">%s</h4>';
	/**
     * href - adı standart uygulama header arka kısım birden fazla düğme tipi
     * 
     * @var string $headerbutontipiiki 
     */
    public string $htmlHeaderButton = '<a class="btn btn-sm btn-outline-dark" href="%s">%s</a>';
	/**
	 * @var string $appHeaderLogo
	 */
	private string $appHeaderLogo = ADDRESS . '/' . 'lokal-gorsel' . '/' . 'uygulama' . '/' . PREFIX;
}
?>