<?php

class buildCustomizer {

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
	var $classFile = '../_customizer.php';

	/**
	 * Location of output JS file
	 *
	 * @var string
	 */
	var $JSFile = '../../resources/dist/customizer.js';

	/**
	 * Location of PHP template
	 *
	 * @var string
	 */
	var $classTemplate = 'templates/customizerClass.tpl.php';

	/**
	 * Location of JS template
	 *
	 * @var string
	 */
	var $JSTemplate = 'templates/customizer.tpl.js';

	/**
	 * Config loads to this property
	 *
	 * @var stdClass
	 */
	var $config = NULL;

	/**
	 * PHP template is loaded and populated to this property
	 *
	 * @var string
	 */
	var $templateContent = '';

	/**
	 * JS template is loaded and populated to this property
	 *
	 * @var string
	 */
	var $JSTemplateContent = '';


	/**
	 * buildCustomizer constructor.
	 */
	public function __construct() {
		$this->configFile    = __DIR__ . '/' . $this->configFile;
		$this->classFile     = __DIR__ . '/' . $this->classFile;
		$this->classTemplate = __DIR__ . '/' . $this->classTemplate;
		$this->JSTemplate    = __DIR__ . '/' . $this->JSTemplate;
		$this->JSFile        = __DIR__ . '/' . $this->JSFile;
		$this->loadConfig();
		$this->loadClassTemplate();
		$this->loadJSTemplate();
		$this->populateClassTemplate();
		$this->populateJSTemplate();

		$this->writeJSFile();
		$this->writeClassFile();
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
	 * Load the PHP Template file
	 */
	public function loadClassTemplate() {
		if ( $this->classTemplateExists() ) {
			$this->templateContent = file_get_contents( $this->classTemplate );
		}
	}


	/**
	 * Load the JS Template file
	 */
	public function loadJSTemplate() {
		if ( $this->JSTemplateExists() ) {
			$this->JSTemplateContent = file_get_contents( $this->JSTemplate );
		}
	}


	/**
	 * Generate and return the code for removing default sections
	 *
	 * return string;
	 */
	public function getRemoveSectionCode() {
		$sections = $this->config->customizer->removeSections;
		$code     = '';

		foreach ( $sections as $section ) {
			$code .= "\t\$wp_customize->remove_section( '" . $section . "' );" . PHP_EOL;
		}

		return $code;
	}


	/**
	 * Generate and return the code that adds the custom sections in the config file
	 *
	 * return string;
	 */
	public function getAddSectionCode() {
		$sections = $this->config->customizer->addSections;
		$code     = '';

		foreach ( $sections as $section ) {
			if ( FALSE === $this->verifySection( $section ) ) {
				echo "Incorrectly configured section, skipping" . PHP_EOL;
				var_dump( $section );

				continue;
			}

			$code .= "\t\$wp_customize->add_section( 'idkomm_" . $section->slug . "', [" . PHP_EOL;
			$code .= "\t\t'title'    => __( '" . $section->title . "', 'idkomm' )," . PHP_EOL;
			$code .= "\t\t'priority' => " . $section->priority . "," . PHP_EOL;
			$code .= "\t] );" . PHP_EOL . PHP_EOL;
		}

		return $code;
	}


	/**
	 * Generate and return the code that add the custom controls in the config file
	 *
	 * return string;
	 */
	public function getAddControlCode() {
		$controls = $this->config->customizer->addControls;
		$code     = '';

		foreach ( $controls as $control ) {
			if ( FALSE === $this->verifyControl( $control ) ) {
				echo "Incorrectly configured control, skipping" . PHP_EOL;
				var_dump( $control );

				continue;
			}

			switch ($control->type) {

				case( "WP_Customize_Color_Control" ):
				case( "WP_Customize_Image_Control" ):
				case( "WP_Customize_Upload_Control" ):
				case( "WP_Customize_Background_Image_Control" ):
				case( "WP_Customize_Header_Image_Control" ):

					$code .= "\t\$wp_customize->add_setting( 'idkomm_" . $control->slug . "', " . PHP_EOL;
					$code .= "\t\tarray( 'default' => '" . $control->default . "', 'sanitize_callback' => '" . $control->sanitize_callback . "', 'transport' => '" . $control->live_preview . "' ) );" . PHP_EOL;
					$code .= "\t\$wp_customize->add_control(" . PHP_EOL;
					$code .= "\t\tnew " . $control->type . "(" .PHP_EOL;
					$code .= "\t\t\t\$wp_customize, " . PHP_EOL;
					$code .= "\t\t\t'idkomm_" . $control->slug . "'," . PHP_EOL;
					$code .= "\t\t\tarray(" . PHP_EOL;
					$code .= "\t\t\t'label'             => __( '" . $control->label . "', 'idkomm' )," . PHP_EOL;
					$code .= "\t\t\t'description'       => __( '" . $control->description . "', 'idkomm' )," . PHP_EOL;

					// Take either an array of choices or a callback
					if ( isset( $control->choices ) && is_object( $control->choices ) ) {
						$choices = $this->stringifyChoices( $control->choices );
						$code    .= "\t\t\t'choices'           => " . $choices . "," . PHP_EOL;
					} elseif ( isset( $control->choices ) && is_string( $control->choices ) ) {
						$code .= "\t\t\t'choices'           => '" . $control->choices . "'," . PHP_EOL;
					}
					$code .= "\t\t\t'section'           => 'idkomm_" . $control->section . "'," . PHP_EOL;
					$code .= "\t\t\t'priority'          => " . $control->priority . "," . PHP_EOL;
					$code .= "\t\t) )" . PHP_EOL;
					$code .= "\t);" . PHP_EOL . PHP_EOL;


					break;

				default:

					$code .= "\t\$wp_customize->add_setting( 'idkomm_" . $control->slug . "', " . PHP_EOL;
					$code .= "\t\tarray( 'default' => '" . $control->default . "', 'sanitize_callback' => '" . $control->sanitize_callback . "', 'transport' => '" . $control->live_preview . "' ) );" . PHP_EOL;
					$code .= "\t\$wp_customize->add_control( 'idkomm_" . $control->slug . "', [" . PHP_EOL;
					$code .= "\t\t'label'             => __( '" . $control->label . "', 'idkomm' )," . PHP_EOL;
					$code .= "\t\t'type'              => '" . $control->type . "'," . PHP_EOL;
					$code .= "\t\t'description'       => __( '" . $control->description . "', 'idkomm' )," . PHP_EOL;

					// Take either an array of choices or a callback
					if ( isset( $control->choices ) && is_object( $control->choices ) ) {
						$choices = $this->stringifyChoices( $control->choices );
						$code    .= "\t\t'choices'           => " . $choices . "," . PHP_EOL;
					} elseif ( isset( $control->choices ) && is_string( $control->choices ) ) {
						$code .= "\t\t'choices'           => '" . $control->choices . "'," . PHP_EOL;
					}
					$code .= "\t\t'section'           => 'idkomm_" . $control->section . "'," . PHP_EOL;
					$code .= "\t\t'priority'          => " . $control->priority . "," . PHP_EOL;
					$code .= "\t] );" . PHP_EOL . PHP_EOL;

					break;
			}

		}

		return $code;
	}


	/**
	 * Generate a getter function for every setting in the config file
	 *
	 * return string;
	 */
	public function getAddGetterCode() {
		$controls = $this->config->customizer->addControls;
		$getters  = '';

		foreach ( $controls as $control ) {
			if ( FALSE === $this->verifyControl( $control ) ) {
				echo "Incorrectly configured control, skipping" . PHP_EOL;
				var_dump( $control );

				continue;
			}

			$getters .= "/**" . PHP_EOL;
			$getters .= " * @return string" . PHP_EOL;
			$getters .= " */" . PHP_EOL;

			$getters .= "function idkomm_get_" . $control->slug . "() {" . PHP_EOL;
			$getters .= "\treturn get_theme_mod( 'idkomm_" . $control->slug . "' );" . PHP_EOL;
			$getters .= "}" . PHP_EOL . PHP_EOL;
		}

		return $getters;
	}


	/**
	 * Generate a Twig filter for every getter function
	 *
	 * return string;
	 */
	public function getAddTwigFilterCode() {
		$controls = $this->config->customizer->addControls;
		$filters  = '';

		foreach ( $controls as $control ) {
			if ( FALSE === $this->verifyControl( $control ) ) {
				echo "Incorrectly configured control, skipping" . PHP_EOL;
				var_dump( $control );

				continue;
			}

			$filters .= "\t\$twig->addFunction( new Timber\Twig_Function( 'idkomm_get_" . $control->slug . "', function () {" . PHP_EOL;
			$filters .= "\t\treturn idkomm_get_" . $control->slug . "();" . PHP_EOL;
			$filters .= "\t} ) );" . PHP_EOL . PHP_EOL;
		}

		return $filters;
	}


	/**
	 * Generate JS code to manage live preview
	 *
	 * return string;
	 */
	public function getJSCode() {
		$controls = $this->config->customizer->addControls;
		$code     = '';

		foreach ( $controls as $control ) {
			if ( FALSE === $this->verifyControl( $control ) ) {
				echo "Incorrectly configured control, skipping" . PHP_EOL;
				var_dump( $control );

				continue;
			}


			if ( $control->live_preview == "postMessage" && ! empty( $control->selector ) && ! empty( $control->attribute ) ) {

				$code .= "\twp.customize( 'idkomm_" . $control->slug . "', function( value ) {" . PHP_EOL;
				$code .= "\t\tvalue.bind( function( new_value ) {" . PHP_EOL;

				if (empty($control->attribute_type)) {
					$code .= "\t\t\t\$('" . $control->selector . "')." . $control->attribute . "(new_value.nl2br());" . PHP_EOL;
				} else {
					$code .= "\t\t\t\$('" . $control->selector . "')." . $control->attribute . "('" . $control->attribute_type . "', new_value);" . PHP_EOL;
				}

				$code .= "\t\t} );" . PHP_EOL;
				$code .= "\t} );" . PHP_EOL;

			}
		}

		return $code;
	}


	/**
	 * Verify the setup for a section
	 *
	 * @param \stdClass $section
	 *
	 * @return bool
	 */
	public function verifySection( &$section ) {

		if (
			! isset( $section->slug ) ||
			! isset( $section->title )
		) {
			return FALSE;
		}

		if ( ! isset( $section->priority ) ) {
			$section->priority = 0;
		}

		return true;
	}


	/**
	 * Verify the setup for a control
	 *
	 * @param \stdClass $control
	 *
	 * @return bool
	 */
	public function verifyControl( &$control ) {

		if (
			! isset( $control->slug ) ||
			! isset( $control->label ) ||
			! isset( $control->section ) ||
			! isset( $control->type )
		) {
			return FALSE;
		}

		if (
			empty( $control->slug ) ||
			empty( $control->label ) ||
			empty( $control->section ) ||
			empty( $control->type )
		) {
			return FALSE;
		}

		if ( ! isset( $control->sanitize_callback ) ) {
			$control->sanitize_callback = "";
		}

		if ( ! isset( $control->default ) ) {
			$control->default = "";
		}

		if ( ! isset( $control->description ) ) {
			$control->description = "";
		}

		if ( ! isset( $control->live_preview ) ) {
			$control->live_preview = "refresh";
		}

		if ( ! isset( $control->priority ) ) {
			$control->priority = 0;
		}

		return TRUE;
	}


	/**
	 * Apply the config to the content of the class file
	 */
	public function populateClassTemplate() {
		$this->templateContent = str_replace( '/**REMOVE_SECTIONS**/', $this->getRemoveSectionCode(), $this->templateContent );
		$this->templateContent = str_replace( '/**ADD_SECTIONS**/', $this->getAddSectionCode(), $this->templateContent );
		$this->templateContent = str_replace( '/**ADD_CONTROLS**/', $this->getAddControlCode(), $this->templateContent );
		$this->templateContent = str_replace( '/**ADD_GETTERS**/', $this->getAddGetterCode(), $this->templateContent );
		$this->templateContent = str_replace( '/**ADD_TWIG_FILTERS**/', $this->getAddTwigFilterCode(), $this->templateContent );
	}


	/**
	 * Apply the config to the content of the JS file
	 */
	public function populateJSTemplate() {
		$this->JSTemplateContent = str_replace( '/**BINDINGS**/', $this->getJSCode(), $this->JSTemplateContent );
	}


	/**
	 * Dump the template contents to the output PHP file
	 *
	 * @return bool|int
	 */
	public function writeClassFile() {
		return file_put_contents( $this->classFile, $this->templateContent );
	}


	/**
	 * Dump the template contents to the output JS file
	 *
	 * @return bool|int
	 */
	public function writeJSFile() {
		return file_put_contents( $this->JSFile, $this->JSTemplateContent );
	}


	/**
	 * Check to see if config file exists
	 *
	 * @return bool
	 */
	public function configExists() {
		return file_exists( $this->configFile );
	}


	/**
	 * Check to see if PHP file exists
	 *
	 * @return bool
	 */
	public function classFileExists() {
		return file_exists( $this->classFile );
	}


	/**
	 * Check to see if PHP template file exists
	 *
	 * @return bool
	 */
	public function classTemplateExists() {
		return file_exists( $this->classTemplate );
	}


	/**
	 * Check to see if JS Template file exists
	 *
	 * @return bool
	 */
	public function JSTemplateExists() {
		return file_exists( $this->JSTemplate );
	}


	/**
	 * Convert an indexed array to PHP code
	 *
	 * @param \stdClass $choices
	 *
	 * @return string
	 */
	public function stringifyChoices( $choices ) {
		$string  = '[';
		$choices = (array) $choices;

		foreach ( $choices as $key => $value ) {
			$string .= '"' . $key . '" => "' . $value . '", ';
		}

		$string .= ']';

		return $string;
	}
}

New buildCustomizer();