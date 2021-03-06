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
use Joomla\Utilities\ArrayHelper;

defined('_JEXEC') or die();

/*
 * Payment Method - is the method stored in Phoca Cart
 * Method - is the method of payment - e.g. Paypal, Cash On Delivery, ...
 *
 * EXAMPLE:
 * Payment Method: Cash to 100eur -> Method: Cash On Delivery
 * Payment Method: Cash over 100eur -> Method: Cash On Delivery 
 * Payment Method: Paypal to 100eur -> Method: Paypal Standard
 * Payment Method: Paypal over 100eur -> Method: Paypal Standard
 * 
 */

class PhocacartPayment
{
	protected $type = array(0,1);// 0 all, 1 online shop, 2 pos (category type, payment method type, shipping method type)
	
	public function __construct() {
		
	}
	
	public function setType($type = array(0,1)) {
		$this->type = $type;
	}
	
	/*
	 * Be aware:
	 * if id > 0 ... it can test if the payment method exists (order)
	 * if id = 0 ... it lists all possible payment methods meeting the criteria (checkout)
	 * Always test for the id before using this function
	 */
									
	public function getPossiblePaymentMethods($amountNetto, $amountBrutto, $country, $region, $shipping, $id = 0, $selected = 0) {
		
		$app			= JFactory::getApplication();
		$paramsC 		= PhocacartUtils::getComponentParameters();
		$payment_amount_rule	= $paramsC->get( 'payment_amount_rule', 0 );
		
		$user 			= PhocacartUser::getUser();
		$userLevels		= implode (',', $user->getAuthorisedViewLevels());
		$userGroups 	= implode (',', PhocacartGroup::getGroupsById($user->id, 1, 1));
		
		$db 			= JFactory::getDBO();
		
		
		$wheres	  = array();
		// ACCESS
		$wheres[] = " p.published = 1";
		$wheres[] = " p.access IN (".$userLevels.")";
		$wheres[] = " (ga.group_id IN (".$userGroups.") OR ga.group_id IS NULL)";
		
		$wheres[] = " p.type IN (". implode(',', $this->type). ')';
		
		
		if ((int)$id > 0) {
			$wheres[] =  'p.id = '.(int)$id;
			$limit = ' LIMIT 1';
			//$group = '';
		} else {
			$limit = '';
			
		}
				
		$columns		= 'p.id, p.tax_id, p.cost, p.cost_additional, p.calculation_type, p.title, p.image, p.access, p.description,'
		.' p.active_amount, p.active_zone, p.active_country, p.active_region, p.active_shipping,'
		.' p.lowest_amount, p.highest_amount, p.default,'
		.' t.id as taxid, t.title as taxtitle, t.tax_rate as taxrate, t.calculation_type as taxcalculationtype,'
		.' GROUP_CONCAT(DISTINCT r.region_id) AS region,'
		.' GROUP_CONCAT(DISTINCT c.country_id) AS country,'
		.' GROUP_CONCAT(DISTINCT z.zone_id) AS zone,'
		.' GROUP_CONCAT(DISTINCT s.shipping_id) AS shipping';
		$groupsFull		= 'p.id, p.tax_id, p.cost, p.cost_additional, p.calculation_type, p.title, p.image, p.access, p.description,'
		.' p.active_amount, p.active_zone, p.active_country, p.active_region, p.active_shipping,'
		.' p.lowest_amount, p.highest_amount, p.default,'
		.' t.id, t.title, t.tax_rate, t.calculation_type';
		$groupsFast		= 'p.id';
		$groups			= PhocacartUtilsSettings::isFullGroupBy() ? $groupsFull : $groupsFast;
				
		$where 		= ( count( $wheres ) ? ' WHERE '. implode( ' AND ', $wheres ) : '' );
		
		/*$query = ' SELECT p.id, p.title, p.image'
				.' FROM #__phocacart_payment_methods AS p'
				.' WHERE p.published = 1'
				.' ORDER BY p.ordering';
		$db->setQuery($query);*/
		
		$query = ' SELECT '.$columns
				.' FROM #__phocacart_payment_methods AS p'
				.' LEFT JOIN #__phocacart_payment_method_regions AS r ON r.payment_id = p.id'
				.' LEFT JOIN #__phocacart_payment_method_countries AS c ON c.payment_id = p.id'
				.' LEFT JOIN #__phocacart_payment_method_zones AS z ON z.payment_id = p.id'
				.' LEFT JOIN #__phocacart_payment_method_shipping AS s ON s.payment_id = p.id'
				.' LEFT JOIN #__phocacart_taxes AS t ON t.id = p.tax_id'	
				.' LEFT JOIN #__phocacart_item_groups AS ga ON p.id = ga.item_id AND ga.type = 8'// type 8 is payment
				. $where
				. ' GROUP BY '.$groups
				. $limit;
		
	
		PhocacartUtils::setConcatCharCount();
		$db->setQuery($query);
		$payments = $db->loadObjectList();
		
		if (!empty($payments) && !isset($payments[0]->id) || (isset($payments[0]->id) && (int)$payments[0]->id < 1)) {
			return false;
		}
		
		$i = 0;
		if (!empty($payments)) {
			foreach($payments as $k => $v) {
				
			
				$v->active = 0;
				$v->selected = 0;
				$a = 0;
				$z = 0;
				$c = 0;
				$r = 0;
				$s = 0;
				
				// Amount Rule
				if($v->active_amount == 1) {
				
					if ($payment_amount_rule == 0 || $payment_amount_rule == 1) {
						// No tax, brutto
						if ($amountBrutto > $v->lowest_amount && $amountBrutto < $v->highest_amount) {
							$a = 1;
						}
					
					} else if ($payment_amount_rule == 2) {
						// Netto
						if ($amountNetto > $v->lowest_amount && $amountNetto < $v->highest_amount) {
							$a = 1;
						}
					
					}
				} else {
					$a = 1;
				}
				
				// Zone Rule
				
				if($v->active_zone == 1) {
					if (isset($v->zone) && $v->zone != '')  {
						$zones = explode(',', $v->zone);
						
						if (PhocacartZone::isCountryOrRegionIncluded($zones, (int)$country, (int)$region)) {
							$z = 1;
						}
					}
				
				} else {
					$z = 1;
				}
				
				// Country Rule
				if($v->active_country == 1) {
					if (isset($v->country) && $v->country != '') {
						$countries = explode(',', $v->country);
						
						if (in_array((int)$country, $countries)) {
							$c = 1;
						}
					}
				} else {
					$c = 1;
				}
				
				// Region Rule
				if($v->active_region == 1) {
					if (isset($v->region) && $v->region != '') {
						$regions = explode(',', $v->region);
						
						if (in_array((int)$region, $regions)) {
							$r = 1;
						}
					}
				}  else {
					$r = 1;
				}
			
				// Shipping Rule
				if($v->active_shipping == 1) {
					if (isset($v->shipping) && $v->shipping != '') {
						$shippings = explode(',', $v->shipping);
						
						if (in_array((int)$shipping, $shippings)) {
							$s = 1;
						}
					}
				} else {
					$s = 1;
				}
			
				// No rule was set for shipping, it will be displayed at all events
				if($v->active_amount == 0 && $v->active_country == 0 && $v->active_region == 0 && $v->active_shipping == 0) {
					$v->active = 1;
				}
				
				
				// if some of the rules is not valid, all the payment is NOT valid
				if ($a == 0 || $z == 0 || $c == 0 || $r == 0 || $s == 0) {
					$v->active = 0;
				} else {
					$v->active = 1;
				}
				
				if ($v->active == 0) {
					if (isset($payments[$i])) {
						unset($payments[$i]);
					}
				}
				
				// Try to set default for frontend form
				// If user selected some payment, such will be set as default
				// If not then the default will be set
				if ((int)$selected > 0) {
					if ((int)$v->id == (int)$selected) {
						$v->selected = 1;
					}
				} else {
					$v->selected = $v->default;
				}
				
				$i++;
			}
		
		}
		
		return $payments;
		
	}
	
	/**
	 * Check current payment method
	 * Payment method must be selected
	 * @param number $id
	 * @return boolean|array
	 */
	public function checkAndGetPaymentMethod($id = 0) {
	
		if ($id > 0) {
			return $this->checkAndGetPaymentMethods($id);
		}
		return false;
		
	}
	
	/**
	 * Check current payment method or all methods they meet criteria to be selected
	 * @param number $selectedPaymentId
	 * @param number $selected
	 * @return boolean|array
	 */
	
	public function checkAndGetPaymentMethods($selectedPaymentId = 0, $selected = 0) {
	
		
		$cart					= new PhocacartCartRendercheckout();
		$cart->setType($this->type);
		$cart->setFullItems();
		$total					= $cart->getTotal();
		$currentShippingId 		= $cart->getShippingId();
		//$currentPaymentId 		= $cart->getPaymentId();
		
		$user					= PhocacartUser::getUser();
		$data					= PhocacartUser::getUserData((int)$user->id);
		$fields 				= PhocacartFormUser::getFormXml('', '_phs', 1,1,0);
		
		if (!empty($data)) {
			$dataAddress	= PhocacartUser::getAddressDataOutput($data, $fields['array'], $user);
		}
		
		$country = 0;
		if(isset($dataAddress['bcountry']) && (int)$dataAddress['bcountry']) {
			$country = (int)$dataAddress['bcountry'];
		}
		
		$region = 0;
		if(isset($dataAddress['bregion']) && (int)$dataAddress['bregion']) {
			$region = (int)$dataAddress['bregion'];
		}
			
		$paymentMethods	= $this->getPossiblePaymentMethods($total[0]['netto'], $total[0]['brutto'], $country, $region, $currentShippingId, $selectedPaymentId, $selected);
		

		if (!empty($paymentMethods)) {
			return $paymentMethods;
		}
		return false;
		
	}
	
	public function getPaymentMethod($paymentId) {
		
		//$paramsC 				= PhocacartUtils::getComponentParameters();
		//$shipping_amount_rule	= $paramsC->get( 'shipping_amount_rule', 0 );
		
		$db = JFactory::getDBO();
		
		/*$query = ' SELECT p.id, p.title, p.image,'
				.' FROM #__phocacart_payment_methods AS s'
				.' WHERE p.id = '.(int)$paymentId
				.' LIMIT 1';
		$db->setQuery($query);*/
		
		$query = ' SELECT p.id, p.tax_id, p.cost, p.cost_additional, p.calculation_type, p.title, p.image, p.method, p.params, p.description, '
				.' t.id as taxid, t.title as taxtitle, t.tax_rate as taxrate, t.calculation_type as taxcalculationtype'
				.' FROM #__phocacart_payment_methods AS p'
				.' LEFT JOIN #__phocacart_taxes AS t ON t.id = p.tax_id'
				.' WHERE p.id = '.(int)$paymentId
				.' ORDER BY p.id'
				.' LIMIT 1';
		$db->setQuery($query);

		$payment = $db->loadObject();
		
		if (isset($payment->params)) {
		
			$registry = new JRegistry;
			$registry->loadString($payment->params);
			$payment->params = $registry;
			//$payment->paramsArray = $registry->toArray();
		}
		return $payment;
	}
	
	/*
	 * Important function - when e.g. user changes the address or change the items in cart, the payment method
	 * needs to be removed, because user can get payment advantage when he orders 10 items but after changing
	 * cart to e.g. one item, payment cannot stay the same, the same happens with countries and region
	 */
	
	public static function removePayment() {
		$db 			= JFactory::getDBO();
		$user			= $vendor = $ticket = $unit	= $section = array();
		$dUser			= PhocacartUser::defineUser($user, $vendor, $ticket, $unit, $section);
		
		$pos_payment_force = 0;
		if (PhocacartPos::isPos()) {
			$app					= JFactory::getApplication();
			$paramsC 				= PhocacartUtils::getComponentParameters();
			$pos_payment_force	= $paramsC->get( 'pos_payment_force', 0 );
		}
		
		$query = 'UPDATE #__phocacart_cart_multiple SET payment = '.(int)$pos_payment_force
			.' WHERE user_id = '.(int)$user->id 
			.' AND vendor_id = '.(int)$vendor->id 
			.' AND ticket_id = '.(int)$ticket->id 
			.' AND unit_id = '.(int)$unit->id
			.' AND section_id = '.(int)$section->id;
		$db->setQuery($query);
		
		$db->execute();
		return true;
	}
	
	/* Checkout - is there even some payment NOT is used reverse - used only in online shop type
	 * This function is different to getPossiblePaymentMethods()
	 * 
	 * getPossiblePaymentMethods() - all methods they fit the criterias (e.g. amount rule, contry rule, etc.)
	 * isPaymentNotUsed() - all existing methods in shop which are published 
	 * 
	 * */
	public static function isPaymentNotUsed($options = array()) {
	
	
		// 1) TEST IF ANY PAYMENT METHOD EXISTS
		$db =JFactory::getDBO();

		$query = 'SELECT a.id'
				.' FROM #__phocacart_payment_methods AS a'
				.' WHERE a.published = 1'
				.' AND a.type IN (0,1)'
				.' ORDER BY id LIMIT 1';
		$db->setQuery($query);
		$methods = $db->loadObjectList();
		
		if (empty($methods)) {
			return true;
		}
		
		// 2) TEST IF PAYMENT METHOD IS NOT DISABLED FOR CART WITH EMPTY PRICE (CART SUM = 0)
		$paramsC 		= PhocacartUtils::getComponentParameters();
		$skip_payment_method	= $paramsC->get( 'skip_payment_method', 0 );
		if (isset($options['order_amount_zero']) &&  $options['order_amount_zero'] == 1 && $skip_payment_method == 1) {
			return true;
		}
		
		return false;
	}
	
	/*
	 * Get all PCP Plugins
	 */
	
	public static function getPaymentPluginMethods($namePlugin = '') {
		
		$db 	= JFactory::getDBO();
		$lang	= JFactory::getLanguage();
		$client	= JApplicationHelper::getClientInfo(0);
		$query = 'SELECT a.extension_id , a.name, a.element, a.folder'
				.' FROM #__extensions AS a'
				.' WHERE a.type = '.$db->quote('plugin')
				.' AND a.enabled = 1'
				.' AND a.folder = ' . $db->quote('pcp');
		
		if ($namePlugin != '') {
			$query .= 'AND a.element = '. $db->quote($name);
		}

		$query .= ' ORDER BY a.ordering';
		$db->setQuery($query);
		$plugins = $db->loadObjectList();
		
		
		if ($namePlugin == '') {
			$i 		= 0;
			$p[0]['text'] 	= '- ' .JText::_('COM_PHOCACART_SELECT_PAYMENT_METHOD').' -';
			$p[0]['value'] 	= '';
		} else {
			$i 		= -1;
		}
		if (!empty($plugins)) {
			foreach($plugins as $k => $v) {
				
				// Load the core and/or local language file(s).
				$folder 	= 'pcp';
				$element	= $v->element;
			$lang->load('plg_'.$folder.'_'.$element, JPATH_ADMINISTRATOR, null, false, false)
		||	$lang->load('plg_'.$folder.'_'.$element, $client->path.'/plugins/'.$folder.'/'.$element, null, false, false)
		||	$lang->load('plg_'.$folder.'_'.$element, JPATH_ADMINISTRATOR, $lang->getDefault(), false, false)
		||	$lang->load('plg_'.$folder.'_'.$element, $client->path.'/plugins/'.$folder.'/'.$element, $lang->getDefault(), false, false);
				
				$i++;
					
				$name = JText::_(strtoupper($v->name) );
				$name = str_replace('Plugin', '', $name);
				$name = str_replace('Phoca Cart Payment -', '', $name);
				
				$p[$i]['text'] = JText::_($name);
				$p[$i]['value'] = $v->element;
			}
		
		}
		
		if ($namePlugin != '' && !empty($p[0])) {
			return $p[0];
		}
		
		return $p;

	}	
	
	public static function proceedToPaymentGateway($payment) {
	
		$proceed = 0;
		$message = array();
		
		if (isset($payment['method'])) {
			//$dispatcher = J EventDispatcher::getInstance();
			JPluginHelper::importPlugin('pcp', htmlspecialchars($payment['method']));
			
			\JFactory::getApplication()->triggerEvent('PCPbeforeProceedToPayment', array(&$proceed, &$message));
		}
		
		// Response is not a part of event parameter because of backward compatibility
		$response['proceed'] = $proceed;
		$response['message'] = $message;
		
		return $response;
	
	}
}
?>