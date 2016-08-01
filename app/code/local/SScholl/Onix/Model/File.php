<?php /**************** Copyright notice ************************
 *  (c) 2011 Simon Eric Scholl <simon@sdscholl.de>
 *  All rights reserved
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 ***************************************************************/

class SScholl_Onix_Model_File
	extends Varien_Object
{

	const LOG_FILE = 'sschollonix_import_onix_file.log';
	const LOG_FILE_ERROR = 'sschollonix_import_onix_file_error.log';
	
	const STATUS_DEFAULT	= 1;
	const STATUS_LOCKED		= 2;
	const STATUS_ERROR		= 3;
	const STATUS_DONE		= 4;
	
	public function init($fileName, $path, $pathLocked, $pathError, $pathDone)
	{
		$this->_status = self::STATUS_DEFAULT;
		$this->setFileName($fileName);
		$this->setPath($path);
		$this->setPathLocked($pathLocked);
		$this->setPathError($pathError);
		$this->setPathDone($pathDone);
		return $this;
	}

	public function getBooks()
	{
		if ( !is_null($this->_books) ) {
			return $this->_book;
		}
		if (!file_exists($this->getCurrentPath())) {
			$this->_log($this->getCurrentPath() . " does not exists");
			return false;
		}
		$products = $this->_getProductDocuments();
		if(!is_object($products) || sizeof($products) < 0) {
			$this->_log($this->getFileName() . ": no products found");
			return false;
		}
		foreach ( $products as $product ) {
			try {
				/* @var $product SScholl_Onix_Model_Dokument_Product */
				$product = Mage::getModel('sschollonix/document_product')
					->init($product);
				$book = $product->getBook();
				if ( !is_null($book) ) $this->_books[] = $book;
			} catch (Exception $e) {
				$this->_logError($this->getFileName() . ' product is defect.');
			}
		}
		$this->_log($this->getFileName() . ' - products: ' . sizeof($products));
		return $this->_books;
	}

	public function lock()
	{
		if (
			file_exists($this->getCurrentPath()) 
			&& rename($this->getCurrentPath(), $this->getPathLocked())
		) {
			$this->_status = self::STATUS_LOCKED;
			return true;
		}
		$this->_logError($this->getFileName() . ' could not lock file');
		return false;
	}

	public function error()
	{
		$this->_logError($this->getFileName() . ' - error in file');
		if (
			file_exists($this->getCurrentPath()) 
			&& rename($this->getCurrentPath(), $this->getPathError())
		) {
			$this->_status = self::STATUS_ERROR;
			return true;
		}
		$this->_logError($this->getCurrentPath() . ' could not renamed to error');
		return false;
	}

	public function done()
	{
		if (
			file_exists($this->getCurrentPath()) 
			&& rename($this->getCurrentPath(), $this->getPathDone())
		) {
			return true;
		}
		$this->_logError($this->getCurrentPath() . ' could not moved after to done folder');
		return false;
	}
	
	/**
	 * returns the current path of the onix file
	 * @throws Exception
	 */
	public function getCurrentPath()
	{
		switch ( $this->_status ) {
			case self::STATUS_DEFAULT:
				return $this->getPath();
			case self::STATUS_LOCKED:
				return $this->getPathLocked();
			case self::STATUS_ERROR:
				return $this->getPathError();
			case self::STATUS_DONE:
				return $this->getPathDone();
			default:
				throw new Exception("wrong status, can't get current file path");
		}
	}

	private $_status	= false;
	private $_books		= null;

	/**
	 * @return SimpleXMLElement
	 */
	private function _getProductDocuments()
	{
		// load the chunk of xml into memory
		$p = file_get_contents($this->getCurrentPath()); 
		$start = stripos($p, '<product>');
		// find the end of the last
		$end = strripos($p, '</product>') + 10 - $start;
		// turn the xml into an xml object that we can process record of this chunk of data, after modifications from above
		$entries = simplexml_load_string("<xml>" . substr($p, $start, $end) . "</xml>");
		unset($p);
		return $entries;
	}
	
	private function _log($message)
	{
		Mage::log($message, null, self::LOG_FILE);
	}
	
	private function _logError($message)
	{
		Mage::log($message, null, self::LOG_FILE_ERROR);
	}

}