<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {counter} function plugin
 *
 * Type:     function<br>
 * Name:     counter<br>
 * Purpose:  print out a counter value
 *
 * @author Monte Ohrt <monte at ohrt dot com>
 * @link http://www.smarty.net/manual/en/language.function.counter.php {counter}
 *       (Smarty online manual)
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 * @return string|null
 */
function smarty_function_showname($args, &$smarty){
    $str = $args['last_name'].$args['first_name'];

    if (preg_match("/^[\x{4e00}-\x{9fa5}]+$/u",$str)) {
        return $str;
    } else {
        return $args['first_name'].' '.$args['last_name'];
    }
}

?>