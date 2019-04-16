<?php
/**
 * Plugin Name: Sqreen Monitoring for Wordpress
 * Plugin URI: https://sqreen.com
 * Description: Monitor and protect your Wordpress with Sqreen
 * Version: 1.0.0
 * Author: Sqreen
 * Author URI: https://sqreen.com
 *
 * @package sqreen
 */

/**
 * Copyright (c) 2019 Sqreen. All Rights Reserved.
 * Please refer to our terms for more information: https://www.sqreen.io/terms.html
 */
define('SQREEN_PLUGIN_DIR', plugin_dir_path(__FILE__));
require_once SQREEN_PLUGIN_DIR . 'includes/Sqreen.php';
Sqreen_Plugin::initialize(SQREEN_PLUGIN_DIR);
