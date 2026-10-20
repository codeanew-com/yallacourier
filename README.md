# Yalla Courier

Website, shipment booking and back office for Yalla Courier (UAE parcel delivery).
Laravel 11 on PHP 8.2.

The app has three audiences, and the code is organised around them:

| Area | Who | Sign-in | URLs |
|---|---|---|---|
| **Frontend** | Anyone on the public site | none | `/`, `/{slug}`, `/country/{slug}`, `/shipment/*`, `/submit-form`, … |
| **Customer portal** | Business customers with an account | `customers` guard | `/customer/*` |
| **Admin** | Yalla Courier staff | default `web` guard | `/login`, `/admin/*` |

## Getting started

Requirements: PHP 8.2+ and Composer, plus MySQL/MariaDB (or SQLite for local work).

```bash
git clone https://github.com/codeanew-com/yallacourier.git
cd yallacourier
composer install
cp .env.example .env        # then fill in the values below
php artisan key:generate
php artisan migrate
php artisan serve
```

The site is CMS-driven: pages, couriers and countries are database rows managed in the admin
panel. Pages show content only after an admin account and the content exist; a fresh database
gives an empty site.

`php artisan sitemap:generate` rebuilds `public/sitemap.xml` (the admin "Generate sitemap" button runs the same code).

### Environment variables

Everything secret or server-specific lives in `.env`, which is never committed. `.env.example`
lists every key. The ones specific to this app:

| Variable | What it is |
|---|---|
| `APP_URL`, `APP_KEY` | Standard Laravel; `APP_KEY` comes from `php artisan key:generate`. |
| `DB_*` | Database connection. |
| `MAIL_*` | SMTP account. `MAIL_FROM_ADDRESS` must be a mailbox that account may send as, or the server rejects order emails. **Mail must work for staff to sign in** (see below). |
| `ADMIN_LOGIN_OTP` | `true` (default): staff log in with password **and** an emailed 6-digit code. Set `false` only as an emergency switch when mail is down. |
| `GOOGLE_MAPS_API_KEY` | Browser key for the address autocomplete on the booking forms. |

### What is not in this repository

These exist on the live server but are deliberately left out of git (see `.gitignore`):

- **`.env`**: credentials.
- **`storage/app/private/`**: customer shipping labels (AWB PDFs). They contain personal data and are
  only served through `OrderLabelController`, to an admin or the customer who owns the order.
- **`public/uploads/`**: images uploaded through the admin panel (page sections, country pages,
  review photos). Copy them from the server if you need a full local copy of the site.
- **Databases, dumps, archives and logs** (`*.sql`, `*.sqlite`, `*.zip`, `*.log`).

## Deployment

Every push to `main` deploys to yallacourier.com through GitHub Actions
(`.github/workflows/deploy.yml`). Nobody runs `git pull` on the server.

1. **Check:** syntax, code style (Pint), and that routes, config and Blade templates compile.
   Nothing deploys if this fails.
2. **Deploy:**
   - Back up the live database to `~/backups/yallacourier/` on the server (the 10 newest are kept).
   - Put the site in maintenance mode.
   - Upload the code with production dependencies, built on GitHub.
   - Run migrations and rebuild the caches.
   - Bring the site back up and check that `/` and `/login` return 200.

The server becomes an exact copy of the repository: files removed from the repo are removed from
the server. Three paths are never touched, because they hold server data that git doesn't have:
**`.env`**, **`storage/`** (sessions, logs, private shipping labels) and **`public/uploads/`**.
Change the live configuration by editing `.env` on the server.

Repository settings → *Secrets and variables → Actions → Secrets* (all six are secrets, because the repository is public):

| Name | Type | Value |
|---|---|---|
| `SSH_PRIVATE_KEY` | secret | Private half of the deploy key (its public half is in the server's `~/.ssh/authorized_keys`) |
| `SSH_KNOWN_HOSTS` | secret | Output of `ssh-keyscan -p <port> <host>` (lets GitHub verify the server) |
| `SSH_HOST` | secret | Server address |
| `SSH_PORT` | secret | SSH port (Hostinger: `65002`) |
| `SSH_USER` | secret | SSH user |
| `DEPLOY_PATH` | secret | Absolute path of the site on the server (the folder containing `artisan`) |

A deploy can also be started by hand from the *Actions* tab (*Deploy → Run workflow*).
To roll back, revert the commit and push; to restore data, use the newest backup in `~/backups/yallacourier/`.

## Security

- Never commit `.env`, database dumps, customer files or keys. If a secret is ever pushed, treat it
  as leaked: **rotate it** (deleting the commit is not enough, because forks and caches keep it).
- **The Google Maps key** is sent to every visitor's browser, so it is public by nature. Restrict it
  in Google Cloud Console to the site's domains (HTTP referrers) and to the Maps JavaScript and Places
  APIs, so nobody else can bill usage to it.
- **Staff sign in** with a password plus an emailed one-time code: 10-minute expiry, 5 attempts,
  resend once a minute.
- **Customer accounts** are created only by admins. Customers set their own password through an
  emailed link, and admins never see it.
- Please report vulnerabilities privately to the maintainers (see below), not in a public issue.

## Maintainers

Built and maintained by [Codeanew](https://codeanew.com) for Yalla Courier. Contact Codeanew about
security reports and anything else to do with this codebase.

## Folder structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/              Staff back office (everything under /admin)
│   │   │   ├── DashboardController     work queues, month stats
│   │   │   ├── OrderController         list/filters, edit & price, courier settlement, resend emails
│   │   │   ├── CustomerController      accounts: create, edit, suspend/ban/disable, password help, sessions
│   │   │   ├── BusinessLeadController  inbox for the public business form
│   │   │   ├── PageController          CMS pages (URL, SEO, visibility)
│   │   │   ├── PageMetaController      section content + images of the built-in pages
│   │   │   ├── CountryController       /country/{slug} landing pages
│   │   │   ├── CourierController, FaqController, ReviewController
│   │   │   ├── SeoController           robots.txt and sitemap.xml
│   │   │   └── TransactionController
│   │   ├── Customer/           Customer portal
│   │   │   ├── AuthController          login / logout
│   │   │   ├── PasswordController      forgot, reset, first-time setup, forced change
│   │   │   ├── AccountController       dashboard, shipments, e-billing, profile
│   │   │   └── WalletController        wallet at checkout (routes disabled, kept on purpose)
│   │   ├── Frontend/           Public website
│   │   │   ├── PageController          CMS pages by slug, country pages, thank-you pages, HS code lookup
│   │   │   ├── ShipmentRequestController  direct booking form
│   │   │   └── BusinessLeadController  business sign-up form
│   │   ├── Auth/               laravel/ui staff login (LoginController, ConfirmPasswordController)
│   │   ├── OrderLabelController  shipping-label download, shared by admins and customers
│   │   └── Controller.php
│   ├── Requests/               Form Requests (all validation), split the same way
│   │   ├── Admin/  Customer/  Frontend/
│   │   └── Concerns/FlashesFirstError.php
│   └── Middleware/
│       ├── AuthenticateCustomer.php        `customer` alias: portal pages need a customer login
│       └── EnforceCustomerAccountStatus.php on every web request: signs out blocked customers,
│                                           forces a pending temporary-password change
├── Services/                   Business logic, grouped by domain (used by every area)
│   ├── Orders/      ShipmentBookingService, OrderUpdater, OrderFilters, OrderPricing,
│   │                CourierSettlementService, OrderMailService
│   ├── Customers/   CustomerAccountService, CustomerSessionRevoker
│   ├── Content/     PageMetaService, SitemapGenerator
│   ├── ActivityLogger.php   writes the admin activity trail (log_admin)
│   └── ImageUploader.php    validated CMS image uploads + `files` records
├── Models/                     Eloquent models (shared; one per table)
├── Policies/CustomerPolicy.php who may manage customer accounts
├── Notifications/CustomerPasswordLink.php
├── View/Composers/AdminSidebarComposer.php  sidebar badge counts
└── Providers/AppServiceProvider.php

routes/
├── admin.php      staff login + /admin/* (all behind `auth`)
├── customer.php   /customer/*
├── web.php        public site; ends with the /{slug?} catch-all
└── console.php

resources/views/
├── admin/         back office (layout: admin/layouts/master)
├── customer/      customer portal (uses the public layout frontend/layouts/master)
├── frontend/      public site, one folder per built-in page
├── auth/          staff login screens
├── mails/         order emails
├── partials/      shared (favicons)
└── vendor/mail/   branded notification email templates
```

## How customer and admin are separated

- **Authentication.** Staff use the default `web` guard (`App\Models\User`); customers use the
  `customers` guard (`App\Models\CustomerModel`, table `customers`). The two never share a login.
  Every `users` row is an admin.
- **Routes.** One file per area. Admin routes are grouped under the `admin` prefix with `auth`
  middleware; customer portal pages use the `customer` middleware. The only endpoint both use,
  `/order-package/{package}/label`, lives in `web.php` and checks "admin, or the customer who owns
  the order" itself.
- **Authorisation.** Customer-account actions in the admin are checked by `CustomerPolicy`, either in
  the controller (`$this->authorize(...)`) or in the Form Request's `authorize()`. Customers can only
  open their own orders (`Customer\AccountController::showShipment` returns 404 otherwise).
- **Views.** `admin/`, `customer/` and `frontend/` mirror the controller folders.
- **Shared code.** Models, services and notifications are shared rather than duplicated per area.
  Areas differ in *who may do what*, not in the domain rules. For example, `OrderPricing` is used by the
  admin order screen and documents the rules the booking data follows.

## Architectural decisions

- **Thin controllers.** Controllers read the request, call a service, and choose the response
  (view, redirect, flash message). Multi-step work such as booking a shipment, saving an order with
  repricing and an audit line, account onboarding or courier settlement lives in `app/Services`.
- **Validation is in Form Requests.** Some public and customer templates show a single flashed
  `msg` line instead of per-field errors. Their requests use `Concerns\FlashesFirstError` to keep
  that behaviour. `UpdateOrderRequest` and `ChangeCustomerStatusRequest` also flash a `msg`/`class`
  banner. The status change uses the `status` error bag, which its modal reads.
  `tests/Feature/FormRequestFailureTest.php` pins these behaviours.
- **Route names and URLs are a contract.** Views and tests call `route('...')` by name, and names
  like `admin-pages.*` and `frontend.customer.*` are historical, so they were kept exactly. Check
  `php artisan route:list` before renaming anything.
- **Route order matters.** `bootstrap/app.php` loads `admin.php`, then `customer.php`, then `web.php`.
  The public `/{slug?}` catch-all must stay last or it swallows URLs such as `/admin`.
- **Model names were not changed.** The `*Model` class names (`OrderModel`, `CountriesModel`, …)
  are not Laravel convention, but Blade views reference them inline in ~900 places. Renaming them
  would be high-risk for no functional gain. Domain constants live on the models
  (`OrderModel::STATUSES`, `PageModel::SYSTEM_PAGE_IDS`, `CustomerModel::STATUSES`).
- **Built-in pages are data-driven.** The public template per page id is
  `Frontend\PageController::TEMPLATES`. The admin editor per page id is
  `Admin\PageMetaController::EDITORS`. The image slots each editor saves are
  `PageMetaService::IMAGE_SLOTS`. Adding a built-in page means adding it to these maps and to
  `PageModel::SYSTEM_PAGE_IDS`.
- **Activity log.** `ActivityLogger::record()` writes `log_admin`. The order and customer screens
  read their history back by message prefix (`Order #12: …`, `Customer #7: …`), so keep those
  prefixes.
- **Admin login uses an emailed code.** After a correct password, `Auth\LoginController` emails a
  6-digit code (`Services/Auth/AdminLoginOtp`) and `Auth\LoginOtpController` signs the admin in only
  once it is entered (`/login/verify`; 10-minute expiry, 5 tries, resend once a minute). Mail must be
  working for staff to sign in; `ADMIN_LOGIN_OTP=false` is the emergency switch.
- **Customer password policy** is `Password::defaults()` (8+ characters, letters and numbers),
  set in `AppServiceProvider`.

## Tests and checks

The test suite runs against the database configured for the `testing` environment (see
`phpunit.xml`). Feature tests use `DatabaseTransactions`, so they roll back their own data.

```bash
php artisan test                 # whole suite
php artisan test --filter=Admin  # one area
php artisan route:list           # every URL, name and middleware
vendor/bin/pint                  # code style (Laravel preset)
vendor/bin/pint --test           # style check only, e.g. in CI
```

Some tests are deliberately skipped (`markTestSkipped`) because they cover the customer
wallet/top-up and self-registration features, which are switched off. Each skip message says why.
