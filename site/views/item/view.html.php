<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view');
jimport( 'joomla.filesystem.folder' );  
jimport( 'joomla.filesystem.file' );

class PhocaCartViewItem extends JViewLegacy
{
	protected $item;
	protected $itemnext;
	protected $itemprev;
	protected $category;
	protected $t;
	protected $p;
	protected $u;

	function display($tpl = null){		
		
		$app = JFactory::getApplication();
		$menus	= $app->getMenu('site', array());
		$items	= $menus->getItems('component', 'com_phocacart');
		
		$app					= JFactory::getApplication();
		$this->p 				= $app->getParams();
		$this->u				= PhocacartUser::getUser();
		$uri 					= \Joomla\CMS\Uri\Uri::getInstance();
		$model					= $this->getModel();
		$document				= JFactory::getDocument();
		$id						= $app->input->get('id', 0, 'int');
		$catid					= $app->input->get('catid', 0, 'int');

		$this->category			= $model->getCategory($id, $catid);

		$this->item				= $model->getItem($id, $catid);
		$this->t['catid']		= 0;
		if (isset($this->category[0]->id)) {
			$this->t['catid']	= (int)$this->category[0]->id;
		}
	
	
	
	
		// PARAMS
		$this->t['tax_calculation'] 		= $this->p->get( 'tax_calculation', 0 );
		$this->t['cart_metakey'] 			= $this->p->get( 'cart_metakey', '' );
		$this->t['cart_metadesc'] 			= $this->p->get( 'cart_metadesc', '' );
		$this->t['display_back']			= $this->p->get( 'display_back', 3 );
		//$this->t['enable_social']			= $this->p->get( 'enable_social', 0 );
		$this->t['enable_item_navigation']	= $this->p->get( 'enable_item_navigation', 0 );
		$this->t['item_addtocart']			= $this->p->get( 'item_addtocart', 1 );
		$this->t['enable_review']			= $this->p->get( 'enable_review', 1 );
		$this->t['dynamic_change_image']	= $this->p->get( 'dynamic_change_image', 0);
		$this->t['dynamic_change_price']	= $this->p->get( 'dynamic_change_price', 0 );
		$this->t['dynamic_change_stock']	= $this->p->get( 'dynamic_change_stock', 0 );
		$this->t['image_popup_method']		= $this->p->get( 'image_popup_method', 1 );
		$this->t['display_compare']			= $this->p->get( 'display_compare', 0 );
		$this->t['display_wishlist']		= $this->p->get( 'display_wishlist', 0 );
		$this->t['add_compare_method']		= $this->p->get( 'add_compare_method', 0 );
		$this->t['add_wishlist_method']		= $this->p->get( 'add_wishlist_method', 0 );
		$this->t['hide_price']				= $this->p->get( 'hide_price', 0 );
		$this->t['hide_addtocart']			= $this->p->get( 'hide_addtocart', 0 );
		$this->t['hide_attributes_item']	= $this->p->get( 'hide_attributes_item', 0 );
		$this->t['hide_attributes']			= $this->p->get( 'hide_attributes', 0 );
		$this->t['item_askquestion']		= $this->p->get( 'item_askquestion', 0 );
		$this->t['popup_askquestion']		= $this->p->get( 'popup_askquestion', 1 );
		$this->t['title_next_prev']			= $this->p->get( 'title_next_prev', 1 );
		$this->t['display_public_download'] = $this->p->get( 'display_public_download', 1 );
		$this->t['display_external_link']	= $this->p->get( 'display_external_link', 1 );
		$this->t['enable_rewards']			= $this->p->get( 'enable_rewards', 1 );
		$this->t['enable_price_history'] 	= $this->p->get( 'enable_price_history', 0 );
		$this->t['display_stock_status']	= $this->p->get( 'display_stock_status', 1 );
		$this->t['hide_add_to_cart_stock']	= $this->p->get( 'hide_add_to_cart_stock', 0 );
		$this->t['zero_attribute_price']	= $this->p->get( 'zero_attribute_price', 1 );
		$this->t['hide_add_to_cart_zero_price']	= $this->p->get( 'hide_add_to_cart_zero_price', 0 );
	
		
		// Catalogue function
		if ($this->t['hide_addtocart'] == 1) {
			$this->t['item_addtocart']		= 0;
			//$this->t['display_addtocart_icon'] 	= 0;
			//$this->t['hide_attributes_category']= 1; Should be displayed or not?
		}
		if ($this->t['hide_attributes'] == 1) {
			$this->t['hide_attributes_item'] = 1;
		}
		
		if (!isset($this->item[0]->id) || (isset($this->item[0]->id) && $this->item[0]->id < 1)) {
			
			header("HTTP/1.0 404 ".JText::_('COM_PHOCACART_NO_PRODUCT_FOUND'));
			echo '<div class="alert alert-error">'.JText::_('COM_PHOCACART_NO_PRODUCT_FOUND').'</div>';
			

			
		} else {
		
			$this->t['add_images']			= PhocacartImage::getAdditionalImages((int)$id);
			$this->t['rel_products']		= PhocacartRelated::getRelatedItemsById((int)$id, 0, 1);
			$this->t['tags_output']			= PhocacartTag::getTagsRendered((int)$id);
			$this->t['taglabels_output']	= PhocacartTag::getTagsRendered((int)$id, 1);
			$this->t['stock_status']		= array();
			//$this->t['stock_status']		= PhocacartStock::getStockStatus((int)$this->item[0]->stock, (int)$this->item[0]->min_quantity, (int)$this->item[0]->min_multiple_quantity, (int)$this->item[0]->stockstatus_a_id,  (int)$this->item[0]->stockstatus_n_id);
			
			
			//$this->t['stock_status_output'] = PhocacartStock::getStockStatusOutput($this->t['stock_status']);
			$this->t['attr_options']		= $this->t['hide_attributes_item'] == 0 ? PhocacartAttribute::getAttributesAndOptions((int)$id) : array();
			
			$this->t['specifications']		= PhocacartSpecification::getSpecificationGroupsAndSpecifications((int)$id);
			$this->t['reviews']				= PhocacartReview::getReviewsByProduct((int)$id);
			
			if ($this->t['enable_price_history']) {
				$this->t['price_history_data']	= PhocacartPriceHistory::getPriceHistoryChartById((int)$id);
			}
			
			$this->t['action']				= $uri->toString();
			//$this->t['actionbase64']		= base64_encode(htmlspecialchars($this->t['action']));
			$this->t['actionbase64']		= base64_encode($this->t['action']);
			$this->t['linkcheckout']		= JRoute::_(PhocacartRoute::getCheckoutRoute((int)$this->item[0]->id, (int)$this->category[0]->id));
			$this->t['linkitem']			= JRoute::_(PhocacartRoute::getItemRoute((int)$this->item[0]->id, (int)$this->category[0]->id));

			$this->t['linkcomparison']	= JRoute::_(PhocacartRoute::getComparisonRoute((int)$this->item[0]->id, (int)$this->category[0]->id));
			$this->t['linkwishlist']	= JRoute::_(PhocacartRoute::getWishListRoute((int)$this->item[0]->id, (int)$this->category[0]->id));
			$this->t['linkdownload']	= JRoute::_(PhocacartRoute::getDownloadRoute((int)$this->item[0]->id, (int)$this->category[0]->id));
			$this->itemnext[0]			= false;
			$this->itemprev[0]			= false;
			if ($this->t['enable_item_navigation'] == 1) {
				if (isset($this->item[0]->ordering) && isset($this->item[0]->catid) && isset($this->item[0]->id) && $this->item[0]->catid > 0 && $this->item[0]->id > 0) {
					$this->itemnext			= $model->getItemNext($this->item[0]->ordering, $this->item[0]->catid);
					$this->itemprev			= $model->getItemPrev($this->item[0]->ordering, $this->item[0]->catid);
				}
			}
			
			
			$media = new PhocacartRenderMedia();
			$media->loadBootstrap();
			$media->loadChosen();
			$media->loadRating();
			$media->loadPhocaSwapImage();
			$media->loadPhocaAttribute(1);
			
			$media->loadTouchSpin('quantity');// only css, js will be loaded in ajax success
			
			
			if ($this->t['popup_askquestion'] == 1) {
				$media->loadWindowPopup();
			}
			
			if ($this->t['image_popup_method'] == 2) {
				PhocacartRenderJs::renderMagnific();
				$this->t['image_rel'] 	= 'rel="magnific"';
				$this->t['image_class']	= 'magnific';
			} else {
				PhocacartRenderJs::renderPrettyPhoto();
				$this->t['image_rel'] = 'rel="prettyPhoto[pc_gal1]"';
				$this->t['image_class']	= '';
			}
			
			if ($this->t['hide_attributes_item'] == 0) {
				$media->loadPhocaAttributeRequired(1); // Some of the attribute can be required and can be a image checkbox
			}

			if ($this->t['dynamic_change_price'] == 1) {
				PhocacartRenderJs::renderAjaxChangeProductPriceByOptions((int)$this->item[0]->id, 'Item', 'ph-item-price-box');
			}
			if ($this->t['dynamic_change_stock'] == 1) {
				PhocacartRenderJs::renderAjaxChangeProductStockByOptions((int)$this->item[0]->id, 'Item', 'ph-item-stock-box');
			}
			
			PhocacartRenderJs::renderAjaxAddToCart();
			PhocacartRenderJs::renderAjaxAddToCompare();
			PhocacartRenderJs::renderAjaxAddToWishList();
			
			
			
			
			if (isset($this->category[0]) && is_object($this->category[0]) && isset($this->item[0]) && is_object($this->item[0])){
				$this->_prepareDocument($this->category[0], $this->item[0]);
			}
			
			$this->t['pathitem'] = PhocacartPath::getPath('productimage');
			
		}
		$model->hit((int)$id);
		PhocacartStatisticsHits::productHit((int)$id);
		
		// Plugins ------------------------------------------
		JPluginHelper::importPlugin('pcv');
		//$this->t['dispatcher']	= J EventDispatcher::getInstance();
		$this->t['event']		= new stdClass;
		
		$results = \JFactory::getApplication()->triggerEvent('PCVonItemBeforeHeader', array('com_phocacart.item', &$this->item, &$this->p));
		$this->t['event']->onItemBeforeHeader = trim(implode("\n", $results));
		
		$results = \JFactory::getApplication()->triggerEvent('PCVonItemAfterAddToCart', array('com_phocacart.item', &$this->item, &$this->p));
		$this->t['event']->onItemAfterAddToCart = trim(implode("\n", $results));
		
		$results = \JFactory::getApplication()->triggerEvent('PCVonItemBeforeEndPricePanel', array('com_phocacart.item', &$this->item, &$this->p));
		$this->t['event']->onItemBeforeEndPricePanel = trim(implode("\n", $results));
		
		$results = \JFactory::getApplication()->triggerEvent('PCVonItemInsideTabPanel', array('com_phocacart.item', &$this->item, &$this->p));
		$this->t['event']->onItemInsideTabPanel = $results;
		
		$results = \JFactory::getApplication()->triggerEvent('PCVonItemAfterTabs', array('com_phocacart.item', &$this->item, &$this->p));
		$this->t['event']->onItemAfterTabs = trim(implode("\n", $results));
		// END Plugins --------------------------------------
			
		parent::display($tpl);
	}
	

	
	protected function _prepareDocument() {
		$category = false;
		if (isset($this->category[0]) && is_object($this->category[0])) {
			$category = $this->category[0];
		}
		$item = false;
		if (isset($this->item[0]) && is_object($this->item[0])) {
			$item = $this->item[0];
		}
		PhocacartRenderFront::prepareDocument($this->document, $this->p, $category, $item);
	}
}
?>