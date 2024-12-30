<?php

namespace WPEssential\Library;

if ( ! \defined( 'ABSPATH' ) )
{
	exit; // Exit if accessed directly.
}

/**
 * Class Ctxm
 * Handles the taxonomy labels for tags and categories.
 */
class Ctxm
{
	// Private parameters
	private $name_string;
	private $description_string;
	private $singular_name_string;
	private $search_items_string;
	private $popular_items_string;
	private $all_items_string;
	private $parent_item_string;
	private $parent_item_colon_string;
	private $name_field_description_string;
	private $slug_field_description_string;
	private $parent_field_description_string;
	private $desc_field_description_string;
	private $edit_item_string;
	private $view_item_string;
	private $update_item_string;
	private $add_new_item_string;
	private $new_item_name_string;
	private $separate_items_with_commas_string;
	private $add_or_remove_items_string;
	private $choose_from_most_used_string;
	private $not_found_string;
	private $no_terms_string;
	private $filter_by_item_string;
	private $items_list_navigation_string;
	private $items_list_string;
	private $most_used_string;
	private $back_to_items_string;
	private $item_link_string;
	private $item_link_description_string;
	/**
	 * @var string The post type key.
	 */
	private $post_type;

	/**
	 * @var string The tax type key.
	 */
	private $tax_type;

	/**
	 * @var array Custom labels.
	 */
	private $labels = [];

	/**
	 * @var bool|null
	 */
	private $public = true;

	/**
	 * @var bool|null
	 */
	private $publiclyQueryable = null;

	/**
	 * @var bool
	 */
	private $hierarchical = false;

	/**
	 * @var bool|null
	 */
	private $showUi = null;

	/**
	 * @var bool|null
	 */
	private $showInMenu = null;

	/**
	 * @var bool|null
	 */
	private $showInNavMenus = null;

	/**
	 * @var bool|null
	 */
	private $showTagCloud = null;

	/**
	 * @var bool|null
	 */
	private $showInQuickEdit = null;

	/**
	 * @var bool
	 */
	private $showAdminColumn = false;

	/**
	 * @var mixed|null
	 */
	private $metaBoxCb = null;

	/**
	 * @var mixed|null
	 */
	private $metaBoxSanitizeCb = null;

	/**
	 * @var array
	 */
	private $capabilities = [];

	/**
	 * @var bool
	 */
	private $rewrite = true;

	/**
	 * @var string
	 */
	private $queryVar;

	/**
	 * @var string
	 */
	private $updateCountCallback = '';

	/**
	 * @var bool
	 */
	private $showInRest = false;

	/**
	 * @var bool|null
	 */
	private $restBase = false;

	/**
	 * @var bool|null
	 */
	private $restNamespace = false;

	/**
	 * @var bool|null
	 */
	private $restControllerClass = false;

	/**
	 * @var mixed|null
	 */
	private $defaultTerm = null;

	/**
	 * @var mixed|null
	 */
	private $sort = null;

	/**
	 * @var mixed|null
	 */
	private $args = null;

	/**
	 * @var bool
	 */
	private $_builtin = false;

	/**
	 * Create a new instance of the WPECPT class.
	 *
	 * @param string $post_type The key for the custom post type where to apply.
	 * @param string $name      The the custom taxonomy name.
	 *
	 * @return self
	 */

	public static function make ( $post_type, $name )
	{
		return new static( $post_type, $name );
	}

	public function __construct ( $post_type, $name )
	{
		$this->setPostType( "wpe_{$post_type}" );
		$this->setNameString( $name );
	}

	/**
	 * Set the value of name_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setNameString ( $value )
	{
		$this->name_string = $value;
		$this->setTaxType( Sanitize::underscore( $this->name_string ) );
		return $this;
	}

	/**
	 * Get the value of name_string
	 *
	 * @return string
	 */
	public function getNameString ()
	{
		return $this->name_string;
	}

	/**
	 * Get the value of description_string
	 *
	 * @return string
	 */
	public function getDescriptionString ( $description )
	{
		return $this->description_string = $description;
	}

	/**
	 * Get the value of description_string
	 *
	 * @return $this
	 */
	public function setDescriptionString ( $description )
	{
		$this->description_string = $description;
		return $this;
	}

	/**
	 * Set the value of singular_name_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setSingularNameString ( $value )
	{
		$this->singular_name_string = $value;
		return $this;
	}

	/**
	 * Get the value of singular_name_string
	 *
	 * @return string
	 */
	public function getSingularNameString ()
	{
		return $this->singular_name_string;
	}

	/**
	 * Set the value of search_items_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setSearchItemsString ( $value )
	{
		$this->search_items_string = $value;
		return $this;
	}

	/**
	 * Get the value of search_items_string
	 *
	 * @return string
	 */
	public function getSearchItemsString ()
	{
		return $this->search_items_string;
	}

	/**
	 * Set the value of popular_items_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setPopularItemsString ( $value )
	{
		$this->popular_items_string = $value;
		return $this;
	}

	/**
	 * Get the value of popular_items_string
	 *
	 * @return string
	 */
	public function getPopularItemsString ()
	{
		return $this->popular_items_string;
	}

	/**
	 * Set the value of all_items_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setAllItemsString ( $value )
	{
		$this->all_items_string = $value;
		return $this;
	}

	/**
	 * Get the value of all_items_string
	 *
	 * @return string
	 */
	public function getAllItemsString ()
	{
		return $this->all_items_string;
	}

	/**
	 * Set the value of parent_item_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setParentItemString ( $value )
	{
		$this->parent_item_string = $value;
		return $this;
	}

	/**
	 * Get the value of parent_item_string
	 *
	 * @return string
	 */
	public function getParentItemString ()
	{
		return $this->parent_item_string;
	}

	/**
	 * Set the value of parent_item_colon_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setParentItemColonString ( $value )
	{
		$this->parent_item_colon_string = $value;
		return $this;
	}

	/**
	 * Get the value of parent_item_colon_string
	 *
	 * @return string
	 */
	public function getParentItemColonString ()
	{
		return $this->parent_item_colon_string;
	}

	/**
	 * Set the value of name_field_description_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setNameFieldDescriptionString ( $value )
	{
		$this->name_field_description_string = $value;
		return $this;
	}

	/**
	 * Get the value of name_field_description_string
	 *
	 * @return string
	 */
	public function getNameFieldDescriptionString ()
	{
		return $this->name_field_description_string;
	}

	/**
	 * Set the value of slug_field_description_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setSlugFieldDescriptionString ( $value )
	{
		$this->slug_field_description_string = $value;
		return $this;
	}

	/**
	 * Get the value of slug_field_description_string
	 *
	 * @return string
	 */
	public function getSlugFieldDescriptionString ()
	{
		return $this->slug_field_description_string;
	}

	/**
	 * Set the value of parent_field_description_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setParentFieldDescriptionString ( $value )
	{
		$this->parent_field_description_string = $value;
		return $this;
	}

	/**
	 * Get the value of parent_field_description_string
	 *
	 * @return string
	 */
	public function getParentFieldDescriptionString ()
	{
		return $this->parent_field_description_string;
	}

	/**
	 * Set the value of desc_field_description_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setDescFieldDescriptionString ( $value )
	{
		$this->desc_field_description_string = $value;
		return $this;
	}

	/**
	 * Get the value of desc_field_description_string
	 *
	 * @return string
	 */
	public function getDescFieldDescriptionString ()
	{
		return $this->desc_field_description_string;
	}

	/**
	 * Set the value of edit_item_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setEditItemString ( $value )
	{
		$this->edit_item_string = $value;
		return $this;
	}

	/**
	 * Get the value of edit_item_string
	 *
	 * @return string
	 */
	public function getEditItemString ()
	{
		return $this->edit_item_string;
	}

	/**
	 * Set the value of view_item_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setViewItemString ( $value )
	{
		$this->view_item_string = $value;
		return $this;
	}

	/**
	 * Get the value of view_item_string
	 *
	 * @return string
	 */
	public function getViewItemString ()
	{
		return $this->view_item_string;
	}

	/**
	 * Set the value of update_item_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setUpdateItemString ( $value )
	{
		$this->update_item_string = $value;
		return $this;
	}

	/**
	 * Get the value of update_item_string
	 *
	 * @return string
	 */
	public function getUpdateItemString ()
	{
		return $this->update_item_string;
	}

	/**
	 * Set the value of add_new_item_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setAddNewItemString ( $value )
	{
		$this->add_new_item_string = $value;
		return $this;
	}

	/**
	 * Get the value of add_new_item_string
	 *
	 * @return string
	 */
	public function getAddNewItemString ()
	{
		return $this->add_new_item_string;
	}

	/**
	 * Set the value of new_item_name_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setNewItemNameString ( $value )
	{
		$this->new_item_name_string = $value;
		return $this;
	}

	/**
	 * Get the value of new_item_name_string
	 *
	 * @return string
	 */
	public function getNewItemNameString ()
	{
		return $this->new_item_name_string;
	}

	/**
	 * Set the value of separate_items_with_commas_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setSeparateItemsWithCommasString ( $value )
	{
		$this->separate_items_with_commas_string = $value;
		return $this;
	}

	/**
	 * Get the value of separate_items_with_commas_string
	 *
	 * @return string
	 */
	public function getSeparateItemsWithCommasString ()
	{
		return $this->separate_items_with_commas_string;
	}

	/**
	 * Set the value of add_or_remove_items_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setAddOrRemoveItemsString ( $value )
	{
		$this->add_or_remove_items_string = $value;
		return $this;
	}

	/**
	 * Get the value of add_or_remove_items_string
	 *
	 * @return string
	 */
	public function getAddOrRemoveItemsString ()
	{
		return $this->add_or_remove_items_string;
	}

	/**
	 * Set the value of choose_from_most_used_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setChooseFromMostUsedString ( $value )
	{
		$this->choose_from_most_used_string = $value;
		return $this;
	}

	/**
	 * Get the value of choose_from_most_used_string
	 *
	 * @return string
	 */
	public function getChooseFromMostUsedString ()
	{
		return $this->choose_from_most_used_string;
	}

	/**
	 * Set the value of not_found_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setNotFoundString ( $value )
	{
		$this->not_found_string = $value;
		return $this;
	}

	/**
	 * Get the value of not_found_string
	 *
	 * @return string
	 */
	public function getNotFoundString ()
	{
		return $this->not_found_string;
	}

	/**
	 * Set the value of no_terms_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setNoTermsString ( $value )
	{
		$this->no_terms_string = $value;
		return $this;
	}

	/**
	 * Get the value of no_terms_string
	 *
	 * @return string
	 */
	public function getNoTermsString ()
	{
		return $this->no_terms_string;
	}

	/**
	 * Set the value of filter_by_item_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setFilterByItemString ( $value )
	{
		$this->filter_by_item_string = $value;
		return $this;
	}

	/**
	 * Get the value of filter_by_item_string
	 *
	 * @return string
	 */
	public function getFilterByItemString ()
	{
		return $this->filter_by_item_string;
	}

	/**
	 * Set the value of items_list_navigation_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setItemsListNavigationString ( $value )
	{
		$this->items_list_navigation_string = $value;
		return $this;
	}

	/**
	 * Get the value of items_list_navigation_string
	 *
	 * @return string
	 */
	public function getItemsListNavigationString ()
	{
		return $this->items_list_navigation_string;
	}

	/**
	 * Set the value of items_list_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setItemsListString ( $value )
	{
		$this->items_list_string = $value;
		return $this;
	}

	/**
	 * Get the value of items_list_string
	 *
	 * @return string
	 */
	public function getItemsListString ()
	{
		return $this->items_list_string;
	}

	/**
	 * Set the value of most_used_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setMostUsedString ( $value )
	{
		$this->most_used_string = $value;
		return $this;
	}

	/**
	 * Get the value of most_used_string
	 *
	 * @return string
	 */
	public function getMostUsedString ()
	{
		return $this->most_used_string;
	}

	/**
	 * Set the value of back_to_items_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setBackToItemsString ( $value )
	{
		$this->back_to_items_string = $value;
		return $this;
	}

	/**
	 * Get the value of back_to_items_string
	 *
	 * @return string
	 */
	public function getBackToItemsString ()
	{
		return $this->back_to_items_string;
	}

	/**
	 * Set the value of item_link_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setItemLinkString ( $value )
	{
		$this->item_link_string = $value;
		return $this;
	}

	/**
	 * Get the value of item_link_string
	 *
	 * @return string
	 */
	public function getItemLinkString ()
	{
		return $this->item_link_string;
	}

	/**
	 * Set the value of item_link_description_string
	 *
	 * @param string $value
	 *
	 * @return Ctxm
	 */
	public function setItemLinkDescriptionString ( $value )
	{
		$this->item_link_description_string = $value;
		return $this;
	}

	/**
	 * Get the value of item_link_description_string
	 *
	 * @return string
	 */
	public function getItemLinkDescriptionString ()
	{
		return $this->item_link_description_string;
	}

	/**
	 * Set the value of public
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
	 * Get the value of public
	 *
	 * @return bool
	 */
	public function getPublic ()
	{
		return $this->public;
	}

	/**
	 * Set the value of publicly_queryable
	 *
	 * @param bool|null $publicly_queryable
	 *
	 * @return $this
	 */
	public function setPubliclyQueryable ( $publicly_queryable )
	{
		$this->publicly_queryable = $publicly_queryable;
		return $this;
	}

	/**
	 * Get the value of publicly_queryable
	 *
	 * @return bool|null
	 */
	public function getPubliclyQueryable ()
	{
		return $this->publicly_queryable;
	}

	/**
	 * Set the value of hierarchical
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
	 * Get the value of hierarchical
	 *
	 * @return bool
	 */
	public function getHierarchical ()
	{
		return $this->hierarchical;
	}

	/**
	 * Set the value of show_ui
	 *
	 * @param bool|null $show_ui
	 *
	 * @return $this
	 */
	public function setShowUi ( $show_ui )
	{
		$this->show_ui = $show_ui;
		return $this;
	}

	/**
	 * Get the value of show_ui
	 *
	 * @return bool|null
	 */
	public function getShowUi ()
	{
		return $this->show_ui;
	}

	/**
	 * Set the value of show_in_menu
	 *
	 * @param bool|null $show_in_menu
	 *
	 * @return $this
	 */
	public function setShowInMenu ( $show_in_menu )
	{
		$this->show_in_menu = $show_in_menu;
		return $this;
	}

	/**
	 * Get the value of show_in_menu
	 *
	 * @return bool|null
	 */
	public function getShowInMenu ()
	{
		return $this->show_in_menu;
	}

	/**
	 * Set the value of show_in_nav_menus
	 *
	 * @param bool|null $show_in_nav_menus
	 *
	 * @return $this
	 */
	public function setShowInNavMenus ( $show_in_nav_menus )
	{
		$this->show_in_nav_menus = $show_in_nav_menus;
		return $this;
	}

	/**
	 * Get the value of show_in_nav_menus
	 *
	 * @return bool|null
	 */
	public function getShowInNavMenus ()
	{
		return $this->show_in_nav_menus;
	}

	/**
	 * Set the value of show_tagcloud
	 *
	 * @param bool|null $show_tagcloud
	 *
	 * @return $this
	 */
	public function setShowTagCloud ( $show_tagcloud )
	{
		$this->show_tagcloud = $show_tagcloud;
		return $this;
	}

	/**
	 * Get the value of show_tagcloud
	 *
	 * @return bool|null
	 */
	public function getShowTagCloud ()
	{
		return $this->show_tagcloud;
	}

	/**
	 * Set the value of show_in_quick_edit
	 *
	 * @param bool|null $show_in_quick_edit
	 *
	 * @return $this
	 */
	public function setShowInQuickEdit ( $show_in_quick_edit )
	{
		$this->show_in_quick_edit = $show_in_quick_edit;
		return $this;
	}

	/**
	 * Get the value of show_in_quick_edit
	 *
	 * @return bool|null
	 */
	public function getShowInQuickEdit ()
	{
		return $this->show_in_quick_edit;
	}

	/**
	 * Set the value of show_admin_column
	 *
	 * @param bool $show_admin_column
	 *
	 * @return $this
	 */
	public function setShowAdminColumn ( $show_admin_column )
	{
		$this->show_admin_column = $show_admin_column;
		return $this;
	}

	/**
	 * Get the value of show_admin_column
	 *
	 * @return bool
	 */
	public function getShowAdminColumn ()
	{
		return $this->show_admin_column;
	}

	/**
	 * Set the value of meta_box_cb
	 *
	 * @param mixed $meta_box_cb
	 *
	 * @return $this
	 */
	public function setMetaBoxCb ( $meta_box_cb )
	{
		$this->meta_box_cb = $meta_box_cb;
		return $this;
	}

	/**
	 * Get the value of meta_box_cb
	 *
	 * @return mixed
	 */
	public function getMetaBoxCb ()
	{
		return $this->meta_box_cb;
	}

	/**
	 * Set the value of meta_box_sanitize_cb
	 *
	 * @param mixed $meta_box_sanitize_cb
	 *
	 * @return $this
	 */
	public function setMetaBoxSanitizeCb ( $meta_box_sanitize_cb )
	{
		$this->meta_box_sanitize_cb = $meta_box_sanitize_cb;
		return $this;
	}

	/**
	 * Get the value of meta_box_sanitize_cb
	 *
	 * @return mixed
	 */
	public function getMetaBoxSanitizeCb ()
	{
		return $this->meta_box_sanitize_cb;
	}

	/**
	 * Set the value of capabilities
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
	 * Get the value of capabilities
	 *
	 * @return array
	 */
	public function getCapabilities ()
	{
		return $this->capabilities;
	}

	/**
	 * Set the value of rewrite
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
	 * Get the value of rewrite
	 *
	 * @return bool
	 */
	public function getRewrite ()
	{
		return $this->rewrite;
	}

	/**
	 * Set the value of query_var
	 *
	 * @param string $query_var
	 *
	 * @return $this
	 */
	public function setQueryVar ( $query_var )
	{
		$this->query_var = $query_var;
		return $this;
	}

	/**
	 * Get the value of query_var
	 *
	 * @return string
	 */
	public function getQueryVar ()
	{
		return $this->query_var;
	}

	/**
	 * Set the value of update_count_callback
	 *
	 * @param string $update_count_callback
	 *
	 * @return $this
	 */
	public function setUpdateCountCallback ( $update_count_callback )
	{
		$this->update_count_callback = $update_count_callback;
		return $this;
	}

	/**
	 * Get the value of update_count_callback
	 *
	 * @return string
	 */
	public function getUpdateCountCallback ()
	{
		return $this->update_count_callback;
	}

	/**
	 * Set the value of show_in_rest
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
	 * Get the value of show_in_rest
	 *
	 * @return bool
	 */
	public function getShowInRest ()
	{
		return $this->show_in_rest;
	}

	/**
	 * Set the value of rest_base
	 *
	 * @param bool|string $rest_base
	 *
	 * @return $this
	 */
	public function setRestBase ( $rest_base )
	{
		$this->rest_base = $rest_base;
		return $this;
	}

	/**
	 * Get the value of rest_base
	 *
	 * @return bool|string
	 */
	public function getRestBase ()
	{
		return $this->rest_base;
	}

	/**
	 * Set the value of rest_namespace
	 *
	 * @param bool|string $rest_namespace
	 *
	 * @return $this
	 */
	public function setRestNamespace ( $rest_namespace )
	{
		$this->rest_namespace = $rest_namespace;
		return $this;
	}

	/**
	 * Get the value of rest_namespace
	 *
	 * @return bool|string
	 */
	public function getRestNamespace ()
	{
		return $this->rest_namespace;
	}

	/**
	 * Set the value of rest_controller_class
	 *
	 * @param bool|string $rest_controller_class
	 *
	 * @return $this
	 */
	public function setRestControllerClass ( $rest_controller_class )
	{
		$this->rest_controller_class = $rest_controller_class;
		return $this;
	}

	/**
	 * Get the value of rest_controller_class
	 *
	 * @return bool|string
	 */
	public function getRestControllerClass ()
	{
		return $this->rest_controller_class;
	}

	/**
	 * Set the value of default_term
	 *
	 * @param mixed $default_term
	 *
	 * @return $this
	 */
	public function setDefaultTerm ( $default_term )
	{
		$this->default_term = $default_term;
		return $this;
	}

	/**
	 * Get the value of default_term
	 *
	 * @return mixed
	 */
	public function getDefaultTerm ()
	{
		return $this->default_term;
	}

	/**
	 * Set the value of sort
	 *
	 * @param mixed $sort
	 *
	 * @return $this
	 */
	public function setSort ( $sort )
	{
		$this->sort = $sort;
		return $this;
	}

	/**
	 * Get the value of sort
	 *
	 * @return mixed
	 */
	public function getSort ()
	{
		return $this->sort;
	}

	/**
	 * Set the value of _builtin
	 *
	 * @param bool $builtin
	 *
	 * @return $this
	 */
	public function setBuiltin ( $builtin )
	{
		$this->_builtin = $builtin;
		return $this;
	}

	/**
	 * Get the value of _builtin
	 *
	 * @return bool
	 */
	public function getBuiltin ()
	{
		return $this->_builtin;
	}

	/**
	 * Set arguments.
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
	 * Get the arguments.
	 *
	 * @return array
	 */
	public function getArgs ()
	{
		return $this->args;
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
	 * Set the post type key.
	 *
	 * @param string $tax_type The key for the custom taxonomy type.
	 *
	 * @return $this
	 */
	public function setTaxType ( $tax_type )
	{
		$this->tax_type = $tax_type;
		return $this;
	}

	/**
	 * Get the tax type key.
	 *
	 * @return string
	 */
	public function getTaxType ()
	{
		return $this->tax_type;
	}

	/**
	 * Set custom labels.
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
	 * Get the labels.
	 *
	 * @return array
	 */
	public function getLabels ()
	{
		return $this->labels;
	}

	/**
	 * Process the all available args for taxonomy.
	 *
	 * @return void
	 */
	private function processArgs ()
	{
		$args = [
			'public'                => '',
			'publicly_queryable'    => '',
			'hierarchical'          => '',
			'show_ui'               => '',
			'show_in_menu'          => '',
			'show_in_nav_menus'     => '',
			'show_tagcloud'         => '',
			'show_in_quick_edit'    => '',
			'show_admin_column'     => '',
			'meta_box_cb'           => '',
			'meta_box_sanitize_cb'  => '',
			'capabilities'          => '',
			'rewrite'               => '',
			'query_var'             => '',
			'update_count_callback' => '',
			'show_in_rest'          => '',
			'rest_base'             => '',
			'rest_namespace'        => '',
			'rest_controller_class' => '',
			'default_term'          => '',
			'sort'                  => '',
			'args'                  => '',
			'_builtin'              => '',
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
	 * Process the all available labels for taxonomy.
	 *
	 * @return void
	 */
	private function processLabels ()
	{
		$name_field_description   = esc_html__( 'The name is how it appears on your site.', 'TEXT_DOMAIN', 'TEXT_DOMAIN' );
		$slug_field_description   = esc_html__( 'The &#8220;slug&#8221; is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'TEXT_DOMAIN' );
		$parent_field_description = esc_html__( 'Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.', 'TEXT_DOMAIN' );
		$desc_field_description   = esc_html__( 'The description is not prominent by default; however, some themes may show it.', 'TEXT_DOMAIN' );

		$labels = [
			'name'                       => [ _x( 'Tags', 'taxonomy general name', 'TEXT_DOMAIN' ), _x( 'Categories', 'taxonomy general name', 'TEXT_DOMAIN' ) ],
			'singular_name'              => [ _x( 'Tag', 'taxonomy singular name', 'TEXT_DOMAIN' ), _x( 'Category', 'taxonomy singular name', 'TEXT_DOMAIN' ) ],
			'search_items'               => [ esc_html__( 'Search Tags', 'TEXT_DOMAIN' ), esc_html__( 'Search Categories', 'TEXT_DOMAIN' ) ],
			'popular_items'              => [ esc_html__( 'Popular Tags', 'TEXT_DOMAIN' ), null ],
			'all_items'                  => [ esc_html__( 'All Tags', 'TEXT_DOMAIN' ), esc_html__( 'All Categories', 'TEXT_DOMAIN' ) ],
			'parent_item'                => [ null, esc_html__( 'Parent Category', 'TEXT_DOMAIN' ) ],
			'parent_item_colon'          => [ null, esc_html__( 'Parent Category:', 'TEXT_DOMAIN' ) ],
			'name_field_description'     => [ $name_field_description, $name_field_description ],
			'slug_field_description'     => [ $slug_field_description, $slug_field_description ],
			'parent_field_description'   => [ null, $parent_field_description ],
			'desc_field_description'     => [ $desc_field_description, $desc_field_description ],
			'edit_item'                  => [ esc_html__( 'Edit Tag', 'TEXT_DOMAIN' ), esc_html__( 'Edit Category', 'TEXT_DOMAIN' ) ],
			'view_item'                  => [ esc_html__( 'View Tag', 'TEXT_DOMAIN' ), esc_html__( 'View Category', 'TEXT_DOMAIN' ) ],
			'update_item'                => [ esc_html__( 'Update Tag', 'TEXT_DOMAIN' ), esc_html__( 'Update Category', 'TEXT_DOMAIN' ) ],
			'add_new_item'               => [ esc_html__( 'Add New Tag', 'TEXT_DOMAIN' ), esc_html__( 'Add New Category', 'TEXT_DOMAIN' ) ],
			'new_item_name'              => [ esc_html__( 'New Tag Name', 'TEXT_DOMAIN' ), esc_html__( 'New Category Name', 'TEXT_DOMAIN' ) ],
			'separate_items_with_commas' => [ esc_html__( 'Separate tags with commas', 'TEXT_DOMAIN' ), null ],
			'add_or_remove_items'        => [ esc_html__( 'Add or remove tags', 'TEXT_DOMAIN' ), null ],
			'choose_from_most_used'      => [ esc_html__( 'Choose from the most used tags', 'TEXT_DOMAIN' ), null ],
			'not_found'                  => [ esc_html__( 'No tags found.', 'TEXT_DOMAIN' ), esc_html__( 'No categories found.', 'TEXT_DOMAIN' ) ],
			'no_terms'                   => [ esc_html__( 'No tags', 'TEXT_DOMAIN' ), esc_html__( 'No categories', 'TEXT_DOMAIN' ) ],
			'filter_by_item'             => [ null, esc_html__( 'Filter by category', 'TEXT_DOMAIN' ) ],
			'items_list_navigation'      => [ esc_html__( 'Tags list navigation', 'TEXT_DOMAIN' ), esc_html__( 'Categories list navigation', 'TEXT_DOMAIN' ) ],
			'items_list'                 => [ esc_html__( 'Tags list', 'TEXT_DOMAIN' ), esc_html__( 'Categories list', 'TEXT_DOMAIN' ) ],
			/* translators: Tab heading when selecting from the most used terms. */
			'most_used'                  => [ _x( 'Most Used', 'tags', 'TEXT_DOMAIN' ), _x( 'Most Used', 'categories', 'TEXT_DOMAIN' ) ],
			'back_to_items'              => [ esc_html__( '&larr; Go to Tags', 'TEXT_DOMAIN' ), esc_html__( '&larr; Go to Categories', 'TEXT_DOMAIN' ) ],
			'item_link'                  => [
				_x( 'Tag Link', 'navigation link block title', 'TEXT_DOMAIN' ),
				_x( 'Category Link', 'navigation link block title', 'TEXT_DOMAIN' ),
			],
			'item_link_description'      => [
				_x( 'A link to a tag.', 'navigation link block description', 'TEXT_DOMAIN' ),
				_x( 'A link to a category.', 'navigation link block description', 'TEXT_DOMAIN' ),
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
	 * Register the custom taxonomy with WordPress.
	 *
	 * @return void
	 */
	public function register ()
	{
		$this->processLabels();
		$this->processargs();
		$this->addPermalinkSettings();
		wpe_add_taxonomy( $this->tax_type, $this->post_type, $this->args );
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
		$slug = $this->tax_type;
		$slug = get_option( $this->tax_type . '_permalink', $slug );
		$this->setRewrite( [ 'slug' => $slug ] );

		add_action( 'admin_init', function () use ( $name, $slug )
		{
			add_settings_field(
				$this->tax_type . '_permalink',
				sprintf( esc_html__( '%s', 'TEXT_DOMAIN' ), $name ),
				function () use ( $slug )
				{
					echo '<input type="text" name="' . esc_attr( $this->tax_type . '_permalink' ) . '" value="' . esc_attr( $slug ) . '" class="regular-text">';
				},
				'permalink',
				'optional'
			);

			register_setting( 'permalink', $this->tax_type . '_permalink' );
		} );
	}
}
