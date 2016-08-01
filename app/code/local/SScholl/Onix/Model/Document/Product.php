<?php /**************** Copyright notice ************************
 *  (c) 2011 Simon Eric Scholl <simon@sdscholl.de>
 *  All rights reserved
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 ***************************************************************/

class SScholl_Onix_Model_Document_Product
{
	
	const TYPE_REFERENCE	= 1;
	const TYPE_SHORT		= 2;

	/**
	 * @param SimpleXMLElement $product
	 * @return SScholl_Onix_Model_Document_Product
	 */
	public function init(SimpleXMLElement $product, $dtd = null)
	{
		$this->_product = $product;
		if ( is_null($dtd) ) {
			if ( (boolean) $this->_getProduct()->xpath('productidentifier') ) {
				$this->_type = self::TYPE_REFERENCE;
			} elseif ( (boolean) $this->_getProduct()->xpath('ProductIdentifier') ) {
				$this->_type = self::TYPE_SHORT;
			} else {
				throw new Exception("Invalid DTD.");
			}
		} else {
			$this->_type = $dtd;
		}
		return $this;
	}

	/**
	 * @return sscholl_Books_Model_Book
	 */
	public function getBook()
	{
		if (is_null($this->_book)) {
			$this->_book = Mage::getModel('sschollbooks/book');
			$processors = Mage::getSingleton('sschollonix/product_processors')->init();
			foreach ( $this->_getProduct()->children() as $tag ) {
				$processor = $processors->getProcessor($tag->getName());
				if ( is_null($processor) ) continue;
				$processor->init($this, $this->_book, $tag);
				$processor->process();
			}
			if (!$this->isValid()) {
				$this->_logError('Product with Record Reverence ' . $this->_book->getRecordreference() . ' not is invalid.');
				return null;
			}
		}
		return $this->_book;
	}
	
	public function isShort()
	{
		return $this->_type === self::TYPE_SHORT; 
	}

	/**
	 * returns true if entry is invalid
	 * @return boolean
	 */
	public function isValid()
	{
		return $this->_valid;
	}
	
	public function setIsValid($valid)
	{
		$this->_valid = $valid;
	}
	
	private $_valid	= true;

	/**
	 * @var SimpleXMLElement
	 */
	private $_product		= null;

	/**
	 * @var sscholl_Books_Model_Book
	 */
	private $_book		= null;
	
	/**
	 * @return SimpleXMLElement
	 */
	private function _getProduct()
	{
		return $this->_product;
	}

	/**
	 * helper function log message with less code
	 * @param string $message
	 */
	private function _logWarning($message)
	{
		Mage::log(
			'Record: ' . $this->getBook()->getRecordreference()
			. ' SKU: ' . $this->getBook()->getSku()
			. ' ' . $message,
			null,
			'sschollonix_onix_entry_warning.log'
		);
	}

	/**
	 * helper function log message with less code
	 * @param string $message
	 */
	private function _logError($message)
	{
		Mage::log(
			'Record: ' . $this->getBook()->getRecordreference()
			. ' SKU: ' . $this->getBook()->getSku()
			. ' ' . $message,
			null,
			'sschollonix_onix_entry_error.log'
		);
	}

}