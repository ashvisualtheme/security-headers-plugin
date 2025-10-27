<?php

/**
 * @file plugins/generic/ashSecurityHeaders/AshSecurityHeadersSettingsForm.inc.php
 *
 * Copyright (c) 2021-2025 AshVisualTheme
 * Copyright (c) 2014-2025 Simon Fraser University
 * Copyright (c) 2003-2025 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class SecurityHeadersSettingsForm
 * @brief Form for managing the Security Headers plugin settings.
 */

namespace APP\plugins\generic\ashSecurityHeaders;

use APP\core\Application;
use APP\notification\Notification;
use APP\notification\NotificationManager;
use APP\template\TemplateManager;
use PKP\form\Form;
use PKP\form\validation\FormValidatorCSRF;
use PKP\form\validation\FormValidatorPost;

class AshSecurityHeadersSettingsForm extends Form
{
    public AshSecurityHeadersPlugin $plugin;
    private $settingKeys;

    public function __construct(AshSecurityHeadersPlugin $plugin)
    {
        parent::__construct($plugin->getTemplateResource('settings.tpl'));
        $this->plugin = $plugin;

        $this->settingKeys = [
            'headerXfo',
            'headerXcto',
            'headerXxss',
            'headerCsp',
            'headerCoep',
            'headerCoop',
            'headerCorp',
            'headerPp',
            'headerRp',
            'headerHsts'
        ];

        $this->addCheck(new FormValidatorPost($this));
        $this->addCheck(new FormValidatorCSRF($this));
    }

    public function initData()
    {
        $context = Application::get()->getRequest()->getContext();
        $contextId = $context ? $context->getId() : CONTEXT_SITE;
        $defaultHeaders = $this->plugin->getDefaultHeaders();

        $settingMap = [
            'headerXfo' => 'X-Frame-Options',
            'headerXcto' => 'X-Content-Type-Options',
            'headerXxss' => 'X-XSS-Protection',
            'headerCsp' => 'Content-Security-Policy',
            'headerCoep' => 'Cross-Origin-Embedder-Policy',
            'headerCoop' => 'Cross-Origin-Opener-Policy',
            'headerCorp' => 'Cross-Origin-Resource-Policy',
            'headerPp' => 'Permissions-Policy',
            'headerRp' => 'Referrer-Policy',
            'headerHsts' => 'Strict-Transport-Security',
        ];

        foreach ($this->settingKeys as $key) {
            $savedValue = $this->plugin->getSetting($contextId, $key);

            if ($savedValue === null) {
                $headerName = $settingMap[$key] ?? null;
                if ($headerName && isset($defaultHeaders[$headerName])) {
                    $this->setData($key, $defaultHeaders[$headerName]);
                }
            } else {
                $this->setData($key, $savedValue);
            }
        }

        parent::initData();
    }

    public function readInputData()
    {
        $this->readUserVars($this->settingKeys);
        parent::readInputData();
    }

    public function fetch($request, $template = null, $display = false)
    {
        $templateMgr = TemplateManager::getManager($request);
        $templateMgr->assign('pluginName', $this->plugin->getName());
        return parent::fetch($request, $template, $display);
    }

    public function execute(...$functionArgs)
    {
        $context = Application::get()->getRequest()->getContext();
        $contextId = $context ? $context->getId() : CONTEXT_SITE;

        foreach ($this->settingKeys as $key) {
            $value = $this->getData($key);
            $sanitizedValue = is_string($value) ? preg_replace('/[\r\n]/', '', $value) : $value;
            $this->plugin->updateSetting($contextId, $key, $sanitizedValue);
        }

        $notificationMgr = new NotificationManager();
        $notificationMgr->createTrivialNotification(
            Application::get()->getRequest()->getUser()->getId(),
            Notification::NOTIFICATION_TYPE_SUCCESS,
            ['contents' => __('common.changesSaved')]
        );

        return parent::execute(...$functionArgs);
    }
}
