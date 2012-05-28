=== BNS Inline Asides ===
Contributors: cais
Donate link: http://buynowshop.com
Tags: posts, pages, content, shortcode
Requires at least: 3.0
Tested up to: 3.4
Stable tag: 0.6.2

This plugin will allow you to style sections of the post, or page, content with added emphasis by leveraging a style element from the active theme.

== Description ==

Have you ever wanted to add a personal comment into the body of a post or page and have it stand out from the rest of the content?
Have you really wanted to throw a rant in a review because the subject just really got under your skin but you don't want to dramatically disrupt the content?
This plugin will allow you to style sections of the post, or page, content with a shortcode that can add more emphasis by leveraging a style element from the active theme.
These asides can be left open as part of the content flow; or these asides can be closed to leave your readers the option of opening them if they choose to.

== Installation ==

This section describes how to install the plugin and get it working.

1. Go to the "Plugins" menu in the Administration Panels ("dashboard").
2. Click the 'Add New' link.
3. Click the "Upload" link. 
4. Browse for the bns-inline-asides.zip file on your computer; upload; and, install accordingly.
5. Activate.

-- or -

1. Go to the "Plugins" menu in the Administration Panels ("dashboard").
2. Click the 'Add New' link.
3. Search for BNS Inline Asides.
4. Install.
5. Activate.

Please read this article for further assistance: http://wpfirstaid.com/2009/12/plugin-installation/

----

= Usage =
This plugin makes use of WordPress Shortcode API (additional information can be found in the codex here: http://codex.wordpress.org/Shortcode_API)

The basic shortcode usage is `[aside]CONTENT[/aside]`. The default values of the shortcode are type: aside; and, status: open.

* `[aside]CONTENT[/aside] = [aside type="aside" status="open"]CONTENT[/aside]`

To use the `[aside]` shortcode and have it initially "closed" any status other than "open" will work as the plugin will change the status to "closed" if it is not equal to "open".

Some pre-defined aside types are currently available:

* Note - uses the theme element's default text color on a Light Grey background
* Rant - uses black text on a red background with a non-repeating flame graphic

See the frequently asked questions section for how to add your own custom type.

== Frequently Asked Questions ==

= How can I style the plugin output? =
To add your own custom aside type styles you might consider creating a new stylesheet in this plugin's folder using the name: bnsia-custom-types.css

The plugin will create a class name from the custom aside type you use in your shortcode. For example, `[aside type="bacon"]` will generate these classes you can style:

* .open-aside.bacon
* .close-aside.bacon
* .bnsia.aside.bacon
* blockquote.aside.bacon
* p.aside.bacon

This method can also be used to over-write the Pre-Defined Aside Types styles as the bnsia-custom-types.css file loads after the main stylesheet.

The bnsia-custom-types.css stylesheet should not be over-written by updates.

= How do I use the 'show' and 'hide' parameters? =
If you do not want to use the default 'show' and 'hide' parameters, you can change them to your own preference in each instance of the shortcode. If you want your aside type to be dynamically inserted into the message simply use the `%s` placeholder in your custom message.

Here are some examples:

* `[aside type="bacon" show="Want to see my <em>%s</em>?" status="closed"]`
* `[aside type="soup" hide="No %s for you!"]`


== Screenshots ==
1. Sample using pre-defined aside Note (open).
2. Sample using pre-defined aside Note (closed).
3. Sample using pre-defined aside Rant (closed).
4. Sample using pre-defined aside Rant (open).

== Other Notes ==

= Copyright 2011-2012  Edward Caissie  (email : edward.caissie@gmail.com) =

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License version 2,
  as published by the Free Software Foundation.

  You may NOT assume that you can use any other version of the GPL.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

  The license for this software can also likely be found here:
  http://www.gnu.org/licenses/gpl-2.0.html
  
= Acknowledgements =

  Credits for jQuery assistance: Trevor Mills www.topquarkproductions.ca

= Screenshots Source Content =
Sample content taken from the "Readability" post of the Theme Unit Test data found here: http://codex.wordpress.org/Theme_Unit_Test used with the default Twenty Ten Theme.

== Upgrade Notice ==
Please stay current with your WordPress installation, your active theme, and your plugins.

== Changelog ==
= 0.6.2 =
* confirmed compatible with WordPress 3.4
* inline documentation updates
* added "changelog" styles

= 0.6 =
* released November 2011
* confirmed compatible with WordPress version 3.3
* added PHPDoc style documentation
* added `BNS Inline Asides TextDomain` i18n support
* added `BNS Theme Element` to set CSS element to be used
* added `bnsia` class (to be used as default)
* removed `is_admin` check from enqueue action function (not needed)
* removed 'span' support; going forward with block display elements only

= 0.5 =
* released June 2011
* re-wrote the enqueue stylesheets code to be more correct

= 0.4.1 =
* enqueued stylesheets
* released May 23, 2011

= 0.4 =
* verified to work with WordPress version 3.2-beta1 
* re-wrote the BNSIA_PATH define statement
* re-wrote the stylesheet paths to use BNSIA_PATH
* released May 23, 2011 

= 0.3 =
* verified to work with WordPress version 3.1.2
* added new parameters to allow end-user to define 'show' and 'hide' messages
* released: May 7, 2011

= 0.2 =
* add the 'span' element
* fix readme markup issues

= 0.1 =
* Initial Release.
* Released: February 20, 2011