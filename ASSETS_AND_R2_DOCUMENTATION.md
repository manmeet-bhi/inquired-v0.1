# Inaquired - Assets & Cloudflare R2 Integration Documentation

## 1. Overview
This document details the asset directory reorganization, Cloudflare R2 cloud storage integration, CMS upload routing, and bandwidth optimization strategies implemented in the Inaquired project.

---

## 2. Directory Structure & Assets Reorganization

All static project assets are now unified and cleanly organized inside the `public/assets/` directory. Legacy redundant folders (`public/css/`, `public/js/`, `public/images/`) have been moved and removed from the public root.

### `public/assets/` Directory Layout:
```
public/
├── assets/
│   ├── css/
│   │   ├── cms-stylesheet.css
│   │   ├── searchable-dropdown.css
│   │   ├── tailwind-full.css
│   │   └── tailwind.min.css
│   ├── js/
│   │   ├── cms-script.js
│   │   ├── lucide.min.js
│   │   └── searchable-dropdown.js
│   ├── logos/
│   │   ├── logo.png
│   │   └── logo-q.png
│   ├── favicon/
│   │   ├── favicon.ico
│   │   ├── favicon-16x16.png
│   │   ├── favicon-32x32.png
│   │   ├── apple-touch-icon.png
│   │   ├── android-chrome-192x192.png
│   │   ├── android-chrome-512x512.png
│   │   └── site.webmanifest
│   ├── fonts/
│   │   ├── inter-400.woff2
│   │   ├── inter.css
│   │   ├── unbounded-700.woff2
│   │   └── unbounded.css
│   ├── icons/
│   │   └── categories/
│   └── images/
│       └── blog/
├── build/                 # Vite compiled application assets
├── favicon.ico
├── index.php
├── manifest.json
├── robots.txt
└── sitemap.xml
```

---

## 3. Cloudflare R2 Cloud Storage Integration

### Bucket Configuration:
- **Bucket Name**: `inaquired-r2`
- **Default Filesystem Disk**: `FILESYSTEM_DISK=r2` in `.env`
- **Driver**: High-performance native REST Flysystem adapter (`App\Services\CloudflareR2Adapter`) supporting Cloudflare API Tokens (`cfat_...`) and standard S3 API credentials.

### Storage Paths in R2:
| Media Type | R2 Storage Folder | Upload Controller / Method | Model / Helper Accessor |
| :--- | :--- | :--- | :--- |
| **Company Logos** | `company-logos/` | `AdminController@storeCompany`, `AdminController@updateCompany` | `$company->logo_url` (`media_url($company->logo)`) |
| **Blog Post Images** | `blog/` | `AdminController@storePost`, `AdminController@updatePost` | `$post->featured_image_url` (`media_url($post->featured_image)`) |
| **Category Icons** | `icons/` | `AdminController@storeCategory`, `AdminController@updateCategory` | `$category->icon_url` (`media_url($category->icon_file)`) |
| **OG Images & Twitter Cards** | `og-images/` | `SeoController@updateGlobalSettings`, `SeoController@storePage`, `SeoController@updatePage` | `media_url($pageSeo->og_image ?? $globalSettings['og_default_image'])` |
| **Custom SEO Favicons** | `seo/favicon/` | `SeoController@updateGlobalSettings` | `media_url($seoSetting->favicon)` |

---

## 4. Bandwidth Optimization Strategy

1. **Zero External Bandwidth for Project Brand Assets**:
   - Site logos (`assets/logos/logo.png`, `assets/logos/logo-q.png`), favicons (`assets/favicon/`), fonts, UI icons, and stylesheet assets are served **100% locally from the server**.
   - No external Cloudflare R2 requests are triggered for site navigation, headers, footers, or CMS UI components.

2. **Cloudflare R2 for Dynamic CMS Media**:
   - Cloudflare R2 is utilized exclusively for user-uploaded dynamic content (company logos, blog post headers, category icons, SEO images).
   - Served securely via `/media/{path}` through `App\Http\Controllers\MediaController` with immutable edge-caching headers (`Cache-Control: public, max-age=31536000, immutable`).

---

---

## 5. Automated Deletion & Cloudflare R2 Sync Lifecycle

All uploaded dynamic media is strictly synchronized with the Cloudflare R2 bucket. When records are deleted (individually or in bulk), or when images are replaced or removed via CMS, the files are immediately and automatically purged from R2:

1. **Company Logos**:
   - Model Hook: `Company::booted()` (`static::deleting`) deletes `$company->logo` from R2.
   - Associated SEO: Automatically deletes any linked `PageSeo` records for the company (which cleans up OG images).
   - Controller: `AdminController@updateCompany` (supports `remove_logo`), `AdminController@destroyCompany`, `AdminController@bulkDeleteCompanies`.

2. **Blog Featured Images**:
   - Model Hook: `Post::boot()` (`static::deleting`) deletes `$post->featured_image` from R2.
   - Associated SEO: Cleans up linked `PageSeo` records and their OG images.
   - Controller: `AdminController@updatePost` (supports `remove_featured_image`), `AdminController@destroyPost`, `AdminController@bulkDeletePosts`.

3. **Category Icons**:
   - Model Hook: `JobCategory::booted()` (`static::deleting`) deletes `$category->icon_file` from R2 (and local SVG copy if present).
   - Controller: `AdminController@updateCategory`, `AdminController@destroyCategory`, `AdminController@bulkDeleteCategories`.

4. **Page SEO & OpenGraph Images**:
   - Model Hook: `PageSeo::booted()` (`static::deleting`) deletes both `$seo->og_image` and `$seo->twitter_image` from R2.
   - Controller: `SeoController@updatePage` (supports `remove_og_image` and `remove_twitter_image`), `SeoController@destroyPage`, `SeoController@updateGlobalSettings`.

---

## 6. Summary of Code & Template Updates

1. **Blade Templates & Views**:
   - Updated all header, footer, CMS, and auth views to reference `asset('assets/logos/logo.png')` and `asset('assets/logos/logo-q.png')`.
   - Updated `resources/views/partials/favicons.blade.php` and `public/manifest.json` to reference `asset('assets/favicon/...')`.
   - Updated `cms/jobs/create.blade.php`, `cms/jobs/edit.blade.php`, `cms/internships/create.blade.php`, and `cms/internships/edit.blade.php` to reference `asset('assets/css/searchable-dropdown.css')` and `asset('assets/js/searchable-dropdown.js')`.
   - Updated `jobs/categories.blade.php`, `cms/categories/index.blade.php`, and `cms/categories/edit.blade.php` to use `$category->icon_url`.

2. **Controllers & Models**:
   - `Company.php`, `Post.php`, `JobCategory.php`, `Job.php`, `PageSeo.php`: Implemented automated `static::deleting` lifecycle hooks ensuring 100% deletion sync with R2.
   - `AdminController.php`: Updated blog upload path to `blog`, category icons upload path to `icons`, and company logos to `company-logos` with removal/replacement handlers.
   - `JobCategory.php`: Added `getIconUrlAttribute()` accessor supporting both R2 and local SVG icons.
   - `MediaController.php`: Optimized candidate path resolution to prioritize local static assets first and route uploaded media (`company-logos/`, `blog/`, `icons/`, `og-images/`, `seo/`) to Cloudflare R2.
   - `SeoHelper.php`: Updated default fallback logo references to `asset('assets/logos/logo.png')`.
