<?php

namespace WPEssential\Library;

if ( ! \defined( 'ABSPATH' ) )
{
	exit; // Exit if accessed directly.
}

abstract class Registrable
{
	protected $use           = [];
	protected $id            = null;
	protected $maxIdLength   = 10000;
	protected $args          = [];
	protected $blocked       = false;
	protected $reservedNames = [
		'attachment',
		'attachment_id',
		'author',
		'author_name',
		'action',
		'calendar',
		'cat',
		'category',
		'category__and',
		'category__in',
		'category__not_in',
		'category_name',
		'comments_per_page',
		'comments_popup',
		'custom_css',
		'customize_messenger_channel',
		'customized',
		'customize_changeset',
		'cpage',
		'day',
		'debug',
		'error',
		'exact',
		'feed',
		'hour',
		'link_category',
		'm',
		'minute',
		'monthnum',
		'more',
		'name',
		'nav_menu',
		'nav_menu_item',
		'nonce',
		'nopaging',
		'oembed_cache',
		'offset',
		'order',
		'orderby',
		'p',
		'page',
		'page_id',
		'paged',
		'pagename',
		'pb',
		'perm',
		'post',
		'post__in',
		'post__not_in',
		'post_format',
		'post_mime_type',
		'post_status',
		'post_tag',
		'post_type',
		'posts',
		'posts_per_archive_page',
		'posts_per_page',
		'preview',
		'robots',
		'revision',
		's',
		'search',
		'second',
		'sentence',
		'showposts',
		'static',
		'subpost',
		'subpost_id',
		'tag',
		'tag__and',
		'tag__in',
		'tag__not_in',
		'tag_id',
		'tag_slug__and',
		'tag_slug__in',
		'taxonomy',
		'tb',
		'term',
		'theme',
		'type',
		'user_request',
		'w',
		'withcomments',
		'withoutcomments',
		'wp_block',
		'year',
	];

	/**
	 * Set the Registrable ID for WordPress to use. Don't use reserved names.
	 *
	 * @param string $id
	 *
	 * @return $this
	 */
	public function setId ( $id )
	{
		$this->id = Sanitize::underscore( $id );
		$this->isReservedId();

		return $this;
	}

	/**
	 * @return int
	 */
	public function getMaxIdLength ()
	{
		return $this->maxIdLength;
	}

	/**
	 * Get the ID
	 *
	 * @return string
	 */
	public function getId ()
	{
		return $this->id;
	}

	/**
	 * Set Arguments
	 *
	 * @param array $args
	 *
	 * @return $this
	 */
	public function setArguments ( array $args )
	{
		$this->args = $args;

		return $this;
	}

	/**
	 * Get Arguments
	 *
	 * @return array
	 */
	public function getArguments ()
	{
		return $this->args;
	}

	/**
	 * Get Argument by key
	 *
	 * @param string $key
	 *
	 * @return string|array
	 */
	public function getArgument ( $key )
	{
		if ( ! array_key_exists( $key, $this->args ) )
		{
			return null;
		}

		return $this->args[ $key ];
	}

	/**
	 * Set Argument by key
	 *
	 * @param string       $key
	 * @param string|array $value
	 *
	 * @return $this
	 */
	public function setArgument ( $key, $value )
	{

		$this->args[ $key ] = $value;

		return $this;
	}

	/**
	 * Remove Argument by key
	 *
	 * @param string $key
	 *
	 * @return $this
	 */
	public function removeArgument ( $key )
	{
		if ( array_key_exists( $key, $this->args ) )
		{
			unset( $this->args[ $key ] );
		}

		return $this;
	}

	/**
	 * Check If Reserved
	 */
	protected function isReservedId ()
	{
		if ( in_array( $this->id, $this->reservedNames ) )
		{
			wp_die( esc_html__( 'You can not register a post type or taxonomy using the WordPress reserved name "%s".', 'TEXT_DOMAIN' ) );
			$this->blocked = true;
			return true;
		}

		return false;
	}

	/**
	 * @return bool
	 */
	public function isBlocked ()
	{
		return $this->blocked;
	}

	/**
	 * Use other Registrable objects or string IDs
	 *
	 * @param array|PostType|Taxonomy $args variadic
	 *
	 * @return $this
	 * @throws \Exception
	 */
	public function apply ( $args )
	{

		if ( ! is_array( $args ) )
		{
			$args = func_get_args();
		}

		if ( ! empty( $args ) && is_array( $args ) )
		{
			$this->use = array_merge( $this->use, $args );
		}

		$this->uses();

		return $this;
	}

	/**
	 * Register with WordPress
	 *
	 * Override this in concrete classes
	 *
	 * @return $this
	 */
	abstract public function register ();

	/**
	 * Used with the apply method to connect Registrable objects together.
	 *
	 * @throws \Exception
	 */
	protected function uses ()
	{
		foreach ( $this->use as $obj )
		{
			if ( $obj instanceof Registrable )
			{
				$class  = get_class( $obj );
				$class  = substr( strrchr( $class, "\\" ), 1 );
				$method = 'add' . $class;
				if ( method_exists( $this, $method ) )
				{
					$this->$method( $obj );
				}
				else
				{
					$current_class = get_class( $this );
					throw new \Exception( 'You are passing the unsupported object ' . $class . ' into ' . $current_class . '.' );
				}
			}
		}
	}

	/**
	 * @param string $id the registered ID
	 *
	 * @return Registrable|PostType|Taxonomy
	 * @throws \Exception
	 */
	public function getAppliedById ( $id )
	{
		foreach ( $this->use as $obj )
		{
			if ( $obj instanceof Registrable )
			{
				if ( $obj->getId() === $id )
				{
					return $obj;
				}
			}
		}

		throw new \Exception( 'Registrable object of ID ' . $id . ' not found.' );
	}

	/**
	 * Get the Use
	 *
	 * @return array
	 */
	public function getApplied ()
	{
		return $this->use;
	}

	/**
	 * @param mixed ...$args
	 *
	 * @return static
	 */
	public static function make ( ...$args )
	{
		return new static( ...$args );
	}

	/**
	 * Add permalink settings to the WordPress admin.
	 *
	 * @return void
	 */
	public function setPermalinkSettings ()
	{
		$field = "{$this->getId()}_permalink";
		$slug  = $this->getSlug();
		$slug  = get_option( $field, $slug );
		$this->setSlug( $slug );

		$this->setPermalinkField( $field, $slug );
		$this->updatePermalink( $field );
		$this->modifyPermalink( $field );

		return $this;
	}

	private function setPermalinkField ( $field, $slug )
	{
		if ( ! function_exists( 'add_settings_field' ) )
		{
			require_once ABSPATH . 'wp-admin/includes/template.php';
		}

		$name = $this->args[ 'labels' ][ 'name' ];
		if ( ! empty( $this->postTypes ) )
		{
			$name = "{$this->args[ 'labels' ][ 'name' ]}: (wpe_{$this->getId()})";
		}

		add_settings_field(
			$field,
			sprintf( esc_html__( '%s', 'TEXT_DOMAIN' ), $name ),
			function () use ( $slug, $field )
			{
				echo '<input type="text" name="' . esc_attr( $field ) . '" value="' . esc_attr( $slug ) . '" class="regular-text">';
			},
			'permalink',
			'optional'
		);

		register_setting( 'permalink', $field );
	}

	private function updatePermalink ( $field )
	{
		global $pagenow;

		if ( isset( $_POST[ $field ] ) && 'options-permalink.php' === $pagenow )
		{
			update_option( $field, sanitize_text_field( $_POST[ $field ] ) );
			flush_rewrite_rules();
		}
	}

	private function modifyPermalink ( $field )
	{
		add_filter( 'rewrite_rules_array', function ( $rules ) use ( $field )
		{
			$custom_field_value = get_option( $field );
			if ( ! empty( $custom_field_value ) )
			{
				$rules[ '^' . $custom_field_value . '/([^/]+)/?$' ] = 'index.php?pagename=$matches[1]';
			}
			return $rules;
		} );
	}
}
