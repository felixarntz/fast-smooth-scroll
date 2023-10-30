=== Fast Smooth Scroll ===

Plugin Name:       Fast Smooth Scroll
Plugin URI:        https://wordpress.org/plugins/fast-smooth-scroll/
Author:            Felix Arntz
Author URI:        https://felix-arntz.me
Contributors:      flixos90
Donate link:       https://felix-arntz.me/wordpress-plugins/
Requires at least: 5.0
Tested up to:      6.4
Requires PHP:      5.2
Stable tag:        1.0.0-beta.1
License:           GNU General Public License v2 (or later)
License URI:       https://www.gnu.org/licenses/gpl-2.0.html
Tags:              smooth scroll, smooth scrolling, scroll animation, scroll behavior, performance, anchor links, user experience, lightweight

This lightweight plugin enhances user experience by enabling smooth scrolling for anchor links without the need for jQuery or other dependencies.

== Description ==

This plugin takes a **no-frills approach** to smooth scrolling, providing a **fast and performant user experience**.

**Simply enable the plugin**, and any anchor links (i.e. links that point to other content on the same page) will provide a smooth scrolling experience rather than abruptly jumping to the destination content.

The plugin relies on the **latest smooth scrolling techniques using CSS**. A very **fast and lightweight JavaScript polyfill (<1KB)** is included to equally support older browsers, including Internet Explorer. So you can rest assured this plugin covers your userbase.

= Why does this plugin exist? =

Smooth scrolling is a basic feature to enhance user experience, so it shouldn't come at a performance cost that at the same time harms user experience elsewhere.

Several other smooth scrolling solutions unfortunately rely on outdated techniques such as jQuery, which can hurt your site's performance, and is really not necessary to provide the feature. Even browsers as old as 10 years don't need jQuery to achieve smooth scrolling. In fact, as of today you can achieve the behavior with only CSS, not even requiring any JavaScript.

You may already use a smooth scrolling plugin, but it is worth double checking that it doesn't use one of those outdated and inefficient approaches that may slow down your site or affect user interactions negatively.

= More technical details =

This plugin simply enables smooth scrolling with the `scroll-behavior` CSS property. This property has been supported by all modern browsers for a few years now.

To support older browsers as well, a lightweight JavaScript polyfill is included, which is only loaded for browsers that lack support for the CSS property and doesn't require any dependencies. The polyfill uses latest JavaScript user experience best practices such as `requestAnimationFrame` to provide a smooth scrolling experience without potentially blocking other user interactions.

For relevant browser support, see:
* [CSS Scroll-behavior](https://caniuse.com/css-scroll-behavior)
* [requestAnimationFrame](https://caniuse.com/requestanimationframe)
* [High Resolution Time API](https://caniuse.com/high-resolution-time)
* [NodeList API](https://caniuse.com/mdn-api_nodelist)
* [Window API: scrollTo](https://caniuse.com/mdn-api_window_scrollto)

== Installation ==

1. Upload the entire `fast-smooth-scroll` folder to the `/wp-content/plugins/` directory or download it through the WordPress backend.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= Where can I configure the plugin? =

This plugin doesn't come with a settings screen or options of any kind. You install it, and it just works.

= I don't care about smooth scrolling for older browsers. How can I disable the JavaScript polyfill? =

Since the JavaScript polyfill is only loaded when needed and is extremely lightweight, there's probably not much value in disabling it. However, if you want to go for the purist solution of only relying on the CSS approach, you can certainly do so, using the built-in filter `fast_smooth_scroll_enqueue_scripts`, which defaults to `true`.

For example, with the following code you would ensure the JavaScript polyfill and even the simple feature detection check are never loaded:

`
<?php

add_filter( 'fast_smooth_scroll_enqueue_scripts', '__return_false' );

`

= How can I test the JavaScript polyfill? =

Most likely, you are using a modern browser which therefore does not trigger the JavaScript polyfill to load.

If you don't have a legacy browser handy, you can still test the behavior: You'll need to be logged in as an administrator, and then you can add a query parameter `fast_smooth_scroll_debug_polyfill=1` to any URL. For example, in case of the home page:

`
https://my-site.com/?fast_smooth_scroll_debug_polyfill=1
`

= Where should I submit my support request? =

For regular support requests, please use the [wordpress.org support forums](https://wordpress.org/support/plugin/fast-smooth-scroll). If you have a technical issue with the plugin where you already have more insight on how to fix it, you can also [open an issue on GitHub instead](https://github.com/felixarntz/fast-smooth-scroll/issues).

= How can I contribute to the plugin? =

If you have ideas to improve the plugin or to solve a bug, feel free to raise an issue or submit a pull request in the [GitHub repository for the plugin](https://github.com/felixarntz/fast-smooth-scroll). Please stick to the [contributing guidelines](https://github.com/felixarntz/fast-smooth-scroll/blob/main/CONTRIBUTING.md).

You can also contribute to the plugin by translating it. Simply visit [translate.wordpress.org](https://translate.wordpress.org/projects/wp-plugins/fast-smooth-scroll) to get started.

== Changelog ==

= 1.0.0 =
* First stable version
