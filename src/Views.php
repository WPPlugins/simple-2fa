<?php

namespace PopularSizzle\Plugins\Simple2FA;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\Output\QRImage;
use chillerlan\QRCode\Output\QRImageOptions;

class Views extends Singleton
{

    public function loginForm()
    {
        echo $this->render('login_form', [
            'login_form_help_url' => wp_login_url() . '?action=simple-2fa'
        ]);
    }

    public function loginMessage($message)
    {
        if (($_GET['action'] ?? null) == 'simple-2fa') {
            $message .= $this->render('login_help');
        }

        return $message;
    }

    public function onboardPage()
    {
        $user = User::getInstance();

        if (!$user->required() || $user->enabled()) {
            wp_redirect(home_url());
            exit;
        }

        $secret = $user->secret();

        add_filter('wp_die_ajax_handler', function() {
            return '_default_wp_die_handler';
        });

        wp_die(
            $this->render('onboarding', [
                'action' => admin_url('admin-ajax.php?action=simple_2fa_enable'),
                'secret' => preg_replace('/.{4}/', '$0 ', $secret),
                'qrcode_url' => admin_url('admin-ajax.php?action=simple_2fa_qrcode'),
                'enable_error' => $_GET['failed'] ?? false ? 'Please try again.' : ''
            ]),
            'Two Factor Authentication - ' . get_bloginfo('name'),
            200
        );
    }

    public function qrcodeImage()
    {
        $user = User::getInstance();

        if (!$user->required() || $user->enabled()) {
            return;
        }

        $uri = $user->secretUri();

        $options = new QRImageOptions;
        $options->base64 = false;

        $output = new QRImage($options);
        $qrcode = new QRCode($uri, $output);

        header('Content-Type: image/png');
        echo $qrcode->output();
    }

    public function loginError()
    {
        add_filter('enable_login_autofocus', '__return_false');

        return $this->render('login_error', $_POST);
    }

    public function throttleError($throttle_seconds)
    {
        add_filter('enable_login_autofocus', '__return_false');

        $throttle_time = human_time_diff(0, $throttle_seconds);

        return $this->render('login_throttle', [
            'throttle_time' => $throttle_time
        ] + $_POST);
    }

    public function userReset()
    {
        $user = User::getInstance();

        if (!$user->required()) {
            return;
        }

        $user_name = IS_PROFILE_PAGE ? 'You' : get_userdata($_GET['user_id'])->display_name;

        echo $this->render('reset', [
            'user' => $user_name
        ]);
    }

    private function render($view, $data = [])
    {
        $hook_ns = $this->hook_namespace;

        $view_dir = apply_filters(
            $hook_ns . '/view_dir',
            dirname(__DIR__) . '/views',
            $view
        );

        $data = apply_filters($hook_ns . '/view_data', $data, $view);
        $ext = apply_filters($hook_ns . '/view_ext', 'html', $view);

        if (is_file($file = $view_dir . '/' . $view . '.' . $ext)) {
            return $this->interpolate($file, $data);
        }
    }

    private function interpolate($file, $data)
    {
        $hook_ns = $this->hook_namespace;

        $delim_open = apply_filters($hook_ns . '/view_delim_open', '{{ ');
        $delim_close = apply_filters($hook_ns . '/view_delim_close', ' }}');

        $data_from = array_map(function($key) use ($delim_open, $delim_close) {
            return $delim_open . $key . $delim_close;
        }, array_keys($data));

        $data_to = array_values($data);

        return str_replace($data_from, $data_to, file_get_contents($file));
    }

}
