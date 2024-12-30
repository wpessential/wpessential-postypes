<?php

namespace WPEssential\Library;

if ( ! \defined( 'ABSPATH' ) && ! \defined( 'WPE_WIDGETS' ) )
{
	exit; // Exit if accessed directly.
}

/**
 * Class Cpt
 * A helper class to register custom post types in WordPress.
 */
final class Cpt
{
	/**
	 * @var string The name.
	 */
	private $name_string;

	/**
	 * @var string The description.
	 */
	private $description_string;

	/**
	 * @var string The singular name.
	 */
	private $singular_name_string;

	/**
	 * @var string The menu name.
	 */
	private $menu_name_string;

	/**
	 * @var string The admin bar name.
	 */
	private $name_admin_bar_string;

	/**
	 * @var string The add new string.
	 */
	private $add_new_string;

	/**
	 * @var string The add new item string.
	 */
	private $add_new_item_string;

	/**
	 * @var string The new item string.
	 */
	private $new_item_string;

	/**
	 * @var string The edit item string.
	 */
	private $edit_item_string;

	/**
	 * @var string The all items string.
	 */
	private $all_items_string;

	/**
	 * @var string The search items string.
	 */
	private $search_items_string;

	/**
	 * @var string The view item string.
	 */
	private $view_item_string;

	/**
	 * @var string The parent item colon string.
	 */
	private $parent_item_colon_string;

	/**
	 * @var string The not found string.
	 */
	private $not_found_string;

	/**
	 * @var string The not found in trash string.
	 */
	private $not_found_in_trash_string;

	/**
	 * @var string The featured image string.
	 */
	private $featured_image_string;

	/**
	 * @var string The set featured image string.
	 */
	private $set_featured_image_string;

	/**
	 * @var string The remove featured image string.
	 */
	private $remove_featured_image_string;

	/**
	 * @var string The use featured image string.
	 */
	private $use_featured_image_string;

	/**
	 * @var string The archives string.
	 */
	private $archives_string;

	/**
	 * @var string The insert into item string.
	 */
	private $insert_into_item_string;

	/**
	 * @var string The uploaded to this item string.
	 */
	private $uploaded_to_this_item_string;

	/**
	 * @var string The filter items list string.
	 */
	private $filter_items_list_string;

	/**
	 * @var string The items list navigation string.
	 */
	private $items_list_navigation_string;

	/**
	 * @var string The items list string.
	 */
	private $items_list_string;
	/**
	 * @var string The post type key.
	 */
	private $post_type;

	/**
	 * @var array Custom labels for the post type.
	 */
	private $labels = [];

	/**
	 * @var array Arguments for registering the post type.
	 */
	private $args = [];

	/**
	 * @var bool Indicates whether the item is public
	 */
	private $public = false;

	/**
	 * @var bool Indicates whether the item is hierarchical
	 */
	private $hierarchical = false;

	/**
	 * @var mixed Exclude from search status
	 */
	private $exclude_from_search = null;

	/**
	 * @var mixed Publicly queryable status
	 */
	private $publicly_queryable = null;

	/**
	 * @var mixed Show UI status
	 */
	private $show_ui = null;

	/**
	 * @var mixed Show in menu status
	 */
	private $show_in_menu = null;

	/**
	 * @var mixed Show in navigation menus status
	 */
	private $show_in_nav_menus = null;

	/**
	 * @var mixed Show in admin bar status
	 */
	private $show_in_admin_bar = null;

	/**
	 * @var mixed Menu position
	 */
	private $menu_position = null;

	/**
	 * @var mixed Menu icon
	 */
	private $menu_icon = null;

	/**
	 * @var string Capability type
	 */
	private $capability_type = 'post';

	/**
	 * @var array Capabilities of the item
	 */
	private $capabilities = [];

	/**
	 * @var mixed Map meta capabilities status
	 */
	private $map_meta_cap = null;

	/**
	 * @var array Supports for the item
	 */
	private $supports = [];

	/**
	 * @var mixed Register meta box callback
	 */
	private $register_meta_box_cb = null;

	/**
	 * @var array Taxonomies associated with the item
	 */
	private $taxonomies = [];

	/**
	 * @var bool Has archive status
	 */
	private $has_archive = false;

	/**
	 * @var bool Rewrite status
	 */
	private $rewrite = true;

	/**
	 * @var bool Query variable status
	 */
	private $query_var = true;

	/**
	 * @var bool Can export status
	 */
	private $can_export = true;

	/**
	 * @var mixed Delete with user status
	 */
	private $delete_with_user = null;

	/**
	 * @var bool Show in REST API status
	 */
	private $show_in_rest = false;

	/**
	 * @var mixed REST base URL
	 */
	private $rest_base = false;

	/**
	 * @var mixed REST namespace
	 */
	private $rest_namespace = false;

	/**
	 * @var mixed REST controller class
	 */
	private $rest_controller_class = false;

	/**
	 * @var mixed Autosave REST controller class
	 */
	private $autosave_rest_controller_class = false;

	/**
	 * @var mixed Revisions REST controller class
	 */
	private $revisions_rest_controller_class = false;

	/**
	 * @var bool Late route registration status
	 */
	private $late_route_registration = false;

	/**
	 * @var array Template for the item
	 */
	private $template = [];

	/**
	 * @var bool Template lock status
	 */
	private $template_lock = false;

	/**
	 * @var bool Built-in status
	 */
	private $_builtin = false;

	/**
	 * @var string Edit link format
	 */
	private $_edit_link = 'post.php?post=%d';

	// Generate getters and setters for all properties

	public function getName ()
	{
		return $this->name_string;
	}

	public function getDescriptionString ( $description )
	{
		$this->description_string = $description;
	}

	public function setDescriptionString ( $description )
	{
		$this->description_string = $description;
		return $this;
	}

	public function setName ( $name )
	{
		$this->name_string = $name;
		$this->setPostType( Sanitize::underscore( $this->name_string ) );
		return $this;
	}

	public function getSingularName ()
	{
		return $this->singular_name_string;
	}

	public function setSingularName ( $singular_name )
	{
		$this->singular_name_string = $singular_name;
		return $this;
	}

	public function getMenuName ()
	{
		return $this->menu_name_string;
	}

	public function setMenuName ( $menu_name )
	{
		$this->menu_name_string = $menu_name;
		return $this;
	}

	public function getNameAdminBar ()
	{
		return $this->name_admin_bar_string;
	}

	public function setNameAdminBar ( $name_admin_bar )
	{
		$this->name_admin_bar_string = $name_admin_bar;
		return $this;
	}

	public function getAddNewstring ()
	{
		return $this->add_new_string;
	}

	public function setAddNewstring ( $add_new_string )
	{
		$this->add_new_string = $add_new_string;
		return $this;
	}

	public function getAddNewItemstring ()
	{
		return $this->add_new_item_string;
	}

	public function setAddNewItemstring ( $add_new_item_string )
	{
		$this->add_new_item_string = $add_new_item_string;
		return $this;
	}

	public function getNewItemstring ()
	{
		return $this->new_item_string;
	}

	public function setNewItemstring ( $new_item_string )
	{
		$this->new_item_string = $new_item_string;
		return $this;
	}

	public function getEditItemstring ()
	{
		return $this->edit_item_string;
	}

	public function setEditItemstring ( $edit_item_string )
	{
		$this->edit_item_string = $edit_item_string;
		return $this;
	}

	public function getAllItemsstring ()
	{
		return $this->all_items_string;
	}

	public function setAllItemsstring ( $all_items_string )
	{
		$this->all_items_string = $all_items_string;
		return $this;
	}

	public function getSearchItemsstring ()
	{
		return $this->search_items_string;
	}

	public function setSearchItemsstring ( $search_items_string )
	{
		$this->search_items_string = $search_items_string;
		return $this;
	}

	public function getViewItemstring ()
	{
		return $this->view_item_string;
	}

	public function setViewItemstring ( $view_item_string )
	{
		$this->view_item_string = $view_item_string;
		return $this;
	}

	public function getParentItemColonstring ()
	{
		return $this->parent_item_colon_string;
	}

	public function setParentItemColonstring ( $parent_item_colon_string )
	{
		$this->parent_item_colon_string = $parent_item_colon_string;
		return $this;
	}

	public function getNotFoundstring ()
	{
		return $this->not_found_string;
	}

	public function setNotFoundstring ( $not_found_string )
	{
		$this->not_found_string = $not_found_string;
		return $this;
	}

	public function getNotFoundInTrashstring ()
	{
		return $this->not_found_in_trash_string;
	}

	public function setNotFoundInTrashstring ( $not_found_in_trash_string )
	{
		$this->not_found_in_trash_string = $not_found_in_trash_string;
		return $this;
	}

	public function getFeaturedImagestring ()
	{
		return $this->featured_image_string;
	}

	public function setFeaturedImagestring ( $featured_image_string )
	{
		$this->featured_image_string = $featured_image_string;
		return $this;
	}

	public function getSetFeaturedImagestring ()
	{
		return $this->set_featured_image_string;
	}

	public function setSetFeaturedImagestring ( $set_featured_image_string )
	{
		$this->set_featured_image_string = $set_featured_image_string;
		return $this;
	}

	public function getRemoveFeaturedImagestring ()
	{
		return $this->remove_featured_image_string;
	}

	public function setRemoveFeaturedImagestring ( $remove_featured_image_string )
	{
		$this->remove_featured_image_string = $remove_featured_image_string;
		return $this;
	}

	public function getUseFeaturedImagestring ()
	{
		return $this->use_featured_image_string;
	}

	public function setUseFeaturedImagestring ( $use_featured_image_string )
	{
		$this->use_featured_image_string = $use_featured_image_string;
		return $this;
	}

	public function getArchivesstring ()
	{
		return $this->archives_string;
	}

	public function setArchivesstring ( $archives_string )
	{
		$this->archives_string = $archives_string;
		return $this;
	}

	public function getInsertIntoItemstring ()
	{
		return $this->insert_into_item_string;
	}

	public function setInsertIntoItemstring ( $insert_into_item_string )
	{
		$this->insert_into_item_string = $insert_into_item_string;
		return $this;
	}

	public function getUploadedToThisItemstring ()
	{
		return $this->uploaded_to_this_item_string;
	}

	public function setUploadedToThisItemstring ( $uploaded_to_this_item_string )
	{
		$this->uploaded_to_this_item_string = $uploaded_to_this_item_string;
		return $this;
	}

	public function getFilterItemsListstring ()
	{
		return $this->filter_items_list_string;
	}

	public function setFilterItemsListstring ( $filter_items_list_string )
	{
		$this->filter_items_list_string = $filter_items_list_string;
		return $this;
	}

	public function getItemsListNavigationstring ()
	{
		return $this->items_list_navigation_string;
	}

	public function setItemsListNavigationstring ( $items_list_navigation_string )
	{
		$this->items_list_navigation_string = $items_list_navigation_string;
		return $this;
	}

	public function getItemsListstring ()
	{
		return $this->items_list_string;
	}

	public function setItemsListstring ( $items_list_string )
	{
		$this->items_list_string = $items_list_string;
		return $this;
	}

	/**
	 * Create a new instance of the WPECPT class.
	 *
	 * @param string $post_type The key for the custom post type.
	 *
	 * @return self
	 */
	public static function make ( $name )
	{
		return new static( $name );
	}

	public function __construct ( $name )
	{
		$this->setName( $name );
	}

	/**
	 * Set the post type key.
	 *
	 * @param string $post_type The key for the custom post type.
	 *
	 * @return $this
	 */
	public function setPostType ( $post_type )
	{
		$this->post_type = $post_type;
		return $this;
	}

	/**
	 * Get the post type key.
	 *
	 * @return string
	 */
	public function getPostType ()
	{
		return $this->post_type;
	}

	/**
	 * Set custom labels for the post type.
	 *
	 * @param array $labels An array of labels.
	 *
	 * @return $this
	 */
	public function setLabels ( $labels )
	{
		$this->labels = $labels;
		return $this;
	}

	/**
	 * Get the labels for the post type.
	 *
	 * @return array
	 */
	public function getLabels ()
	{
		return $this->labels;
	}

	/**
	 * Set the public status
	 *
	 * @param bool $public
	 *
	 * @return $this
	 */
	public function setPublic ( $public )
	{
		$this->public = $public;
		return $this;
	}

	/**
	 * Get the public status
	 *
	 * @return bool
	 */
	public function getPublic ()
	{
		return $this->public;
	}

	/**
	 * Set the hierarchical status
	 *
	 * @param bool $hierarchical
	 *
	 * @return $this
	 */
	public function setHierarchical ( $hierarchical )
	{
		$this->hierarchical = $hierarchical;
		return $this;
	}

	/**
	 * Get the hierarchical status
	 *
	 * @return bool
	 */
	public function getHierarchical ()
	{
		return $this->hierarchical;
	}

	/**
	 * Set the exclude from search status
	 *
	 * @param mixed $exclude_from_search
	 *
	 * @return $this
	 */
	public function setExcludeFromSearch ( $exclude_from_search )
	{
		$this->exclude_from_search = $exclude_from_search;
		return $this;
	}

	/**
	 * Get the exclude from search status
	 *
	 * @return mixed
	 */
	public function getExcludeFromSearch ()
	{
		return $this->exclude_from_search;
	}

	/**
	 * Set the publicly queryable status
	 *
	 * @param mixed $publicly_queryable
	 *
	 * @return $this
	 */
	public function setPubliclyQueryable ( $publicly_queryable )
	{
		$this->publicly_queryable = $publicly_queryable;
		return $this;
	}

	/**
	 * Get the publicly queryable status
	 *
	 * @return mixed
	 */
	public function getPubliclyQueryable ()
	{
		return $this->publicly_queryable;
	}

	/**
	 * Set the show UI status
	 *
	 * @param mixed $show_ui
	 *
	 * @return $this
	 */
	public function setShowUi ( $show_ui )
	{
		$this->show_ui = $show_ui;
		return $this;
	}

	/**
	 * Get the show UI status
	 *
	 * @return mixed
	 */
	public function getShowUi ()
	{
		return $this->show_ui;
	}

	/**
	 * Set the show in menu status
	 *
	 * @param mixed $show_in_menu
	 *
	 * @return $this
	 */
	public function setShowInMenu ( $show_in_menu )
	{
		$this->show_in_menu = $show_in_menu;
		return $this;
	}

	/**
	 * Get the show in menu status
	 *
	 * @return mixed
	 */
	public function getShowInMenu ()
	{
		return $this->show_in_menu;
	}

	/**
	 * Set the show in navigation menus status
	 *
	 * @param mixed $show_in_nav_menus
	 *
	 * @return $this
	 */
	public function setShowInNavMenus ( $show_in_nav_menus )
	{
		$this->show_in_nav_menus = $show_in_nav_menus;
		return $this;
	}

	/**
	 * Get the show in navigation menus status
	 *
	 * @return mixed
	 */
	public function getShowInNavMenus ()
	{
		return $this->show_in_nav_menus;
	}

	/**
	 * Set the show in admin bar status
	 *
	 * @param mixed $show_in_admin_bar
	 *
	 * @return $this
	 */
	public function setShowInAdminBar ( $show_in_admin_bar )
	{
		$this->show_in_admin_bar = $show_in_admin_bar;
		return $this;
	}

	/**
	 * Get the show in admin bar status
	 *
	 * @return mixed
	 */
	public function getShowInAdminBar ()
	{
		return $this->show_in_admin_bar;
	}

	/**
	 * Set the menu position
	 *
	 * @param mixed $menu_position
	 *
	 * @return $this
	 */
	public function setMenuPosition ( $menu_position )
	{
		$this->menu_position = $menu_position;
		return $this;
	}

	/**
	 * Get the menu position
	 *
	 * @return mixed
	 */
	public function getMenuPosition ()
	{
		return $this->menu_position;
	}

	/**
	 * Set the menu icon
	 *
	 * @param mixed $menu_icon
	 *
	 * @return $this
	 */
	public function setMenuIcon ( $menu_icon )
	{
		$this->menu_icon = $menu_icon;
		return $this;
	}

	/**
	 * Get the menu icon
	 *
	 * @return mixed
	 */
	public function getMenuIcon ()
	{
		return $this->menu_icon;
	}

	/**
	 * Set the capability type
	 *
	 * @param string $capability_type
	 *
	 * @return $this
	 */
	public function setCapabilityType ( $capability_type )
	{
		$this->capability_type = $capability_type;
		return $this;
	}

	/**
	 * Get the capability type
	 *
	 * @return string
	 */
	public function getCapabilityType ()
	{
		return $this->capability_type;
	}

	/**
	 * Set the capabilities
	 *
	 * @param array $capabilities
	 *
	 * @return $this
	 */
	public function setCapabilities ( $capabilities )
	{
		$this->capabilities = $capabilities;
		return $this;
	}

	/**
	 * Get the capabilities
	 *
	 * @return array
	 */
	public function getCapabilities ()
	{
		return $this->capabilities;
	}

	/**
	 * Set the map meta cap status
	 *
	 * @param mixed $map_meta_cap
	 *
	 * @return $this
	 */
	public function setMapMetaCap ( $map_meta_cap )
	{
		$this->map_meta_cap = $map_meta_cap;
		return $this;
	}

	/**
	 * Get the map meta cap status
	 *
	 * @return mixed
	 */
	public function getMapMetaCap ()
	{
		return $this->map_meta_cap;
	}

	/**
	 * Set the supports array
	 *
	 * @param array $supports
	 *
	 * @return $this
	 */
	public function setSupports ( $supports )
	{
		$this->supports = $supports;
		return $this;
	}

	/**
	 * Get the supports array
	 *
	 * @return array
	 */
	public function getSupports ()
	{
		return $this->supports;
	}

	/**
	 * Set the register meta box callback
	 *
	 * @param mixed $register_meta_box_cb
	 *
	 * @return $this
	 */
	public function setRegisterMetaBoxCb ( $register_meta_box_cb )
	{
		$this->register_meta_box_cb = $register_meta_box_cb;
		return $this;
	}

	/**
	 * Get the register meta box callback
	 *
	 * @return mixed
	 */
	public function getRegisterMetaBoxCb ()
	{
		return $this->register_meta_box_cb;
	}

	/**
	 * Set the taxonomies
	 *
	 * @param array $taxonomies
	 *
	 * @return $this
	 */
	public function setTaxonomies ( $taxonomies )
	{
		$this->taxonomies = $taxonomies;
		return $this;
	}

	/**
	 * Get the taxonomies
	 *
	 * @return array
	 */
	public function getTaxonomies ()
	{
		return $this->taxonomies;
	}

	/**
	 * Set the has archive status
	 *
	 * @param bool $has_archive
	 *
	 * @return $this
	 */
	public function setHasArchive ( $has_archive )
	{
		$this->has_archive = $has_archive;
		return $this;
	}

	/**
	 * Get the has archive status
	 *
	 * @return bool
	 */
	public function getHasArchive ()
	{
		return $this->has_archive;
	}

	/**
	 * Set the rewrite status
	 *
	 * @param bool|array $rewrite
	 *
	 * @return $this
	 */
	public function setRewrite ( $rewrite )
	{
		$this->rewrite = $rewrite;
		return $this;
	}

	/**
	 * Get the rewrite status
	 *
	 * @return bool
	 */
	public function getRewrite ()
	{
		return $this->rewrite;
	}

	/**
	 * Set the query variable status
	 *
	 * @param bool $query_var
	 *
	 * @return $this
	 */
	public function setQueryVar ( $query_var )
	{
		$this->query_var = $query_var;
		return $this;
	}

	/**
	 * Get the query variable status
	 *
	 * @return bool
	 */
	public function getQueryVar ()
	{
		return $this->query_var;
	}

	/**
	 * Set the can export status
	 *
	 * @param bool $can_export
	 *
	 * @return $this
	 */
	public function setCanExport ( $can_export )
	{
		$this->can_export = $can_export;
		return $this;
	}

	/**
	 * Get the can export status
	 *
	 * @return bool
	 */
	public function getCanExport ()
	{
		return $this->can_export;
	}

	/**
	 * Set the delete with user status
	 *
	 * @param mixed $delete_with_user
	 *
	 * @return $this
	 */
	public function setDeleteWithUser ( $delete_with_user )
	{
		$this->delete_with_user = $delete_with_user;
		return $this;
	}

	/**
	 * Get the delete with user status
	 *
	 * @return mixed
	 */
	public function getDeleteWithUser ()
	{
		return $this->delete_with_user;
	}

	/**
	 * Set the show in REST API status
	 *
	 * @param bool $show_in_rest
	 *
	 * @return $this
	 */
	public function setShowInRest ( $show_in_rest )
	{
		$this->show_in_rest = $show_in_rest;
		return $this;
	}

	/**
	 * Get the show in REST API status
	 *
	 * @return bool
	 */
	public function getShowInRest ()
	{
		return $this->show_in_rest;
	}

	/**
	 * Set the REST base URL
	 *
	 * @param mixed $rest_base
	 *
	 * @return $this
	 */
	public function setRestBase ( $rest_base )
	{
		$this->rest_base = $rest_base;
		return $this;
	}

	/**
	 * Get the REST base URL
	 *
	 * @return mixed
	 */
	public function getRestBase ()
	{
		return $this->rest_base;
	}

	/**
	 * Set the REST namespace
	 *
	 * @param mixed $rest_namespace
	 *
	 * @return $this
	 */
	public function setRestNamespace ( $rest_namespace )
	{
		$this->rest_namespace = $rest_namespace;
		return $this;
	}

	/**
	 * Get the REST namespace
	 *
	 * @return mixed
	 */
	public function getRestNamespace ()
	{
		return $this->rest_namespace;
	}

	/**
	 * Set the REST controller class
	 *
	 * @param mixed $rest_controller_class
	 *
	 * @return $this
	 */
	public function setRestControllerClass ( $rest_controller_class )
	{
		$this->rest_controller_class = $rest_controller_class;
		return $this;
	}

	/**
	 * Get the REST controller class
	 *
	 * @return mixed
	 */
	public function getRestControllerClass ()
	{
		return $this->rest_controller_class;
	}

	/**
	 * Set the autosave REST controller class
	 *
	 * @param mixed $autosave_rest_controller_class
	 *
	 * @return $this
	 */
	public function setAutosaveRestControllerClass ( $autosave_rest_controller_class )
	{
		$this->autosave_rest_controller_class = $autosave_rest_controller_class;
		return $this;
	}

	/**
	 * Get the autosave REST controller class
	 *
	 * @return mixed
	 */
	public function getAutosaveRestControllerClass ()
	{
		return $this->autosave_rest_controller_class;
	}

	/**
	 * Set the revisions REST controller class
	 *
	 * @param mixed $revisions_rest_controller_class
	 *
	 * @return $this
	 */
	public function setRevisionsRestControllerClass ( $revisions_rest_controller_class )
	{
		$this->revisions_rest_controller_class = $revisions_rest_controller_class;
		return $this;
	}

	/**
	 * Get the revisions REST controller class
	 *
	 * @return mixed
	 */
	public function getRevisionsRestControllerClass ()
	{
		return $this->revisions_rest_controller_class;
	}

	/**
	 * Set the late route registration status
	 *
	 * @param bool $late_route_registration
	 *
	 * @return $this
	 */
	public function setLateRouteRegistration ( $late_route_registration )
	{
		$this->late_route_registration = $late_route_registration;
		return $this;
	}

	/**
	 * Get the late route registration status
	 *
	 * @return bool
	 */
	public function getLateRouteRegistration ()
	{
		return $this->late_route_registration;
	}

	/**
	 * Set the template
	 *
	 * @param array $template
	 *
	 * @return $this
	 */
	public function setTemplate ( $template )
	{
		$this->template = $template;
		return $this;
	}

	/**
	 * Get the template
	 *
	 * @return array
	 */
	public function getTemplate ()
	{
		return $this->template;
	}

	/**
	 * Set the template lock status
	 *
	 * @param bool $template_lock
	 *
	 * @return $this
	 */
	public function setTemplateLock ( $template_lock )
	{
		$this->template_lock = $template_lock;
		return $this;
	}

	/**
	 * Get the template lock status
	 *
	 * @return bool
	 */
	public function getTemplateLock ()
	{
		return $this->template_lock;
	}

	/**
	 * Set the built-in status
	 *
	 * @param bool $_builtin
	 *
	 * @return $this
	 */
	public function setBuiltin ( $_builtin )
	{
		$this->_builtin = $_builtin;
		return $this;
	}

	/**
	 * Get the built-in status
	 *
	 * @return bool
	 */
	public function getBuiltin ()
	{
		return $this->_builtin;
	}

	/**
	 * Set the edit link format
	 *
	 * @param string $_edit_link
	 *
	 * @return $this
	 */
	public function setEditLink ( $_edit_link )
	{
		$this->_edit_link = $_edit_link;
		return $this;
	}

	/**
	 * Get the edit link format
	 *
	 * @return string
	 */
	public function getEditLink ()
	{
		return $this->_edit_link;
	}

	/**
	 * Set arguments for the post type.
	 *
	 * @param array $args An array of arguments.
	 *
	 * @return $this
	 */
	public function setArgs ( $args )
	{
		$this->args = $args;
		return $this;
	}

	/**
	 * Get the arguments for the post type.
	 *
	 * @return array
	 */
	public function getArgs ()
	{
		return $this->args;
	}

	/**
	 * Process the all available args for post types.
	 *
	 * @return void
	 */
	private function processArgs ()
	{
		$args = [
			'public'                          => '',
			'hierarchical'                    => '',
			'exclude_from_search'             => '',
			'publicly_queryable'              => '',
			'show_ui'                         => '',
			'show_in_menu'                    => '',
			'show_in_nav_menus'               => '',
			'show_in_admin_bar'               => '',
			'menu_position'                   => '',
			'menu_icon'                       => '',
			'capability_type'                 => '',
			'capabilities'                    => '',
			'map_meta_cap'                    => '',
			'supports'                        => '',
			'register_meta_box_cb'            => '',
			'taxonomies'                      => '',
			'has_archive'                     => '',
			'rewrite'                         => '',
			'query_var'                       => '',
			'can_export'                      => '',
			'delete_with_user'                => '',
			'show_in_rest'                    => '',
			'rest_base'                       => '',
			'rest_namespace'                  => '',
			'rest_controller_class'           => '',
			'autosave_rest_controller_class'  => '',
			'revisions_rest_controller_class' => '',
			'late_route_registration'         => '',
			'template'                        => '',
			'template_lock'                   => '',
			'_builtin'                        => '',
			'_edit_link'                      => '',
		];

		foreach ( $args as $key => $value )
		{
			wpe_array_set( $args, $key, $this->$key );
		}

		$args[ 'labels' ]      = $this->labels;
		$args[ 'description' ] = $this->description_string;

		$this->setArgs( $args );
	}

	/**
	 * Process the all available labels for post types.
	 *
	 * @return void
	 */
	private function processLabels ()
	{
		$labels = [
			'name'                     => [ _x( 'Posts', 'post type general name', 'TEXT_DOMAIN' ), _x( 'Pages', 'post type general name', 'TEXT_DOMAIN' ) ],
			'singular_name'            => [ _x( 'Post', 'post type singular name', 'TEXT_DOMAIN' ), _x( 'Page', 'post type singular name', 'TEXT_DOMAIN' ) ],
			'add_new'                  => [ esc_html__( 'Add New', 'TEXT_DOMAIN' ), esc_html__( 'Add New', 'TEXT_DOMAIN' ) ],
			'add_new_item'             => [ esc_html__( 'Add New Post', 'TEXT_DOMAIN' ), esc_html__( 'Add New Page', 'TEXT_DOMAIN' ) ],
			'edit_item'                => [ esc_html__( 'Edit Post', 'TEXT_DOMAIN' ), esc_html__( 'Edit Page', 'TEXT_DOMAIN' ) ],
			'new_item'                 => [ esc_html__( 'New Post', 'TEXT_DOMAIN' ), esc_html__( 'New Page', 'TEXT_DOMAIN' ) ],
			'view_item'                => [ esc_html__( 'View Post', 'TEXT_DOMAIN' ), esc_html__( 'View Page', 'TEXT_DOMAIN' ) ],
			'view_items'               => [ esc_html__( 'View Posts', 'TEXT_DOMAIN' ), esc_html__( 'View Pages', 'TEXT_DOMAIN' ) ],
			'search_items'             => [ esc_html__( 'Search Posts', 'TEXT_DOMAIN' ), esc_html__( 'Search Pages', 'TEXT_DOMAIN' ) ],
			'not_found'                => [ esc_html__( 'No posts found.', 'TEXT_DOMAIN' ), esc_html__( 'No pages found.', 'TEXT_DOMAIN' ) ],
			'not_found_in_trash'       => [ esc_html__( 'No posts found in Trash.', 'TEXT_DOMAIN' ), esc_html__( 'No pages found in Trash.', 'TEXT_DOMAIN' ) ],
			'parent_item_colon'        => [ null, esc_html__( 'Parent Page:', 'TEXT_DOMAIN' ) ],
			'all_items'                => [ esc_html__( 'All Posts', 'TEXT_DOMAIN' ), esc_html__( 'All Pages', 'TEXT_DOMAIN' ) ],
			'archives'                 => [ esc_html__( 'Post Archives', 'TEXT_DOMAIN' ), esc_html__( 'Page Archives', 'TEXT_DOMAIN' ) ],
			'attributes'               => [ esc_html__( 'Post Attributes', 'TEXT_DOMAIN' ), esc_html__( 'Page Attributes', 'TEXT_DOMAIN' ) ],
			'insert_into_item'         => [ esc_html__( 'Insert into post', 'TEXT_DOMAIN' ), esc_html__( 'Insert into page', 'TEXT_DOMAIN' ) ],
			'uploaded_to_this_item'    => [ esc_html__( 'Uploaded to this post', 'TEXT_DOMAIN' ), esc_html__( 'Uploaded to this page', 'TEXT_DOMAIN' ) ],
			'featured_image'           => [ _x( 'Featured image', 'post', 'TEXT_DOMAIN' ), _x( 'Featured image', 'page', 'TEXT_DOMAIN' ) ],
			'set_featured_image'       => [ _x( 'Set featured image', 'post', 'TEXT_DOMAIN' ), _x( 'Set featured image', 'page', 'TEXT_DOMAIN' ) ],
			'remove_featured_image'    => [ _x( 'Remove featured image', 'post', 'TEXT_DOMAIN' ), _x( 'Remove featured image', 'page', 'TEXT_DOMAIN' ) ],
			'use_featured_image'       => [ _x( 'Use as featured image', 'post', 'TEXT_DOMAIN' ), _x( 'Use as featured image', 'page', 'TEXT_DOMAIN' ) ],
			'filter_items_list'        => [ esc_html__( 'Filter posts list', 'TEXT_DOMAIN' ), esc_html__( 'Filter pages list', 'TEXT_DOMAIN' ) ],
			'filter_by_date'           => [ esc_html__( 'Filter by date', 'TEXT_DOMAIN' ), esc_html__( 'Filter by date', 'TEXT_DOMAIN' ) ],
			'items_list_navigation'    => [ esc_html__( 'Posts list navigation', 'TEXT_DOMAIN' ), esc_html__( 'Pages list navigation', 'TEXT_DOMAIN' ) ],
			'items_list'               => [ esc_html__( 'Posts list', 'TEXT_DOMAIN' ), esc_html__( 'Pages list', 'TEXT_DOMAIN' ) ],
			'item_published'           => [ esc_html__( 'Post published.', 'TEXT_DOMAIN' ), esc_html__( 'Page published.', 'TEXT_DOMAIN' ) ],
			'item_published_privately' => [ esc_html__( 'Post published privately.', 'TEXT_DOMAIN' ), esc_html__( 'Page published privately.', 'TEXT_DOMAIN' ) ],
			'item_reverted_to_draft'   => [ esc_html__( 'Post reverted to draft.', 'TEXT_DOMAIN' ), esc_html__( 'Page reverted to draft.', 'TEXT_DOMAIN' ) ],
			'item_trashed'             => [ esc_html__( 'Post trashed.', 'TEXT_DOMAIN' ), esc_html__( 'Page trashed.', 'TEXT_DOMAIN' ) ],
			'item_scheduled'           => [ esc_html__( 'Post scheduled.', 'TEXT_DOMAIN' ), esc_html__( 'Page scheduled.', 'TEXT_DOMAIN' ) ],
			'item_updated'             => [ esc_html__( 'Post updated.', 'TEXT_DOMAIN' ), esc_html__( 'Page updated.', 'TEXT_DOMAIN' ) ],
			'item_link'                => [
				_x( 'Post Link', 'navigation link block title', 'TEXT_DOMAIN' ),
				_x( 'Page Link', 'navigation link block title', 'TEXT_DOMAIN' ),
			],
			'item_link_description'    => [
				_x( 'A link to a post.', 'navigation link block description', 'TEXT_DOMAIN' ),
				_x( 'A link to a page.', 'navigation link block description', 'TEXT_DOMAIN' ),
			],
		];

		foreach ( $labels as $key => $value )
		{
			$_value = "{$key}_string";
			wpe_array_set( $labels, $key, $this->$_value ?? $value );
		}

		$this->setLabels( $labels );
	}

	/**
	 * Register the custom post type with WordPress.
	 *
	 * @return void
	 */
	public function register ()
	{
		$this->processLabels();
		$this->processargs();
		$this->addPermalinkSettings();
		wpe_add_post_type( $this->post_type, $this->args );
	}

	/**
	 * Add permalink settings to the WordPress admin.
	 *
	 * @return void
	 */
	public function addPermalinkSettings ()
	{
		if ( ! $this->rewrite ) return;

		$name = $this->name_string;
		$slug = $this->post_type;
		$slug = get_option( $this->post_type . '_permalink', $slug );
		$this->setRewrite( [ 'slug' => $slug ] );

		add_action( 'admin_init', function () use ( $name, $slug )
		{
			add_settings_field(
				$this->post_type . '_permalink',
				sprintf( esc_html__( '%s', 'TEXT_DOMAIN' ), $name ),
				function () use ( $slug )
				{
					echo '<input type="text" name="' . esc_attr( $this->post_type . '_permalink' ) . '" value="' . esc_attr( $slug ) . '" class="regular-text">';
				},
				'permalink',
				'optional'
			);

			register_setting( 'permalink', $this->post_type . '_permalink' );
		} );
	}
}
