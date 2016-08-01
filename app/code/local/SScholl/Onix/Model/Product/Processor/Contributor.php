<?php /**************** Copyright notice ************************
 *  (c) 2011 Simon Eric Scholl <simon@sdscholl.de>
 *  All rights reserved
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 ***************************************************************/

class SScholl_Onix_Model_Product_Processor_Contributor
	extends SScholl_Onix_Model_Product_Processor_Abstract
{
	
	public function process()
	{
		$name 			= $this->getSubTagValue('b036');
		$nameInverted	= $this->getSubTagValue('b037');
		/* @var $contributor sscholl_Books_Model_Book_Contributor */
		$contributor	= Mage::getModel('sschollbooks/book_contributor');
		$contributor->setRole($this->getSubTagValue('b035'));
		if ( !$name ) {
			$name = explode(',', $nameInverted);
			if (isset($name[0], $name[1]) ) {
				$contributor->setName(trim($name[1] . ' ' . $name[0]));
			}
		} else {
			$contributor->setName($name);
		}
		$contributor->setNameInverted($nameInverted);
		$this->getBook()->addContributor($contributor, $this->getSubTagValue('b034'));
		
		$this->getBook()->addListData('contributors' , $contributor->getName());
		if ( $contributor->isAuthor() ) {
			$this->getBook()->addListData('authors' , $contributor->getName());
		}
	}

}