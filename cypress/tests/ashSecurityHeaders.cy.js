/**
 * @file plugins/generic/ashSecurityHeaders/cypress/tests/ashSecurityHeaders.cy.js
 *
 * Copyright (c) 2021-2025 AshVisualTheme
 * Copyright (c) 2014-2025 Simon Fraser University
 * Copyright (c) 2003-2025 John Willinsky
 *
 * @brief Test for the ashSecurityHeaders plugin settings UI.
 */

describe('Security Headers Plugin Tests', function() {
	const pluginDisplayName = 'Security Headers by AshVisual Theme';

	it('Enables the plugin', function() {
		cy.login('admin', 'admin', 'publicknowledge');

		cy.get('.app__nav a').contains('Website').click();
		cy.get('button[id="plugins-button"]').click();
		cy.get('div[id^="component-grid-settings-plugins-settingsplugingrid-"] td:contains("' + pluginDisplayName + '")')
			.parent() // Dapatkan <tr> parent
			.find('input[type="checkbox"].toggle-plugin')
			.check();
		cy.get('div:contains("The plugin \\"Security Headers by AshVisual Theme\\" has been enabled.")');
	});

	it('Configures and verifies a custom setting', function() {
		const customValue = 'DENY';
		const defaultValue = 'SAMEORIGIN';

		cy.login('admin', 'admin', 'publicknowledge');

		cy.get('.app__nav a').contains('Website').click();
		cy.get('button[id="plugins-button"]').click();
		cy.get('div[id^="component-grid-settings-plugins-settingsplugingrid-"] td:contains("' + pluginDisplayName + '")')
			.parent()
			.find('a.show_extras')
			.click();
		cy.get('a.settings').click();
		cy.get('#ashSecurityHeadersSettings', { timeout: 20000 }).should('be.visible');
		cy.get('input#headerXfo').clear().type(customValue, { delay: 0 });
		cy.get('form[id="ashSecurityHeadersSettings"] button:contains("Save")').click();
		cy.get('.pkp_notification:contains("Changes saved")').should('be.visible');
		cy.get('input#headerXfo').clear().type(defaultValue, { delay: 0 });
		cy.get('form[id="ashSecurityHeadersSettings"] button:contains("Save")').click();
		cy.get('.pkp_notification:contains("Changes saved")').should('be.visible');
	});

	it('Verifies the custom header is applied on the frontend', function() {
		const customValue = 'DENY';
		const defaultValue = 'SAMEORIGIN';

		cy.login('admin', 'admin', 'publicknowledge');
		cy.get('.app__nav a').contains('Website').click();
		cy.get('button[id="plugins-button"]').click();
		cy.get('div[id^="component-grid-settings-plugins-settingsplugingrid-"] td:contains("' + pluginDisplayName + '")').parent().find('a.show_extras').click();
		cy.get('a.settings').click();
		cy.get('#ashSecurityHeadersSettings', { timeout: 20000 }).should('be.visible');
		cy.get('input#headerXfo').clear().type(customValue, { delay: 0 });
		cy.get('form[id="ashSecurityHeadersSettings"] button:contains("Save")').click();
		cy.get('.pkp_notification:contains("Changes saved")').should('not.exist');

		cy.request('/index.php/publicknowledge/index').its('headers').should('include', {
			'x-frame-options': customValue
		});

		cy.login('admin', 'admin', 'publicknowledge');
		cy.get('.app__nav a').contains('Website').click();
		cy.get('button[id="plugins-button"]').click();
		cy.get('div[id^="component-grid-settings-plugins-settingsplugingrid-"] td:contains("' + pluginDisplayName + '")').parent().find('a.show_extras').click();
		cy.get('a.settings').click();
		cy.get('#ashSecurityHeadersSettings', { timeout: 20000 }).should('be.visible');
		cy.get('input#headerXfo').clear().type(defaultValue, { delay: 0 });
		cy.get('form[id="ashSecurityHeadersSettings"] button:contains("Save")').click();
	});
});
