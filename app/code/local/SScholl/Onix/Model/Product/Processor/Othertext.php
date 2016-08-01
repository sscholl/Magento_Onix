<?php /**************** Copyright notice ************************
 *  (c) 2011 Simon Eric Scholl <simon@sdscholl.de>
 *  All rights reserved
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 ***************************************************************/

class SScholl_Onix_Model_Product_Processor_Othertext
	extends SScholl_Onix_Model_Product_Processor_Abstract
{

	const MAIN_DESCRIPTION		= '01';
	const SHORT_DESCRIPTION		= '02';
	const LONG_DESCRIPTION		= '03';

	public function process()
	{
		$text = $this->getSubTagValue('d104');
		switch ( $this->getSubTagValue('d102') ) {
			case self::MAIN_DESCRIPTION:
				$this->getBook()->setDescription($text);
			break;
			case self::SHORT_DESCRIPTION:
				$this->getBook()->setShortDescription($text);
			break;
			case self::LONG_DESCRIPTION:
				if ( !$this->getBook()->getDescription() )
					$this->getBook()->setDescription($text);
			break;
		}
	}

}