{**
 * templates/settings.tpl
 *
 * Copyright (c) 2021-2025 AshVisualTheme
 * Copyright (c) 2014-2025 Simon Fraser University
 * Copyright (c) 2003-2025 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * Settings form template for the Security Headers plugin.
 *}

<script>
	$(function() {ldelim}
	$('#ashSecurityHeadersSettings').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
	{rdelim});
</script>

<form class="pkp_form" id="ashSecurityHeadersSettings" method="POST"
	action="{url router=$smarty.const.ROUTE_COMPONENT op="manage" category="generic" plugin=$pluginName verb="settings" save=true}">
	{csrf}
	<div class="section">
		<p>{translate key="plugins.generic.ashSecurityHeaders.settings.description"}</p>
	</div>

	{fbvFormSection label="plugins.generic.ashSecurityHeaders.settings.headerXfoLabel"}
	<p>{translate key="plugins.generic.ashSecurityHeaders.settings.headerXfoInfo"}</p>
	{fbvElement type="text" id="headerXfo" value=$headerXfo label="plugins.generic.ashSecurityHeaders.settings.headerXfoDescription"}
	{/fbvFormSection}

	{fbvFormSection label="plugins.generic.ashSecurityHeaders.settings.headerXctoLabel"}
	<p>{translate key="plugins.generic.ashSecurityHeaders.settings.headerXctoInfo"}</p>
	{fbvElement type="text" id="headerXcto" value=$headerXcto label="plugins.generic.ashSecurityHeaders.settings.headerXctoDescription"}
	{/fbvFormSection}

	{fbvFormSection label="plugins.generic.ashSecurityHeaders.settings.headerXxssLabel"}
	<p>{translate key="plugins.generic.ashSecurityHeaders.settings.headerXxssInfo"}</p>
	{fbvElement type="text" id="headerXxss" value=$headerXxss label="plugins.generic.ashSecurityHeaders.settings.headerXxssDescription"}
	{/fbvFormSection}

	{fbvFormSection label="plugins.generic.ashSecurityHeaders.settings.headerCspLabel"}
	<p>{translate key="plugins.generic.ashSecurityHeaders.settings.headerCspInfo"}</p>
	{fbvElement type="textarea" id="headerCsp" value=$headerCsp label="plugins.generic.ashSecurityHeaders.settings.headerCspDescription"}
	{/fbvFormSection}

	{fbvFormSection label="plugins.generic.ashSecurityHeaders.settings.headerCoepLabel"}
	<p>{translate key="plugins.generic.ashSecurityHeaders.settings.headerCoepInfo"}</p>
	{fbvElement type="text" id="headerCoep" value=$headerCoep label="plugins.generic.ashSecurityHeaders.settings.headerCoepDescription"}
	{/fbvFormSection}

	{fbvFormSection label="plugins.generic.ashSecurityHeaders.settings.headerCoopLabel"}
	<p>{translate key="plugins.generic.ashSecurityHeaders.settings.headerCoopInfo"}</p>
	{fbvElement type="text" id="headerCoop" value=$headerCoop label="plugins.generic.ashSecurityHeaders.settings.headerCoopDescription"}
	{/fbvFormSection}

	{fbvFormSection label="plugins.generic.ashSecurityHeaders.settings.headerCorpLabel"}
	<p>{translate key="plugins.generic.ashSecurityHeaders.settings.headerCorpInfo"}</p>
	{fbvElement type="text" id="headerCorp" value=$headerCorp label="plugins.generic.ashSecurityHeaders.settings.headerCorpDescription"}
	{/fbvFormSection}

	{fbvFormSection label="plugins.generic.ashSecurityHeaders.settings.headerPpLabel"}
	<p>{translate key="plugins.generic.ashSecurityHeaders.settings.headerPpInfo"}</p>
	{fbvElement type="textarea" id="headerPp" value=$headerPp rows=8 label="plugins.generic.ashSecurityHeaders.settings.headerPpDescription"}
	{/fbvFormSection}

	{fbvFormSection label="plugins.generic.ashSecurityHeaders.settings.headerRpLabel"}
	<p>{translate key="plugins.generic.ashSecurityHeaders.settings.headerRpInfo"}</p>
	{fbvElement type="text" id="headerRp" value=$headerRp label="plugins.generic.ashSecurityHeaders.settings.headerRpDescription"}
	{/fbvFormSection}

	{fbvFormSection label="plugins.generic.ashSecurityHeaders.settings.headerHstsLabel"}
	<p>{translate key="plugins.generic.ashSecurityHeaders.settings.headerHstsInfo"}</p>
	{fbvElement type="text" id="headerHsts" value=$headerHsts label="plugins.generic.ashSecurityHeaders.settings.headerHstsDescription"}
	{/fbvFormSection}

	{fbvFormButtons submitText="common.save"}
</form>