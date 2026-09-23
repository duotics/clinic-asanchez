# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A legacy procedural PHP clinic management app (patients, clinical histories, consultations, exams, prescriptions, billing, IESS reports). UI text, identifiers and DB columns are in Spanish. **It targets PHP 5.6 and uses the removed `mysql_*` extension**, so it only runs inside the XAMPP 5 container. Do not modernize it to `mysqli`/PDO or PHP 7+ syntax (`??`, scalar type hints, etc.) unless asked.

## Environment and commands

- The repo lives at `www/clinic-asanchez` inside the `xampp5-docker` project. `../../docker-compose.yml` runs container `myXampp5` (XAMPP 5 / PHP 5.6.40) with `./www` mounted at `/www`. There is no `php` on the host.
- There is no build step and no test suite. The check to run after edits is a lint in the container:
  ```sh
  docker exec myXampp5 /opt/lampp/bin/php -l /www/clinic-asanchez/path/to/file.php
  ```
- Dependencies are committed/installed in `vendor/` (Composer, only `vlucas/phpdotenv` ^4, platform pinned to PHP 5.6) and `node_modules/` (Bootstrap 3, Bootswatch 3, Font Awesome 6, served directly to the browser). Both are gitignored.
- Configuration is in `.env` (see `.env.example`): `APP_URL` (the public base URL, which must end in `/`), `DB_*` and branding vars.
- The DB schema (structure only, including triggers) is in `docs/schema.sql`, dumped from the live `clinic_asanchez` database in container `myDb5` (MariaDB 11.5). Check column names there before writing SQL. Never commit table data, because it holds patient records. Regenerate it after schema changes:
  ```sh
  docker exec -e MYSQL_PWD=<DB_PASS> myDb5 mariadb-dump -uroot --no-data --skip-comments --skip-dump-date clinic_asanchez | sed -e 's/ AUTO_INCREMENT=[0-9]*//' -e '1{/sandbox mode/d}' > docs/schema.sql
  ```
  The old `db/20230901-urologoh_clinic-structure.sql` in git history (`fa7d438`) belongs to a different app (`tbl_*` tables). Don't use it.

## Architecture

**Bootstrap chain.** Every page starts with `include('init.php')` (or `include('../../init.php')` from `com/*/`). `init.php` starts the session, loads Composer and dotenv, then includes:
- `system/paths.php` defines two parallel sets of path variables. Filesystem constants (`RAIZ`, `RAIZc`, `RAIZf`, `RAIZm`, `RAIZs`, `RAIZa`…) are used for `include`. URL globals (`$RAIZ`, `$RAIZc`, `$RAIZa`, `$RAIZn`…, built from `APP_URL`) are used in HTML `href`/`src`. Don't mix them up.
- `system/config.php` parses `system/config.ini` into `$_SESSION['conf']`, exposed as `$cfg`. It holds UI strings and icons such as `$cfg['i']['new']` and `$cfg['b']['ins']`. It also sets the timezone to America/Guayaquil and the Spanish locale, and defines `$sdate`/`$sdatet`.
- `system/conn/conn.php` opens a global `mysql_pconnect` connection. All queries call `mysql_query()` directly against it.
- `system/fncts.php` is the global function library. It loads `system/inc/fnc_sys.php` (auth, menus, page headers, uploads, `SSQL`), `fnc_data.php` (row/lookup helpers), `fnc_gen.php` (select/form generators), `fnc_tra.php` (report inserts, `AUD()` audit log) and `fncDocs.php`, plus bundled libs (html2pdf, phplot, paginator).

**Components (`com/com_*`).** Each feature folder is a self-contained set of pages, usually:
- `index.php` / `*_list.php` / `form.php` / `_form.php` are display pages. The typical page skeleton is: `init.php` → `$dM = vLogin('MENU_NAME')` → `include(RAIZf.'head.php')` → `include(RAIZm.'mod_menu/menuMain.php')` → content → `include(RAIZf.'footer.php')`.
- `_acc.php` (sometimes `actions.php`) is the POST/GET action handler. It reads params via `vParam('acc', $_GET…, $_POST…)`, checks `$data['mod'] == md5($dM['mod_ref'])` and dispatches on hashed action codes such as `$acc == md5("INSp")`/`md5("UPDp")`/`md5("DELd")`. It wraps writes in manual `BEGIN`/`COMMIT`/`ROLLBACK`, accumulates messages in `$LOG`, and debug output in `$LOGd` (shown when `$vD` is TRUE). It stores the result in `$_SESSION['LOG']` and redirects to `$goTo`. `sLOG()` renders that flash message on the next page.
- `_fncts.php` holds component-local functions, and `json.php`/`search_*.php` are AJAX endpoints.
- Files named `* - Copia*.php` and `*-old`/`*-ant` folders are stale backups. Ignore them unless asked.

**Auth and menus.** `login()` in `fnc_sys.php` stores the user row in `$_SESSION['dU']`. `vLogin($menuName)` redirects to `wrongaccess.php` unless the session user has that entry in `db_menus_items`/`db_menus_user`. On success it returns the joined `db_componentes` row (`mod_cod`, `mod_ref`, …) that pages use for headers (`genPageHeader($dM['mod_cod'], …)`) and form tokens.

**Shared UI.** `frames/` holds the page chrome (`head.php` sets JS globals `RAIZ`/`RAIZc`/`RAIZs`, then includes `system/styles.php` and `system/libs.php`) and print headers/footers. `modulos/mod_*` holds reusable widgets (main menu, taskbars, user header, image upload). The frontend is jQuery 1.11 + Bootstrap 3 + chosen, tablesorter, TinyMCE, fancybox, gritter and fullcalendar, all loaded in `system/libs.php`. `libs.php` also wires the global confirm-before-submit handlers: `#vAcc` is the main save button (Ctrl+S clicks it), and `.vAccM`/`.vAccL` do the same for list and link actions.

## Conventions

- Escape every value that goes into SQL through `SSQL($value, 'text'|'int'|'date'|…)` (the Dreamweaver-style `GetSQLValueString`) inside `sprintf`. Table names are prefixed `db_` (e.g. `db_pacientes`, `db_paciente_hc`, `db_consultas`).
- Recent work fixes PHP notices and fatal errors across modules. Commits are small and scoped, with messages like `fix <what> in <module>`. Follow the same style: initialize variables, use `isset(...) ? ... : NULL` rather than `??`, and quote array keys. Never rely on `short_open_tag` (`<?`); always use `<?php`.
