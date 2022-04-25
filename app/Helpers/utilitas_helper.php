<?php

use Config\Services;

// Sidebar Menu Active Dinamis
function menu_active($data, $segmen)
{
    $request = Services::request();
    if ($request->uri->getTotalSegments() >= $segmen && $request->uri->getSegment($segmen)) {
        $uri = $request->uri->getSegment($segmen);

        return $data == 'admin' && $request->uri->getTotalSegments() > $segmen ? '' : ($data == $uri ? 'active' : '');
    } else {
        return false;
    }
}

// Sidebar Menu Dropdown Opener Dinamis
function dropdown_opener($data, $segmen, $tempat)
{
    $request = Services::request();
    $uri = $request->uri->getSegment($segmen);

    if ($request->uri->getTotalSegments() >= $segmen && $request->uri->getSegment($segmen)) {
        if ($tempat == 'nav-item') {
            return in_array($uri, $data) ? 'menu-open' : '';
        } else if ($tempat == 'nav-link') {
            return in_array($uri, $data) ? 'active' : '';
        } else {
            return false;
        }
    } else {
        return false;
    }
}

// Breadcrumb Dinamis
function auto_breadcrumb()
{
    $request = Services::request();

    $segmen = $request->uri->getSegments();
    $count = count($segmen) - 1;
    $path = base_url();
    $crumbs = array_filter($segmen);
    $result = [];

    foreach ($crumbs as $k => $crumb) {
        $path .= '/' . $crumb;

        $name = ucwords(str_replace(array(".php", "_"), array("", " "), $crumb));
        $name = ucwords(str_replace('-', ' ', $name));

        if ($k != $count) {
            $result[] = '<li class="breadcrumb-item"><a href="' . $path . '">' . $name . '</a></li>';
        } else {
            $result[] = '<li class="breadcrumb-item active">' . $name . '</li>';
        }
    }

    $output = implode($result);

    return $output;
}
