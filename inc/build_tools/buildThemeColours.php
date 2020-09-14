<?php

class buildThemeColours {

	/**
	 * Location of theme config file
	 *
	 * @var string
	 */
	var $configFile = '../../theme_config.json';

	/**
	 * Location of output PHP file
	 *
	 * @var string
	 */
	var $PHPFile = '../_colours.php';

	/**
	 * Location of output SCSS file
	 *
	 * @var string
	 */
	var $SCSSFile = '../../resources/src/sass/_colours.scss';

	/**
	 * Location of SCSS template file
	 *
	 * @var string
	 */
	var $SCSSTemplate = 'templates/_colours.tpl.scss';

	/**
	 * Location of PHP template file
	 *
	 * @var string
	 */
	var $PHPTemplate = 'templates/_colours.tpl.php';

	/**
	 * Theme config is loaded to this property
	 *
	 * @var stdClass
	 */
	var $config = NULL;

	/**
	 * SCSS template is loaded and populated to this property
	 *
	 * @var string
	 */
	var $templateSCSSContent = '';

	/**
	 * PHP template is loaded and populated to this property
	 *
	 * @var string
	 */
	var $templatePHPContent = '';


	/**
	 * buildCustomizer constructor.
	 */
	public function __construct() {
		$this->configFile   = __DIR__ . '/' . $this->configFile;
		$this->SCSSFile     = __DIR__ . '/' . $this->SCSSFile;
		$this->SCSSTemplate = __DIR__ . '/' . $this->SCSSTemplate;
		$this->PHPFile      = __DIR__ . '/' . $this->PHPFile;
		$this->PHPTemplate  = __DIR__ . '/' . $this->PHPTemplate;
		$this->loadConfig();
		$this->loadSCSSTemplate();
		$this->loadPHPTemplate();
		$this->populateSCSSTemplate();
		$this->populatePHPTemplate();

		$this->writeSCSSFile();
		$this->writePHPFile();
	}


	/**
	 * Load the relevant contents of the theme config file
	 */
	public function loadConfig() {
		if ( $this->configExists() ) {
			$content      = utf8_encode( file_get_contents( $this->configFile ) );
			$this->config = json_decode( $content );
		}
	}


	/**
	 * Load the SCSS Template file
	 */
	public function loadSCSSTemplate() {
		if ( $this->SCSSTemplateExists() ) {
			$this->templateSCSSContent = file_get_contents( $this->SCSSTemplate );
		}
	}


	/**
	 * Load the PHP Template file
	 */
	public function loadPHPTemplate() {
		if ( $this->PHPTemplateExists() ) {
			$this->templatePHPContent = file_get_contents( $this->PHPTemplate );
		}
	}


	/**
	 * Generate and return the SCSS code from the config file
	 *
	 * return string;
	 */
	public function getColoursSCSSCode() {
		$colour_groups = $this->config->colours;
		$code          = '';

		foreach ( $colour_groups as $group_name => $colours ) {
			$code .= "// " . $group_name . PHP_EOL;

			foreach ( $colours as $slug => $colour ) {
				if ( FALSE === $this->verifyColour( $colour ) ) {
					echo "Incorrectly configured control, skipping" . PHP_EOL;
					var_dump( $colour );

					continue;
				}

				$line = "\$" . $slug . ": " . $colour->colour . ";";
				$code .= $line . str_repeat( ' ', 60 - strlen( $line ) ) . "//" . $colour->name . PHP_EOL;
			}

			$code .= PHP_EOL;
		}

		return $code;
	}


	/**
	 * Generate and return the PHP code from the config file
	 *
	 * return string;
	 */
	public function getColoursPHPCode() {
		$colour_groups = $this->config->colours;
		$code          = '';

		foreach ( $colour_groups as $group_name => $colours ) {
			$code .= "'" . $group_name . "' => [" . PHP_EOL;

			foreach ( $colours as $slug => $colour ) {
				if ( FALSE === $this->verifyColour( $colour ) ) {
					echo "Incorrectly configured control, skipping" . PHP_EOL;
					var_dump( $colour );

					continue;
				}

				$code .= "\t\t\t[" . PHP_EOL;
				$code .= "\t\t\t\t	'name'  => __( '" . $colour->name . "', 'idkomm' )," . PHP_EOL;
				$code .= "\t\t\t\t	'slug'  => '" . $slug . "'," . PHP_EOL;
				$code .= "\t\t\t\t	'color' => '" . $colour->colour . "'," . PHP_EOL;
				$code .= "\t\t\t]," . PHP_EOL;
			}

			$code .= "\t\t]," . PHP_EOL . "\t\t";
		}

		return $code;
	}


	/**
	 * Validate the colour setup
	 *
	 * @param \stdClass $colour
	 *
	 * @return bool
	 */
	public function verifyColour( &$colour ) {

		if ( ! isset( $colour->colour ) ) {
			return FALSE;
		}

		if ( !isset( $colour->name ) ) {
			$colour->name = '';
		}

		if ( empty( $colour->colour ) ) {
			return FALSE;
		}

		return TRUE;
	}


	/**
	 * Apply the config to the content of the SCSS template file
	 */
	public function populateSCSSTemplate() {
		$this->templateSCSSContent = str_replace( '/**THEME_COLOURS**/', $this->getColoursSCSSCode(), $this->templateSCSSContent );
	}


	/**
	 * Output content of SCSS template to SCSS file
	 *
	 * @return bool|int
	 */
	public function writeSCSSFile() {
		return file_put_contents( $this->SCSSFile, $this->templateSCSSContent );
	}


	/**
	 * Apply the config to the content of the PHP template file
	 */
	public function populatePHPTemplate() {
		$this->templatePHPContent = str_replace( '/**THEME_COLOURS**/', $this->getColoursPHPCode(), $this->templatePHPContent );
	}


	/**
	 * Output content of PHP template to PHP file
	 *
	 * @return bool|int
	 */
	public function writePHPFile() {
		return file_put_contents( $this->PHPFile, $this->templatePHPContent );
	}


	/**
	 * Check to see if theme config file exists
	 *
	 * @return bool
	 */
	public function configExists() {
		return file_exists( $this->configFile );
	}


	/**
	 * Check to see if output SCSS file exists
	 *
	 * @return bool
	 */
	public function SCSSFileExists() {
		return file_exists( $this->SCSSFile );
	}


	/**
	 * Check to see if SCSS template exists
	 *
	 * @return bool
	 */
	public function SCSSTemplateExists() {
		return file_exists( $this->SCSSTemplate );
	}


	/**
	 * Check to see if output PHP file exists
	 *
	 * @return bool
	 */
	public function PHPFileExists() {
		return file_exists( $this->PHPFile );
	}


	/**
	 * Check to see if PHP template file exists
	 *
	 * @return bool
	 */
	public function PHPTemplateExists() {
		return file_exists( $this->PHPTemplate );
	}
}

New buildThemeColours();