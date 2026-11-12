<?php

/**
 * Google Tag Manager with Consent Mode v2.
 *
 * GTM loads on every page, but Google tags start with all consent "denied".
 * The cookie banner (Complianz) sends the consent update once the visitor chooses.
 */

namespace Flynt\GoogleTagManager;

use Flynt\Utils\Options;

Options::addGlobal('GoogleTagManager', [
    [
        'label' => __('Enable Google Tag Manager', 'flynt'),
        'instructions' => __('Keep this off on staging and local sites so they do not send data to Analytics or Ads.', 'flynt'),
        'name' => 'enabled',
        'type' => 'true_false',
        'default_value' => 0,
        'ui' => true,
    ],
    [
        'label' => __('Container ID', 'flynt'),
        'instructions' => __('Format: GTM-XXXXXXX', 'flynt'),
        'name' => 'containerId',
        'type' => 'text',
        'placeholder' => 'GTM-XXXXXXX',
        'conditional_logic' => [
            [
                [
                    'fieldPath' => 'enabled',
                    'operator' => '==',
                    'value' => '1',
                ],
            ],
        ],
    ],
]);

/**
 * Return the container ID when GTM is enabled and the ID is valid, otherwise null.
 */
function getContainerId()
{
    if (is_admin()) {
        return null;
    }

    $options = Options::getGlobal('GoogleTagManager') ?: [];

    if (empty($options['enabled'])) {
        return null;
    }

    $containerId = strtoupper(trim($options['containerId'] ?? ''));

    return preg_match('/^GTM-[A-Z0-9]+$/', $containerId) ? $containerId : null;
}

// Consent defaults + GTM loader, as early in <head> as possible.
add_action('wp_head', function () {
    $containerId = getContainerId();

    if (!$containerId) {
        return;
    }
    ?>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('consent', 'default', {
  ad_storage: 'denied',
  ad_user_data: 'denied',
  ad_personalization: 'denied',
  analytics_storage: 'denied',
  functionality_storage: 'granted',
  security_storage: 'granted',
  wait_for_update: 500
});
gtag('set', 'ads_data_redaction', true);
</script>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo esc_js($containerId); ?>');</script>
    <?php
}, 1);

// No-JS fallback, right after <body>.
add_action('wp_body_open', function () {
    $containerId = getContainerId();

    if (!$containerId) {
        return;
    }

    printf(
        '<noscript><iframe src="%s" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>',
        esc_url('https://www.googletagmanager.com/ns.html?id=' . $containerId)
    );
});
