<?php

/**
* Instagram class
*
* @package Open Classifieds
* @subpackage Core
* @category Helper
* @author Oliver <oliver@open-classifieds.com>
* @license GPL v3
*/

use EspressoDev\InstagramBasicDisplay\InstagramBasicDisplay;

class Controller_Instagram extends Controller{

    public function action_auth()
    {
        if (Core::config('advertisement.instagram') == 0)
        {
            $this->redirect(Route::url('oc-panel', ['controller' => 'profile', 'action' => 'edit']));
        }

        if (! Auth::instance()->logged_in())
        {
            $this->redirect(Route::url('oc-panel', ['controller' => 'auth', 'action' => 'login']) . '?auth_redirect=' . URL::current());
        }

        if (! isset($_GET['code']))
        {
            Alert::set(Alert::ERROR, 'We could not connect with Instagram.');

            $this->redirect(Route::url('oc-panel', ['controller' => 'profile', 'action' => 'edit']));
        }

        require_once Kohana::find_file('vendor/instagram-basic-display-php/src', 'InstagramBasicDisplay');

        $instagram = new InstagramBasicDisplay([
            'appId' => Core::config('advertisement.instagram_app_id'),
            'appSecret' => Core::config('advertisement.instagram_app_secret'),
            'redirectUri' => Route::url('default', ['controller' => 'instagram', 'action' => 'auth', 'id' => 'now']),
        ]);

        $code = $_GET['code'];

        $o_auth_token = $instagram->getOAuthToken($code, TRUE);

        $long_lived_token = $instagram->getLongLivedToken($o_auth_token);

        $this->user->instagram_token = $long_lived_token->access_token;

        $this->user->instagram_token_expires_at = Date::unix2mysql(time() + ($long_lived_token->expires_in));

        $this->user->save();

        Alert::set(Alert::INFO, __('Instagram Connected'));

        $this->redirect(Route::url('oc-panel', ['controller' => 'profile', 'action' => 'edit']));
    }

}
