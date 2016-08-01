<?php /**************** Copyright notice ************************
 *  (c) 2011 Simon Eric Scholl <simon@sdscholl.de>
 *  All rights reserved
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 ***************************************************************/

class SScholl_Onix_Model_Product_Processor_Date
	extends SScholl_Onix_Model_Product_Processor_Abstract
{

	/**
	 * Set the data to the book
	 */
	public function process()
	{
		$value = substr($this->getValue(), 0, 8);
		$value = date_create_from_format('Ymd', $value);
		if ( !$value instanceof DateTime ) {
			$value = substr($this->getValue(), 0, 6);
			$value = date_create_from_format('Ym', $value);
			if ( !$value instanceof DateTime ) {
				$value = substr($this->getValue(), 0, 4);
				$value = date_create_from_format('Y', $value);
				if ( !$value instanceof DateTime ) {
					$this->getBook()->setData($this->getAttributeCode(), $this->getValue());
					return;
				} else {
					$value = $value->format('Y-01-01 H:i:s');
				}
			} else {
				$value = $value->format('Y-m-01 H:i:s');
			}
		} else {
			$value = $value->format('Y-m-d H:i:s');
		}
		$this->getBook()->setData($this->getAttributeCode(), $value);
	}

}