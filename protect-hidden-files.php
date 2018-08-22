<?php
/**
*  Plugin Name:    Protect Hidden Files
*  Plugin URI:     https://github.com/scaffold-digital/wordpress-protect-hidden-files
*  Description:    Ensure that hidden (dot) files (such as .git) cannot be accessed on your Wordpress site
*  Author:         Scaffold Digital
*  Author URI:     https://scaffold.digital
*  Version:        1.0.1
*/

class ScaffoldProtectHiddenFiles {

    protected static $deactivated = false;

    public static function activation_hook()
    {
        self::flush_rules();
    }
   
    public static function add_filter($tag, $function_to_add = null, $priority = 10, $accepted_args = 1)
    {
        if (!$function_to_add) $function_to_add = $tag;
        add_filter($tag, array(__CLASS__, $function_to_add), $priority, $accepted_args);
    }

    public static function deactivation_hook()
    {
        self::$deactivated = true;
        self::flush_rules();
    }

    public static function flush_rules()
    {
        global $wp_rewrite;
        $wp_rewrite->flush_rules();
    }

    public static function init()
    {
        self::register_deactivation_hook('deactivation_hook');
        self::add_filter('mod_rewrite_rules');
        self::register_activation_hook('activation_hook');
    }

    public static function mod_rewrite_rules($rules)
    {
        if (self::$deactivated) return $rules;

        $rule  = "\n# Scaffold - Protect Hidden Files\n";
        $rule .= "<IfModule mod_rewrite.c>\n";
        $rule .= "RewriteEngine On\n";
        $rule .= "RewriteRule \"(^|/)\.(?!well-known\/)\" - [F]\n";
        $rule .= "</IfModule>\n\n";

        return $rule . $rules;
    }

    public static function register_activation_hook($function)
    {
        register_activation_hook(__FILE__, array(__CLASS__, $function));
    }

    public static function register_deactivation_hook($function)
    {
        register_deactivation_hook(__FILE__, array(__CLASS__, $function));
    }

}

ScaffoldProtectHiddenFiles::init();
