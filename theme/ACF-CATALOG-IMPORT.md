# ACF Fields Import Instructions for Catalog Page

## Overview
This document explains how to import ACF (Advanced Custom Fields) fields for the catalog/shop pages.

## Required ACF Field Groups

### 1. Product Category Fields (`group_catalog_category_fields.json`)
Fields for WooCommerce product categories:
- **Hero Image (Mobile)** - Category banner for mobile (768x200px)
- **Hero Image (Desktop)** - Category banner for desktop (1920x300px)
- **Hero Text** - Italic quote displayed over the hero
- **SEO Title** - Title for SEO text block
- **SEO Content** - WYSIWYG content with "Show more" functionality

### 2. Shop Settings (`group_shop_settings.json`)
Options page fields for the main shop page:
- **Hero Image (Mobile)** - Shop page banner for mobile
- **Hero Image (Desktop)** - Shop page banner for desktop
- **Hero Text** - Default hero quote
- **SEO Title** - SEO block title
- **SEO Content** - SEO text content

### 3. Product Extra Fields (`group_product_fields.json`)
Additional fields for individual products:
- **Bestseller** - Toggle to mark product as bestseller (shows badge)

## Import Instructions

### Method 1: Automatic Sync (Recommended)
1. Ensure the `acf-json` folder exists in your theme directory
2. ACF Pro will automatically sync these field groups on next admin page load
3. Go to **Custom Fields > Field Groups** to verify import

### Method 2: Manual Import
1. Go to **Custom Fields > Tools** in WordPress admin
2. Click **Import Field Groups**
3. Upload each JSON file from the `acf-json` folder:
   - `group_catalog_category_fields.json`
   - `group_shop_settings.json`
   - `group_product_fields.json`
4. Click **Import**

## Usage

### Category Hero Images
1. Go to **Products > Categories**
2. Edit any category
3. Fill in the Hero Section fields
4. The hero will display on that category's archive page

### Shop Page Settings
1. Go to **Shop Settings** in the admin menu (cart icon)
2. Configure the main shop page hero and SEO content
3. These settings apply when viewing the main shop page

### Bestseller Badge
1. Edit any product
2. In the sidebar, find "Product Extra Fields"
3. Toggle "Bestseller" to Yes
4. The product will show a yellow "Bestseller" badge in the catalog

## Product Attributes for Filters

Ensure you have created these WooCommerce attributes:
1. Go to **Products > Attributes**
2. Create attribute: **Size** (slug: `size`)
   - Add terms: S, M, L, XL
3. Create attribute: **Color** (slug: `color`)
   - Add terms: White, Black, Red (or your colors)

## Yoast SEO Breadcrumbs

1. Install and activate **Yoast SEO** plugin
2. Go to **SEO > Settings > Site Features**
3. Enable **Breadcrumbs**
4. Breadcrumbs will automatically display on catalog pages

## File Structure

```
theme/
├── acf-json/
│   ├── group_catalog_category_fields.json
│   ├── group_shop_settings.json
│   └── group_product_fields.json
├── woocommerce/
│   └── archive-product.php
└── tailwind/custom/components/
    └── catalog.css
```
