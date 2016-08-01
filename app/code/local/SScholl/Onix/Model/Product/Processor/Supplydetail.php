<?php /**************** Copyright notice ************************
 *  (c) 2011 Simon Eric Scholl <simon@sdscholl.de>
 *  All rights reserved
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 ***************************************************************/

class SScholl_Onix_Model_Product_Processor_Supplydetail
	extends SScholl_Onix_Model_Product_Processor_Abstract
{

	const CODE_AVAILABLE = 'IP';
	
	public function process()
	{
		$name 		= $this->getSubTagValue('j137');
		/* @var $supplier sscholl_Books_Model_Book_Supplier */
		$supplier	= Mage::getModel('sschollbooks/book_supplier');
		$supplier->setName($name);
		$supplier->setSupplierAvailabilityCode($this->getSubTagValue('j141'));
		$supplier->setSupplierProductAvailability((int) $this->getSubTagValue('j396'));
		foreach ( $this->getValue()->price as $price ){
			$priceModel	= Mage::getModel('sschollbooks/book_supplier_price');
			$priceModel->setTypeCode((string) $price->j148);
			$priceModel->setAmount((string) $price->j151);
			$priceModel->setCurrencyCode((string) $price->j152);
			$priceModel->setTaxRateCode((string) $price->j153);
			//$priceModel->setTaxRatePercent((string) $price->j154);
			//$priceModel->setCountryCode((string) $price->b251);
			$supplier->addPrice($priceModel);
		}
		foreach ( $this->getValue()->stock as $stock ) {
			$stockModel	= Mage::getModel('sschollbooks/book_supplier_stock');
			$stockModel->setOnHand((int) $stock->j350);
			$supplier->addStock($stockModel);
		}
		$this->getBook()->addSupplier($supplier);

		$this->getBook()->setDefaultSupplier();
	}

}