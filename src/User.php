<?php

namespace PopularSizzle\Plugins\Simple2FA;

use chillerlan\GoogleAuth\Authenticator;

use WP_User;
use WP_Error;
use WP_Session_Tokens;

class User extends Singleton
{

    public $user;

    public function __construct()
    {
        $this->user = wp_get_current_user();
    }

    public function required($user_id = null)
    {
        return apply_filters($this->hook_namespace . '/2fa_required', true, $user_id ?: $this->user->ID);
    }

    public function enabled($user_id = null)
    {
        return get_user_meta($user_id ?: $this->user->ID, 'simple_2fa_enabled', true);
    }

    public function enable()
    {
        if ($this->verify($this->user->ID)) {
            add_user_meta($this->user->ID, 'simple_2fa_enabled', 'true', true);

            wp_redirect(admin_url());
            exit;
        }

        wp_redirect(admin_url('admin-ajax.php?action=simple_2fa_onboard&failed=1'));
    }

    public function secret($user_id = null)
    {
        $secret = get_user_meta($user_id ?: $this->user->ID, 'simple_2fa_secret', true);

        if (!$secret) {
            $secret = Authenticator::createSecret();
            add_user_meta($user_id ?: $this->user->ID, 'simple_2fa_secret', $secret, true);
        }

        return $secret;
    }

    public function secretUri()
    {
        $secret = $this->secret();
        $uri = Authenticator::getUri($secret, $this->user->user_login, get_bloginfo('name'));

        return apply_filters($this->hook_namespace . '/totp_uri', $uri, $secret);
    }

    public function deleteMeta($user_id)
    {
        delete_user_meta($user_id, 'simple_2fa_secret');
        delete_user_meta($user_id, 'simple_2fa_enabled');
        delete_user_meta($user_id, 'simple_2fa_login_attempts');
        delete_user_meta($user_id, 'simple_2fa_login_attempt_time');

        foreach (apply_filters($this->hook_namespace . '/delete_meta', [], $user_id) as $meta) {
            delete_user_meta($user_id, $meta);
        }
    }

    public function onboardRedirect()
    {
        if (wp_doing_ajax()) {
            return;
        }

        if ($this->required() && !$this->enabled()) {
            wp_redirect(admin_url('admin-ajax.php?action=simple_2fa_onboard'));

            exit;
        }
    }

    public function authenticate($user, $username)
    {
        if ($user instanceof WP_User && $this->required($user->ID)) {
            $enabled = $this->enabled($user->ID);

            if ($enabled && !$this->verify($user->ID)) {
                $error = Views::getInstance()->loginError();

                return new WP_Error('simple_2fa', $error);
            }
        }

        return $user;
    }

    public function reset()
    {
        $user = get_userdata($_POST['user_id'] ?? 0);

        if (
            $user && current_user_can('edit_user', $user->ID) &&
            wp_verify_nonce($_POST['nonce'] ?? '', 'update-user_' . $user->ID))
        {

            $this->deleteMeta($user->ID);

            WP_Session_Tokens::get_instance($user->ID)->destroy_all();

            wp_send_json_success([
                'message' => 'Two Factor Authentication reset.'
            ]);
        }

        wp_send_json_error([
            'message' => 'There was an error. Please try again.'
        ]);
    }

    private function verify($user_id)
    {
        $code = $_POST['simple_2fa_totp'] ?? '';
        $secret = $this->secret($user_id);

        if (!$code || !$secret) {
            return false;
        }

        return Authenticator::verifyCode($code, $secret);
    }

}
