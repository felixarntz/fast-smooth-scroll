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

Another potential reason to use this plugin over other smooth scrolling solutions is accessibility: This plugin respects the user preferences around reduced motion, which can avoid discomfort for those with [vestibular motion disorders](https://www.a11yproject.com/posts/understanding-vestibular-disorders/).

You may already use a smooth scrolling plugin, but it is worth double checking that it doesn't use one of those outdated, inefficient, and inaccessible approaches that may slow down your site or affect user interactions negatively.

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

You can download the latest version from the [WordPress plugin repository](https://wordpress.org/plugins/fast-smooth-scroll/).

Please see the [plugin repository installation instructions](https://wordpress.org/plugins/fast-smooth-scroll/#installation) for detailed information on installation and the [plugin repository FAQ](https://wordpress.org/plugins/fast-smooth-scroll/#faq) for additional details on usage and customization.

Alternatively, if you use Composer to manage your WordPress site, you can also [install the plugin from Packagist](https://packagist.org/packages/felixarntz/fast-smooth-scroll):

```
composer require felixarntz/fast-smooth-scroll:^1.0
```

## Contributions

If you have ideas to improve the plugin or to solve a bug, feel free to raise an issue or submit a pull request right here on GitHub. Please refer to the [contributing guidelines](https://github.com/felixarntz/fast-smooth-scroll/blob/main/CONTRIBUTING.md) to learn more and get started.

You can also contribute to the plugin by translating it. Simply visit [translate.wordpress.org](https://translate.wordpress.org/projects/wp-plugins/fast-smooth-scroll) to get started.
