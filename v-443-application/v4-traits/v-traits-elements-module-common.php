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

Version\VersionCheck::dkontrol(__FILE__,'4.4.3');

trait CommonModuleElements{

    /**
     * @var string $anasayfagosterhtml
     */
    private string $anasayfagosterhtml = '<div class="d-none">%s modül ana sayfa aktif</div>';
    /**
     * @var string $modulgosterhtml
     */
    private string $modulgosterhtml = '<div class="d-none">%s modül aktif</div>';
    /**
     * @var string $testortamyolu uygulama html test sayfaları klasörü
     */
    private string $testortamyolu = BASE . '/' . RELEASE . '-publications' . '/' . 'html-test' . '/';
    /**
     * css dosyalari için head ifadesi barındırır
     * @var $cssdosyasi
     */
    private string $cssdosyasiIc = '<link rel="stylesheet" href="'. ADDRESS . '/'. RELEASE . '-css' . '/' . '%s" type="text/css" />';
    /**
     * css dosyalari için head ifadesi barındırır
     * @var $cssdosyasi
     */
    private string $cssdosyasiDis = '<link rel="stylesheet" href="'. ADDRESS . '/'. 'external-resources' . '/' . '%s" type="text/css" />';
    /**
     * javascript dosyaları için head ifadesi barındırır
     * @var $jsdosyasi
     */
    private string $jsdosyasiDis = '<script src="'. ADDRESS . '/' . 'external-resources' . '/' . '%s"></script>';
    /**
     * javascript dosyaları için head ifadesi barındırır
     * @var $jsdosyasi
     */
    private string $jsdosyasiIc = '<script src="'. ADDRESS . '/' . RELEASE . '-js' . '/' . '%s"></script>';
    /**
     * @var string $sayfascriptleri sayfada kullanılacak javascriptler
     */
    private string $sayfascriptleri = '<script type="text/javascript" charset="UTF-8"> $(\'.toast\').toast("show"); $(\'[data-toggle="detay-ver"]\').tooltip(); $(\'[data-toggle="bilgi-kutusu-ac"]\').popover(); </script> ';
    /**
     * @var string $sayfasonu body ve html tag ı kapatır
     */
    private string $sayfasonu = '<script src="'. ADDRESS . '/' . RELEASE . '-js' . '/' . 'temel.js" charset="UTF-8"></script></body></html>';
    /**
     * @var string $slickbody slick body script i
     */
    private string $slickbody = '<script type="text/javascript"> $(\'.normal-slider\').slick({ slidesToShow: 1, slidesToScroll: 1, arrows: false, autoplay: true, variableWidth: false, autoplaySpeed: 3000, responsive: [ {breakpoint: 768, settings: { arrows: false, centerMode: true, centerPadding: \'40px\', slidesToShow: 3 } }, {breakpoint: 480, settings: { arrows: false, centerMode: true, centerPadding: \'40px\', slidesToShow: 1 } } ] }); </script>';
    /**
     * @var string $datatablesbody dt body script i
     */
    private string $datatablesbody = '<script type="text/javascript" charset="UTF-8"> $(document).ready( function (){ $(\'#tablo\').DataTable({ "paging":   true, "ordering": true, "info":     true, "autoWidth": true, "fixedColumns": false, "stateSave": true, "dom": "lB<\'butonlar\'>frtipr", buttons: [ "copy", "excelHtml5" ], "language": { "lengthMenu": "Sayfa başına _MENU_ sonuç gösteriliyor.", "zeroRecords": "Sonuç Bulunamadı.", "info": "Gösterilen Sayfa: _PAGE_ , Toplam _PAGES_", "infoEmpty": "Veri Yok", "infoFiltered": "(Filtre Uygulandı: _MAX_ Toplam Adet.)", "search": "Tüm Sayfalarda Ara:", "paginate": { "previous": "Önceki", "next": "Sonraki" } } }); /* $("div.butonlar").html(\'%s\');*/ }); </script>';
    /**
     * @var string $datatableshead datatables head css js dosyalari
     */
    private string $datatableshead = '<link rel="stylesheet" href="' . ADDRESS .'/' . 'external-resources' . '/' . 'datatables' . '/' . 'datatables.min.css" type="text/css">
    <link rel="stylesheet" href="' . ADDRESS .'/' . 'external-resources' . '/' . 'datatables' . '/' . 'Buttons-1.6.1' . '/' . 'css' . '/' . 'buttons.dataTables.min.css" type="text/css">
    <script src="'. ADDRESS .'/' . 'external-resources' . '/' . 'datatables' . '/' . 'datatables.min.js"></script>
    <script src="'. ADDRESS .'/' . 'external-resources' . '/' . 'datatables' . '/' . 'Buttons-1.6.1' . '/' . 'js' . '/' . 'dataTables.buttons.min.js"></script>';
    /**
     * @var string $ileti yazılacak toast ileti şablonu
     */
    private string $ileti = '
        <div class="toast ileti" role="alert" aria-live="assertive" aria-atomic="true" data-delay="8000">
            <div class="iletiler">
                <div class="toast-header">
                    <img src="' . ADDRESS . '/lokal-gorsel/uygulama/' . PREFIX .'-web-mobile-icon.png" class="logo-mobil-boyutu rounded mr-2">
                    <strong class="mr-auto">v.İşlem %s</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">
                            <i class="far fa-times-circle mobil-mt-1"></i>
                        </span>
                    </button>
                </div>
                <div class="toast-body"> %s </div>
            </div>
        </div>
    ';
    /**
     * @var string $klasikFormBasligi
     */
    private string $klasikFormBasligi = 'enctype="multipart/form-data" accept-charset="UTF-8" method="post" action="%s" validate';
    /**
     * @var string $aramaFormBasligi
     */
    private string $aramaFormBasligi = 'accept-charset="UTF-8" method="get" action="%s" novalidate';
}
?>