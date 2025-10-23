#!/bin/bash

set -e

npx cypress run  --headless --browser chrome  --config '{"specPattern":["plugins/generic/ashSecurityHeaders/cypress/tests/*.cy.js"]}'


