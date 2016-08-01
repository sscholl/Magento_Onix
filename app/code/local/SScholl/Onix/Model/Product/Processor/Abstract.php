<?php
abstract class SScholl_Onix_Model_Product_Processor_Abstract
{

	private $_product	= null;
	private $_book		= null;
	private $_value		= null;
	

	public function init(
		SScholl_Onix_Model_Document_Product $product,
		sscholl_Books_Model_Book $book,
		$value
	) {
		$this->_product	= $product;
		$this->_book	= $book;
		$this->_value	= $value;
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
	
	public function getSubTagValue($tag)
	{
		return (string) $this->getValue()->$tag;
	}

	private $_attributeCode		= null;
	
	public function setAttributeCode($attributeCode)
	{
		$this->_attributeCode = $attributeCode;
		return $this;
	}
	
	public function getAttributeCode()
	{
		return $this->_attributeCode;
	}
	
	abstract public function process();

}