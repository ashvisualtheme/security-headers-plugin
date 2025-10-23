<?php

/**
 * @file plugins/generic/securityHeaders/index.php
 *
 * Copyright (c) 2021-2025 AshVisualTheme
 * Copyright (c) 2014-2025 Simon Fraser University
 * Copyright (c) 2003-2025 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_generic_securityHeaders
 * @brief Wrapper for the security headers plugin.
 *
 */

require_once('SecurityHeadersPlugin.inc.php');
return new SecurityHeadersPlugin();
