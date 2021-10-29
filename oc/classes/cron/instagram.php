<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Cron for Algolia
 *
 * @author      Oliver <oliver@open-classifieds.com>
 * @package     Cron
 * @copyright   (c) 2009-2014 Open Classifieds Team
 * @license     GPL v3
 *
 */
class Cron_Instagram {

    /**
     * refreshes all user token before expire
     * @return void
     */
    public static function refreshUserTokens()
    {
        $days = 2;

        if (! Core::config('advertisement.instagram'))
        {
            return;
        }

        //get expiring subscription that are active
        $users= (new Model_User())
            ->where('status', '=', Model_User::STATUS_ACTIVE)
            ->where(DB::expr('DATE(instagram_token_expires_at)'), '=', Date::format('+'.$days.' days','Y-m-d'))
            ->find_all();

        foreach ($users as $user)
        {
            Instagram::refreshUserToken($user);
        }
    }

}
