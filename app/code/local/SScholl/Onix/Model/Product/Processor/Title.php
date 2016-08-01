<?php /**************** Copyright notice ************************
 *  (c) 2011 Simon Eric Scholl <simon@sdscholl.de>
 *  All rights reserved
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 ***************************************************************/

class SScholl_Onix_Model_Product_Processor_Title
	extends SScholl_Onix_Model_Product_Processor_Abstract
{

	const TITLE				= '01';
	const ORIGINAL_TITLE	= '03';
	const EXPANDED_TITLE	= '13';
	
	public function process()
	{
		$title = $this->getSubTagValue('b203');
		$subTitle = $this->getSubTagValue('b029');
		switch ( $this->getSubTagValue('b202') ) {
			case self::TITLE:
				$this->getBook()->setName($title);
				$this->getBook()->setTitle($title);
				$this->getBook()->setSubtitle($subTitle);
			break;
			case self::ORIGINAL_TITLE:
				$this->getBook()->setOriginalTitle($title);
			break;
			case self::EXPANDED_TITLE:
				$this->getBook()->setExpandedTitle($title);
			break;
		}
	}

}