<?php /**************** Copyright notice ************************
 *  (c) 2011 Simon Eric Scholl <simon@sdscholl.de>
 *  All rights reserved
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 ***************************************************************/

class SScholl_Onix_Model_Product_Processor_Measure
	extends SScholl_Onix_Model_Product_Processor_Abstract
{

	const HEIGHT		= '01';
	const WIDTH			= '02';
	const THICKNESS		= '03';
	const WEIGHT		= '08';

	public function process()
	{
		$value = $this->getSubTagValue('c094');
		$unit = $this->getSubTagValue('c095');
		switch ( $this->getSubTagValue('c093') ) {
			case self::HEIGHT:
				$this->getBook()->setHeight($value . ' ' . $unit);
			break;
			case self::WIDTH:
				$this->getBook()->setWidth($value . ' ' . $unit);
			break;
			case self::THICKNESS:
				$this->getBook()->setThickness($value . ' ' . $unit);
			break;
			case self::WEIGHT:
				$this->getBook()->setWeight($value . ' ' . $unit);
			break;
		}
	}

}