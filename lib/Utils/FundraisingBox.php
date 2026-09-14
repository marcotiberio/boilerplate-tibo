<?php

namespace Flynt\Utils;

/**
 * Builds FundraisingBox paymentJS embed URLs from structured parts, so editors
 * pick values in the backend instead of hand-editing query strings.
 *
 * @see https://developer.fundraisingbox.com/reference/form-prepopulation-api
 */
class FundraisingBox
{
    const ENDPOINT = 'https://secure.fundraisingbox.com/app/paymentJS';
    const CREDIT_URL = 'https://www.fundraisingbox.com/?utm_source=donation_form';
    const LOGO_URL = 'https://secure.fundraisingbox.com/images/FundraisingBox-Logo-Widget.png';

    /**
     * Assemble the embed URL for a form hash plus prepopulation parameters.
     * Empty parameters are dropped, values are URL-encoded.
     *
     * @param string $hash Form hash (FundraisingBox → Forms → Embed code → hash=…).
     * @param array $params Prepopulation parameters, e.g. ['country_fix' => 'DE'].
     * @return string Embed URL, or an empty string when no hash is set.
     */
    public static function embedUrl($hash, array $params = [])
    {
        $hash = trim((string) $hash);

        if ($hash === '') {
            return '';
        }

        $params = array_filter($params, function ($value, $key) {
            return $key !== '' && $value !== null && $value !== '';
        }, ARRAY_FILTER_USE_BOTH);

        // RFC 3986 encoding so spaces become %20 rather than "+".
        return self::ENDPOINT . '?' . http_build_query(
            array_merge(['hash' => $hash], $params),
            '',
            '&',
            PHP_QUERY_RFC3986
        );
    }

    /**
     * The complete embed snippet as FundraisingBox hands it out: the paymentJS
     * script, a noscript fallback and the attribution link.
     *
     * The attribution link is not decoration — paymentJS looks for a logo link
     * on the parent page and removes the form when it cannot find one. It is
     * hidden from view in _style.scss (via stylesheet, never inline, or
     * paymentJS treats it as missing).
     *
     * @param string $embedUrl Result of embedUrl().
     * @param string $noscriptText Fallback text shown without JavaScript.
     * @return string Embed markup, or an empty string without an embed URL.
     */
    public static function embedScript($embedUrl, $noscriptText = '')
    {
        $embedUrl = trim((string) $embedUrl);

        if ($embedUrl === '') {
            return '';
        }

        if ($noscriptText === '') {
            $noscriptText = __('Please enable JavaScript to view the donation form.', 'flynt');
        }

        return sprintf(
            '<script type="text/javascript" src="%s"></script>' .
            '<noscript><p class="font-small">%s</p></noscript>' .
            '<a target="_blank" rel="noopener" href="%s">' .
            '<img src="%s" alt="FundraisingBox Logo" /></a>',
            esc_url($embedUrl),
            esc_html($noscriptText),
            esc_url(self::CREDIT_URL),
            esc_url(self::LOGO_URL)
        );
    }

    /**
     * Parameter name for a custom field, e.g. donation_custom_field_16562.
     * The ID is listed in FundraisingBox under Konfiguration → benutzerdef. Felder.
     *
     * @param string|int $id Custom field ID.
     * @param bool $lock Append _fix so donors cannot change the value.
     * @param string $scope 'donation' or 'person'.
     * @return string Parameter name, or an empty string without a numeric ID.
     */
    public static function customFieldParam($id, $lock = false, $scope = 'donation')
    {
        $id = trim((string) $id);

        if ($id === '' || !ctype_digit($id)) {
            return '';
        }

        $scope = $scope === 'person' ? 'person' : 'donation';

        return "{$scope}_custom_field_{$id}" . ($lock ? '_fix' : '');
    }

    /**
     * Country prepopulation parameter, as a single-entry array ready to merge
     * into embedUrl() parameters. Country codes are ISO 3166-1 alpha-2.
     *
     * @param string $code Country code, e.g. 'DE'.
     * @param bool $lock Use country_fix so donors cannot change it. Off by
     *                   default: the dropdown opens on the preselected country
     *                   but donors abroad can still pick their own.
     * @return array
     */
    public static function countryParams($code, $lock = false)
    {
        $code = strtoupper(trim((string) $code));

        if ($code === '') {
            return [];
        }

        return [($lock ? 'country_fix' : 'country') => $code];
    }

    /**
     * Country choices for backend dropdowns. Keys are ISO 3166-1 alpha-2 codes.
     *
     * @return array
     */
    public static function countryChoices()
    {
        return [
            'DE' => __('Germany', 'flynt'),
            'AT' => __('Austria', 'flynt'),
            'CH' => __('Switzerland', 'flynt'),
            'NL' => __('Netherlands', 'flynt'),
            'BE' => __('Belgium', 'flynt'),
            'FR' => __('France', 'flynt'),
            'LU' => __('Luxembourg', 'flynt'),
            'GB' => __('United Kingdom', 'flynt'),
        ];
    }
}
