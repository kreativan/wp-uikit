<?php

/**
 *  Plugin Name: WP UIkit
 *  Description: Use uikit framework with wordpress
 *  Version: 0.0.1
 *  Author: Ivan Milincic
 *  Author URI: http://kreativan.dev/
 */

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Echo all uikit requered files less, js...
 * @param array $less_vars - less variables
 * @example wp_uikit(['@basic-font-family' => "Ariel"]);
 * @example twig {{ wp_uikit(['@basic-font-family' => "Ariel"]) }}
 */
function wp_uikit($less_vars = []) {

  $html = "";

  // plugin url
  $url = plugin_dir_url(__DIR__) . "wp-uikit/";

  /** 
   * Less 
   * - uikit less files
   * - _vars.less from the theme directory
   * - get all the less files from the theme directory
   */

  $less_files = [];

  require_once __DIR__ . "/Less.php";
  $less = new Less_Compiler;
  $less_files[] = __DIR__ . "/uikit/src/less/uikit.theme.less";

  // Get the directory
  $theme_dir = get_template_directory() . "/assets/less/";

  // get _vars.less
  $vars_less = $theme_dir . "_vars.less";
  if (file_exists($vars_less)) $less_files[] = $vars_less;

  // get all the files from the directory except the ones starting with _
  $files = glob("{$theme_dir}[!_]*.less");
  foreach ($files as $file) $less_files[] = $file;

  // Update html out
  $html .= "<link rel='stylesheet' href='{$less->less($less_files,$less_vars, "main.min", true)}' />\n";


  /**
   * JS
   * - ukit js files
   * - uikit-icons js file
   */

  $js_files[] = $url . "uikit/dist/js/uikit.min.js";
  $js_files[] = $url .  "uikit/dist/js/uikit-icons.min.js";
  foreach ($js_files as $js_file) {
    $html .= "<script src='$js_file'></script>\n";
  }

  echo $html;
}
