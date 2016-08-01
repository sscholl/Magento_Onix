<?php /**************** Copyright notice ************************
 *  (c) 2011 Simon Eric Scholl <simon@sdscholl.de>
 *  All rights reserved
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 ***************************************************************/

class SScholl_Onix_Model_Product_Processor_Int
	extends SScholl_Onix_Model_Product_Processor_Abstract
{

	/**
	 * Set the data to the book
	 */
	public function process()
	{
		$this->getBook()->setData(
			$this->getAttributeCode(),
			(int) $this->getValue()
		);
	}

}