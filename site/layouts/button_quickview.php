<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();
$d = $displayData;
?>
<form action="<?php echo $d['linkqvb']; ?>" method="post" id="phQuickView<?php echo (int)$d['id']; ?>" class="phItemQuickViewBoxForm">
	<input type="hidden" name="id" value="<?php echo (int)$d['id']; ?>" />
	<input type="hidden" name="catid" value="<?php echo (int)$d['catid']; ?>" />
	<input type="hidden" name="tmpl" value="component" />
	<input type="hidden" name="option" value="com_phocacart" />
	<input type="hidden" name="return" value="<?php echo $d['return']; ?>" />
	<div class="ph-pull-right">
		<div class="ph-category-item-quickview">
			<a href="javascript:void(0)" onclick="phItemQuickViewBoxFormAjax('phQuickView<?php echo (int)$d['id']; ?>');" title="<?php echo JText::_('COM_PHOCACART_QUICK_VIEW'); ?>"  data-toggle="tooltip" data-placement="top"><span class="<?php echo PhocacartRenderIcon::getClass('quick-view') ?>"></span></a>
		</div>
	</div>
	<?php /*<div class="clearfix"></div> */ ?>
	<?php echo JHtml::_('form.token'); ?>
</form>