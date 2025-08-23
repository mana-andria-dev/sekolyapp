<?php

if (! function_exists('tenant')) {
    function tenant($key = null) {
        if (! app()->bound('tenant')) {
            return null;
        }

        $tenant = app('tenant');

        return $key ? $tenant->$key : $tenant;
    }
}
