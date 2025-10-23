<?php

/**
 * @file plugins/generic/ashSecurityHeaders/SecurityHeadersPlugin.inc.php
 *
 * Copyright (c) 2021-2025 AshVisualTheme
 * Copyright (c) 2014-2025 Simon Fraser University
 * Copyright (c) 2003-2025 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class SecurityHeadersPlugin
 * @brief Main class for the Security Headers plugin.
 */

import('lib.pkp.classes.core.PKPApplication');
import('lib.pkp.classes.core.JSONMessage');
import('lib.pkp.classes.linkAction.LinkAction');
import('lib.pkp.classes.linkAction.request.AjaxModal');
import('lib.pkp.classes.plugins.GenericPlugin');
import('lib.pkp.classes.plugins.HookRegistry');

import('plugins.generic.ashSecurityHeaders.SecurityHeadersSettingsForm');

class SecurityHeadersPlugin extends GenericPlugin
{
    public function register($category, $path, $mainContextId = null)
    {
        $success = parent::register($category, $path, $mainContextId);
        if ($success && $this->getEnabled()) {
            HookRegistry::register('Dispatcher::dispatch', [$this, 'addSecurityHeaders']);
        }
        return $success;
    }

    public function getDisplayName()
    {
        return __('plugins.generic.ashSecurityHeaders.displayName');
    }

    public function getDescription()
    {
        return __('plugins.generic.ashSecurityHeaders.description');
    }

    public function isSitePlugin()
    {
        if (!$this->getRequest()->getContext()) {
            return true;
        }
        return false;
    }

    public function getActions($request, $actionArgs)
    {
        $actions = parent::getActions($request, $actionArgs);
        if (!$this->getEnabled()) {
            return $actions;
        }

        $router = $request->getRouter();
        $linkAction = new LinkAction(
            'settings',
            new AjaxModal(
                $router->url(
                    $request,
                    null,
                    null,
                    'manage',
                    null,
                    ['verb' => 'settings', 'plugin' => $this->getName(), 'category' => 'generic']
                ),
                $this->getDisplayName()
            ),
            __('manager.plugins.settings'),
            null
        );
        array_unshift($actions, $linkAction);
        return $actions;
    }

    public function manage($args, $request)
    {
        switch ($request->getUserVar('verb')) {
            case 'settings':
                $form = new SecurityHeadersSettingsForm($this);

                if (!$request->getUserVar('save')) {
                    $form->initData();
                    return new JSONMessage(true, $form->fetch($request));
                }

                $form->readInputData();
                if ($form->validate()) {
                    $form->execute();
                    return new JSONMessage(true);
                }
        }
        return parent::manage($args, $request);
    }

    public function getDefaultHeaders()
    {
        return [
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-Content-Type-Options' => 'nosniff',
            'X-XSS-Protection' => '1; mode=block',
            'Content-Security-Policy' => "upgrade-insecure-requests;",
            'Cross-Origin-Embedder-Policy' => "same-origin; report-to='default'",
            'Cross-Origin-Opener-Policy' => 'require-corp',
            'Cross-Origin-Resource-Policy' => 'same-origin',
            'Permissions-Policy' => "accelerometer=(), camera=(), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), usb=(), fullscreen=(self)",
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Strict-Transport-Security' => 'max-age=63072000; includeSubDomains; preload',
        ];
    }

    public function addSecurityHeaders($hookName, $params)
    {

        if (defined('SESSION_DISABLE_INIT') || php_sapi_name() === 'cli' || headers_sent()) {
            return false;
        }

        $defaultHeaders = $this->getDefaultHeaders();
        $request = PKPApplication::get()->getRequest();
        $context = $request->getContext();
        $contextId = $context ? $context->getId() : CONTEXT_SITE;

        $settingMap = [
            'X-Frame-Options' => 'headerXfo',
            'X-Content-Type-Options' => 'headerXcto',
            'X-XSS-Protection' => 'headerXxss',
            'Content-Security-Policy' => 'headerCsp',
            'Cross-Origin-Embedder-Policy' => 'headerCoep',
            'Cross-Origin-Opener-Policy' => 'headerCoop',
            'Cross-Origin-Resource-Policy' => 'headerCorp',
            'Permissions-Policy' => 'headerPp',
            'Referrer-Policy' => 'headerRp',
            'Strict-Transport-Security' => 'headerHsts',
        ];

        $finalHeaders = [];
        foreach ($settingMap as $headerName => $settingKey) {
            $savedValue = $this->getSetting($contextId, $settingKey);

            if ($savedValue === null) {
                if (isset($defaultHeaders[$headerName])) {
                    $finalHeaders[$headerName] = $defaultHeaders[$headerName];
                }
            } elseif ($savedValue !== '') {
                $finalHeaders[$headerName] = $savedValue;
            }
        }

        header_remove('X-Powered-By');

        if (!empty($finalHeaders)) {
            foreach ($finalHeaders as $name => $value) {
                header("{$name}: {$value}");
            }
        }

        return false;
    }
}
