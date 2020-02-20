<?php
/**
 * Copyright (c) 2019 Sqreen. All Rights Reserved.
 * Please refer to our terms for more information: https://www.sqreen.io/terms.html
 */

if (!class_exists('Sqreen_Plugin')) {
    class Sqreen_Plugin
    {
        protected $dir = null;
        protected static $_instance = null;

        protected function __construct($dir, $config)
        {
            $this->dir = $dir;
            $this->hook_plugin();
            $this->hook_user_monitoring();
            $this->hook_custom_events();
        }

        protected function __clone()
        {}

        public static function initialize($dir)
        {
            if (is_null(self::$_instance)) {
                self::$_instance = new Sqreen_Plugin($dir, $config);
            } else {
                throw new Exception('Sqreen Plugin has already been initialized');
            }
        }

        public static function getInstance()
        {
            if (is_null(self::$_instance)) {
                throw new Exception('Sqreen Plugin has not been initialized. Use Sqreen_Plugin::initialize.');
            }
            return self::$_instance;
        }

        protected function hook_plugin()
        {
            $plugin_file = $this->dir . 'sqreen.php';
            register_activation_hook($plugin_file, array('Sqreen_Plugin', 'onPluginActivated'));
        }

        /**
         * @return Boolean True when SDK functions are defined
         */
        public static function isSDKAvailable()
        {
            return function_exists('sqreen\auth_track') && function_exists('sqreen\signup_track') && function_exists('sqreen\identify') && function_exists('sqreen\track');
        }

        public function onPluginActivated()
        {
            if (!self::isSDKAvailable()) {
                wp_die('<p><strong>Plugin can not be activated</strong>: Sqreen SDK is not installed</p>', array('response' => 200, 'back_link' => true));
                return false;
            }
        }

        protected function hook_user_monitoring()
        {
            add_action('wp_login', array('Sqreen_Plugin', 'onAutoLoginSuccess'));
            add_action('wp_login_failed', array('Sqreen_Plugin', 'onAutoLoginError'));
            add_action('user_register', array('Sqreen_Plugin', 'onAutoSignup'));
        }

        public function onAutoLoginSuccess($username)
        {
            if (!self::isSDKAvailable()) {
                return false;
            }

            sqreen\auth_track(true, ['username' => $username]);
        }

        public function onAutoLoginError($username)
        {
            if (!self::isSDKAvailable()) {
                return false;
            }

            sqreen\auth_track(false, ['username' => $username]);
        }

        public function onAutoSignup($user_id)
        {
            if (!self::isSDKAvailable()) {
                return false;
            }

            $user = get_user_by('id', $user_id);
            if ($user) {
                sqreen\signup_track(['username' => $user->user_login]);
            }
        }

        protected function hook_custom_events()
        {
            add_action('init', array('Sqreen_Plugin', 'identify'));
            add_action('admin_init', array('Sqreen_Plugin', 'onAdminAccess'));
        }

        public function identify()
        {
            if (!self::isSDKAvailable()) {
                return false;
            }

            $current_user = wp_get_current_user();
            if ($current_user->ID !== 0) {
                sqreen\identify(['username' => $current_user->user_login]);
            }
        }

        public function onAdminAccess()
        {

            if (!self::isSDKAvailable()) {
                return false;
            }

            sqreen\track('admin_init');
        }
    }
}
