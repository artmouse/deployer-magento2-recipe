<?php

/**
 * Magento 2.4.x Deployer Recipe
 *
 * Provides a Deployer-based series of recipes to properly deploy Magento 2.4+.
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2022 August Ash, Inc. (https://www.augustash.com)
 */

namespace Deployer;

desc('Check Magento cache status');
task('magento:cache:status', function () {
    within('{{release_path}}', function () {
        run('{{bin/magento}} cache:status');
    });
});

desc('Clean Magento cache storage');
task('magento:cache:clean', function () {
    within('{{release_path}}', function () {
        run('{{bin/magento}} cache:clean');
    });
});

desc('Flush Magento cache storage');
task('magento:cache:flush', function () {
    within('{{release_path}}', function () {
        run('{{bin/magento}} cache:flush');
    });
});

desc('Enable Magento cache');
task('magento:cache:enable', function () {
    within('{{release_path}}', function () {
        run('{{bin/magento}} cache:enable');
    });
});

desc('Disable Magento cache');
task('magento:cache:disable', function () {
    within('{{release_path}}', function () {
        run('{{bin/magento}} cache:disable');
    });
});

desc('Flush CloudFlare Cache');
task('cloudflare:cache:flush', function () {
    $zone = get('cloudflare_zone', null);
    $key = get('cloudflare_key', null);

    if ($zone !== null && $key !== null) {
        run('{{bin/curl}} -X POST "https://api.cloudflare.com/client/v4/zones/{{cloudflare_zone}}/purge_cache" \
            -H "Authorization: Bearer {{cloudflare_key}}" \
            -H "Content-Type: application/json" \
            --data \'{"purge_everything":true}\'');
    }
});
