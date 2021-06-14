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
    <meta name="robots" content="noimageindex,archive,index,follow,translate">
    <meta property="fb:app_id" content="%s">
    <meta property="og:locale" content="'. LANGL .'">
    <meta property="og:email" content="'. CONTACT .'">
    <meta property="og:country-name" content="' . LANG . '">
    <meta property="og:site_name" content="'. DOMAIN .'">
    <meta property="og:image" content="'. ADDRESS . '/' . RELEASE . '-local-image' . '/' . 'uygulama' . '/' . PREFIX. '-temel-logo.png">
    <link rel="shortcut icon" href="'. ADDRESS . '/' . RELEASE . '-local-image' . '/' . 'uygulama' . '/' . PREFIX . '-web-mobile-icon.png">';
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
    private string $headuc = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"><script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="'. ADDRESS . '/' . RELEASE . '-css' . '/' . 'css-duzenlemeler.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	';
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
     * uygulama temel html head kısmı
     * 
     * @var string $head 
     */
    private string $head;
    /**
     * @var string $doctype html il satırı verir
     */
    private string $doctype = '<!doctype html><html lang="%s"><head><meta charset="utf-8">';
    /* YAN MENU */
    /**
     * birinci tamamlanmış yan menü
     * 
     * @var string $yanmenubir 
     */
    public string $yanmenubir;
    /**
     * @var bool $yanmenukullan yan menü kullanılıyor mu kullanılmıyor mu
     */
    public string $yanmenukullan;
    /**
     * @var string $yanmenu standart uygulama yan menu ust kısım DEFAULT - %s sticky-top , %s inceliste
     */
    public string $yanmenuust = '<div class="col-md-3 d-none d-lg-flex %s %s menu-acaip rounded p-sag-yok p-sol-yok border border-warning shadow dik-sutun-flex"><div class="list-group mx-auto my-auto %s">';
    /**
     * @var string $yanmenualt standart uygulama yan menu alt kısım
     */
    public string $yanmenualt = '</div></div>';
    /**
     * @var string $yanmenulink standart uygulama yan menu linkler href - Yazı(adı)
     */
    public string $yanmenulink = '<a class="list-group-item list-group-item-action list-group-item-dark bg-verisanat-kapali mx-auto rounded mb-1" href="%s">%s</a>';
    /* YAN MENU  */
    /* HEADER MENU */
    /**
     * standart uygulama header alanı kapsayıcı html
     * 
     * @var string $headermenuust 
     */
    public string $headermenuust = '<header class="d-none d-md-block d-lg-block py-2 fixed-top shadow %s"><div class="container arayuz-sabit"><div class="row flex-nowrap justify-content-between align-items-center">';
    /**
     * standart uygulama header alanı kapsayıcı html
     * 
     * @var string $headermenualt 
     */
    public string $headermenualt = '</div></div></header>';
    /**
     * standart uygulama header ön kısım col-2
     * 
     * @var array $headeron 
     */
    public array $headeron = array(0 => '<div class="col-1">',2 => '</div>');
    /**
     * standart uygulama header orta kısım col-8
     * 
     * @var array $headerorta 
     */
    public array $headerorta = array(0 => '<div class="col-10"><nav class="nav d-flex justify-content-between">',2 => '</nav></div>');
    /**
     * standart uygulama header arka kısım col-2
     * 
     * @var array $headerarka 
     */
    public array $headerarka = array(0 => '<div class="col-1 d-flex align-items-center">',2 => '</div>');
    /**
     * standart uygulama header kısmı - moduler çerçeve aktif olduğunda kullanılır.
     * 
     * @var string $headertam 
     */
    public string $headertam = '<div class="col-12"><nav class="nav d-flex align-items-center">%s</nav></div>';
    /**
     * href - adı - standart uygulama header arka kısım düğmele tipi
     * 
     * @var string $headerbutontipi 
     */
    public string $headerbutontipi = '<a class="btn btn-sm btn-outline-dark" href="%s">%s</a>';
    /**
     * href - adı standart uygulama header arka kısım birden fazla düğme tipi
     * 
     * @var string $headerbutontipiiki 
     */
    public string $headerbutontipiiki = '<a class="btn btn-sm btn-outline-dark ml-1" href="%s">%s</a>';
    /**
     * href - imghref - sabit (-web-mobile-icon.png) standart uygulama header logo tipi, header ön kısımda yer alır
     * 
     * @var string $headerlogo 
     */
    public string $headerlogo = '<a title="Ana Sayfa" href="%s" class="animated fadeInRight mb-4"><img class="logo-yuvarla logo-header-boyutu shadow" src="%s-web-mobile-icon.png"></a>';
    /**
     * standart uygulama mobil header yapısı. href - %sweb-mobil-icon - mobil header linkleri
     * 
     * @var string $headermobilyapi 
     */
    public string $headermobilyapi = '<div class="mobil-header text-right %s d-md-none d-lg-none d-sm-block arka-plan-v-header">
    <div class="mobil-hizli-erisim">
        <div class="mobil-hizli-erisim-bas"><a href="%s"><img class="animated fadeInLeft float-left ml-3 mt-1 logo-mobil-yuvarla logo-mobil-boyutu" src="%s-web-mobile-icon.png"></a></div>
        <div class="text-center mobil-hizli-erisim-orta"><img class="mobil-hizli-erisim-logo" src="'. ADDRESS .'/lokal-gorsel/kullanici/'. PREFIX .'-logo-mobil.png"></div>
        <div class="mobil-hizli-erisim-son"><button class="navbar-toggler pt-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon rounded"><i class="fas fa-home mt-1"></i></span></button></div>
    </div>
    <div class="collapse navbar-collapse ufak-arka-plan d-lg-none d-md-none arka-plan-v-header" id="navbarCollapse"><ul class="navbar-nav">%s</ul></div></div>';
    /**
     * title - href - link adı 9002 - pratik sürüm $genelhlink
     * 
     * @var string $headerlink 
     */
    public string $headerlink = '<a class="p-2" title="%s" href="%s">%s</a>';
    /**
     * standart uygulama tekil mobil header link yapısı
     * 
     * @var string $mlink 
     */
    public string $mlink = '<li class="nav-item active"><a class="nav-link" title="%s" href="%s">%s</a></li>';
    /**
     * @var string $headerLinkMobil
     */
    public string $headerLinkMobil = '<li class="nav-item active"><a class="nav-link" title="%s" href="%s">%s</a></li>'; // '<a title="%s" href="%s">%s</a>';
    
}
?>