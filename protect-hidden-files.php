<?php
/**
*  Plugin Name:    Protect Hidden Files
*  Plugin URI:     https://github.com/scaffold-digital/wordpress-protect-hidden-files
*  Description:    Ensure that hidden (dot) files cannot be accessed on your site
*  Author:         Scaffold Digital
*  Author URI:     https://scaffold.digital
*  Version:        1.0.0
*/

class ScaffoldProtectHiddenFiles {
   
    public static function add_filter($tag, $function_to_add = null, $priority = 10, $accepted_args = 1)
    {
        if (!$function_to_add) $function_to_add = $tag;
        add_filter($tag, array(__CLASS__, $function_to_add), $priority, $accepted_args);
    }

    public static function mod_rewrite_rules($rules)
    {
        $rule  = "\n# Scaffold - Protect Hidden Files\n";
        $rule .= "<IfModule mod_rewrite.c>\n";
        $rule .= "RewriteEngine On\n";
        $rule .= "RewriteRule \"(^|/)\.(?!well-known\/)\" - [F]\n";
        $rule .= "</IfModule>\n\n";

        return $rule . $rules;
    }

}

ScaffoldProtectHiddenFiles::add_filter('mod_rewrite_rules');
