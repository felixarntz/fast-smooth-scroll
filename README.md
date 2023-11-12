[![PHP Unit Testing](https://img.shields.io/github/actions/workflow/status/felixarntz/fast-smooth-scroll/php-test.yml?style=for-the-badge&label=PHP%20Unit%20Testing)](https://github.com/felixarntz/fast-smooth-scroll/actions/workflows/php-test.yml)
[![Packagist version](https://img.shields.io/packagist/v/felixarntz/fast-smooth-scroll?style=for-the-badge)](https://packagist.org/packages/felixarntz/fast-smooth-scroll)
[![Packagist license](https://img.shields.io/packagist/l/felixarntz/fast-smooth-scroll?style=for-the-badge)](https://packagist.org/packages/felixarntz/fast-smooth-scroll)

# Fast Smooth Scroll

This lightweight plugin enhances user experience by enabling smooth scrolling for anchor links without the need for jQuery or other dependencies.

This plugin takes a **no-frills approach** to smooth scrolling, providing a **fast and performant user experience**.

**Simply enable the plugin**, and any anchor links (i.e. links that point to other content on the same page) will provide a smooth scrolling experience rather than abruptly jumping to the destination content.

The plugin relies on the **latest smooth scrolling techniques using CSS**. A very **fast and lightweight JavaScript polyfill (<1KB)** is included to equally support older browsers, including Internet Explorer. So you can rest assured this plugin covers your userbase.

## Why does this plugin exist?

Smooth scrolling is a basic feature to enhance user experience, so it shouldn't come at a performance cost that at the same time harms user experience elsewhere.

Several other smooth scrolling solutions unfortunately rely on outdated techniques such as jQuery, which can hurt your site's performance, and is really not necessary to provide the feature. Even browsers as old as 10 years don't need jQuery to achieve smooth scrolling. In fact, as of today you can achieve the behavior with only CSS, not even requiring any JavaScript.

You may already use a smooth scrolling plugin, but it is worth double checking that it doesn't use one of those outdated and inefficient approaches that may slow down your site or affect user interactions negatively.

## More technical details

This plugin simply enables smooth scrolling with the `scroll-behavior` CSS property. This property has been supported by all modern browsers for a few years now.

To support older browsers as well, a lightweight JavaScript polyfill is included, which is only loaded for browsers that lack support for the CSS property and doesn't require any dependencies. The polyfill uses latest JavaScript user experience best practices such as `requestAnimationFrame` to provide a smooth scrolling experience without potentially blocking other user interactions.

For relevant browser support, see:
* [CSS Scroll-behavior](https://caniuse.com/css-scroll-behavior)
* [CSS property: scroll-padding-top](https://caniuse.com/mdn-css_properties_scroll-padding-top)
* [prefers-reduced-motion media query](https://caniuse.com/prefers-reduced-motion)
* [requestAnimationFrame](https://caniuse.com/requestanimationframe)
* [High Resolution Time API](https://caniuse.com/high-resolution-time)
* [NodeList API](https://caniuse.com/mdn-api_nodelist)
* [Window API: scrollTo](https://caniuse.com/mdn-api_window_scrollto)

## Installation and usage

Eventually, once the plugin has been reviewed and approved in the WordPress plugin repository, you will be able to install it from there. Until then, you can download a ZIP from the [GitHub releases page](https://github.com/felixarntz/fast-smooth-scroll/releases) and upload it to your WordPress site via _Plugins > Add New > Upload Plugin_.

Alternatively, if you use Composer to manage your WordPress site, you can also [install the plugin from Packagist](https://packagist.org/packages/felixarntz/fast-smooth-scroll):

```
composer require felixarntz/fast-smooth-scroll:^1.0.0-beta.2
```

## Frequently asked questions

### Where can I configure the plugin?

This plugin doesn't come with a settings screen or options of any kind. You install it, and it just works.

### Why is the scrolling slightly off vertically?

If the anchor scrolling doesn't end up in exactly the right place, there is a good chance this is happening because your site uses a fixed header or another element that overlaps the main content.

For such situations, the plugin supports setting a scroll offset. You can use the filter `fast_smooth_scroll_offset` to set such an offset in pixels (default is 0, i.e. no offset).

For example, with the following code you would set a scroll offset of 120 pixels. This works for both the default CSS-only implementation as well as for the JavaScript polyfill.

```php
<?php

function myplugin_get_custom_scroll_offset() {
	return 120;
}
add_filter( 'fast_smooth_scroll_offset', 'myplugin_get_custom_scroll_offset' );

```

### Does the plugin support reduced motion preferences?

Yes! For better accessibility, clients that are configured to reduce motion will not be affected by the smooth scroll behavior.

The `prefers-reduced-motion` media query is used to detect such a preference. Note that this only works with the CSS-only solution, as the older browsers that would require the JavaScript polyfill do not support this preference.

### I don't care about smooth scrolling for older browsers. How can I disable the JavaScript polyfill?

Since the JavaScript polyfill is only loaded when needed and is extremely lightweight, there's probably not much value in disabling it. However, if you want to go for the purist solution of only relying on the CSS approach, you can certainly do so, using the built-in filter `fast_smooth_scroll_enqueue_scripts`, which defaults to `true`.

For example, with the following code you would ensure the JavaScript polyfill and even the simple feature detection check are never loaded:

```php
<?php

add_filter( 'fast_smooth_scroll_enqueue_scripts', '__return_false' );

```

### How can I test the JavaScript polyfill?

Most likely, you are using a modern browser which therefore does not trigger the JavaScript polyfill to load.

If you don't have a legacy browser handy, you can still test the behavior: You'll need to be logged in as an administrator, and then you can add a query parameter `fast_smooth_scroll_debug_polyfill=1` to any URL. For example, in case of the home page:

```
https://my-site.com/?fast_smooth_scroll_debug_polyfill=1
```

## Contributions

If you have ideas to improve the plugin or to solve a bug, feel free to raise an issue or submit a pull request right here on GitHub. Please refer to the [contributing guidelines](https://github.com/felixarntz/fast-smooth-scroll/blob/main/CONTRIBUTING.md) to learn more and get started.
