<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();
$d 					= $displayData;
$displayData 		= null;
$v 					= $d['attribute'];
$attributeIdName	= 'V'.$d['typeview'].'P'.(int)$d['product_id'].'A'.(int)$v->id;
$productIdName		= 'V'.$d['typeview'].'P'.(int)$d['product_id'];

$attr				= array();
$attr[]				= 'id="phItemAttribute'.$attributeIdName.'"';// ID
$attr[]				= 'class="form-control chosen-select ph-item-input-set-attributes phj'. $d['typeview'].' phjProductAttribute"';// CLASS
$attr[]				= $d['required']['attribute'];
$attr[]				= 'name="attribute['.(int)$v->id.']"';
$attr[]				= 'data-product-id="'. $d['product_id'].'"';// Product ID
$attr[]				= 'data-product-id-name="'. $productIdName.'"';// Product ID - Unique name between different views
$attr[]				= 'data-attribute-type="'. $v->type.'"';// Type of attribute (select, checkbox, color, image)
$attr[]				= 'data-attribute-id-name="'. $attributeIdName.'"';// Attribute ID - Unique name between different views and products
$attr[]				= 'data-type-view="'. $d['typeview'].'"';// In which view are attributes displayed: Category, Items, Item, Quick Item

echo '<div id="phItemBoxAttribute'.$attributeIdName.'">';
echo '<select '.implode(' ', $attr).'>';
echo '<option value="">'. JText::_('COM_PHOCACART_SELECT_OPTION').'</option>';

foreach ($v->options as $k2 => $v2) {
	if($v2->operator == '=') {
		$operator = '';
	} else {
		$operator = $v2->operator;
	}
	$amount = $d['price']->getPriceFormat($v2->amount);
	
	// Switch large image
	$attrO		= '';
	
	if ($d['dynamic_change_image'] == 1) {
		if ($d['image_size'] == 'large' && isset($v2->image) && $v2->image != '') {
			$imageO 	= PhocacartImage::getThumbnailName($d['pathitem'], $v2->image, $d['image_size']);
		} else if ($d['image_size'] == 'medium' && isset($v2->image) && $v2->image != '') {
			$imageO 	= PhocacartImage::getThumbnailName($d['pathitem'], $v2->image, $d['image_size']);
		}
		
		if (isset($imageO->rel) && $imageO->rel != '') {
			$linkO 		= JURI::base(true).'/'.$imageO->rel;
			
			if (JFile::exists($imageO->abs)) {
				$attrO		.= 'data-image-option="'.htmlspecialchars($linkO).'"';
			}
		}
		
	}
	
	// SELECTBOX COLOR
	if ($v->type == 2 && isset($v2->color) && $v2->color != '') {
		$attrO		.= ' data-color="'.strip_tags($v2->color).'"';
	}
	
	// SELECTBOX IMAGE
	if ($v->type == 3 && isset($v2->image_small) && $v2->image_small != '') {
		$linkI 		= JURI::base(true).'/'.$d['pathitem']['orig_rel'].'/'.$v2->image_small;
		$attrO		.= ' data-image="'.strip_tags($linkI).'"';
	}
	
	// SELECTED SOME VALUE? 
	if ($v2->default_value == 1) {
		$attrO		.= ' selected="seleced"';
	}
	
	echo '<option '.$attrO.' value="'.$v2->id.'">'.htmlspecialchars($v2->title).' ('.$operator.' '.$amount.')</option>';
}

echo '</select>';// end select box
echo '</div>';// end attribute
echo '<div id="phItemHiddenAttribute'.$attributeIdName.'" style="display:none;"></div>';
?>