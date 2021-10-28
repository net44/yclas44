<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Cron for digest mails
 *
 * @author      Oliver <oliver@open-classifieds.com>
 * @package     Cron
 * @copyright   (c) 2009-2021 Open Classifieds Team
 * @license     GPL v3
 *
 */
class Cron_Digestmail {

    public static function dispatch_daily_digest()
    {
        if (Core::config('general.multilingual'))
        {
            foreach (i18n::get_selectable_languages() as $locale => $language)
            {
                // Set i18n config for each selectable language
                self::set_i18n_config($locale);

                Cron_Digestmail::dispatch_digest('daily', $locale);
            }

            // Restore to default i18n
            self::set_i18n_config(array_key_first(i18n::get_selectable_languages()));

            return;
        }

        return Cron_Digestmail::dispatch_digest('daily');
    }

    public static function dispatch_weekly_digest()
    {
        if (Core::config('general.multilingual'))
        {
            foreach (i18n::get_selectable_languages() as $locale => $language)
            {
                // Set i18n config for each selectable language
                self::set_i18n_config($locale);

                Cron_Digestmail::dispatch_digest('weekly', $locale);
            }

            // Restore to default i18n
            self::set_i18n_config(array_key_first(i18n::get_selectable_languages()));

            return;
        }

        return Cron_Digestmail::dispatch_digest('weekly');
    }

    public static function dispatch_monthly_digest()
    {
        if (Core::config('general.multilingual'))
        {
            foreach (i18n::get_selectable_languages() as $locale => $language)
            {
                // Set i18n config for each selectable language
                self::set_i18n_config($locale);

                Cron_Digestmail::dispatch_digest('monthly', $locale);
            }

            // Restore to default i18n
            self::set_i18n_config(array_key_first(i18n::get_selectable_languages()));

            return;
        }

        return Cron_Digestmail::dispatch_digest('monthly');
    }

    public static function dispatch_digest($interval = 'weekly', $locale = NULL)
    {
        if (! Core::config('email.digest'))
        {
            return;
        }

        $ads = (new Model_Ad())
            ->where('status', '=', Model_Ad::STATUS_PUBLISHED)
            ->where('published', 'between', Cron_Digestmail::get_interval_expr_for($interval));

        if (Core::config('email.digest_ad_type') === 'featured')
        {
            $ads->where('featured','IS NOT', NULL)
                ->where('featured', '>=', Date::unix2mysql());
        }

        if ($locale)
        {
            $ads->where('locale', '=', $locale);
        }

        $ads = $ads->limit(Core::config('email.digest_ad_limit'))
            ->find_all()
            ->as_array();

        if (! Core::count($ads) > 0)
        {
            return;
        }

        $recipients = DB::select('email')
            ->select('name')
            ->from('users')
            ->where('status', '=', Model_User::STATUS_ACTIVE)
            ->where('digest_interval', '=', $interval);

        if ($locale AND isset(Model_UserField::get_all()['language']))
        {
            $recipients->where('cf_language', '=', $locale);
        }

        $recipients = $recipients->execute()->as_array();

        if (! Core::count($recipients) > 0)
        {
            return;
        }

        Email::send_digest_mail($recipients, $ads, $interval, $locale);
    }

    public static function get_interval_expr_for($interval = 'weekly')
    {
        if ($interval === 'daily')
        {
            return [DB::expr('NOW() - INTERVAL 36 HOUR'), DB::expr('NOW() - INTERVAL 12 HOUR')];
        }

        if ($interval === 'monthly')
        {
            return [DB::expr('NOW() - INTERVAL 1 MONTH'), DB::expr('NOW()')];
        }

        return [DB::expr('NOW() - INTERVAL 8 DAY'), DB::expr('NOW() - INTERVAL 1 DAY')];
    }

    public static function set_i18n_config($locale)
    {
        i18n::$lang = $locale;
        i18n::$locale = $locale;

        return;
    }

}
