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
* [requestAnimationFrame](https://caniuse.com/requestanimationframe)
* [High Resolution Time API](https://caniuse.com/high-resolution-time)
* [NodeList API](https://caniuse.com/mdn-api_nodelist)
* [Window API: scrollTo](https://caniuse.com/mdn-api_window_scrollto)

## Installation and usage

Eventually, once the plugin has been reviewed and approved in the WordPress plugin repository, you will be able to install it from there. Until then, you can download a ZIP from the [GitHub releases page](https://github.com/felixarntz/fast-smooth-scroll/releases) and upload it to your WordPress site via _Plugins > Add New > Upload Plugin_.

## Frequently asked questions

### Where can I configure the plugin?

This plugin doesn't come with a settings screen or options of any kind. You install it, and it just works.

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
