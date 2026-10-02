=== Uncoder ===
Contributors: uncoder
Requires at least: 6.6
Tested up to: 7.1
Requires PHP: 8.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

The free companion theme for the Uncoder visual website builder: a clean, fast canvas that gets out of the way.

== Description ==

Uncoder is a lightweight classic theme made for the Uncoder website builder (https://uncoderbuilder.com/). It does as little as possible, so that what you build with Uncoder looks exactly as designed:

* Pages and posts built with Uncoder get the full width of the window, without theme padding or a content column, also with the default page template.
* Headers, footers and page layouts from the Uncoder Theme Builder replace the theme's own, with no duplicate header or footer.
* Posts and pages written in the block editor get readable typography and a reading column, with wide and full-width blocks.
* The theme's colors and fonts follow your Uncoder Design System (the --uncoder-c-* and --uncoder-f-* variables), with sensible defaults when the plugin is not active.
* A simple header with your logo or site title and a menu, a footer with a second menu, a mobile menu that works without JavaScript, and styles for comments, search and the 404 page.
* About 10 KB of CSS (3 KB compressed), no JavaScript of its own, no web fonts, no external requests, no tracking.

The theme also works on its own, without the plugin.

== Installation ==

1. Download uncoder-theme.zip from https://github.com/UncoderBuilder/uncoder-theme/releases/latest (later versions arrive as normal theme updates while the theme is active).
2. In WordPress, go to Appearance > Themes > Add New Theme > Upload Theme, choose the zip file and click Install Now.
3. Click Activate.
4. Optional: add your logo in Appearance > Customize > Site Identity, and assign menus to the Primary menu and Footer menu locations in Appearance > Menus.

== Frequently Asked Questions ==

= Do I need the Uncoder plugin? =

No. The theme works without it. With Uncoder active you can build your pages, header and footer visually, and the theme uses your Design System colors and fonts. While the plugin is not active, a small notice on the Themes screen links to it; dismiss it once and it does not come back.

= Which page template should I use for pages built with Uncoder? =

Any. With the default template the page title is shown above your content (turn on "Hide page title" in the Uncoder page settings to remove it) and your sections run edge to edge. "Uncoder Full Width" does the same without the title, and "Uncoder Canvas" also leaves out the header and footer.

= Where do the header and footer come from? =

From the theme, until you create a header or footer template in the Uncoder Theme Builder. Then Uncoder prints its template instead, on the pages where its display conditions match.

= Does it support WooCommerce? =

Yes. Shop pages render inside the theme's layout with WooCommerce's own styles.

= Can I make a child theme? =

Yes. Set "Template: uncoder" in the child theme's style.css and enqueue the child stylesheet with the parent's handle, "uncoder-theme", as a dependency.

== Changelog ==

= 1.0.0 =
* First release.

== Copyright ==

Uncoder WordPress Theme, Copyright 2026 Uncoder.
Uncoder is distributed under the terms of the GNU GPL v2 or later.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

Resources:

* screenshot.png, Copyright 2026 Uncoder. Original artwork made for this theme, including the Uncoder logo. License: GPLv2 or later.
* Menu and close icons in inc/template-tags.php, Copyright 2026 Uncoder. License: GPLv2 or later.
