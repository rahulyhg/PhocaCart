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
defined( '_JEXEC' ) or die( 'Restricted access' );

class PhocacartRenderIcon
{
	private static $iconType = '';
	private static $i = 0;
	private function __construct(){}
	
	public static function getClassAdmin($name = '') {
		
		if ($name != ''){
			return 'glyphicon glyphicon-'.$name;
		}
		return '';
	}
	
	public static function getIconType() {
		if( self::$iconType == '' ) {
			$pC 		= PhocacartUtils::getComponentParameters();
			self::$iconType	= $pC->get( 'icon_type', 'bs' );
			
		}
		return self::$iconType;
	}
	
	public static function getClass( $name = '') {
		self::$i++;
		
		
		
		if( self::$iconType == '' ) {
			$pC 		= PhocacartUtils::getComponentParameters();
			self::$iconType	= $pC->get( 'icon_type', 'bs' );
		}
		
		switch (self::$iconType) {
			
			case 'fa':
				$iconP = 'fa fa-';
				$iconS = ' fa-fw';
				$iconA = array(
'view-category' 	=> 'search',
'view-product' 		=> 'search',
'back-category'		=> 'arrow-left',
'ok' 				=> 'check',
'not-ok' 			=> 'remove',
'remove' 			=> 'remove',
'clear' 			=> 'remove',
'edit'				=> 'edit',
'plus' 				=> 'plus',
'minus' 			=> 'minus',
'chevron-up' 		=> 'chevron-up',
'chevron-down'		=> 'chevron-down',
'shopping-cart'		=> 'shopping-bag',
'question-sign' 	=> 'question-circle',
'info-sign' 		=> 'info-circle',
'compare'			=> 'clone',
'ext-link' 			=> 'share',
'int-link' 			=> 'share-alt',
'download' 			=> 'download',
'quick-view'		=> 'eye',
'wish-list' 		=> 'heart',
'ban' 				=> 'ban',
'refresh' 			=> 'refresh',
'trash'				=> 'trash',				
'triangle-bottom'	=> 'caret-down',
'triangle-right'	=> 'caret-right',
'save'				=> 'save',
'user'				=> 'user',
'grid'				=> 'th-large',					
'gridlist'			=> 'th-list',
'list'				=> 'align-justify',					
'next'				=> 'arrow-right',
'prev'				=> 'arrow-left',				
'submit'			=> 'ok',
'invoice'			=> 'list-alt fa-file-invoice-dollar',
'del-note'			=> 'barcode fa-file-invoice',
'order'				=> 'search fa-file-alt',
'receipt'			=> 'th-list fa-receipt',
'print'				=> 'print',
'barcode'			=> 'barcode',
'search'			=> 'search',
'payment-method'	=> 'credit-card',
'shipping-method'	=> 'barcode',
'log-out'			=> 'sign-out-alt',
'calendar'			=> 'calendar'		
);
			break;
			
			case 'bs':
			default:
				$iconP = 'glyphicon glyphicon-';
				$iconS = '';
				$iconA = array(
'view-category' 	=> 'search',
'view-product' 		=> 'search',
'back-category'		=> 'arrow-left',
'ok' 				=> 'ok',
'not-ok' 			=> 'remove',
'remove' 			=> 'remove',
'clear' 			=> 'remove',
'edit'				=> 'edit',
'plus' 				=> 'plus',
'minus' 			=> 'minus',
'chevron-up' 		=> 'chevron-up',
'chevron-down'		=> 'chevron-down',
'shopping-cart'		=> 'shopping-cart',
'question-sign' 	=> 'question-sign',
'info-sign' 		=> 'info-sign',
'compare'			=> 'stats',
'ext-link' 			=> 'share',
'int-link' 			=> 'share-alt',
'download' 			=> 'download',
'quick-view'		=> 'eye-open',
'wish-list' 		=> 'heart',
'ban' 				=> 'ban-circle',
'refresh' 			=> 'refresh',
'trash'				=> 'trash',				
'triangle-bottom'	=> 'triangle-bottom',
'triangle-right'	=> 'triangle-right',
'save'				=> 'floppy-disk',
'user'				=> 'user',
'grid'				=> 'th-large',					
'gridlist'			=> 'th-list',
'list'				=> 'align-justify',					
'next'				=> 'arrow-right',
'prev'				=> 'arrow-left',				
'submit'			=> 'ok',
'invoice'			=> 'list-alt',
'del-note'			=> 'barcode',
'order'				=> 'search',
'receipt'			=> 'th-list',
'print'				=> 'print',
'barcode'			=> 'barcode',
'search'			=> 'search',
'payment-method'	=> 'credit-card',
'shipping-method'	=> 'barcode',
'log-out'			=> 'arrow-left',
'calendar'			=> 'calendar'				
);
			break;
		}
		
		if (isset($iconA[$name]) && $iconA[$name] != '') {
			return $iconP . $iconA[$name] . $iconS;
		} else {
			return $iconP . htmlspecialchars(strip_tags($name)) . $iconS;
		}
		
	}	
	
	public final function __clone() {
		throw new Exception('Function Error: Cannot clone instance of Singleton pattern', 500);
		return false;
	}
}
?>