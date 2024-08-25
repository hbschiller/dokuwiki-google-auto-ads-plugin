<?php

use dokuwiki\Extension\ActionPlugin;
use dokuwiki\Extension\Event;
use dokuwiki\Extension\EventHandler;

/**
 * Invite Code Plugin
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Herbert Schiller <hbschiller@schillerapp.com>
 */
class action_plugin_gautoads extends ActionPlugin
{
		
    /**
     * Register the event handlers
     */
    public function register(EventHandler $controller)
    {
        // inject in user registration
		$controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, 'hookGoogleAutoAdsScript');
    }
	
	/**
     * Inject the invitation code field in the registration form
     */
    public function hookGoogleAutoAdsScript(Event $event)
    {
		$adsenseId = $this->getAdsenseId();
		
		// Add Google AdSense script
        $event->data['script'][] = [
            'type' => 'text/javascript',
            'src'  => "https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-$adsenseId",
            '_data' => '',
            'async' => 'async',
            'crossorigin' => 'anonymous'
        ];

        // Add inline script to push AdSense ads
        $event->data['script'][] = [
            'type' => 'text/javascript',
            '_data' => "(adsbygoogle = window.adsbygoogle || []).push({});"
        ];
		
    }
	
	private function getAdsenseId()
    {
        return $this->getConf('adsense_id');
    }
}