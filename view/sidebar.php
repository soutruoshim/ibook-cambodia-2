<?php
require_once("../configuration/Connection.php");
require_once('../model/AppSetting.php');

$active = "";
$active_submenu = "";
if (isset($_GET['page'])) {
    $action = $_GET['page'];
    $url = explode("_", $action);
    
    if (count($url) == 1) {
        $active = $url[0];
        $active_submenu = $url[0] . "_list";
    } else {
        $active = $url[0];
        $active_submenu = $url[0] . "_" . $url[1];
    }
} else {
    $active = "";
}
?>
<div class="mm-sidebar  sidebar-default">
    <div class="mm-sidebar-logo d-flex align-items-center justify-content-between">
        <a href="./index.php" class="header-logo">
            <img src="../assets/images/logo.png" class="img-fluid rounded-normal light-logo" alt="logo">
        </a>
        <div class="side-menu-bt-sidebar">
            <i class="las la-bars wrapper-menu"></i>
        </div>
    </div>
    <div class="data-scrollbar" data-scroll="1">
        <nav class="mm-sidebar-menu">
            <ul id="mm-sidebar-toggle" class="side-menu">
                <li class="<?= $active === '' ? 'active' : '' ?>">
                    <a href="../view/index.php" class="svg-icon">
                        <i class="">
                        <svg class="svg-icon" id="mm-dash" width="20" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </i><span class="">Dashboard</span>
                    </a>
                </li>

                <li class="<?= $active === 'appconfiguration' ? 'active' : '' ?>">
                    <a href="../view/index.php?page=appconfiguration" class="svg-icon">
                        <i class="">
                            <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" id="mm-app-1" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <rect x="4" y="4" width="6" height="6" rx="1" />
                                <rect x="4" y="14" width="6" height="6" rx="1" />
                                <rect x="14" y="14" width="6" height="6" rx="1" />
                                <line x1="14" y1="7" x2="20" y2="7" />
                                <line x1="17" y1="4" x2="17" y2="10" />
                            </svg>
                        </i><span class="">App Configuration</span>
                    </a>
                </li>

                <li class="<?= $active === 'adsconfiguration' ? 'active' : '' ?>">
                    <a href="../view/index.php?page=adsconfiguration" class="svg-icon">
                    <i class="">
                            <svg xmlns="http://www.w3.org/2000/svg" id="mm-ads" class="svg-icon" viewBox="0 0 24 24" stroke-width="2" 
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <rect x="3" y="5" width="18" height="14" rx="2" />
                                <path d="M7 15v-4a2 2 0 0 1 4 0v4" />
                                <line x1="7" y1="13" x2="11" y2="13" />
                                <path d="M17 9v6h-1.5a1.5 1.5 0 1 1 1.5 -1.5" />
                            </svg>
                        </i><span class="">Ads Configuration</span>
                    </a>
                </li>
                
                <li class="<?= $active === 'category' ? 'active' : '' ?>">
                    <a href="#category" class="collapsed svg-icon" data-toggle="collapse" aria-expanded="false">
                        <i>
                            <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" id="mm-category-1" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <rect x="4" y="4" width="6" height="6" rx="1" />
                                <rect x="14" y="4" width="6" height="6" rx="1" />
                                <rect x="4" y="14" width="6" height="6" rx="1" />
                                <rect x="14" y="14" width="6" height="6" rx="1" />
                            </svg>
                        </i>
                        <span class="ml-2"> Category</span>
                        <i class="las la-angle-right mm-arrow-right arrow-active"></i>
                        <i class="las la-angle-down mm-arrow-right arrow-hover"></i>
                    </a>

                    <ul id="category" class="submenu collapse" data-parent="#mm-sidebar-toggle">
                        <li class="<?= $active_submenu === 'category_list' ? 'active' : '' ?>">
                            <a href="../view/index.php?page=category" class="svg-icon">
                                <i class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="mm-category-list" class="svg-icon" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <rect x="5" y="3" width="14" height="18" rx="2" />
                                        <line x1="9" y1="7" x2="15" y2="7" />
                                        <line x1="9" y1="11" x2="15" y2="11" />
                                        <line x1="9" y1="15" x2="13" y2="15" />
                                    </svg>
                                </i><span class="">List</span>
                            </a>
                        </li>
                        <li class="<?= $active_submenu === 'category_create' ? 'active' : '' ?>">
                            <a href="../view/index.php?page=category_create" class="svg-icon">
                                <i class="">
                                    <svg xmlns="http://www.w3.org/2000/svg"  id="mm-category-add" class="svg-icon" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <rect x="4" y="4" width="16" height="16" rx="2" />
                                            <line x1="9" y1="12" x2="15" y2="12" />
                                            <line x1="12" y1="9" x2="12" y2="15" />
                                    </svg>
                                </i><span class="">Add</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="<?= $active === 'author' ? 'active' : '' ?>">
                    <a href="#author" class="collapsed svg-icon" data-toggle="collapse" aria-expanded="false">
                        <i>
                            <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" id="mm-author-1" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <circle cx="12" cy="7" r="4" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                        </i>
                        <span class="ml-2"> Author</span>
                        <i class="las la-angle-right mm-arrow-right arrow-active"></i>
                        <i class="las la-angle-down mm-arrow-right arrow-hover"></i>
                    </a>

                    <ul id="author" class="submenu collapse" data-parent="#mm-sidebar-toggle">
                        <li class="<?= $active_submenu === 'author_list' ? 'active' : '' ?>">
                            <a href="../view/index.php?page=author" class="svg-icon">
                                <i class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="mm-author-list" class="svg-icon" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <rect x="5" y="3" width="14" height="18" rx="2" />
                                        <line x1="9" y1="7" x2="15" y2="7" />
                                        <line x1="9" y1="11" x2="15" y2="11" />
                                        <line x1="9" y1="15" x2="13" y2="15" />
                                    </svg>
                                </i><span class="">List</span>
                            </a>
                        </li>
                        <li class="<?= $active_submenu === 'author_create' ? 'active' : '' ?>">
                            <a href="../view/index.php?page=author_create" class="svg-icon">
                                <i class="">
                                    <svg xmlns="http://www.w3.org/2000/svg"  id="mm-author-add" class="svg-icon" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <rect x="4" y="4" width="16" height="16" rx="2" />
                                            <line x1="9" y1="12" x2="15" y2="12" />
                                            <line x1="12" y1="9" x2="12" y2="15" />
                                    </svg>
                                </i><span class="">Add</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="<?= $active === 'book' ? 'active' : '' ?>">
                    <a href="#book" class="collapsed svg-icon" data-toggle="collapse" aria-expanded="false">
                        <i>
                            <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" id="mm-book-1" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                                <path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                                <line x1="3" y1="6" x2="3" y2="19" />
                                <line x1="12" y1="6" x2="12" y2="19" />
                                <line x1="21" y1="6" x2="21" y2="19" />
                            </svg>
                        </i>
                        <span class="ml-2"> Book</span>
                        <i class="las la-angle-right mm-arrow-right arrow-active"></i>
                        <i class="las la-angle-down mm-arrow-right arrow-hover"></i>
                    </a>

                    <ul id="book" class="submenu collapse" data-parent="#mm-sidebar-toggle">
                        <li class="<?= $active_submenu === 'book_list' ? 'active' : '' ?>">
                            <a href="../view/index.php?page=book" class="svg-icon">
                                <i class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="mm-book-list" class="svg-icon" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <rect x="5" y="3" width="14" height="18" rx="2" />
                                        <line x1="9" y1="7" x2="15" y2="7" />
                                        <line x1="9" y1="11" x2="15" y2="11" />
                                        <line x1="9" y1="15" x2="13" y2="15" />
                                    </svg>
                                </i><span class="">List</span>
                            </a>
                        </li>
                        <li class="<?= $active_submenu === 'book_create' ? 'active' : '' ?>">
                            <a href="../view/index.php?page=book_create" class="svg-icon">
                                <i class="">
                                    <svg xmlns="http://www.w3.org/2000/svg"  id="mm-book-add" class="svg-icon" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <rect x="4" y="4" width="16" height="16" rx="2" />
                                            <line x1="9" y1="12" x2="15" y2="12" />
                                            <line x1="12" y1="9" x2="12" y2="15" />
                                    </svg>
                                </i><span class="">Add</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="<?= $active === 'order' ? 'active' : '' ?>">
                    <a href="#order" class="collapsed svg-icon" data-toggle="collapse" aria-expanded="false">
                        <i>
                        <svg version="1.1" id="mm-order-list" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            width="16px" height="16px" viewBox="0 0 28.145 28.145" style="enable-background:new 0 0 28.145 28.145;"
                            xml:space="preserve" id="mm-order-list" class="svg-icon" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <g>
                                <g>
                                    <circle cx="9.026" cy="22.371" r="2.086"/>
                                    <circle cx="25.016" cy="22.371" r="2.086"/>
                                    <path d="M28.145,7.746c0-0.033-0.016-0.061-0.018-0.094c-0.008-0.071-0.021-0.137-0.041-0.203
                                        c-0.021-0.064-0.043-0.125-0.072-0.183c-0.031-0.059-0.067-0.109-0.109-0.161c-0.042-0.054-0.086-0.102-0.139-0.146
                                        c-0.049-0.042-0.101-0.074-0.157-0.106c-0.063-0.035-0.125-0.064-0.195-0.087c-0.03-0.01-0.054-0.031-0.085-0.038
                                        c-0.04-0.009-0.076,0.001-0.115-0.002c-0.039-0.003-0.072-0.022-0.111-0.022L6.939,6.701c-0.015,0-0.027,0.008-0.042,0.009
                                        L6.213,4.432C6.081,3.991,5.674,3.688,5.214,3.688H1.043C0.467,3.688,0,4.155,0,4.731c0,0.576,0.467,1.043,1.043,1.043h3.396
                                        l3.949,13.162c0.132,0.441,0.539,0.742,0.999,0.742h15.294c0.49,0,0.912-0.338,1.019-0.816l2.42-10.888
                                        c0.009-0.038-0.002-0.075,0.002-0.113C28.127,7.821,28.145,7.786,28.145,7.746z M23.846,17.592H10.163L7.521,8.786l18.281,0.003
                                        L23.846,17.592z"/>
                                </g>
                                </g> <g> </g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                            </svg>
                        </i>
                        <span class="ml-2"> order</span>
                        <i class="las la-angle-right mm-arrow-right arrow-active"></i>
                        <i class="las la-angle-down mm-arrow-right arrow-hover"></i>
                    </a>

                    <ul id="order" class="submenu collapse" data-parent="#mm-sidebar-toggle">
                        <li class="<?= $active_submenu === 'order_list' ? 'active' : '' ?>">
                            <a href="../view/index.php?page=order" class="svg-icon">
                                <i class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="mm-order-list" class="svg-icon" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <rect x="5" y="3" width="14" height="18" rx="2" />
                                        <line x1="9" y1="7" x2="15" y2="7" />
                                        <line x1="9" y1="11" x2="15" y2="11" />
                                        <line x1="9" y1="15" x2="13" y2="15" />
                                    </svg>
                                </i><span class="">List Pending</span>
                            </a>
                        </li>
                        <li class="<?= $active_submenu === 'confirm_list' ? 'active' : '' ?>">
                            <a href="../view/index.php?page=confirm" class="svg-icon">
                                <i class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="mm-confirm_list" class="svg-icon" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <rect x="5" y="3" width="14" height="18" rx="2" />
                                        <line x1="9" y1="7" x2="15" y2="7" />
                                        <line x1="9" y1="11" x2="15" y2="11" />
                                        <line x1="9" y1="15" x2="13" y2="15" />
                                    </svg>
                                </i><span class="">List Confirmed</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="<?= $active === 'slider' ? 'active' : '' ?>">
                    <a href="#slider" class="collapsed svg-icon" data-toggle="collapse" aria-expanded="false">
                        <i>
                            <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" id="mm-slider-1" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <circle cx="14" cy="6" r="2" />
                                <line x1="4" y1="6" x2="12" y2="6" />
                                <line x1="16" y1="6" x2="20" y2="6" />
                                <circle cx="8" cy="12" r="2" />
                                <line x1="4" y1="12" x2="6" y2="12" />
                                <line x1="10" y1="12" x2="20" y2="12" />
                                <circle cx="17" cy="18" r="2" />
                                <line x1="4" y1="18" x2="15" y2="18" />
                                <line x1="19" y1="18" x2="20" y2="18" />
                            </svg>
                        </i>
                        <span class="ml-2"> Slider</span>
                        <i class="las la-angle-right mm-arrow-right arrow-active"></i>
                        <i class="las la-angle-down mm-arrow-right arrow-hover"></i>
                    </a>

                    <ul id="slider" class="submenu collapse" data-parent="#mm-sidebar-toggle">
                        <li class="<?= $active_submenu === 'slider_list' ? 'active' : '' ?>">
                            <a href="../view/index.php?page=slider" class="svg-icon">
                                <i class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="mm-slider-list" class="svg-icon" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <rect x="5" y="3" width="14" height="18" rx="2" />
                                        <line x1="9" y1="7" x2="15" y2="7" />
                                        <line x1="9" y1="11" x2="15" y2="11" />
                                        <line x1="9" y1="15" x2="13" y2="15" />
                                    </svg>
                                </i><span class="">List</span>
                            </a>
                        </li>
                        <li class="<?= $active_submenu === 'slider_create' ? 'active' : '' ?>">
                            <a href="../view/index.php?page=slider_create" class="svg-icon">
                                <i class="">
                                    <svg xmlns="http://www.w3.org/2000/svg"  id="mm-slider-add" class="svg-icon" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <rect x="4" y="4" width="16" height="16" rx="2" />
                                            <line x1="9" y1="12" x2="15" y2="12" />
                                            <line x1="12" y1="9" x2="12" y2="15" />
                                    </svg>
                                </i><span class="">Add</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="<?= $active === 'onesignal' ? 'active' : '' ?>">
                    <a href="#onesignal" class="collapsed svg-icon" data-toggle="collapse" aria-expanded="false">
                        <i>
                            <svg class="svg-icon" id="mm-ui-1-16" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </i>
                        <span class="ml-2">Notification </span>
                        <i class="las la-angle-right mm-arrow-right arrow-active"></i>
                        <i class="las la-angle-down mm-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="onesignal" class="submenu collapse" data-parent="#mm-sidebar-toggle">
                        
                        <li class="<?= $active_submenu === 'onesignal_configuration' ? 'active' : '' ?>">
                            <a href="../view/index.php?page=onesignal_configuration" class="svg-icon">
                                <i class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" id="mm-config" viewBox="0 0 24 24" 
                                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                                        <path d="M10 9v6l5 -3z" />
                                    </svg>
                                </i><span class="">Configuration</span>
                            </a>
                        </li>
                        
                        <li class="<?= $active_submenu === 'onesignal_send' ? 'active' : '' ?>">
                            <a href="../view/index.php?page=onesignal_send" class="svg-icon">
                                <i class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon"  id="mm-send" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 18h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7.5" />
                                        <path d="M3 6l9 6l9 -6" />
                                        <path d="M15 18h6" />
                                        <path d="M18 15l3 3l-3 3" />
                                    </svg>
                                </i><span class="">Send</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="<?= $active === 'apiconfiguration' ? 'active' : '' ?>">
                    <a href="../view/index.php?page=apiconfiguration" class="svg-icon">
                    <i class="">
                        <svg xmlns="http://www.w3.org/2000/svg" id="mm-ads" class="svg-icon" viewBox="0 0 24 24" stroke-width="2" 
                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </i><span class="">API Configuration</span>
                    </a>
                </li>

                <li>
                    <a href="../logout.php" class="svg-icon">
                        <i class="">
                            <svg class="svg-icon mr-0 text-primary" id="h-05-p" width="20"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </i><span class="">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <div class="pt-5 pb-2"></div>
    </div>
</div>