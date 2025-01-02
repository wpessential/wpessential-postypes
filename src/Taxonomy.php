<?php

namespace WPEssential\Library;

if ( ! \defined( 'ABSPATH' ) )
{
	exit; // Exit if accessed directly.
}

use WPEssential\Library\Helper\Resourceful;

/**
 * Taxonomy
 *
 * API for http://codex.wordpress.org/Function_Reference/register_taxonomy
 */
class Taxonomy extends Registrable
{
	use Resourceful;

	protected $postTypes   = [];
	protected $form        = [];
	protected $existing    = null;
	protected $maxIdLength = 32;

	/**
	 * Make Taxonomy. Do not use before init.
	 *
	 * @param string      $singular singular name is required
	 * @param string|null $plural   plural name
	 * @param array|null  $settings args override and extend
	 * @param string|null $id       taxonomy ID
	 */
	public function __construct ( $singular, $plural = null, $settings = null, $id = null )
	{
		$lowerSingular = strtolower( trim( $singular ) );
		$id            ??= $lowerSingular;

		if ( is_array( $plural ) && is_null( $settings ) )
		{
			$settings = $plural;
			$plural   = null;
		}

		if ( is_null( $settings ) )
		{
			$settings = [];
		}

		if ( empty( $plural ) )
		{
			$plural = strtolower( trim( (string) Inflect::pluralize( $singular ) ) );
		}

		$labelSingular = $singular;
		$labelPlural   = $plural;
		$keep_case     = false;

		if ( ! empty( $settings[ 'labeled' ] ) )
		{
			$labelSingular = $settings[ 'labeled' ][ 0 ] ?? $labelSingular;
			$labelPlural   = $settings[ 'labeled' ][ 1 ] ?? $labelPlural;
			$keep_case     = $settings[ 'labeled' ][ 2 ] ?? $keep_case;
			unset( $settings[ 'labeled' ] );
		}

		if ( empty( $settings[ 'labeled' ] ) )
		{
			$this->applyQuickLabels( $labelSingular, $labelPlural, $keep_case );
		}

		$existing = get_taxonomy( "wpe_{$id}" );

		if ( $existing )
		{
			$this->existing = $existing;

			$singular = Sanitize::underscore( $singular );
			$plural   = Sanitize::underscore( $plural );

			$this->id        = $this->existing->name;
			$args            = (array) $this->existing;
			$this->resource  = [
				'singular'   => $singular,
				'plural'     => $plural,
				'controller' => null
			];
			$this->postTypes = $this->existing->object_type;
			$this->args      = array_merge( $args, $this->args, $settings );
		}

		// setup object for later use
		$plural   = Sanitize::underscore( $plural );
		$singular = Sanitize::underscore( $singular );

		// obj is set on registration
		$this->resource = [
			'singular'   => $singular,
			'plural'     => $plural,
			'controller' => null
		];

		$this->setId( $this->id ? : ( $id ?? $singular ) );

		if ( array_key_exists( 'capabilities', $settings ) && $settings[ 'capabilities' ] === true ) :
			$settings[ 'capabilities' ] = ( new Roles )->getTaxonomyCapabilities( $singular, $plural );
		endif;

		$defaults = [
			'show_admin_column' => false,
			'rewrite'           => [ 'slug' => Sanitize::dash( $plural ) ],
		];

		$this->args = array_merge( $this->args, $defaults, $settings );
	}

	/**
	 * Use Custom Capabilities
	 *
	 * @return Taxonomy $this
	 */
	public function customCapabilities ()
	{
		$cap = ( new Roles )->getTaxonomyCapabilities( $this->resource[ 'singular' ], $this->resource[ 'plural' ] );
		return $this->setArgument( 'capabilities', $cap );
	}

	/**
	 * Apply Quick Labels
	 *
	 * @param string $singular
	 * @param string $plural
	 * @param bool   $keep_case
	 *
	 * @return Taxonomy $this
	 */
	public function applyQuickLabels ( $singular, $plural = null, $keep_case = false )
	{
		if ( ! $plural )
		{
			$plural = Inflect::pluralize( $singular );
		}

		// make lowercase
		$upperPlural   = $keep_case ? $plural : Str::uppercaseWords( $plural );
		$upperSingular = $keep_case ? $singular : Str::uppercaseWords( $singular );
		$lowerPlural   = $keep_case ? $plural : mb_strtolower( (string) $plural );

		$context = 'taxonomy:' . $this->getId();

		$labels = [
			'add_new_item'               => sprintf( _x( 'Add New %s', $context, 'TEXT_DOMAIN' ), $upperSingular ),
			'add_or_remove_items'        => sprintf( _x( 'Add or remove %s', $context, 'TEXT_DOMAIN' ), $lowerPlural ),
			'all_items'                  => sprintf( _x( 'All %s', $context, 'TEXT_DOMAIN' ), $upperPlural ),
			'back_to_items'              => sprintf( _x( '← Back to %s', $context, 'TEXT_DOMAIN' ), $lowerPlural ),
			'choose_from_most_used'      => sprintf( _x( 'Choose from the most used %s', $context, 'TEXT_DOMAIN' ), $lowerPlural ),
			'edit_item'                  => sprintf( _x( 'Edit %s', $context, 'TEXT_DOMAIN' ), $upperSingular ),
			'name'                       => sprintf( _x( '%s', $context . ':taxonomy general name', 'TEXT_DOMAIN' ), $upperPlural ),
			'menu_name'                  => sprintf( _x( '%s', $context . ':admin menu', 'TEXT_DOMAIN' ), $upperPlural ),
			'new_item_name'              => sprintf( _x( 'New %s Name', $context, 'TEXT_DOMAIN' ), $upperSingular ),
			'no_terms'                   => sprintf( _x( 'No %s', $context, 'TEXT_DOMAIN' ), $lowerPlural ),
			'not_found'                  => sprintf( _x( 'No %s found.', $context, 'TEXT_DOMAIN' ), $lowerPlural ),
			'parent_item'                => sprintf( _x( 'Parent %s', $context, 'TEXT_DOMAIN' ), $upperSingular ),
			'parent_item_colon'          => sprintf( _x( 'Parent %s:', $context, 'TEXT_DOMAIN' ), $upperSingular ),
			'popular_items'              => sprintf( _x( 'Popular %s', $context, 'TEXT_DOMAIN' ), $upperPlural ),
			'search_items'               => sprintf( _x( 'Search %s', $context, 'TEXT_DOMAIN' ), $upperPlural ),
			'separate_items_with_commas' => sprintf( _x( 'Separate %s with commas', $context, 'TEXT_DOMAIN' ), $lowerPlural ),
			'singular_name'              => sprintf( _x( '%s', $context . ':taxonomy singular name', 'TEXT_DOMAIN' ), $upperSingular ),
			'update_item'                => sprintf( _x( 'Update %s', $context, 'TEXT_DOMAIN' ), $upperSingular ),
			'view_item'                  => sprintf( _x( 'View %s', $context, 'TEXT_DOMAIN' ), $upperSingular ),
		];

		return $this->setLabels( $labels, $upperPlural, false );;
	}

	/**
	 * Set Labels
	 *
	 * @param array  $labels
	 * @param string $plural
	 * @param bool   $merge
	 *
	 * @return Taxonomy $this
	 */
	public function setLabels ( array $labels, $plural = null, $merge = true )
	{
		$this->args[ 'labels' ] = $merge ? array_merge( $this->args[ 'labels' ] ?? [], $labels ) : $labels;
		$this->args[ 'label' ]  = $plural ?? $this->args[ 'label' ];

		return $this;
	}

	/**
	 * Set Hierarchical
	 *
	 * @param bool $bool
	 *
	 * @return Taxonomy $this
	 */
	public function setHierarchical ( $bool = true )
	{
		return $this->setArgument( 'hierarchical', $bool );
	}

	/**
	 * Get Existing Post Type
	 *
	 * @return \WP_Taxonomy|null
	 */
	public function getExisting ()
	{
		return $this->existing;
	}

	/**
	 * Set the rewrite slug for the post type
	 *
	 * @param string    $slug
	 * @param null|bool $withFront
	 *
	 * @return Taxonomy $this
	 */
	public function setSlug ( $slug, $withFront = null )
	{
		if ( ! is_array( $this->args[ 'rewrite' ] ) )
		{
			$this->args[ 'rewrite' ] = [];
		}

		$this->args[ 'rewrite' ][ 'slug' ] = Sanitize::dash( $slug );

		if ( isset( $withFront ) )
		{
			$this->args[ 'rewrite' ][ 'with_front' ] = $withFront;
		}

		return $this;
	}

	/**
	 * Disable Slug With Front
	 *
	 * @return $this
	 */
	public function disableSlugWithFront ()
	{
		$this->args[ 'rewrite' ][ 'with_front' ] = false;

		return $this;
	}

	/**
	 * Enable Hierarchical Rewrite
	 *
	 * @return $this
	 */
	public function enableHierarchicalSlug ()
	{
		$this->args[ 'rewrite' ][ 'hierarchical' ] = true;

		return $this;
	}

	/**
	 * Set the resource
	 *
	 * @param array $resource
	 *
	 * @return Taxonomy $this
	 */
	public function setResource ( array $resource )
	{
		$this->resource = $resource;

		return $this;
	}

	/**
	 * Get the form hook value by key
	 *
	 * @return mixed
	 */
	public function getMainForm ()
	{
		return $this->form[ 'main' ] ?? null;
	}

	/**
	 * Get the form hook value by key
	 *
	 * @return mixed
	 */
	public function getAddForm ()
	{
		return $this->form[ 'add' ] ?? null;
	}

	/**
	 * Get the form hook value by key
	 *
	 * @return mixed
	 */
	public function getEditForm ()
	{
		return $this->form[ 'edit' ] ?? null;
	}

	/**
	 * Set the form main hook
	 *
	 * From hook to be added just above the title field
	 *
	 * @param bool|true|callable $value
	 *
	 * @return Taxonomy $this
	 */
	public function setMainForm ( $value = true )
	{
		if ( is_callable( $value ) )
		{
			$this->form[ 'main' ] = $value;
		}
		else
		{
			$this->form[ 'main' ] = true;
		}

		return $this;
	}

	/**
	 * Set the form add page hook
	 *
	 * From hook to be added just above the title field
	 *
	 * @param bool|true|callable $value
	 *
	 * @return Taxonomy $this
	 */
	public function setAddForm ( $value = true )
	{
		if ( is_callable( $value ) )
		{
			$this->form[ 'add' ] = $value;
		}
		else
		{
			$this->form[ 'add' ] = true;
		}

		return $this;
	}

	/**
	 * Set the form edit page hook
	 *
	 * From hook to be added just above the title field
	 *
	 * @param bool|true|callable $value
	 *
	 * @return Taxonomy $this
	 */
	public function setEditForm ( $value = true )
	{
		if ( is_callable( $value ) )
		{
			$this->form[ 'edit' ] = $value;
		}
		else
		{
			$this->form[ 'edit' ] = true;
		}

		return $this;
	}

	/**
	 * Get the slug
	 *
	 * @return mixed
	 */
	public function getSlug ()
	{
		return $this->args[ 'rewrite' ][ 'slug' ];
	}

	/**
	 * Show Quick Edit
	 *
	 * @param bool $bool
	 *
	 * Whether to show the taxonomy in the quick/bulk edit panel.
	 *
	 * @return Taxonomy
	 */
	public function showQuickEdit ( $bool = true )
	{
		return $this->setArgument( 'show_in_quick_edit', $bool );
	}

	/**
	 * Show Post Type Admin Column
	 *
	 * Whether to allow automatic creation of taxonomy columns on associated post-types table.
	 *
	 * @param bool $bool
	 *
	 * @return Taxonomy
	 */
	public function showPostTypeAdminColumn ( $bool = true )
	{
		return $this->setArgument( 'show_admin_column', $bool );
	}

	/**
	 * @param bool|string $rest_base  the REST API base path
	 * @param null|string $controller the REST controller default is \WP_REST_Terms_Controller::class
	 *
	 * @return Taxonomy $this
	 */
	public function setRest ( $rest_base = false, $controller = null )
	{
		$this->args[ 'rest_base' ]    = $rest_base ? : $this->id;
		$this->args[ 'show_in_rest' ] = true;
		$controller ? $this->args[ 'rest_controller_class' ] = $controller : null;

		return $this;
	}

	/**
	 * Set the taxonomy to only show in WordPress Admin
	 *
	 * @return Taxonomy $this
	 */
	public function setAdminOnly ()
	{
		$this->args[ 'public' ]            = false;
		$this->args[ 'show_ui' ]           = true;
		$this->args[ 'show_in_nav_menus' ] = true;

		return $this;
	}

	/**
	 * Hide Frontend
	 *
	 * @param bool $bool
	 *
	 * @return $this
	 */
	public function hideFrontend ( $bool = true )
	{
		$this->args[ 'publicly_queryable' ] = ! $bool;

		return $this;
	}

	/**
	 * Hide Admin
	 *
	 * @return Taxonomy $this
	 */
	public function hideAdmin ()
	{
		$this->args[ 'show_ui' ]           = false;
		$this->args[ 'show_in_menu' ]      = false;
		$this->args[ 'show_in_nav_menus' ] = false;

		return $this;
	}

	/**
	 * Register the taxonomy with WordPress
	 *
	 * @return Taxonomy $this
	 */
	public function register ()
	{
		if ( ! $this->existing )
		{
			if ( $this->isReservedId() )
			{
				return $this;
			}
		}
		wpe_add_taxonomy( $this->id, $this->postTypes, $this->args );
		$this->resource[ 'object' ] = $this;
	}

	/**
	 * Apply post types
	 *
	 * @param string|PostType|array $s
	 *
	 * @return Taxonomy $this
	 */
	public function addPostType ( $s )
	{

		if ( $s instanceof PostType )
		{
			$s = $s->getId();
		}
		elseif ( is_array( $s ) )
		{
			foreach ( $s as $n )
			{
				$this->addPostType( $n );
			}
		}

		if ( is_string( $s ) && ! in_array( $s, $this->postTypes, true ) )
		{
			$this->postTypes[] = "wpe_{$s}";
		}

		return $this;
	}
}
