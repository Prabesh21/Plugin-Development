<?php
/**
 * @package Abcd
 */
class AbcdPluginActivate{
    public static function activate(){
        flush_rewrite_rules();
    }
}