<?php /**************** Copyright notice ************************
 *  (c) 2011 Simon Eric Scholl <simon@sdscholl.de>
 *  All rights reserved
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 ***************************************************************/

class SScholl_Onix_Model_Product_Processor_Productidentifier
	extends SScholl_Onix_Model_Product_Processor_Abstract
{

	const PROPRIETARY		= '01';
	const ISBN10			= '02';
	const EAN				= '03';
	const ISBN13			= '15';

	/**
	 * Set Product Identifier
	 */
	public function process()
	{
		$id = $this->getSubTagValue('b244');
		switch ( $this->getSubTagValue('b221') ) {
			case self::PROPRIETARY:
				$this->getBook()->setProprietaryProductIdentifier($id);
			break;
			case self::ISBN10:
				$this->getBook()->setIsbn($id);
			break;
			case self::EAN:
				$this->getBook()->setEan($id);
			break;
			case self::ISBN13:
				$this->getBook()->setEan($id);
			break;
		}
	}

}