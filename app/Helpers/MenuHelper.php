<?php

namespace App\Helpers;

class MenuHelper
{
    public static function isActive($routes)
    {
        foreach ((array)$routes as $route) {
            if (request()->routeIs($route)) {
                return 'active';
            }
        }
        return '';
    }

    public static function isOpen($routes)
    {
        foreach ((array)$routes as $route) {
            if (request()->routeIs($route)) {
                return 'active opened has-sub';
            }
        }
        return 'has-sub';
    }

    public static function showSubmenu($routes)
    {
        foreach ((array)$routes as $route) {
            if (request()->routeIs($route)) {
                return 'visible';
            }
        }
        return '';
    }
    public static function GetGeneralSetting()
    {
        $settings = \App\Models\GeneralSetting::first();
        return $settings;

    }
}