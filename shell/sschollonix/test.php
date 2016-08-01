<?php
require_once '../abstract.php';

/**
 * Magento Compiler Shell Script
 *
 * @category    Mage
 * @package     Mage_Shell
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Shell_Compiler extends Mage_Shell_Abstract
{

    /**
     * Run script
     *
     */
    public function run()
    {
    	$path = "../../sampleOnix0.xml";
    	/* @var $model SScholl_Onix_Model_File */
		$model = Mage::getModel('sschollonix/file');
		$model->init($path,$path,$path,$path,$path);
		$model->getBooks();
    }

    /**
     * Retrieve Usage Help Message
     *
     */
    public function usageHelp()
    {
        return <<<USAGE
Usage:  php -f test.php
USAGE;
    }
}

$shell = new Mage_Shell_Compiler();
$shell->run();
