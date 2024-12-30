# WPEssential Postypes

Help to register the custom post types and taxonomies in WordPress.

`composer require wpessential/wpessential-postypes`

Add the post type to WordPress registry

```php
$name = 'YOUR_POST_TYPE_NAME';
$cpt = \WPEssential\Library\Cpt::make($name);
$cpt->register();
```

Remove the post type from WordPress registry

```php
$name = 'YOUR_POST_TYPE_NAME';
$cpt = \WPEssential\Library\Cpt::make($name);
$cpt->remove();
```
Add the taxonomy to WordPress registry

```php
$post_type = 'YOUR_POST_TYPE_SLUG';
$name = 'YOUR_TAXONOMY_NAME';
$ctxm = \WPEssential\Library\Ctxm::make($post_type, $name);
$ctxm->register();
```

Remove the taxonomy from WordPress registry

```php
$post_type = 'YOUR_POST_TYPE_SLUG';
$name = 'YOUR_TAXONOMY_NAME';
$ctxm = \WPEssential\Library\Ctxm::make($post_type, $name);
$ctxm->remove();
```
