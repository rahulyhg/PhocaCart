<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

class PhocaCartControllerComparison extends JControllerForm
{
	
	public function add() {
		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$app				= JFactory::getApplication();
		$item				= array();
		$item['id']			= $this->input->get( 'id', 0, 'int' );
		$item['return']		= $this->input->get( 'return', '', 'string'  );
		
		$compare	= new PhocaCartCompare();
		$added	= $compare->addItem((int)$item['id']);
		if ($added) {
			$app->enqueueMessage(JText::_('COM_PHOCACART_PRODUCT_ADDED_TO_COMPARISON_LIST'), 'success');
		} else {
			$app->enqueueMessage(JText::_('COM_PHOCACART_PRODUCT_NOT_ADDED_TO_COMPARISON_LIST'), 'error');
		}
		//$app->redirect(JRoute::_('index.php?option=com_phocacart&view=checkout'));
		$app->redirect(base64_decode($item['return']));
	}
	
		public function remove() {
		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$app				= JFactory::getApplication();
		$item				= array();
		$item['id']			= $this->input->get( 'id', 0, 'int' );
		$item['return']		= $this->input->get( 'return', '', 'string'  );
		
		$compare	= new PhocaCartCompare();
		$added	= $compare->removeItem((int)$item['id']);
		if ($added) {
			$app->enqueueMessage(JText::_('COM_PHOCACART_PRODUCT_REMOVED_FROM_COMPARISON_LIST'), 'success');
		} else {
			$app->enqueueMessage(JText::_('COM_PHOCACART_PRODUCT_NOT_REMOVED_FROM_COMPARISON_LIST'), 'error');
		}
		//$app->redirect(JRoute::_('index.php?option=com_phocacart&view=checkout'));
		$app->redirect(base64_decode($item['return']));
	}
	
}
?>