<?php


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
		$this->version = 1.0;
		$this->author = 'Devil Themes';
		$this->need_instance = 0;

		parent::__construct();
		
		$this->displayName = $this->l('Total User Online');
		$this->description = $this->l('Total User Online in website currently');
		
		
	
	
	
	
	
	
	
	
	
	
	
	
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

	
	public function hookFooter($params)
	{
	
	if (!$this->isCached('totaluseronline-footer.tpl', $this->getCacheId()))
			$this->smarty->assign(array(
				'online_users' => $this->count
			));
	
	
	
		
		return $this->display(__FILE__, 'totaluseronline-footer.tpl', $this->getCacheId());
	}
	public function hookLeftColumn($params)
	{
		return $this->hookFooter($params);
	}
	

	public function hookHeader($params)
	{
		$this->visitors_online = new usersOnline();

if (count($this->visitors_online->error) == 0) {

    
       $this->count=$this->visitors_online->count_users();
   
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


