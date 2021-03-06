<?php
/**
 * @package   Phoca Cart
 * @author    Jan Pavelka - https://www.phoca.cz
 * @copyright Copyright (C) Jan Pavelka https://www.phoca.cz
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 and later
 * @cms       Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die();

class PhocacartText {
	
	/*
	 * type ... 1 customers - email sent to customer
	 * type ... 2 others - email sent to all others
	 */
	
	public static function completeText($body, $replace, $type = 1) {
	
	
		if ($type == 2) {
			$body = isset($replace['name']) ? str_replace('{name}', $replace['name'], $body) : $body;
			//$body = isset($replace['name_others']) ? str_replace('{nameothers}', $replace['name_others'], $body) : $body;
		} else {
			$body = isset($replace['name']) ? str_replace('{name}', $replace['name'], $body) : $body;
		}
		
		if ($type == 2) {
			$body = isset($replace['email_others']) ? str_replace('{emailothers}', $replace['email_others'], $body) : $body;
		} else {
			$body = isset($replace['email']) ? str_replace('{email}', $replace['email'], $body) : $body;
		}
		
		
		$body = isset($replace['downloadlink']) 			? str_replace('{downloadlink}', $replace['downloadlink'], $body) 					: $body;
		$body = isset($replace['orderlink'])				? str_replace('{orderlink}', $replace['orderlink'], $body)							: $body;
		$body = isset($replace['trackinglink'])				? str_replace('{trackinglink}', $replace['trackinglink'], $body)					: $body;
		$body = isset($replace['shippingtitle'])			? str_replace('{shippingtitle}', $replace['shippingtitle'], $body)					: $body;
		$body = isset($replace['dateshipped'])				? str_replace('{dateshipped}', $replace['dateshipped'], $body)						: $body;
		$body = isset($replace['trackingdescription'])		? str_replace('{trackingdescription}', $replace['trackingdescription'], $body)		: $body;
		$body = isset($replace['customercomment'])			? str_replace('{customercomment}', $replace['customercomment'], $body)				: $body;
		$body = isset($replace['websitename'])				? str_replace('{websitename}', $replace['websitename'], $body)						: $body;
		$body = isset($replace['websiteurl'])				? str_replace('{websiteurl}', $replace['websiteurl'], $body)						: $body;
	
		$body = isset($replace['orderid'])					? str_replace('{orderid}', $replace['orderid'], $body)								: $body;
		$body = isset($replace['ordernumber'])				? str_replace('{ordernumber}', $replace['ordernumber'], $body)						: $body;
		$body = isset($replace['invoicenumber'])			? str_replace('{invoicenumber}', $replace['invoicenumber'], $body)					: $body;
		$body = isset($replace['receiptnumber'])			? str_replace('{receiptnumber}', $replace['receiptnumber'], $body)					: $body;
		$body = isset($replace['paymentreferencenumber'])	? str_replace('{paymentreferencenumber}', $replace['paymentreferencenumber'], $body): $body;
		$body = isset($replace['invoiceduedate'])			? str_replace('{invoiceduedate}', $replace['invoiceduedate'], $body)				: $body;
		$body = isset($replace['invoicedate'])				? str_replace('{invoicedate}', $replace['invoicedate'], $body)						: $body;
		$body = isset($replace['totaltopay'])				? str_replace('{totaltopay}', $replace['totaltopay'], $body)						: $body;
		
		
		$body = isset($replace['orderyear'])				? str_replace('{orderyear}', $replace['orderyear'], $body)							: $body;
		$body = isset($replace['ordermonth'])				? str_replace('{ordermonth}', $replace['ordermonth'], $body)						: $body;
		$body = isset($replace['orderday'])					? str_replace('{orderday}', $replace['orderday'], $body)							: $body;
		
		$body = isset($replace['ordernumbertxt'])			? str_replace('{ordernumbertxt}', $replace['ordernumbertxt'], $body)				: $body;
	
		
		$body = isset($replace['bankaccountnumber'])		? str_replace('{bankaccountnumber}', $replace['bankaccountnumber'], $body)			: $body;
		$body = isset($replace['iban'])						? str_replace('{iban}', $replace['iban'], $body)									: $body;
		$body = isset($replace['bicswift'])					? str_replace('{bicswift}', $replace['bicswift'], $body)							: $body;
		$body = isset($replace['totaltopaynoformat'])		? str_replace('{totaltopaynoformat}', $replace['totaltopaynoformat'], $body)		: $body;
		$body = isset($replace['currencycode'])				? str_replace('{currencycode}', $replace['currencycode'], $body)		: $body;
		return $body;
	}
	
	public static function completeTextFormFields($body, $bas, $type = 1) {
		
		if ($type == 1) {
			$prefix = 'b_';
		} else {
			$prefix = 's_';
		}
		
		if (!empty($bas)) {
			if (isset($bas['id'])) {unset($bas['id']);}
			if (isset($bas['order_id'])) {unset($bas['order_id']);}
			if (isset($bas['user_address_id'])) {unset($bas['user_address_id']);}
			if (isset($bas['user_token'])) {unset($bas['user_token']);}
			if (isset($bas['user_groups'])) {unset($bas['user_groups']);}
			if (isset($bas['ba_sa'])) {unset($bas['ba_sa']);}
			if (isset($bas['type'])) {unset($bas['type']);}
		
			foreach($bas as $k => $v) {
				
		
				
				if ($v != '') {
					$body = str_replace('{'.$prefix.$k.'}', $v, $body);
				}
			}
		}
		
		return $body;
	}
	
	public static function prepareReplaceText($order, $orderId, $common, $bas){
		
		
		
		$pC				= JComponentHelper::getParams( 'com_phocacart' );
		$config 		= JFactory::getConfig();
		$price			= new PhocacartPrice();
		$price->setCurrency($common->currency_code, $orderId);
		$totalBrutto	= $order->getItemTotal($orderId, 0, 'brutto');
		
		$r = array();
		// Standard User get standard download page and order page
		if ($common->user_id > 0) {
			$r['orderlink'] 	= PhocacartPath::getRightPathLink(PhocacartRoute::getOrdersRoute());
			$r['downloadlink'] 	= PhocacartPath::getRightPathLink(PhocacartRoute::getDownloadRoute());
		} else {
			if (isset($common->order_token) && $common->order_token != '') {
				$r['orderlink'] = PhocacartPath::getRightPathLink(PhocacartRoute::getOrdersRoute() . '&o='.$common->order_token);
			}
			$products 	= $order->getItemProducts($orderId);
			
			$downloadO 	= '';
			if(!empty($products) && isset($common->order_token) && $common->order_token != '') {
				$downloadO	= '<p>&nbsp;</p><h4>'.JText::_('COM_PHOCACART_DOWNLOAD_LINKS').'</h4>';
				foreach ($products as $k => $v) {
					if ($v->download_published == 1) {
						$downloadO .= '<div><strong>'.$v->title.'</strong></div>';
						$downloadLink = PhocacartPath::getRightPathLink(PhocacartRoute::getDownloadRoute() . '&o='.$common->order_token.'&d='.$v->download_token);
						$downloadO .= '<div><a href="'.$downloadLink.'">'.$downloadLink.'</a></div>';
					}
				}
				$downloadO .= '<p>&nbsp;</p>';
			}
			$r['downloadlink'] = $downloadO;
		}
		
		$r['trackinglink'] 			= PhocacartOrderView::getTrackingLink($common);
		$r['trackingdescription'] 	= PhocacartOrderView::getTrackingDescription($common);
		$r['shippingtitle'] 		= PhocacartOrderView::getShippingTitle($common);
		$r['dateshipped'] 			= PhocacartOrderView::getDateShipped($common);
		$r['customercomment'] 		= $common->comment;
		$r['currencycode'] 			= $common->currency_code;
		$r['websitename']			= $config->get( 'sitename' );
		$r['websiteurl']			= JURI::root();
		
		$r['orderid']				= $orderId;
		$r['ordernumber']			= PhocacartOrder::getOrderNumber($orderId, $common->date, $common->order_number);
		$r['invoicenumber']			= PhocacartOrder::getInvoiceNumber($orderId, $common->date, $common->invoice_number);
		$r['receiptnumber']			= PhocacartOrder::getReceiptNumber($orderId, $common->date, $common->receipt_number);
		$r['paymentreferencenumber']= PhocacartOrder::getPaymentReferenceNumber($orderId, $common->date, $common->invoice_prn);
		$r['invoiceduedate']		= PhocacartOrder::getInvoiceDueDate($orderId, $common->date, $common->invoice_due_date, 'Y-m-d');
		//$r['invoiceduedateyear']	= PhocacartOrder::getInvoiceDueDate($orderId, $common->date, $common->invoice_due_date, 'Y');
		//$r['invoiceduedatemonth']	= PhocacartOrder::getInvoiceDueDate($orderId, $common->date, $common->invoice_due_date, 'm');
		//$r['invoiceduedateday']	= PhocacartOrder::getInvoiceDueDate($orderId, $common->date, $common->invoice_due_date, 'd');
		$r['invoicedate']			= PhocacartOrder::getInvoiceDate($orderId, $common->invoice_date, 'Y-m-d');
		$totalToPay					= isset($totalBrutto[0]->amount) ? $totalBrutto[0]->amount : 0;
		$r['totaltopaynoformat']	= number_format($totalToPay, 2, '.', '');
		$r['totaltopay']			= $price->getPriceFormat($totalToPay, 0, 1);
		$dateO 						= PhocacartDate::splitDate($common->date);
		$r['orderyear']				= $dateO['year'];
		$r['ordermonth']			= $dateO['month'];
		$r['orderday']				= $dateO['day'];
		$r['ordernumbertxt']		= JText::_('COM_PHOCACART_ORDER_NR');
		
		
		$r['bankaccountnumber']		= $pC->get( 'bank_account_number', '' );
		$r['iban']					= $pC->get( 'iban', '' );
		$r['bicswift']				= $pC->get( 'bic_swift', '' );
		
	
		return $r;
		
	}
	
	
}