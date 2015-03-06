-- -------------------------------------------------------------------- --
-- Phoca Cart manual installation                                       --
-- -------------------------------------------------------------------- --
-- See documentation on http://www.phoca.cz/                            --
--                                                                      --
-- Change all prefixes #__ to prefix which is set in your Joomla! site  --
-- (e.g. from #__phocacart to jos_phocacart)                            --
-- Run this SQL queries in your database tool, e.g. in phpMyAdmin       --
-- If you have questions, just ask in Phoca Forum                       --
-- http://www.phoca.cz/forum/                                           --
-- -------------------------------------------------------------------- --

CREATE TABLE IF NOT EXISTS `#__phocacart_categories` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `access` int(11) unsigned NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `count` int(11) NOT NULL DEFAULT '0',
  `hits` int(11) NOT NULL DEFAULT '0',
  `params` text,
  `metakey` text,
  `metadesc` text,
  `metadata` text,
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY  (`id`),
  KEY `cat_idx` (`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_alias` (`alias`),
  KEY `idx_language` (`language`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0',
  `tax_id` int(11) NOT NULL DEFAULT '0',
  `manufacturer_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `description_long` text,
  `price` float NOT NULL DEFAULT '0',
  `price_original` float NOT NULL DEFAULT '0',
  `length` float NOT NULL DEFAULT '0',
  `width` float NOT NULL DEFAULT '0',
  `height` float NOT NULL DEFAULT '0',
  `unit_size` int(2) NOT NULL DEFAULT '0',
  `weight` float NOT NULL DEFAULT '0',
  `unit_weight` int(2) NOT NULL DEFAULT '0',
  `volume` float NOT NULL DEFAULT '0',
  `unit_volume` int(2) NOT NULL DEFAULT '0',
  `stock` int(11) NOT NULL DEFAULT '0',
  `min_quantity` int(11) NOT NULL DEFAULT '0',
  `stockstatus_a_id` int(11) NOT NULL DEFAULT '0',
  `stockstatus_n_id` int(11) NOT NULL DEFAULT '0',
  `availability` text,
  `sku` varchar(255) NOT NULL DEFAULT '',
  `upc` varchar(15) NOT NULL DEFAULT '',
  `ean` varchar(15) NOT NULL DEFAULT '',
  `jan` varchar(15) NOT NULL DEFAULT '',
  `isbn` varchar(15) NOT NULL DEFAULT '',
  `mpn` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `allow_upload` tinyint(1) NOT NULL DEFAULT '0',
  `custom_text` text,
  `download_token` char(64) NOT NULL DEFAULT '',
  `download_folder` varchar(255) NOT NULL DEFAULT '',
  `download_file` varchar(255) NOT NULL DEFAULT '',
  `download_hits` int(11) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `access` int(11) unsigned NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL DEFAULT '0',
  `params` text,
  `metakey` text,
  `metadesc` text,
  `metadata` text,
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY  (`id`),
  KEY `product_idx` (`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_alias` (`alias`),
  KEY `idx_manufacturer` (`manufacturer_id`), 
  KEY `idx_tax` (`tax_id`), 
  KEY `idx_language` (`language`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_product_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`id`),
  KEY `idx_product` (`product_id`) 
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `params` text,
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_language` (`language`)
) DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `#__phocacart_attribute_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `amount` float NOT NULL DEFAULT '0',
  `operator` char(1) NOT NULL DEFAULT '',
  `stock` int(11) NOT NULL DEFAULT '0',
  `weight` float NOT NULL DEFAULT '0',
  `operator_weight` char(1) NOT NULL DEFAULT '0',
  `volume` float NOT NULL DEFAULT '0',
  `operator_volume` char(1) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_attribute` (`attribute_id`) ,
  KEY `idx_language` (`language`)
) DEFAULT CHARSET=utf8 ;

-- CREATE TABLE IF NOT EXISTS `#__phocacart_product_attributes` (
--  `product_id` int(11) NOT NULL,
--   `attribute_id` int(11) NOT NULL,
-- KEY `idx_product` (`product_id`, `attribute_id`) 
-- ) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_specifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `value` text,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `params` text,
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_language` (`language`)
) DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `#__phocacart_specification_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `params` text,
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_language` (`language`)
) DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS `#__phocacart_product_related` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_a` int(11) NOT NULL DEFAULT '0',
  `product_b` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product_a` (`product_a`),
  KEY `product_b` (`product_b`) 
) DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `#__phocacart_shipping_methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_id` int(11) NOT NULL DEFAULT '0',
  `cost` float NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `lowest_weight` float NOT NULL DEFAULT '0',
  `highest_weight` float NOT NULL DEFAULT '0',
  `active_volume` tinyint(1) NOT NULL DEFAULT '0',
  `lowest_volume` float NOT NULL DEFAULT '0',
  `highest_volume` float NOT NULL DEFAULT '0',
  `active_weight` tinyint(1) NOT NULL DEFAULT '0',
  `lowest_amount` float NOT NULL DEFAULT '0',
  `highest_amount` float NOT NULL DEFAULT '0',
  `active_amount` tinyint(1) NOT NULL DEFAULT '0',
  `active_country` tinyint(1) NOT NULL DEFAULT '0',
  `active_region` tinyint(1) NOT NULL DEFAULT '0',
  `access` int(11) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `params` text,
  `language` char(7) NOT NULL DEFAULT '',
  INDEX (`published`),
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS `#__phocacart_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `type` int(11) NOT NULL DEFAULT '0',
  `code2` varchar(20) NOT NULL DEFAULT '',
  `code3` varchar(20) NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text,
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `#__phocacart_regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `type` int(11) NOT NULL DEFAULT '0',
  `code2` varchar(20) NOT NULL DEFAULT '',
  `code3` varchar(20) NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text,
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `#__phocacart_shipping_method_countries` (
  `shipping_id` int(11) NOT NULL DEFAULT '0',
  `country_id` int(11) NOT NULL DEFAULT '0',
  KEY `idx_shipping` (`shipping_id`, `country_id`) 
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_shipping_method_regions` (
  `shipping_id` int(11) NOT NULL DEFAULT '0',
  `region_id` int(11) NOT NULL DEFAULT '0',
  KEY `idx_shipping` (`shipping_id`, `region_id`) 
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_manufacturers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `params` text,
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_language` (`language`)
) DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS `#__phocacart_stock_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `params` text,
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS `#__phocacart_tags` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `link_ext` varchar(255) NOT NULL DEFAULT '',
  `link_cat` int(11) unsigned NOT NULL DEFAULT '0',
  `description` text,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text,
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_tags_related` (
  `id` SERIAL,
  `item_id` int(11) NOT NULL DEFAULT '0',
  `tag_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `i_file_id` (`item_id`,`tag_id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_taxes` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `tax_rate` float NOT NULL DEFAULT '0',
  `calculation_type` tinyint(1) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text,
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_currencies` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `code` varchar(5) NOT NULL DEFAULT '',
  `exchange_rate` float NOT NULL DEFAULT 0,
  `price_format` tinyint(1) NOT NULL DEFAULT '0',
  `price_currency_symbol` varchar(10) NOT NULL DEFAULT '',
  `price_dec_symbol` char(1) NOT NULL DEFAULT '',
  `price_decimals` tinyint(1) NOT NULL DEFAULT '0',
  `price_thousands_sep` char(1) NOT NULL DEFAULT '',
  `price_suffix` varchar(30) NOT NULL DEFAULT '',
  `price_prefix` varchar(30) NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text,
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_coupons` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `code` varchar(255) NOT NULL DEFAULT '',
  `discount` float NOT NULL DEFAULT '0',
  `total_amount` float NOT NULL DEFAULT '0',
  `calculation_type` tinyint(1) NOT NULL DEFAULT '0',
  `free_shipping` tinyint(1) NOT NULL DEFAULT '0',
  `free_payment` tinyint(1) NOT NULL DEFAULT '0',
  `valid_from` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `valid_to` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `available_quantity` int(11) NOT NULL DEFAULT '0',
  `available_quantity_user` int(11) NOT NULL DEFAULT '0',
  `description` text,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text,
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_coupon_count` (
  `id` int(11) NOT NULL auto_increment,
  `coupon_id` int(11) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_coupon_count_user` (
  `coupon_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  KEY `idx_coupon` (`coupon_id`,`user_id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_coupon_products` (
  `coupon_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0',
  KEY `idx_coupon` (`coupon_id`,`product_id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_coupon_categories` (
  `coupon_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  KEY `idx_coupon` (`coupon_id`,`category_id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_payment_methods` (
  `id` int(11) NOT NULL auto_increment,
  `tax_id` int(11) NOT NULL DEFAULT '0',
  `cost` float NOT NULL DEFAULT '0',
  `operator` char(1) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `lowest_amount` float NOT NULL DEFAULT '0',
  `highest_amount` float NOT NULL DEFAULT '0',
  `active_amount` tinyint(1) NOT NULL DEFAULT '0',
  `active_country` tinyint(1) NOT NULL DEFAULT '0',
  `active_region` tinyint(1) NOT NULL DEFAULT '0',
  `active_shipping` tinyint(1) NOT NULL DEFAULT '0',
  `method` varchar(100) NOT NULL DEFAULT '',
  `access` int(11) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text,
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__phocacart_payment_method_countries` (
  `payment_id` int(11) NOT NULL DEFAULT '0',
  `country_id` int(11) NOT NULL DEFAULT '0',
  KEY `idx_payment` (`payment_id`, `country_id`) 
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_payment_method_regions` (
  `payment_id` int(11) NOT NULL DEFAULT '0',
  `region_id` int(11) NOT NULL DEFAULT '0',
  KEY `idx_payment` (`payment_id`, `region_id`) 
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_payment_method_shipping` (
  `payment_id` int(11) NOT NULL DEFAULT '0',
  `shipping_id` int(11) NOT NULL DEFAULT '0',
  KEY `idx_payment` (`payment_id`, `shipping_id`) 
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `review` text,
  `rating` int(1) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS `#__phocacart_form_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '',
  `alias` varchar(50) NOT NULL DEFAULT '',
  `label` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `id_input` varchar(50) NOT NULL DEFAULT '',
  `type` varchar(50) NOT NULL DEFAULT '',
  `DEFAULT` varchar(255) NOT NULL DEFAULT '',
  `size` varchar(50) NOT NULL DEFAULT '',
  `cols` varchar(5) NOT NULL DEFAULT '',
  `rows` varchar(5) NOT NULL DEFAULT '',
  `class` varchar(100) NOT NULL DEFAULT '',
  `filter` varchar(25) NOT NULL DEFAULT '',
  `read_only` tinyint(1) NOT NULL DEFAULT '0',
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `validate` varchar(50) NOT NULL DEFAULT '',
  `unique` tinyint(1) NOT NULL DEFAULT '0',
  `preicon` varchar(100) NOT NULL DEFAULT '',
  `format` varchar(50) NOT NULL DEFAULT '',
  `additional` text,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `display_billing` tinyint(1) NOT NULL DEFAULT '0',
  `display_shipping` tinyint(1) NOT NULL DEFAULT '0',
  `display_account` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `access` int(11) unsigned NOT NULL DEFAULT '0',
  `params` text,
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `#__phocacart_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `ba_sa` tinyint(1) NOT NULL DEFAULT '0',
  `newsletter` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  
	`name_first` varchar(100) NOT NULL DEFAULT '',
	`name_middle` varchar(100) NOT NULL DEFAULT '',
	`name_last` varchar(100) NOT NULL DEFAULT '',
	`name_degree` varchar(100) NOT NULL DEFAULT '',
	`company` varchar(255) NOT NULL DEFAULT '',
	`vat_1` varchar(25) NOT NULL DEFAULT '',
	`vat_2` varchar(25) NOT NULL DEFAULT '',
	`address_1` varchar(255) NOT NULL DEFAULT '',
	`address_2` varchar(255) NOT NULL DEFAULT '',
	`city` varchar(255) NOT NULL DEFAULT '',
	`zip` varchar(20) NOT NULL DEFAULT '',
	`country` int(11) NOT NULL DEFAULT '0',
	`region` int(11) NOT NULL DEFAULT '0',
	`email` varchar(100) NOT NULL DEFAULT '',
	`email_contact` varchar(100) NOT NULL DEFAULT '',
	`phone_1` varchar(20) NOT NULL DEFAULT '',
	`phone_2` varchar(20) NOT NULL DEFAULT '',
	`phone_mobile` varchar(20) NOT NULL DEFAULT '',
	`fax` varchar(20) NOT NULL DEFAULT '',

  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_cart` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `cart` text,
  `shipping` int(11) NOT NULL DEFAULT '0',
  `coupon` int(11) NOT NULL DEFAULT '0',
  `payment` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`)
) DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS `#__phocacart_order_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `stock_movements` char(1) NOT NULL DEFAULT '',
  `email_customer` tinyint(1) NOT NULL DEFAULT '0',
  `email_others` text,
  `email_text` text,
  `email_subject` varchar(255) NOT NULL DEFAULT '',
  `email_send` int(2) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `params` text,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `download` tinyint(1) NOT NULL DEFAULT '0',
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS `#__phocacart_orders` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`order_token` char(64) NOT NULL DEFAULT '',
	`user_id` int(11) NOT NULL DEFAULT '0',
	`invoice_id` int(11) NOT NULL DEFAULT '0',
	`status_id` int(11) NOT NULL DEFAULT '0',
	`shipping_id` int(11) NOT NULL DEFAULT '0',
	`payment_id` int(11) NOT NULL DEFAULT '0',
	`coupon_id` int(11) NOT NULL DEFAULT '0',
	`currency_id` int(11) NOT NULL DEFAULT '0',
	`tax_calculation` int(11) NOT NULL DEFAULT '0',
	`currency_code` varchar(5) NOT NULL DEFAULT '',
	`currency_exchange_rate` float NOT NULL DEFAULT '0',
	`unit_weight` varchar(50) NOT NULL DEFAULT '',
	`unit_volume` varchar(50) NOT NULL DEFAULT '',
	`title` varchar(255) NOT NULL DEFAULT '',
	`alias` varchar(255) NOT NULL DEFAULT '',
	`comment` text,
	`ip` varchar(40) NOT NULL DEFAULT '',
	`user_agent` varchar(255) NOT NULL DEFAULT '',
	`published` tinyint(1) NOT NULL DEFAULT '0',
	`checked_out` int(11) unsigned NOT NULL DEFAULT '0',
	`checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`ordering` int(11) NOT NULL DEFAULT '0',
	`date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`params` text,
	PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS `#__phocacart_order_users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`order_id` int(11) NOT NULL DEFAULT '0',
	`user_token` char(64) NOT NULL DEFAULT '',
	`user_address_id` int(11) NOT NULL DEFAULT '0',
	`type` tinyint(1) NOT NULL DEFAULT '0',
	`ba_sa` tinyint(1) NOT NULL DEFAULT '0',
	`name_first` varchar(100) NOT NULL DEFAULT '',
	`name_middle` varchar(100) NOT NULL DEFAULT '',
	`name_last` varchar(100) NOT NULL DEFAULT '',
	`name_degree` varchar(100) NOT NULL DEFAULT '',
	`company` varchar(255) NOT NULL DEFAULT '',
	`vat_1` varchar(25) NOT NULL DEFAULT '',
	`vat_2` varchar(25) NOT NULL DEFAULT '',
	`address_1` varchar(255) NOT NULL DEFAULT '',
	`address_2` varchar(255) NOT NULL DEFAULT '',
	`city` varchar(255) NOT NULL DEFAULT '',
	`zip` varchar(20) NOT NULL DEFAULT '',
	`country` int(11) NOT NULL DEFAULT '0',
	`region` int(11) NOT NULL DEFAULT '0',
	`email` varchar(100) NOT NULL DEFAULT '',
	`email_contact` varchar(100) NOT NULL DEFAULT '',
	`phone_1` varchar(20) NOT NULL DEFAULT '',
	`phone_2` varchar(20) NOT NULL DEFAULT '',
	`phone_mobile` varchar(20) NOT NULL DEFAULT '',
	`fax` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_order_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0',
  `product_id_key` text,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `sku` varchar(255) NOT NULL DEFAULT '',
  `netto` float NOT NULL DEFAULT '0',
  `tax` float NOT NULL DEFAULT '0',
  `brutto` float NOT NULL DEFAULT '0',
  `dnetto` float NOT NULL DEFAULT '0',
  `dtax` float NOT NULL DEFAULT '0',
  `dbrutto` float NOT NULL DEFAULT '0',
  `dtype` int(11) NOT NULL DEFAULT '0',
  `damount` float NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `weight` float NOT NULL DEFAULT '0',
  `volume` float NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_order_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0',
  `order_product_id` int(11) NOT NULL DEFAULT '0',
  `attribute_id` int(11) NOT NULL DEFAULT '0',
  `option_id` int(11) NOT NULL DEFAULT '0',
  `attribute_title` varchar(255) NOT NULL DEFAULT '',
  `option_title` varchar(255) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_order_coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `coupon_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `code` varchar(255) NOT NULL DEFAULT '',
  `amount` float NOT NULL DEFAULT '0',
  `netto` float NOT NULL DEFAULT '0',
  `brutto` float NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_order_total` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`order_id` int(11) NOT NULL DEFAULT '0',
	`title` varchar(255) NOT NULL DEFAULT '',
	`type` varchar(50) NOT NULL DEFAULT '',
	`amount` float NOT NULL DEFAULT '0',
	`text` varchar(255) NOT NULL DEFAULT '',
	`checked_out` int(11) unsigned NOT NULL DEFAULT '0',
	`checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`ordering` int(11) NOT NULL DEFAULT '0',
	`published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_order_history` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`order_id` int(11) NOT NULL DEFAULT '0',
	`order_status_id` int(11) NOT NULL DEFAULT '0',
	`user_id` int(11) NOT NULL DEFAULT '0',
	`notify` tinyint(1) NOT NULL DEFAULT '0',
	`comment` varchar(255) NOT NULL DEFAULT '',
	`date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_order_downloads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0',
  `order_product_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `download_token` char(64) NOT NULL DEFAULT '',
  `download_folder` varchar(255) NOT NULL DEFAULT '',
  `download_file` varchar(255) NOT NULL DEFAULT '',
  `download_hits` int(11) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__phocacart_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL default '0',
  `type_id` int(11) NOT NULL default '0',
  `type` tinyint(3) NOT NULL default '0',
  `priority` tinyint(1) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `ip` varchar(20) NOT NULL default '',
  `incoming_page` varchar(255) NOT NULL,
  `description` text,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `params` text,
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_language` (`language`)
) DEFAULT CHARSET=utf8 ;




 
-- Data
INSERT INTO `#__phocacart_order_statuses` (`id`, `title`, `published`, `ordering`, `stock_movements`, `type`, `download`) VALUES
(1, 'Pending', '1', '1', '-', '1', '0'),
(2, 'Confirmed', '1', '2', '=', '1', '0'),
(3, 'Canceled', '1', '3', '+', '1', '0'),
(4, 'Shipped', '1', '4', '=', '1', '0'),
(5, 'Refunded', '1', '5', '=', '1', '0'),
(6, 'Completed', '1', '6', '=', '1', '1');
-- -
INSERT INTO `#__phocacart_stock_statuses` (`id`, `title`, `published`, `ordering`) VALUES (NULL, 'Out Of Stock', '1', '1');
INSERT INTO `#__phocacart_stock_statuses` (`id`, `title`, `published`, `ordering`) VALUES (NULL, 'In Stock', '1', '2');
INSERT INTO `#__phocacart_stock_statuses` (`id`, `title`, `published`, `ordering`) VALUES (NULL, '2 - 3 Days', '1', '3');
-- -
INSERT INTO `#__phocacart_currencies` (`id`, `title`, `code`, `exchange_rate`, `price_currency_symbol`, `price_format`, `price_dec_symbol`, `price_decimals`, `price_thousands_sep`, `price_suffix`, `price_prefix`, `published`) VALUES
(1, 'Euro', 'EUR', 1, '€', 3, ',', 2, '.', '', '', 1);

-- - 
INSERT INTO `#__phocacart_form_fields` ( `title`, `label`, `description`, `type`, `published`, `display_billing`, `display_shipping`, `display_account`, `required`, `read_only`, `filter`, `unique`, `class`, `validate`, `ordering`, `access`) VALUES 
('name_first', 'COM_PHOCACART_FIRST_NAME_LABEL', 'COM_PHOCACART_FIRST_NAME_DESC', 'text', 1, 1, 1, 1, 1, 0, '', '', '', '', 1, 1),
('name_middle', 'COM_PHOCACART_MIDDLE_NAME_LABEL', 'COM_PHOCACART_MIDDLE_NAME_DESC', 'text', 0, 0, 0, 0, 0, 0, '', '', '', '', 2, 1),
('name_last', 'COM_PHOCACART_LAST_NAME_LABEL', 'COM_PHOCACART_LAST_NAME_DESC', 'text', 1, 1, 1, 1, 1, 0, '', '', '', '', 3, 1),
('name_degree', 'COM_PHOCACART_DEGREE_LABEL', 'COM_PHOCACART_DEGREE_DESC', 'text', 0, 0, 0, 0, 0, 0, '', '', '', '', 4, 1),
('company', 'COM_PHOCACART_COMPANY_LABEL', 'COM_PHOCACART_COMPANY_DESC', 'text', 1, 1, 1, 1, 0, 0, '', '', '', '', 5, 1),
('vat_1', 'COM_PHOCACART_VAT_1_LABEL', 'COM_PHOCACART_VAT_1_DESC', 'text', 0, 0, 0, 0, 0, 0, '', '', '', '', 6, 1),
('vat_2', 'COM_PHOCACART_VAT_2_LABEL', 'COM_PHOCACART_VAT_2_DESC', 'text', 0, 0, 0, 0, 0, 0, '', '', '', '', 7, 1),
('address_1', 'COM_PHOCACART_ADDRESS_1_LABEL', 'COM_PHOCACART_ADDRESS_1_DESC', 'text', 1, 1, 1, 1, 1, 0, '', '', '', '', 8, 1),
('address_2', 'COM_PHOCACART_ADDRESS_2_LABEL', 'COM_PHOCACART_ADDRESS_2_DESC', 'text', 0, 0, 0, 0, 0, 0, '', '', '', '', 9, 1),
('zip', 'COM_PHOCACART_ZIP_LABEL', 'COM_PHOCACART_ZIP_DESC', 'text', 1, 1, 1, 1, 1, 0, '', '', '', '', 10, 1),
('city', 'COM_PHOCACART_CITY_LABEL', 'COM_PHOCACART_CITY_DESC', 'text', 1, 1, 1, 1, 1, 0, '', '', '', '', 11, 1),
('country', 'COM_PHOCACART_COUNTRY_LABEL', 'COM_PHOCACART_COUNTRY_DESC', 'phocaformcountry', 1, 1, 1, 1, 1, 0, '', '', '', '', 12, 1),
('region', 'COM_PHOCACART_REGION_LABEL', 'COM_PHOCACART_REGION_DESC', 'phocaformregion', 1, 1, 1, 1, 0, 0, '', '', '', '', 13, 1),
('email', 'COM_PHOCACART_EMAIL_LABEL', 'COM_PHOCACART_EMAIL_DESC', 'text', 1, 1, 0, 1, 1, 2, 'string', 1, '', 'email', 14, 1),
('email_contact', 'COM_PHOCACART_CONTACT_EMAIL_LABEL', 'COM_PHOCACART_CONTACT_EMAIL_DESC', 'text', 0, 0, 0, 0, 0, 0, 'string', 'true', '', 'email', 15, 1),
('phone_1', 'COM_PHOCACART_PHONE_1_LABEL', 'COM_PHOCACART_PHONE_1_DESC', 'text', 0, 0, 0, 0, 0, 0, '', '', '', '', 16, 1),
('phone_2', 'COM_PHOCACART_PHONE_2_LABEL', 'COM_PHOCACART_PHONE_2_DESC', 'text', 0, 0, 0, 0, 0, 0, '', '', '', '', 17, 1),
('phone_mobile', 'COM_PHOCACART_MOBILE_PHONE_LABEL', 'COM_PHOCACART_MOBILE_PHONE_DESC', 'text', 0, 0, 0, 0, 0, 0, '', '', '', '', 18, 1),
('fax', 'COM_PHOCACART_FAX_LABEL', 'COM_PHOCACART_FAX_DESC', 'text', 0, 0, 0, 0, 0, 0, '', '', '', '', 19, 1);

-- UTF-8 test: ä,ö,ü

-- ALPHA1 -> ALPHA2
-- `type` tinyint(1) NOT NULL DEFAULT '0' added - `#__phocacart_order_statuses`
-- `download` tinyint(1) NOT NULL DEFAULT '0' added - `#__phocacart_order_statuses`
-- `email_text` text added - `#__phocacart_order_statuses`
-- `email_subject` varchar(255) added - `#__phocacart_order_statuses`
-- `email_send` int(2) NOT NULL DEFAULT '0' - `#__phocacart_order_statuses`
-- `type` tinyint(1) NOT NULL DEFAULT '0' added - `#__phocacart_stock_statuses`

-- `weight` float NOT NULL DEFAULT '0' added - `#__phocacart_order_products`
-- `volume` float NOT NULL DEFAULT '0' added - `#__phocacart_order_products`

-- `unit_weight` varchar(50) NOT NULL DEFAULT '' - `#__phocacart_orders`
-- `unit_volume` varchar(50) NOT NULL DEFAULT '' - `#__phocacart_orders`

-- `lowest_amount` float NOT NULL DEFAULT '0', - `#__phocacart_payment_methods`
-- `highest_amount` float NOT NULL DEFAULT '0', - `#__phocacart_payment_methods`
-- `active_amount` tinyint(1) NOT NULL DEFAULT '0', - `#__phocacart_payment_methods`
-- `active_country` tinyint(1) NOT NULL DEFAULT '0', - `#__phocacart_payment_methods`
-- `active_region` tinyint(1) NOT NULL DEFAULT '0', - `#__phocacart_payment_methods`
-- `active_shipping` tinyint(1) NOT NULL DEFAULT '0', - `#__phocacart_payment_methods`
-- `access` int(11) unsigned NOT NULL DEFAULT '0',  - `#__phocacart_payment_methods`

-- `access` int(11) unsigned NOT NULL DEFAULT '0',  - `#__phocacart_payment_methods`
-- `access` int(11) unsigned NOT NULL DEFAULT '0',  - `#__phocacart_form_fields`

-- CREATE TABLE IF NOT EXISTS `#__phocacart_payment_method_countries` (
--  `payment_id` int(11) NOT NULL DEFAULT '0',
--  `country_id` int(11) NOT NULL DEFAULT '0',
--  KEY `idx_payment` (`payment_id`, `country_id`) 
-- ) DEFAULT CHARSET=utf8;

-- CREATE TABLE IF NOT EXISTS `#__phocacart_payment_method_regions` (
--  `payment_id` int(11) NOT NULL DEFAULT '0',
--  `region_id` int(11) NOT NULL DEFAULT '0',
--  KEY `idx_payment` (`payment_id`, `region_id`) 
-- ) DEFAULT CHARSET=utf8;

-- CREATE TABLE IF NOT EXISTS `#__phocacart_payment_method_shipping` (
-- `payment_id` int(11) NOT NULL DEFAULT '0',
-- `shipping_id` int(11) NOT NULL DEFAULT '0',
-- KEY `idx_payment` (`payment_id`, `shipping_id`) 
-- ) DEFAULT CHARSET=utf8;

-- `free_payment` tinyint(1) NOT NULL DEFAULT '0' - `#__phocacart_coupons`