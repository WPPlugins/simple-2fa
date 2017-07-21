<?php

namespace PopularSizzle\Plugins\Simple2FA;

use chillerlan\GoogleAuth\Authenticator;

use WP_User;
use WP_Error;

class Throttle extends Singleton
{

    private $allowed_attempts;
    private $throttle_factor;
    private $max_throttle;

    public function __construct()
    {
        $hook_ns = $this->hook_namespace;

        $this->allowed_attempts = apply_filters($hook_ns . '/throttle_allowed_attempts', 3);
        $this->throttle_factor = apply_filters($hook_ns . '/throttle_factor', 2);
        $this->max_throttle = apply_filters($hook_ns . '/throttle_max', 1500);
    }

    public function check($user, $username)
    {
        $user_error = $user;

        if ($username && $user = (get_user_by('email', $username) ?: get_user_by('login', $username))) {
            $throttle_seconds = $this->throttleTime($user->ID);

            if ($throttle_seconds) {
                remove_all_actions('authenticate');

                $error = Views::getInstance()->throttleError($throttle_seconds);

                if ($user_error instanceof WP_Error) {
                    $user_error->add('simple_2fa', $error);

                    return $user_error;
                } else {
                    return new WP_Error('simple_2fa', $error);
                }
            }
        }

        return $user_error;
    }

    public function updateAttempts($user, $username)
    {
        $user_error = $user;

        if ($user instanceof WP_User) {
            update_user_meta($user->ID, 'simple_2fa_login_attempts', 0);
            update_user_meta($user->ID, 'simple_2fa_login_attempt_time', 0);
        }

        if ($user instanceof WP_Error) {
            if ($username && $user = (get_user_by('email', $username) ?: get_user_by('login', $username))) {
                $current_attempts = get_user_meta($user->ID, 'simple_2fa_login_attempts', true) ?: 0;

                update_user_meta($user->ID, 'simple_2fa_login_attempts', $current_attempts + 1);
                update_user_meta($user->ID, 'simple_2fa_login_attempt_time', time());

                return $this->check($user_error, $username) ?: $user_error;
            }
        }

        return $user_error;
    }

    private function throttleTime($user_id)
    {
        $attempts = get_user_meta($user_id, 'simple_2fa_login_attempts', true) ?: 0;
        $attempt_time = get_user_meta($user_id, 'simple_2fa_login_attempt_time', true) ?: 0;

        $throttle = min(
            pow(
                max($attempts - $this->allowed_attempts, 0),
                $this->throttle_factor
            ) * MINUTE_IN_SECONDS,

            $this->max_throttle
        );

        return max($attempt_time + $throttle - time(), 0);
    }

}
