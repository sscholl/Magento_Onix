<?php /**************** Copyright notice ************************
 *  (c) 2011 Simon Eric Scholl <simon@sdscholl.de>
 *  All rights reserved
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 ***************************************************************/

class SScholl_Onix_Model_Product_Processors
{

	const PROCESSOR_DEFAULT = 'sschollonix/product_processor_default';

	private $_tags	= array();
	private $_book		= null;
	private $_value		= null;

	public function init()
	{
		$data = Mage::getConfig()->getNode('sschollonix');
		foreach ( $data->tags->children() as $tag ) {
			$processor = $this->_getProcessor($tag->getName(), $tag->processor);
			if ( !is_null($processor) ) {
				$processor->setAttributeCode((string) $tag->attribute);
			}
		}
		return $this;
	}
	
	public function getProduct()
	{
		return $this->_product;
	}
	
	public function getBook()
	{
		return $this->_book;
	}
	
	public function getValue()
	{
		return $this->_value;
	}
	
	public function getProcessor($tag)
	{
		if (
			!isset($this->_tags[$tag])
			|| !$this->_tags[$tag] instanceof SScholl_Onix_Model_Product_Processor_Abstract
		) {
			return null;
		}
		return $this->_tags[$tag];
	}
	
	private function _getProcessor($name, $processor)
	{
		$processor = (string) $processor;
		if ( $processor ) {
			$processorModel = Mage::getModel($processor);
			if ( $processorModel instanceof SScholl_Onix_Model_Product_Processor_Abstract ) {
				return $this->_tags[$name] = $processorModel;
			}
		}
		return $this->_tags[$name] = Mage::getModel(self::PROCESSOR_DEFAULT);
	}

}