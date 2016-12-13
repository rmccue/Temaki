<?php

require dirname( dirname( __FILE__ ) ) . '/temaki.php';

// Load GlotPress locales to test against.

$locales = file_get_contents( 'https://raw.githubusercontent.com/GlotPress/GlotPress-WP/develop/locales/locales.php' );
file_put_contents( dirname( __FILE__ ) . '/locales.php', $locales );

include dirname( __FILE__ ) . '/locales.php';

$locales = new GP_Locales();
