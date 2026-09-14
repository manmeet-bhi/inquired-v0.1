# Automatic Schema (JSON-LD) Generation System Plan

## 1. Problem & Requirement Analysis
- **Problem**: Previously, only global schema JSON could be updated easily. For hundreds of dynamic job posts, internships, blog posts, company profiles, and categories, writing and maintaining manual JSON-LD is nearly impossible and error-prone.
- **Requirement**: Build an automated system that automatically detects and generates full, Google-compliant structured data (JSON-LD) for every job, internship, blog post, company, and category using their database records, with zero manual input required.

---

## 2. Proposed Architecture

### A. Dedicated Schema Service (`App\Services\SchemaService`) & `App\Helpers\SeoHelper`
Build rich generators for each entity type:
1. **Jobs & Internships (`JobPosting`)**:
   - Automatically detects internship vs full-time/part-time (`employmentType: 'INTERN' | 'FULL_TIME' | 'PART_TIME' | 'CONTRACTOR'`).
   - Determines remote status (`jobLocationType: 'TELECOMMUTE'`).
   - Injects hiring organization, logo, dates (`datePosted`, `validThrough`), salary range with currency (`baseSalary`), location, skills, and sanitized description.
2. **Blog Posts (`BlogPosting` / `Article`)**:
   - Injects headline, author name (Person), publisher (Organization with logo), publish & update timestamps, featured image, and excerpt/description.
3. **Company Profiles (`Organization` / `EmployerAggregateRating`)**:
   - Injects name, URL, logo, description, address, founding date, and social links.
4. **Category Hubs & Listings (`CollectionPage` / `ItemList` / `BreadcrumbList`)**:
   - Injects category title, URL, breadcrumbs, and listing meta.
5. **Global Pages (`Organization` / `WebSite`)**:
   - Injects global organization info and Google Sitelinks SearchAction.

---

### B. Hierarchical Automatic Injection in Frontend (`layouts/app.blade.php`, `layouts/blog.blade.php`)
Every page automatically loads schema following this priority:
1. **Tier 1 (Explicit Custom)**: If an admin provided a custom `schema_json` in CMS Page SEO, use it.
2. **Tier 2 (Automatic Dynamic)**: If viewing a job, internship, blog post, company, or category, automatically build and render its exact JSON-LD.
3. **Tier 3 (Global Fallback)**: If on home or static page, render global Organization / WebSite schema.

---

### C. CMS Page SEO 1-Click Auto-Generator
- Add an AJAX route: `GET /cms/seo/generate-entity-schema?type={type}&id={id}`
- In CMS Page SEO Create/Edit (`cms/seo/create-page.blade.php` and `cms/seo/edit-page.blade.php`), add an **"Auto-Generate Schema"** button so admins can preview or customize the auto-generated JSON-LD with 1 click.

---

## 3. Verification & Bug Finding
- Automated script to verify that:
  1. Job detail pages output valid `JobPosting` schema with all Google-required fields.
  2. Internship postings output `employmentType: "INTERN"`.
  3. Blog detail pages output valid `BlogPosting` schema.
  4. Company pages output valid `Organization` schema.
  5. Category pages output valid `CollectionPage` schema.
  6. All JSON-LD outputs pass `json_decode()` with 0 syntax errors.
