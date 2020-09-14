<?php

/**
 * Check if site is on stage
 *
 * @return bool
 */
function idkomm_is_stage() {
    if ( strpos( site_url(), 'stage' ) !== false ) {
        return true;
    }

    return false;
}


/**
 * Check if site is on dev
 *
 * @return bool
 */
function idkomm_is_dev()
{
    if (strstr(site_url(), '.dev') !== false || strstr(site_url(), '.test') !== false) {
        return true;
    }

    return false;
}


/**
 * Render the GTM-script
 *
 * @return string
 */
function idkomm_add_GTM()
{
    $gtm_code = get_theme_mod('idkomm_google_tag_manager_code');
    if (empty($gtm_code)) {
        return '';
    }

    ob_start();

    ?>
    <!-- Google Tag Manager -->
    <script>(function ( w, d, s, l, i ) {
            w[ l ] = w[ l ] || []
            w[ l ].push( {
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js',
            } )
            var f = d.getElementsByTagName( s )[ 0 ],
                j = d.createElement( s ), dl = l != 'dataLayer' ? '&l=' + l : ''
            j.async = true
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl
            f.parentNode.insertBefore( j, f )
        })( window, document, 'script', 'dataLayer', '<?php echo $gtm_code ?>' )</script>
    <!-- End Google Tag Manager -->
    <?php

    return ob_get_clean();
}


/**
 * Render the GTM-script
 *
 * @return string
 */
function idkomm_add_GTM_noscript()
{
    $gtm_code = get_theme_mod('idkomm_google_tag_manager_code');
    if (empty($gtm_code)) {
        return '';
    }

    ob_start();

    ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $gtm_code ?>"
                height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php

    return ob_get_clean();
}


/**
 * Get the current language slug from polylang if available
 *
 * @return bool|string
 */
function idkomm_get_current_language_slug() {
	$lang_slug = '';
	if ( function_exists( 'pll_current_language' ) ) {
		$lang_slug = pll_current_language( 'slug' );
	}

	return $lang_slug;
}
