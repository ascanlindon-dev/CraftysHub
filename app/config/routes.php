<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 *
 * Copyright (c) 2020 Ronald M. Marasigan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 1
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/*
| -------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------
| Here is where you can register web routes for your application.
|
|
*/

// Default routes
$router->get('/', 'Auth::login');

// Authentication routes
$router->get('/login', 'Auth::login');
$router->post('/login', 'Auth::login');
$router->get('/signup', 'Auth::signup');
$router->post('/signup', 'Auth::signup');
$router->get('/logout', 'Auth::logout');

// Google login and callback routes
$router->get('/auth/google-login', 'Auth::googleLogin');
$router->get('/auth/google-callback', 'Auth::googleCallback');

// Admin dashboard routes (protected)
$router->get('/admin', 'Admin::dashboard');
$router->get('/admin/dashboard', 'Admin::dashboard');
$router->get('/admin/logout', 'Admin::logout');

// Admin product routes
$router->get('/admin/products', 'Admin::products');
$router->get('/admin/add_product', 'Admin::addProduct');
$router->post('/admin/create_product', 'Admin::addProduct');
$router->get('/admin/edit_product/{id}', 'Admin::updateProduct');
$router->post('/admin/update_product', 'Admin::updateProduct');
$router->post('/admin/products/delete', 'Admin::deleteProduct');

// Admin user routes
$router->get('/admin/users', 'Admin::users');
$router->post('/admin/users/delete', 'Admin::deleteUser');

// Admin order routes
$router->get('/admin/orders', 'Admin::orders');
$router->get('/admin/orders/view/{id}', 'Admin::viewOrder');

$router->post('/admin/update_order_status', 'Admin::update_order_status');

// Admin revenue routes
$router->get('/admin/revenue', 'Admin::revenue');
$router->get('/admin/sync-revenue', 'Admin::sync_revenue');

// Admin other routes
$router->get('/admin/reports', 'Admin::reports');
$router->get('/admin/settings', 'Admin::settings');

// Admin inventory routes
$router->get('/admin/inventory', 'Admin::inventory');
$router->post('/admin/inventory/update-stock', 'Admin::updateStock');
$router->post('/admin/inventory/bulk-update', 'Admin::bulkUpdateStock');
$router->get('/admin/inventory/stats', 'Admin::getInventoryStats');
$router->get('/admin/inventory/export', 'Admin::exportInventory');

// Admin settings update routes
$router->post('/admin/update_general_settings', 'Admin::update_general_settings');
$router->post('/admin/update_email_settings', 'Admin::update_email_settings');
$router->post('/admin/update_security_settings', 'Admin::update_security_settings');
$router->post('/admin/test_email', 'Admin::test_email');

// Buyer dashboard routes
$router->get('/buyer/product/{product_id}', 'Buyer::product');
$router->post('/buyer/product/{product_id}', 'Buyer::product');
$router->get('/buyer/dashboard', 'Buyer::dashboard');
$router->get('/buyer/products', 'Buyer::products');
$router->get('/buyer/orders', 'Buyer::orders');
$router->get('/buyer/cart', 'Buyer::cart');
$router->get('/buyer/account-settings', 'Buyer::accountSettings');
$router->post('/buyer/account-settings', 'Buyer::accountSettings');
$router->post('/buyer/add-to-cart', 'Buyer::addToCart');
$router->post('/buyer/buy-now', 'Buyer::buyNow');
$router->post('/buyer/remove-from-cart', 'Buyer::removeFromCart');
$router->post('/buyer/update-cart', 'Buyer::updateCart');
$router->get('/buyer/checkout', 'Buyer::checkout');
$router->post('/buyer/checkout', 'Buyer::checkout');
$router->post('/buyer/get-order-items', 'Buyer::getOrderItems');
$router->post('/buyer/cancel-order', 'Buyer::cancelOrder');
$router->get('/buyer/logout', 'Buyer::logout');

// Buyer payment routes (GCash via PayMongo)
$router->get('/buyer/payment/gcash', 'Buyer::processGCashPayment');
$router->get('/buyer/payment/gcash-success', 'Buyer::gcashSuccess');
$router->get('/buyer/payment/gcash-failed', 'Buyer::gcashFailed');

// Buyer customer service routes
$router->get('/buyer/customer-service', 'Buyer::customerService');
$router->post('/buyer/customer-service', 'Buyer::customerService');

$router->get('/otp_verify', 'Auth::verifyOtp');
$router->post('/otp_verify', 'Auth::verifyOtp');





