<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Instagram helper class
 *
 * @package    OC
 * @category   Social
 * @author     Oliver <oliver@open-classifieds.com>
 * @copyright  (c) 2009-2014 Open Classifieds Team
 * @license    GPL v3
 */

use EspressoDev\InstagramBasicDisplay\InstagramBasicDisplay;

class Instagram {

    public static function loginUrl()
    {
        require_once Kohana::find_file('vendor/instagram-basic-display-php/src', 'InstagramBasicDisplay');

        $instagram = new InstagramBasicDisplay([
            'appId' => Core::config('advertisement.instagram_app_id'),
            'appSecret' => Core::config('advertisement.instagram_app_secret'),
            'redirectUri' => Route::url('default', ['controller' => 'instagram', 'action' => 'auth', 'id' => 'now']),
        ]);

        return $instagram->getLoginUrl();
    }

    public static function getUserMedia(Model_User $user)
    {
        require_once Kohana::find_file('vendor/instagram-basic-display-php/src', 'InstagramBasicDisplay');

        $instagram = new InstagramBasicDisplay([
            'appId' => Core::config('advertisement.instagram_app_id'),
            'appSecret' => Core::config('advertisement.instagram_app_secret'),
            'redirectUri' => Route::url('default', ['controller' => 'instagram', 'action' => 'auth', 'id' => 'now']),
        ]);

        $instagram->setAccessToken($user->instagram_token);

        return $instagram->getUserMedia()->data;
    }

    public static function hasUserToken(Model_User $user)
    {
        if (Core::config('advertisement.instagram') == 0)
        {
            return FALSE;
        }

        if (empty($user->instagram_token))
        {
            return FALSE;
        }

        return TRUE;
    }

    public static function refreshUserToken(Model_User $user)
    {
        if (empty($user->instagram_token))
        {
            return;
        }

        require_once Kohana::find_file('vendor/instagram-basic-display-php/src', 'InstagramBasicDisplay');

        $instagram = new InstagramBasicDisplay($user->instagram_token);

        $token = $instagram->refreshToken($user->instagram_token);

        $user->instagram_token = $token->access_token;

        $user->instagram_token_expires_at = Date::unix2mysql(time() + ($token->expires_in));

        $user->save();
    }

}
