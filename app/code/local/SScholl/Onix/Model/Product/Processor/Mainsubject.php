<?php /**************** Copyright notice ************************
 *  (c) 2011 Simon Eric Scholl <simon@sdscholl.de>
 *  All rights reserved
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 ***************************************************************/

class SScholl_Onix_Model_Product_Processor_Mainsubject
	extends SScholl_Onix_Model_Product_Processor_Abstract
{

	const WGS_CODE		= '26';

	public function process()
	{
		$code = $this->getSubTagValue('b069');
		$name = $this->getSubTagValue('b070');
		switch ( $this->getSubTagValue('b191') ) {
			case self::WGS_CODE:
				$this->getBook()->setWgsCode($code);
				$code = substr($name, 0, 2);
				if ($code === 'HC' || $code === 'TB') {
					$name = 'Book' . substr($name, 2);
				}
				$this->getBook()->setCategoryName($name);
			break;
		}
	}

}