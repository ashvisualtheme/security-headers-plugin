/**
 * @file plugins/generic/ashSecurityHeaders/cypress/tests/ashSecurityHeaders.cy.js
 *
 * Copyright (c) 2021-2025 AshVisualTheme
 * Copyright (c) 2014-2025 Simon Fraser University
 * Copyright (c) 2003-2025 John Willinsky
 *
 * @brief Test for the ashSecurityHeaders plugin settings UI.
 */

const pluginRowId = 'component-grid-settings-plugins-settingsplugingrid-category-generic-row-ashsecurityheadersplugin';

function openSettingsModal() {
    cy.get('nav a:contains("Website")').click();
    cy.get('button#plugins-button').click();

    cy.get('#' + pluginRowId + ' .show_extras').click();
    cy.get('a[id^=' + pluginRowId + '-settings-button]').click();

    cy.get('#ashSecurityHeadersSettings', { timeout: 10000 }).should('be.visible');
}

describe('Security Headers Plugin UI Tests', function() {
    beforeEach(() => {
        cy.setLocale('en_US');
        cy.login('admin', 'admin', 'publicknowledge');
        cy.get('nav a:contains("Settings")').click();
    });

    it('Saves a custom header value and verifies it is stored', function() {
        const customValue = 'DENY';
        const defaultValue = 'SAMEORIGIN';

        openSettingsModal();

        cy.get('input#headerXfo').clear().type(customValue);
        cy.get('#ashSecurityHeadersSettings button:contains("Save")').click();

        cy.get('.pkp_notification:contains("Changes saved")').should('be.visible');
        cy.get('.pkp_notification:contains("Changes saved")').should('not.exist');
        cy.get('div.pkp_modal_close').click();

        openSettingsModal();
        cy.get('input#headerXfo').should('have.value', customValue);

        cy.get('input#headerXfo').clear().type(defaultValue);
        cy.get('#ashSecurityHeadersSettings button:contains("Save")').click();
        cy.get('.pkp_notification:contains("Changes saved")').should('not.exist');
    });

    it('Disables a header by saving an empty value', function() {
        const defaultValue = 'SAMEORIGIN';

        openSettingsModal();

        cy.get('input#headerXfo').clear();
        cy.get('#ashSecurityHeadersSettings button:contains("Save")').click();

        cy.get('.pkp_notification:contains("Changes saved")').should('be.visible');
        cy.get('.pkp_notification:contains("Changes saved")').should('not.exist');
        cy.get('div.pkp_modal_close').click();

        openSettingsModal();
        cy.get('input#headerXfo').should('have.value', '');

        cy.get('input#headerXfo').clear().type(defaultValue);
        cy.get('#ashSecurityHeadersSettings button:contains("Save")').click();
        cy.get('.pkp_notification:contains("Changes saved")').should('not.exist');
    });
});
