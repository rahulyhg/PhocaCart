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
<div class="ph-pull-right">
<?php
if ($d['display_view_category_button'] == 1) {
	
	?><a href="<?php echo $d['link']; ?>" class="btn btn-primary" role="button"><span class="<?php echo PhocacartRenderIcon::getClass('view-category') ?>"></span> <?php echo JText::_('COM_PHOCACART_VIEW_CATEGORY'); ?></a><?php

} else if ($d['display_view_category_button'] == 2) {
	
	?><a href="<?php echo $d['link']; ?>" class="btn btn-primary" role="button" title="<?php echo JText::_('COM_PHOCACART_VIEW_CATEGORY'); ?>"><span class="<?php echo PhocacartRenderIcon::getClass('view-category') ?>"></span></a><?php

} ?>
</div>
<div class="clearfix"></div>