<?php
# @version $version 0.1 Amvis United Company Limited $
# @copyright Copyright (C) 2014 AUnited Co Ltd. All rights reserved.
# @license PeelAd has been originally created by Vitaliy Zhukov under GNU/GPL and relicensed under Apache v2.0, see LICENSE
# Updated 1st March 2015
#
# Site: http://aunited.ru
# Email: info@aunited.ru
# Phone
#
# Joomla! is free software. This version may have been modified pursuant
# to the GNU General Public License, and as distributed it includes or
# is derivative of works licensed under the GNU General Public License or
# other free or open source software licenses.
# See COPYRIGHT.php for copyright notices and details.

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin');

class plgSystemSunStat extends JPlugin
	{
	function plgSunStat(&$subject, $config)
		{
		parent::__construct($subject, $config);
		$this->_plugin = JPluginHelper::getPlugin( 'system', 'SunStat' );
		$this->_params = new JParameter( $this->_plugin->params );
		}
	function onAfterRender()
		{
		if($app->isAdmin())
			{
				return;
			}
		$app = JFactory::getApplication();
		// Initialise variables
		$peelad_enabled = $this->params->get( 'peelad_enabled', '' );
		$peelad_jquery = $this->params->get( 'peelad_jquery', '' );
		$peelad_path = $this->params->get( 'peelad_image', '' );
		$peelad_link = $this->params->get( 'peelad_link', '' );
		
		switch($peelad_jquery) {
			case 'google': $jqlink='//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js'; break;
			case 'local1': $jqlink='js/jquery-1.x.min.js'; break;
			case 'local2': $jqlink='js/jquery-2.x.min.js'; break;
			case 'external': $jqlink=''; break;
			default: $jqlink='//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js'; break;
		}
		$javascript="<script src='".$jqlink."'></script>
  <script src=\"jquery.peelback.js\"></script>  
  <script>
    $(function() {
      $('body').peelback({
        adImage  : 'images/peelads/peel-ad.png',
        peelImage  : 'peel1.png',
        clickURL : 'peelad_link',
        smallSize: 50,
        bigSize: 500,
        gaTrack  : true,
        gaLabel  : 'AUnited',
        autoAnimate: true
      });
    });
  </script>"
		
		$buffer = preg_replace ("/<\/body>/", $javascript."\n\n</body>", $buffer);
		
		//output the buffer
		JResponse::setBody($buffer);
		
		return true;
		
?>