<?php
/*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
	exit;
	
require_once dirname(__FILE__) . '/class/usersOnline.php';

class TotalUserOnline extends Module
{
	var $count;
	var $visitors_online;

	public function __construct()
	{
		$this->name = 'totaluseronline';
		$this->tab = 'front_office_features';
		$this->version = 0.1;
		$this->author = 'PrestaShop';
		$this->need_instance = 0;

		parent::__construct();
		
		$this->displayName = $this->l('Total User Online');
		$this->description = $this->l('Adds a block that displays permanent links such as sitemap, contact, etc...');
		
		
	
	
	
	
	
	
	
	
	
	
	
	
	}
	
	public function install()
	{
		 
	
        if (!parent::install() OR
                
				!Db::getInstance()->Execute('CREATE TABLE IF NOT EXISTS `ps_useronline` (`id` int(10) NOT NULL AUTO_INCREMENT,`ip` varchar(15) NOT NULL,`timestamp` varchar(15) NOT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1') OR
                !$this->registerHook('footer') OR
				!$this->registerHook('header') OR
				!$this->registerHook('leftColumn') 
           
        ) {
            return false;
        }
	
		return true;
	
			

			
	}

	 public function uninstall() {

        if (!parent::uninstall() OR
                !Db::getInstance()->Execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'useronline`') 
        ) {
            return false;
        }
        return true;
    }
	/**
	* Returns module content for header
	*
	* @param array $params Parameters
	* @return string Content
	*/
	

	/**
	* Returns module content for left column
	*
	* @param array $params Parameters
	* @return string Content
	*/
	
	
	public function hookFooter($params)
	{
		$this->smarty->assign(array(
				'count' => $this->count
			));
		return $this->display(__FILE__, 'totaluseronline-footer.tpl', $this->getCacheId('totaluseronline-footer'));
	}
	public function hookLeftColumn($params)
	{
		return $this->hookFooter($params);
	}
	

	public function hookHeader($params)
	{
		$this->visitors_online = new usersOnline();

if (count($this->visitors_online->error) == 0) {

    if ($this->visitors_online->count_users() == 1) {
       $this->count=$this->visitors_online->count_users();
    }
    else {
       $this->count=$this->visitors_online->count_users();
    }
}
else {
    echo "<b>Users online class errors:</b><br /><ul>\r\n";
    for ($i = 0; $i < count($this->visitors_online->error); $i ++ ) {
        echo "<li>" . $this->visitors_online->error[$i] . "</li>\r\n";
    }
    echo "</ul>\r\n";

}


		$this->context->controller->addCSS(($this->_path).'totaluseronline.css', 'all');
	}
}


