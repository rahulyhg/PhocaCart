<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */


/*
 * +-------------------------------------------+
 * |        TYPE      |      FORMAT            |
 * +------------------+------------------------+
 * | 1. ORDER/RECEIPT |  html - HTML/SITE      |
 * | 2. INVOICE       |  pdf - PDF             |
 * | 3. DELIVERY NOTE |  mail - Mail           |
 * | 4. RECEIPT (POS) |  rss - RSS             |
 * |                  |  raw - RAW (POS PRINT) |
 * +------------------+------------------------+   
 */

defined('_JEXEC') or die();
$d = $displayData;

/*
 * Parameters
 */
$store_title						= $d['params']->get( 'store_title', '' );
$store_logo							= $d['params']->get( 'store_logo', '' );
$store_info							= $d['params']->get( 'store_info', '' );
$store_info							= PhocacartRenderFront::renderArticle($store_info, $d['format']);
//$invoice_prefix					= $d['params']->get( 'invoice_prefix', '');
//$invoice_number_format			= $d['params']->get( 'invoice_number_format', '');
//$invoice_number_chars				= $d['params']->get( 'invoice_number_chars', 12);
$invoice_tp							= $d['params']->get( 'invoice_terms_payment', '');
$display_discount_price_product		= $d['params']->get( 'display_discount_price_product', 1);

$tax_calculation                    = $d['params']->get( 'tax_calculation', 0 );

$store_title_pos						= $d['params']->get( 'store_title_pos', '' );
$store_logo_pos							= $d['params']->get( 'store_logo_pos', '' );
$store_info_pos							= $d['params']->get( 'store_info_pos', '' );
$store_info_footer_pos					= $d['params']->get( 'store_info_footer_pos', '' );

// Used in Phoca PDF Phocacart plugin because of converting the TCPDF QR code into html
//$pdf_invoice_qr_code					= $d['params']->get( 'pdf_invoice_qr_code', '' );
$pdf_invoice_signature_image			= $d['params']->get( 'pdf_invoice_signature_image', '' );
$pdf_invoice_qr_information				= $d['params']->get( 'pdf_invoice_qr_information', '' );
$invoice_global_top_desc				= $d['params']->get( 'invoice_global_top_desc', 0 );// Article ID
$invoice_global_middle_desc				= $d['params']->get( 'invoice_global_middle_desc', 0 );
$invoice_global_bottom_desc				= $d['params']->get( 'invoice_global_bottom_desc', 0 );
$display_tax_recapitulation_invoice		= $d['params']->get( 'display_tax_recapitulation_invoice', 0 );
$display_tax_recapitulation_pos			= $d['params']->get( 'display_tax_recapitulation_pos', 0 );

$display_reward_points_invoice			= $d['params']->get( 'display_reward_points_invoice', 0 );
$display_reward_points_pos				= $d['params']->get( 'display_reward_points_pos', 0 );

/*
 * FORMAT
 */
// FORMAT - HTML
$box		= 'class="ph-idnr-box"';
$table 		= 'class="ph-idnr-box-in"';
$pho1 		= $pho12	= 'class="pho1"';
$pho2 		= $pho22	= 'class="pho2"';
$pho3 		= $pho32	= 'class="pho3"';
$pho4 		= $pho42	= 'class="pho4"';
$pho5 		= $pho52	= 'class="pho5"';
$pho6 		= $pho62	= 'class="pho6"';
$pho7 		= $pho72	= 'class="pho7"';
$pho6Sep 	= $pho6Sep2	= 'class="pho6 ph-idnr-sep"';
$pho7Sep 	= $pho7Sep2	= 'class="pho7 ph-idnr-sep"';
$pho8 		= $pho82	= 'class="pho8"';
$pho9 		= $pho92	= 'class="pho9"';
$pho10 		= $pho102	= 'class="pho10"';
$pho11 		= $pho112	= 'class="pho11"';
$pho12 		= $pho122	= 'class="pho12"';
$sep		= $sep2		= 'class="ph-idnr-sep"';
$bBox		= 'class="ph-idnr-billing-box"';
$bBoxIn		= 'class="ph-idnr-billing-box-in"';
$sBox		= 'class="ph-idnr-shipping-box"';
$sBoxIn		= 'class="ph-idnr-shipping-box-in"';
$boxIn 		= 'class="ph-idnr-box-in"';
$hProduct 	= 'class="ph-idnr-header-product"';
$bProduct	= 'class="ph-idnr-body-product"';
$sepH		= 'class="ph-idnr-sep-horizontal"';
$totalF		= 'class="ph-idnr-total"';
$toPayS		= 'class="ph-idnr-to-pay"';
$toPaySV	= 'class="ph-idnr-to-pay-value"';
$bDesc		= 'class="ph-idnr-body-desc"';
$hrSmall	= 'class="ph-idnr-hr-small"';
$taxRecTable= 'class="ph-idnr-tax-rec"';
$taxRecTd	= 'class="ph-idnr-tax-rec-td"';
$bQrInfo	= '';
$firstRow	= '';


// POS RECEIPT
$pR 	= false;

if ($d['format'] == 'raw' && $d['type'] == 4) {
	$pR 	= true;
	$oPr	= array();
	$pP 	= new PhocacartPosPrint(0);


}

if ($d['format'] == 'pdf') {
	// FORMAT PDF
	
	
	// Products
	if ($tax_calculation > 0) {
		$colW = 8.3333;// 12 cols x 8.3333 = 100%
	} else {
		$colW = 11.11;// 9 cols x 11.11 = 100%
	}
	$box		= '';
	$table 		= 'style="width: 100%; font-size: 80%;padding:3px;margin-top:-200px"';
	$pho1 		= 'style="width: '.$colW.'%;"';
	$pho2 		= 'style="width: '.$colW.'%;"';
	$pho3 		= 'style="width: '.$colW.'%;"';
	$pho4 		= 'style="width: '.$colW.'%;"';
	$pho5 		= 'style="width: '.$colW.'%;"';
	$pho6 		= 'style="width: '.$colW.'%;"';
	$pho7 		= 'style="width: '.$colW.'%;"';
	$pho6Sep 	= 'style="width: 3%;"';
	$pho7Sep 	= 'style="width: 3%;"';
	$pho8 		= 'style="width: '.$colW.'%;"';
	$pho9 		= 'style="width: '.$colW.'%;"';
	$pho10 		= 'style="width: '.$colW.'%;"';
	$pho11 		= 'style="width: '.$colW.'%;"';
	$pho12 		= 'style="width: '.$colW.'%;"';
	$sep		= 'style="width: 3%;"';

	
	
	$pho12 		= 'style="width: 9%;"';
	$pho22 		= 'style="width: 9%;"';
	$pho32 		= 'style="width: 9%;"';
	$pho42 		= 'style="width: 9%;"';
	$pho52 		= 'style="width: 9%;"';
	$pho62 		= 'style="width: 9%;"';
	$pho72 		= 'style="width: 9%;"';
	$pho6Sep2 	= 'style="width: 5%;"';
	$pho7Sep2 	= 'style="width: 5%;"';
	$pho82 		= 'style="width: 9%;"';
	$pho92 		= 'style="width: 9%;"';
	$pho102 	= 'style="width: 9%;"';
	$pho112 	= 'style="width: 9%;"';
	$pho122 	= 'style="width: 9%;"';
	$seps2		= 'style="width: 10%;"';


	$bBox		= 'style="border: 1pt solid #dddddd;"';
	$bBoxIn		= 'style=""';
	$sBox		= 'style="border: 1pt solid #dddddd;"';
	$sBoxIn		= 'style=""';
	//$boxIn 		= 'style="width: 100%; font-family: sans-serif, arial; font-size: 60%;padding:3px 1px;"';
	$boxIn 		= 'style="width: 100%; font-size: 60%;padding:1px 1px;"';
	$hProduct 	= 'style="white-space:nowrap;font-weight: bold;background-color: #dddddd;"';
	$bProduct	= 'style="white-space:nowrap;"';
	$sepH		= 'style="border-top: 1pt solid #dddddd;"';
	$totalF		= 'style=""';
	$toPayS		= 'style="background-color: #eeeeee;padding: 20px;"';
	$toPaySV	= 'style="background-color: #eeeeee;padding: 20px;text-align:right;"';
	$firstRow	= 'style="font-size:0pt;"';

	$bDesc		= 'style="padding: 2px 0px 0px 0px;margin:0;font-size:60%;"';
	$hrSmall	= 'style="font-size:30%;"';
	$taxRecTable= 'style="border: 1pt solid #dddddd; width: 50%"';
	$taxRecTd	= 'style="border: 1pt solid #dddddd;"';
	$bQrInfo	= 'style="font-size: 70%"';

} else if ($d['format'] == 'mail') {

	// FORMAT EMAIL
	$box		= '';
	//$table 		= 'style="width: 100%; font-family: sans-serif, arial; font-size: 90%;"';
	$table 		= 'style="width: 100%; font-size: 90%;"';
	$pho1 		= 'style="width: 8.3333%;"';
	$pho2 		= 'style="width: 8.3333%;"';
	$pho3 		= 'style="width: 8.3333%;"';
	$pho4 		= 'style="width: 8.3333%;"';
	$pho5 		= 'style="width: 8.3333%;"';
	$pho6 		= 'style="width: 8.3333%;"';
	$pho7 		= 'style="width: 8.3333%;"';
	$pho6Sep 	= 'style="width: 3%;"';
	$pho7Sep 	= 'style="width: 3%;"';
	$pho8 		= 'style="width: 8.3333%;"';
	$pho9 		= 'style="width: 8.3333%;"';
	$pho10 		= 'style="width: 8.3333%;"';
	$pho11 		= 'style="width: 8.3333%;"';
	$pho12 		= 'style="width: 8.3333%;"';
	$sep		= 'style="width: 3%;"';

	$pho12 		= 'style="width: 9%;"';
	$pho22 		= 'style="width: 9%;"';
	$pho32 		= 'style="width: 9%;"';
	$pho42 		= 'style="width: 9%;"';
	$pho52 		= 'style="width: 9%;"';
	$pho62 		= 'style="width: 9%;"';
	$pho72 		= 'style="width: 9%;"';
	$pho6Sep2 	= 'style="width: 5%;"';
	$pho7Sep2 	= 'style="width: 5%;"';
	$pho82 		= 'style="width: 9%;"';
	$pho92 		= 'style="width: 9%;"';
	$pho102 	= 'style="width: 9%;"';
	$pho112 	= 'style="width: 9%;"';
	$pho122 	= 'style="width: 9%;"';
	$seps2		= 'style="width: 10%;"';

	$bBox		= 'style="border: 1px solid #ddd;padding: 10px;"';
	$bBoxIn		= 'style=""';
	$sBox		= 'style="border: 1px solid #ddd;padding: 10px;"';
	$sBoxIn		= 'style=""';
	//$boxIn 		= 'style="width: 100%; font-family: sans-serif, arial; font-size: 90%;"';
	$boxIn 		= 'style="width: 100%; font-size: 90%;"';
	$hProduct 	= 'style="white-space:nowrap;padding: 5px;font-weight: bold;background: #ddd;"';
	$bProduct	= 'style="white-space:nowrap;padding: 5px;"';
	$sepH		= 'style="border-top: 1px solid #ddd;"';
	$totalF		= 'style=""';
	$toPayS		= 'style="background-color: #eeeeee;padding: 20px;"';
	$toPaySV	= 'style="background-color: #eeeeee;padding: 20px;text-align:right;"';
	$firstRow	= '';
	$taxRecTable= 'style="border: 1pt solid #dddddd; width: 50%;"';
	$taxRecTd	= 'style="border: 1pt solid #dddddd;"';

}


// -----------
// R E N D E R
// -----------
$o = array();
$o[] = '<div '.$box.'>';


// -----------
// 1. PART
// -----------
$o[] = '<table '.$table.'>';

$o[] = '<tr '.$firstRow.'>';
$o[] = '<td '.$pho12.'>&nbsp;</td><td '.$pho22.'>&nbsp;</td><td '.$pho32.'>&nbsp;</td><td '.$pho42.'>&nbsp;</td>';
$o[] = '<td '.$pho52.'>&nbsp;</td><td '.$pho6Sep2.'>&nbsp;</td><td '.$pho7Sep2.'>&nbsp;</td><td '.$pho82.'>&nbsp;</td>';
$o[] = '<td '.$pho92.'>&nbsp;</td><td '.$pho102.'>&nbsp;</td><td '.$pho112.'>&nbsp;</td><td '.$pho122.'>&nbsp;</td>';
$o[] = '</tr>';


// -----------
// HEADER LEFT
// -----------
$o[] = '<tr><td colspan="5">';
if ($store_title != '') {
	$o[] = '<div><h1>'.$store_title.'</h1></div>';
}
if ($store_logo != '') {
	$o[] = '<div><img class="ph-idnr-header-img" src="'.JURI::root(false). ''.$store_logo.'" /></div>';
}
if ($store_info != '') {
	$o[] = '<div>'.$store_info.'</div>';
}
$o[] = '</td>';

$o[] = '<td colspan="2" '.$sep2.'></td>';


// -----------
// HEADER RIGHT
// -----------
$o[] = '<td colspan="5">';
if ($d['type'] == 1) {
	$o[] = '<div><h1>'.JText::_('COM_PHOCACART_ORDER').'</h1></div>';
	$o[] = '<div><b>'.JText::_('COM_PHOCACART_ORDER_NR').'</b>: '.PhocacartOrder::getOrderNumber($d['common']->id, $d['common']->date, $d['common']->order_number).'</div>';
	$o[] = '<div><b>'.JText::_('COM_PHOCACART_ORDER_DATE').'</b>: '.JHtml::date($d['common']->date, 'DATE_FORMAT_LC4').'</div>';
} else if ($d['type'] == 2) {

	$o[] = '<div><h1>'.JText::_('COM_PHOCACART_INVOICE').'</h1></div>';
	$o[] = '<div><b>'.JText::_('COM_PHOCACART_INVOICE_NR').'</b>: '.PhocacartOrder::getInvoiceNumber($d['common']->id, $d['common']->date, $d['common']->invoice_number).'</div>';
	$o[] = '<div><b>'.JText::_('COM_PHOCACART_INVOICE_DATE').'</b>: '.JHtml::date($d['common']->invoice_date, 'DATE_FORMAT_LC4').'</div>';
	$o[] = '<div><b>'.JText::_('COM_PHOCACART_INVOICE_DUE_DATE').'</b>: '.PhocacartOrder::getInvoiceDueDate($d['common']->id, $d['common']->date, $d['common']->invoice_due_date, 'DATE_FORMAT_LC4').'</div>';
	$o[] = '<div><b>'.JText::_('COM_PHOCACART_PAYMENT_REFERENCE_NUMBER').'</b>: '.PhocacartOrder::getPaymentReferenceNumber($d['common']->id, $d['common']->date, $d['common']->invoice_prn).'</div>';

} else if ($d['type'] == 3) {
	$o[] = '<div><h1>'.JText::_('COM_PHOCACART_DELIVERY_NOTE').'</h1></div>';
	$o[] = '<div style="margin:0;"><b>'.JText::_('COM_PHOCACART_ORDER_NR').'</b>: '.PhocacartOrder::getOrderNumber($d['common']->id, $d['common']->date, $d['common']->order_number).'</div>';
	$o[] = '<div style="margin:0"><b>'.JText::_('COM_PHOCACART_ORDER_DATE').'</b>: '.JHtml::date($d['common']->date, 'DATE_FORMAT_LC4').'</div>';

}

$o[] = '<div>&nbsp;</div>';
if (isset($d['common']->paymenttitle) && $d['common']->paymenttitle != '') {
	$o[] = '<div><b>'.JText::_('COM_PHOCACART_PAYMENT').'</b>: '.$d['common']->paymenttitle.'</div>';
}

if ($d['type'] == 2 && $invoice_tp	!= '') {
	$o[] = '<div><b>'.JText::_('COM_PHOCACART_TERMS_OF_PAYMENT').'</b>: '.$invoice_tp.'</div>';
}

if (isset($d['common']->shippingtitle) && $d['common']->shippingtitle != '') {
	$o[] = '<div><b>'.JText::_('COM_PHOCACART_SHIPPING').'</b>: '.$d['common']->shippingtitle.'</div>';
}

$o[] = '</td></tr>';

$o[] = '<tr><td colspan="12">&nbsp;</td></tr>';


// POS HEADER
if ($pR) {
	$oPr[] = $pP->printImage($store_logo_pos);
}
if ($pR) {
	$storeTitlePos = array();
	if ($store_title_pos != '') {
		$storeTitlePos = explode("\n", $store_title_pos);
	}
	$oPr[] = $pP->printFeed(1);
	$oPr[] = $pP->printLine($storeTitlePos, 'pDoubleSizeCenter');
	$oPr[] = $pP->printFeed(1);
}
if ($pR) {
	$storeInfoPos = array();
	if ($store_info_pos != '') {
		$storeInfoPos = explode("\n", $store_info_pos);
	}
	$oPr[] = $pP->printLine($storeInfoPos, 'pCenter');
}




// -----------
// BILLING AND SHIPPING HEADER
// -----------
$o[] = '<tr><td colspan="5"><b>'.JText::_('COM_PHOCACART_BILLING_ADDRESS').'</b></td>';
$o[] = '<td colspan="2"></td>';
$o[] = '<td colspan="5"><b>'.JText::_('COM_PHOCACART_SHIPPING_ADDRESS').'</b></td></tr>';


// -----------
// BILLING
// -----------
$ob = array();

if (!empty($d['bas']['b'])) {
	$v = $d['bas']['b'];
	if ($v['company'] != '') { $ob[] = '<b>'.$v['company'].'</b><br />';}
	$name = array();
	if ($v['name_degree'] != '') { $name[] = $v['name_degree'];}
	if ($v['name_first'] != '') { $name[] = $v['name_first'];}
	if ($v['name_first'] != '') { $name[] = $v['name_middle'];}
	if ($v['name_first'] != '') { $name[] = $v['name_last'];}
	if (!empty($name)) {$ob[] = '<b>' . implode("\n", $name).'</b><br />';}
	if ($v['address_1'] != '') { $ob[] = $v['address_1'].'<br />';}
	if ($v['address_2'] != '') { $ob[] = $v['address_2'].'<br />';}
	$city = array();
	if ($v['zip'] != '') { $city[] = $v['zip'];}
	if ($v['city'] != '') { $city[] = $v['city'];}
	if (!empty($city)) {$ob[] = implode("\n", $city).'<br />';}
	//echo '<br />';
	if (!empty($v['regiontitle'])) {$ob[] = $v['regiontitle'].'<br />';}
	if (!empty($v['countrytitle'])) {$ob[] = $v['countrytitle'].'<br />';}
	//echo '<br />';
	if ($v['vat_1'] != '') { $ob[] = '<br />'.JText::_('COM_PHOCACART_VAT1').': '. $v['vat_1'].'<br />';}
	if ($v['vat_2'] != '') { $ob[] = JText::_('COM_PHOCACART_VAT2').': '.$v['vat_2'].'<br />';}


}


// -----------
// SHIPPING
// -----------
$os = array();
if (!empty($d['bas']['s'])) {
	$v = $d['bas']['s'];
	if ($v['company'] != '') { $os[] = '<b>'.$v['company'].'</b><br />';}
	$name = array();
	if ($v['name_degree'] != '') { $name[] = $v['name_degree'];}
	if ($v['name_first'] != '') { $name[] = $v['name_first'];}
	if ($v['name_first'] != '') { $name[] = $v['name_middle'];}
	if ($v['name_first'] != '') { $name[] = $v['name_last'];}
	if (!empty($name)) {$os[] = '<b>' . implode("\n", $name).'</b><br />';}
	if ($v['address_1'] != '') { $os[] = $v['address_1'].'<br />';}
	if ($v['address_2'] != '') { $os[] = $v['address_2'].'<br />';}
	$city = array();
	if ($v['zip'] != '') { $city[] = $v['zip'];}
	if ($v['city'] != '') { $city[] = $v['city'];}
	if (!empty($city)) {$os[] = implode("\n", $city).'<br />';}
	//echo '<br />';
	if (!empty($v['regiontitle'])) {$os[] = $v['regiontitle'].'<br />';}
	if (!empty($v['countrytitle'])) {$os[] = $v['countrytitle'].'<br />';}
	//echo '<br />';
	if ($v['vat_1'] != '') { $os[] = '<br />'.JText::_('COM_PHOCACART_VAT1').': '. $v['vat_1'].'<br />';}
	if ($v['vat_2'] != '') { $os[] = JText::_('COM_PHOCACART_VAT2').': '.$v['vat_2'].'<br />';}
}


// BILLING OUTPUT
$o[] = '<tr><td colspan="5" '.$bBox.' ><div '.$bBoxIn.'>';
$o[] = implode("\n", $ob);
$o[] = '</div></td>';
$o[] = '<td colspan="2">&nbsp;</td>';


// SHIPPING OUTPUT
$o[] = '<td colspan="5" '.$sBox.'><div '.$sBoxIn.'>';
if ((isset($d['bas']['b']['ba_sa']) && $d['bas']['b']['ba_sa'] == 1) || (isset($d['bas']['s']['ba_sa']) && $d['bas']['s']['ba_sa'] == 1)) {
	$o[] = implode("\n", $ob);
} else {
	$o[] = implode("\n", $os);
}
$o[] = '</div></td></tr>';
//$o[] = '<tr><td colspan="12">&nbsp;</td></tr>';
$o[] = '</table>';


// -----------------------
// INVOICE TOP DESCRIPTION
// -----------------------
$hrSmallTop = 0;
if ($d['type'] == 2) {
	
	
	if ($d['common']->invoice_spec_top_desc != '') {
		$o[] = $hrSmallTop == 1 ? '' : '<div '.$hrSmall.'>&nbsp;</div>';
		$invoice_spec_top_desc_article = PhocacartPdf::skipStartAndLastTag($d['common']->invoice_spec_top_desc, 'p');
		//$o[] = '<div '.$bDesc.'>'.$invoice_spec_top_desc_article.'</div>';
		$o[] = '<table '.$bDesc.'><tr><td>'.$invoice_spec_top_desc_article.'</td></tr></table>';
	} else if ((int)$invoice_global_top_desc > 0) {
		$invoice_global_top_desc_article = PhocacartRenderFront::renderArticle((int)$invoice_global_top_desc);
		if ($invoice_global_top_desc_article != '') {
			$o[] = '<div '.$hrSmall.'>&nbsp;</div>';
			$hrSmallTop = 1;
			$invoice_global_top_desc_article = PhocacartPdf::skipStartAndLastTag($invoice_global_top_desc_article, 'p');
			//$o[] = '<div '.$bDesc.'>'.$invoice_global_top_desc_article.'</div>';
			$o[] = '<table '.$bDesc.'><tr><td>'.$invoice_global_top_desc_article.'</td></tr></table>';
		}
	}
}


// -----------
// 2. PART
// -----------
$o[] = '<table '.$boxIn.'>';
$o[] = '<tr>';
$o[] = '<td '.$pho1.'>&nbsp;</td><td '.$pho2.'>&nbsp;</td><td '.$pho3.'>&nbsp;</td><td '.$pho4.'>&nbsp;</td>';
$o[] = '<td '.$pho5.'>&nbsp;</td><td '.$pho6.'>&nbsp;</td><td '.$pho7.'>&nbsp;</td><td '.$pho8.'>&nbsp;</td>';
$o[] = '<td '.$pho9.'>&nbsp;</td>';
if ($tax_calculation > 0) {
	$o[] = '<td '.$pho10.'>&nbsp;y</td><td '.$pho11.'>&nbsp;y</td><td '.$pho12.'>&nbsp;y</td>';
}
$o[] = '</tr>';


$dDiscount 	= 0; // Display Discount (Coupon, cnetto)
$cTitle		= 3; // Colspan Title


$p = array();
if (!empty($d['products'])) {

	// Prepare header and body
	foreach ($d['products'] as $k => $v) {
		if ($v->damount > 0) {
			$dDiscount 	= 1;
			$cTitle 	= 2;
		}
	}

	if ($d['type'] == 3) {
		$cTitle	= 10;
	}

	$p[] = '<tr '.$hProduct.'>';
	$p[] = '<td>'.JText::_('COM_PHOCACART_SKU').'</td>';
	$p[] = '<td colspan="'.$cTitle.'">'.JText::_('COM_PHOCACART_ITEM').'</td>';
	$p[] = '<td style="text-align:center">'.JText::_('COM_PHOCACART_QTY').'</td>';

	if ($d['type'] != 3) {
		$p[] = '<td style="text-align:right" colspan="2">'.JText::_('COM_PHOCACART_PRICE_UNIT').'</td>';
		if ($dDiscount == 1) {
			$p[] = '<td style="text-align:center"">'.JText::_('COM_PHOCACART_DISCOUNT').'</td>';
		}
		if ($tax_calculation > 0) {
			$p[] = '<td style="text-align:right" colspan="2">'.JText::_('COM_PHOCACART_PRICE_EXCL_TAX').'</td>';
			$p[] = '<td style="text-align:right">'.JText::_('COM_PHOCACART_TAX').'</td>';
			$p[] = '<td style="text-align:right" colspan="2">'.JText::_('COM_PHOCACART_PRICE_INCL_TAX').'</td>';
		} else {
			$p[] = '<td style="text-align:right" colspan="2">'.JText::_('COM_PHOCACART_PRICE').'</td>';
		}

	}
	$p[] = '</tr>';

	if ($pR) { $oPr[] = $pP->printSeparator(); }

	foreach($d['products'] as $k => $v) {

		// $codes = PhocacartProduct::getProductCodes((int)$v->product_id);
		// echo $codes['isbn']; getting codes like isbn, ean, jpn, serial_number from product
		// codes are the latest stored in database not codes which were valid in date of order
		$p[] = '<tr '.$bProduct.'>';
		$p[] = '<td>'.$v->sku.'</td>';
		$p[] = '<td colspan="'.$cTitle.'">'.$v->title.'</td>';

		if ($pR) { $oPr[] = $pP->printLineColumns(array($v->sku, $v->title), 1); }

		$p[] = '<td style="text-align:center">'.$v->quantity.'</td>';


		$netto 		= (int)$v->quantity * $v->netto;
		$nettoUnit	= $v->netto;
		$tax 		= (int)$v->quantity * $v->tax;
		$brutto 	= (int)$v->quantity * $v->brutto;
		if ($d['type'] != 3) {
			if ($tax_calculation > 0) {
				$p[] = '<td style="text-align:right" colspan="2">'.$d['price']->getPriceFormat($v->netto).'</td>';
				$p[] = '<td style="text-align:right" colspan="2">'.$d['price']->getPriceFormat($netto).'</td>';
				$p[] = '<td style="text-align:right" colspan="1">'.$d['price']->getPriceFormat($tax).'</td>';
				$p[] = '<td style="text-align:right" colspan="2">'.$d['price']->getPriceFormat($brutto).'</td>';
			} else {
				$p[] = '<td style="text-align:right" colspan="2">'.$d['price']->getPriceFormat($v->netto).'</td>';
				$p[] = '<td style="text-align:right" colspan="2">'.$d['price']->getPriceFormat($brutto).'</td>';
			}

		}
		$p[] = '</tr>';

		if (!empty($v->attributes)) {
			$p[] = '<tr>';
			$p[] = '<td></td>';
			$p[] = '<td colspan="3" align="left"><ul class="ph-idnr-ul">';
			foreach ($v->attributes as $k2 => $v2) {
				$p[] = '<li><span class="ph-small ph-cart-small-attribute ph-idnr-li">'.$v2->attribute_title .' '.$v2->option_title.'</span></li>';

				if ($pR) { $oPr[] = $pP->printLineColumns(array(' - ' .$v2->attribute_title .' '.$v2->option_title)); }

			}
			$p[] = '</ul></td>';
			$p[] = '<td colspan="8"></td>';
			$p[] = '</tr>';
		}

		if ($pR) {
			$brutto = (int)$v->quantity * $v->brutto;
			$oPr[] = $pP->printLineColumns(array((int)$v->quantity . ' x ' . $d['price']->getPriceFormat($v->brutto), $d['price']->getPriceFormat($brutto)));
		}

		$lastSaleNettoUnit 	= array();
		$lastSaleNetto 		= array();
		$lastSaleTax 		= array();
		$lastSaleBrutto 	= array();
		if (!empty($d['discounts'][$v->product_id_key]) && $d['type'] != 3) {

			$lastSaleNettoUnit[$v->product_id_key] 	= $nettoUnit;
			$lastSaleNetto[$v->product_id_key] 		= $netto;
			$lastSaleTax[$v->product_id_key] 		= $tax;
			$lastSaleBrutto[$v->product_id_key] 	= $brutto;


			foreach($d['discounts'][$v->product_id_key] as $k3 => $v3) {

				$nettoUnit3 							= $v3->netto;
				$netto3									= (int)$v->quantity * $v3->netto;
				$tax3 									= (int)$v->quantity * $v3->tax;
				$brutto3 								= (int)$v->quantity * $v3->brutto;

				$saleNettoUnit							= $lastSaleNettoUnit[$v->product_id_key] 	- $nettoUnit3;
				$saleNetto								= $lastSaleNetto[$v->product_id_key] 		- $netto3;
				$saleTax								= $lastSaleTax[$v->product_id_key] 			- $tax3;
				$saleBrutto								= $lastSaleBrutto[$v->product_id_key] 		- $brutto3;

				$lastSaleNettoUnit[$v->product_id_key] 	= $nettoUnit3;
				$lastSaleNetto[$v->product_id_key] 		= $netto3;
				$lastSaleTax[$v->product_id_key] 		= $tax3;
				$lastSaleBrutto[$v->product_id_key] 	= $brutto3;

				if ($display_discount_price_product == 2) {

					$p[] = '<tr '.$bProduct.'>';
					$p[] = '<td></td>';
					$p[] = '<td colspan="'.$cTitle.'">'.$v3->title.'</td>';
					$p[] = '<td style="text-align:center"></td>';
					if ($tax_calculation > 0) {
						$p[] = '<td style="text-align:right" colspan="2">'.$d['price']->getPriceFormat($saleNettoUnit, 1).'</td>';
						$p[] = '<td style="text-align:right" colspan="2">'.$d['price']->getPriceFormat($saleNetto, 1).'</td>';
						$p[] = '<td style="text-align:right" colspan="1">'.$d['price']->getPriceFormat($saleTax, 1).'</td>';
						$p[] = '<td style="text-align:right" colspan="2">'.$d['price']->getPriceFormat($saleBrutto, 1).'</td>';
					} else {
						$p[] = '<td style="text-align:right" colspan="2">'.$d['price']->getPriceFormat($saleNettoUnit, 1).'</td>';
						$p[] = '<td style="text-align:right" colspan="2">'.$d['price']->getPriceFormat($saleBrutto, 1).'</td>';
					}

					$p[] = '</tr>';

					if ($pR) {
						$oPr[] = $pP->printLineColumns(array($v3->title, $d['price']->getPriceFormat($saleBrutto, 1)));
					}
				} else if ($display_discount_price_product == 1) {

					$p[] = '<tr '.$bProduct.'>';
					$p[] = '<td></td>';
					$p[] = '<td colspan="'.$cTitle.'">'.$v3->title.'</td>';
					$p[] = '<td style="text-align:center"></td>';
					/*$p[] = '<td style="text-align:right" colspan="2">'.$d['price']->getPriceFormat($nettoUnit3).'</td>';
					$p[] = '<td style="text-align:right" colspan="2">'.$d['price']->getPriceFormat($netto3).'</td>';
					$p[] = '<td style="text-align:right" colspan="1">'.$d['price']->getPriceFormat($tax3).'</td>';
					$p[] = '<td style="text-align:right" colspan="2">'.$d['price']->getPriceFormat($brutto3).'</td>';*/
					
					if ($tax_calculation > 0) {
						$p[] = '<td style="text-align:right" colspan="2">'.$d['price']->getPriceFormat($nettoUnit3).'</td>';
						$p[] = '<td style="text-align:right" colspan="2">'.$d['price']->getPriceFormat($netto3).'</td>';
						$p[] = '<td style="text-align:right" colspan="1">'.$d['price']->getPriceFormat($tax3).'</td>';
						$p[] = '<td style="text-align:right" colspan="2">'.$d['price']->getPriceFormat($brutto3).'</td>';
					} else {
						$p[] = '<td style="text-align:right" colspan="2">'.$d['price']->getPriceFormat($nettoUnit3).'</td>';
						$p[] = '<td style="text-align:right" colspan="2">'.$d['price']->getPriceFormat($brutto3).'</td>';
					}
					
					$p[] = '</tr>';

					if ($pR) {
						$oPr[] = $pP->printLineColumns(array($v3->title, $d['price']->getPriceFormat($brutto3)));
					}
				}

			}
		}

	}

	if ($pR) { $oPr[] = $pP->printSeparator(); }

}

$o[] = implode("\n", $p);


if ($tax_calculation > 0) {
	$o[] = '<tr><td colspan="12" '.$sepH.'>&nbsp;</td></tr>';
} else {
	$o[] = '<tr><td colspan="9" '.$sepH.'>&nbsp;</td></tr>';
}


// -----------
// TOTAL
// -----------
$t = array();
$toPay = 0;

$tColspanLeft = 5;
$tColspanMid = 2;
$tColspanRight = 2;

if ($tax_calculation > 0) {
	$tColspanLeft = 7;
	$tColspanMid = 3;
	$tColspanRight = 2;
}

if (!empty($d['total'])) {
	foreach($d['total'] as $k => $v) {

		if($v->amount == 0 && $v->amount_currency == 0 && $v->type != 'brutto') {
			// Don't display coupon if null

		} else if ($v->type == 'netto') {
			$t[] = '<tr '.$totalF.'>';
			$t[] = '<td colspan="'.$tColspanLeft.'"></td>';
			$t[] = '<td colspan="'.$tColspanMid.'"><b>'.$v->title.'</b></td>';
			$t[] = '<td style="text-align:right" colspan="'.$tColspanRight.'"><b>'.$d['price']->getPriceFormat($v->amount).'</b></td>';
			$t[] = '</tr>';

			if ($pR) { $oPr[] = $pP->printLineColumns(array($v->title, $d['price']->getPriceFormat($v->amount))); }

		} else if ($v->type == 'brutto') {

			// Brutto or Brutto currency
			$amount = (isset($v->amount_currency) && $v->amount_currency > 0) ? $d['price']->getPriceFormat($v->amount_currency, 0, 1) : $d['price']->getPriceFormat($v->amount);

			$t[] = '<tr '.$totalF.'>';
			$t[] = '<td colspan="'.$tColspanLeft.'"></td>';
			$t[] = '<td colspan="'.$tColspanMid.'"><b>'.$v->title.'</b></td>';
			$t[] = '<td style="text-align:right" colspan="'.$tColspanRight.'"><b>'.$amount.'</b></td>';
			$t[] = '</tr>';


			if ($pR) {
				$oPr[] = $pP->printSeparator();
				$oPr[] = $pP->printLineColumns(array($v->title, $amount), 0, 'pDoubleSize');
				$oPr[] = $pP->printFeed(2);
			}

		} else if ($v->type == 'rounding') {

			// Rounding or rounding currency
			$amount = (isset($v->amount_currency) && $v->amount_currency > 0) ? $d['price']->getPriceFormat($v->amount_currency, 0, 1) : $d['price']->getPriceFormat($v->amount);

			$t[] = '<tr '.$totalF.'>';
			$t[] = '<td colspan="'.$tColspanLeft.'"></td>';
			$t[] = '<td colspan="'.$tColspanMid.'">'.$v->title.'</td>';
			$t[] = '<td style="text-align:right" colspan="'.$tColspanRight.'">'.$amount.'</td>';
			$t[] = '</tr>';

			if ($pR) { $oPr[] = $pP->printLineColumns(array($v->title, $amount)); }


		} else {
			$t[] = '<tr '.$totalF.'>';
			$t[] = '<td colspan="'.$tColspanLeft.'"></td>';
			$t[] = '<td colspan="'.$tColspanMid.'">'.$v->title.'</td>';
			$t[] = '<td style="text-align:right" colspan="'.$tColspanRight.'">'.$d['price']->getPriceFormat($v->amount).'</td>';
			$t[] = '</tr>';

			if ($pR) { $oPr[] = $pP->printLineColumns(array($v->title, $d['price']->getPriceFormat($v->amount))); }
		}

		if ($v->type == 'brutto' && $d['type'] == 2) {
			$toPay = $v->amount;
		}
	}
}

if ($d['type'] != 3) {
	$o[] = implode("\n", $t);
}

if ($tax_calculation > 0) {
	$o[] = '<tr><td colspan="12">&nbsp;</td></tr>';
} else {
	$o[] = '<tr><td colspan="9">&nbsp;</td></tr>';
}



// -----------
// TO PAY
// -----------
if ($toPay > 0) {
	$o[] = '<tr class="ph-idnr-to-pay-box">';
	$o[] = '<td colspan="'.$tColspanLeft.'">&nbsp;</td>';
	$o[] = '<td colspan="'.$tColspanMid.'" '.$toPayS.'><b>'.JText::_('COM_PHOCACART_TO_PAY').'</b></td>';
	$o[] = '<td colspan="'.$tColspanRight.'" '.$toPaySV.'><b>'.$d['price']->getPriceFormat($toPay).'</b></td>';
	$o[] = '</tr>';
}


$o[] = '</table>';// End box in


// -----------------------
// INVOICE MIDDLE DESCRIPTION
// -----------------------
$hrSmallMiddle = 0;
if ($d['type'] == 2) {
	
	if ($d['common']->invoice_spec_middle_desc != '') {
		$o[] = $hrSmallMiddle == 1 ? '' : '<div '.$hrSmall.'>&nbsp;</div>';
		$invoice_spec_middle_desc_article = PhocacartPdf::skipStartAndLastTag($d['common']->invoice_spec_middle_desc, 'p');
		//$o[] = '<div '.$bDesc.'>'.$invoice_spec_middle_desc_article.'</div>';
		$o[] = '<table '.$bDesc.'><tr><td>'.$invoice_spec_middle_desc_article.'</td></tr></table>';
	} else if ((int)$invoice_global_middle_desc > 0) {
		$invoice_global_middle_desc_article = PhocacartRenderFront::renderArticle((int)$invoice_global_middle_desc);
		if ($invoice_global_middle_desc_article != '') {
			$o[] = '<div '.$hrSmall.'>&nbsp;</div>';
			$hrSmallMiddle = 1;
			$invoice_global_middle_desc_article = PhocacartPdf::skipStartAndLastTag($invoice_global_middle_desc_article, 'p');
			//$o[] = '<div '.$bDesc.'>'.$invoice_global_middle_desc_article.'</div>';
			$o[] = '<table '.$bDesc.'><tr><td>'.$invoice_global_middle_desc_article.'</td></tr></table>';
		}
	}
}


// -----------------------
// INVOICE QR CODE, STAMP IMAGE
// -----------------------
if ($d['format'] == 'pdf' && $d['type'] == 2 && ($d['qrcode'] != '' || $pdf_invoice_signature_image != '')) {
	$o[] = '<div>&nbsp;</div><div>&nbsp;</div>';
	$o[] = '<table>';// End box in
	$o[] = '<tr><td>';

	if ($pdf_invoice_qr_information != '') {
		$o[] = '<span '.$bQrInfo.'>'.$pdf_invoice_qr_information . '</span><br />';
	}

	if ($d['qrcode'] != '') {
		$o[] = '{phocapdfqrcode|'.urlencode($d['qrcode']).'}';
	}
	$o[] = '</td><td>';
	if ($pdf_invoice_signature_image != '') {
		$o[] = '<img src="'.JURI::root().'/'.$pdf_invoice_signature_image.'" style="width:80"/>';
	}
	$o[] = '</td></tr>';
	$o[] = '</table>';
}

// -----------------------
// TAX RECAPITULATION
// -----------------------
if (($display_tax_recapitulation_invoice == 1 && $d['type'] == 2 ) ||  ($display_tax_recapitulation_pos == 1 && $d['type'] == 4 )) {
	$orderCalc 		= new PhocacartOrderCalculation();
	$calcItems		= array();
	$calcItems[0]	= $d['common'];
	$orderCalc->calculateOrderItems($calcItems);
	$calcTotal		= $orderCalc->getTotal();
	$taxes 			= PhocacartTax::getAllTaxes();
	if (!empty($calcTotal)) {
		foreach ($calcTotal as $k => $v) {
			

			if (!empty($v)) {
				$d['price']->setCurrency($k);
				
				
				if ($pR) {
					$oPr[] = $pP->printLine(array(JText::_('COM_PHOCACART_TAX_RECAPITULATION')), 'pLeft');
				}
				
				if (!empty($v['tax'])) {
					
					$o[] = '<table '.$taxRecTable.'>';
					$o[] = '<tr><th colspan="2">'.JText::_('COM_PHOCACART_TAX_RECAPITULATION').'</th></tr>';
					
					foreach($v['tax'] as $kT => $vT) {
						
						$calcTitle = isset($taxes[$kT]['title']) ? $taxes[$kT]['title'] : '';
						
						$o[] = '<tr><td '.$taxRecTd.'>'.$calcTitle.'</td>';
						$o[] = '<td '.$taxRecTd.'>'.$d['price']->getPriceFormat($vT,0,1) . '</td></tr>';
						
						if ($pR) {
							$oPr[] = $pP->printLineColumns(array($calcTitle, $d['price']->getPriceFormat($vT,0,1)));
						}
					}
					
					$o[] = '</table>';
					if ($pR) {
						$oPr[] = $pP->printFeed(1);
					}
				}
			}
		}
	}
}


// -----------------------
// POINTS RECEIVED
// -----------------------

if (($display_reward_points_invoice == 1 && $d['type'] == 2 ) ||  ($display_reward_points_pos == 1 && $d['type'] == 4 )) {
	if ((int)$d['common']->user_id > 0 && (int)$d['common']->id > 0) {
		$pointsUser 	= PhocacartReward::getTotalPointsByUserIdExceptCurrentOrder($d['common']->user_id, $d['common']->id);
		$pointsOrder 	= PhocacartReward::getTotalPointsByOrderId($d['common']->id);
		
		
		$o[] = '<div>'.JText::_('COM_PHOCACART_YOUR_CURRENT_REWARD_POINTS_BALANCE').': '.$pointsUser.'</div>';
		$o[] = '<div>'.JText::_('COM_PHOCACART_POINTS_RECEIVED_FOR_THIS_PURCHASE').': '.$pointsOrder.'</div>';
		
		if ($pR) {
			$oPr[] = $pP->printLineColumns(array(JText::_('COM_PHOCACART_YOUR_CURRENT_REWARD_POINTS_BALANCE').': ', $pointsUser));
			$oPr[] = $pP->printLineColumns(array(JText::_('COM_PHOCACART_POINTS_RECEIVED_FOR_THIS_PURCHASE'). ': ', $pointsOrder));
			$oPr[] = $pP->printFeed(1);
		}
	}
}

// -----------------------
// INVOICE BOTTOM DESCRIPTION
// -----------------------
$hrSmallBottom = 0;
if ($d['type'] == 2) {
	
	if ($d['common']->invoice_spec_bottom_desc != '') {
		$o[] = $hrSmallBottom == 1 ? '' : '<div '.$hrSmall.'>&nbsp;</div>';
		$invoice_spec_bottom_desc_article = PhocacartPdf::skipStartAndLastTag($d['common']->invoice_spec_bottom_desc, 'p');
		//$o[] = '<div '.$bDesc.'>'.$invoice_spec_bottom_desc_article.'</div>';
		$o[] = '<table '.$bDesc.'><tr><td>'.$invoice_spec_bottom_desc_article.'</td></tr></table>';
	} else if ((int)$invoice_global_bottom_desc > 0) {
		$invoice_global_bottom_desc_article = PhocacartRenderFront::renderArticle((int)$invoice_global_bottom_desc);
		if ($invoice_global_bottom_desc_article != '') {
			$o[] = '<div '.$hrSmall.'>&nbsp;</div>';
			$hrSmallBottom = 1;
			$invoice_global_bottom_desc_article = PhocacartPdf::skipStartAndLastTag($invoice_global_bottom_desc_article, 'p');
			//$o[] = '<div '.$bDesc.'>'.$invoice_global_bottom_desc_article.'</div>';
			$o[] = '<table '.$bDesc.'><tr><td>'.$invoice_global_bottom_desc_article.'</td></tr></table>';
		}
	}
}



$o[] = '</div>';// End box


// POS FOOTER
if ($pR) {

	
	
	if (isset($d['common']->amount_tendered) && $d['common']->amount_tendered > 0 && isset($d['common']->amount_change) && ($d['common']->amount_change > 0 || $d['common']->amount_change == 0)) {
		//$oPr[] = $pP->printLine(array(JText::_('COM_PHOCACART_RECEIPT_AMOUNT_TENDERED').': '.$d['price']->getPriceFormat($d['common']->amount_tendered)), 'pLeft');
		//$oPr[] = $pP->printLine(array(JText::_('COM_PHOCACART_RECEIPT_AMOUNT_CHANGED').': '.$d['price']->getPriceFormat($d['common']->amount_change)), 'pLeft');
		$oPr[] = $pP->printLineColumns(array(JText::_('COM_PHOCACART_RECEIPT_AMOUNT_TENDERED').': ', $d['price']->getPriceFormat($d['common']->amount_tendered)));
		$oPr[] = $pP->printLineColumns(array(JText::_('COM_PHOCACART_RECEIPT_AMOUNT_CHANGED').': ', $d['price']->getPriceFormat($d['common']->amount_change)));
		$oPr[] = $pP->printFeed(1);
	}
	

	$oPr[] = $pP->printLine(array(JText::_('COM_PHOCACART_RECEIPT_NR').': '.PhocacartOrder::getReceiptNumber($d['common']->id, $d['common']->date, $d['common']->receipt_number)), 'pLeft');
	$oPr[] = $pP->printLine(array(JText::_('COM_PHOCACART_PURCHASE_DATE').': '.JHtml::date($d['common']->date, 'DATE_FORMAT_LC5')), 'pLeft');
	$oPr[] = $pP->printFeed(1);

	$storeInfoFooterPos = array();
	if ($store_info_footer_pos != '') {
		$storeInfoFooterPos = explode("\n", $store_info_footer_pos);
	}

	$oPr[] = $pP->printLine($storeInfoFooterPos, 'pCenter');
}

if ($pR) {
	//$oPr2 = implode("\n", $oPr);
	$oPr2 = implode("", $oPr);// new rows set in print library
	echo $oPr2;
} else {
	$o2 = implode("\n", $o);
	echo $o2;
}

?>