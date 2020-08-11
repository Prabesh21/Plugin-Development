<?php
/**
 * @package Abcd
 */
class AbcdPluginDeactivate{
    public static function deactivate(){
        flush_rewrite_rules();
    }
}