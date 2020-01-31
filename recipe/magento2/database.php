<?php

/**
 * Magento 2.3.x Deployer Recipe
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2020 August Ash (https://www.augustash.com)
 * @license   MIT
 */

namespace Deployer;

desc('Check if database schema and/or data require upgrading');
task('magento:database:status', function () {
    within('{{release_path}}', function () {
        try {
            run('{{bin/magento}} {{verbose}} setup:db:status --no-ansi');
            writeln('All modules are up to date');
        } catch (\Exception $e) {
            writeln('Please update your DB schema and data');
        }
    });
});

desc('Upgrade database');
task('magento:database:upgrade', function () {
    within('{{release_path}}', function () {
        try {
            run('{{bin/magento}} {{verbose}} setup:db:status --no-ansi');
            writeln('All modules are up to date');
            return;
        } catch (\Exception $e) {
            invoke('magento:database:schema:upgrade');
            invoke('magento:database:data:upgrade');
        }
    });
});

desc('Upgrade data fixtures');
task('magento:database:schema:upgrade', function () {
    within('{{release_path}}', function () {
        run('{{bin/magento}} {{verbose}} setup:db-schema:upgrade');
    });
});

desc('Upgrade database schema');
task('magento:database:data:upgrade', function () {
    within('{{release_path}}', function () {
        run('{{bin/magento}} {{verbose}} setup:db-data:upgrade');
    });
});