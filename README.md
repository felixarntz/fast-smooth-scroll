# Fast Smooth Scroll

This lightweight plugin enhances user experience by enabling smooth scrolling for anchor links without the need for jQuery or other dependencies.

This plugin takes a no-frills approach to smooth scrolling, providing a fast and performant user experience.

Simply enable the plugin, and any anchor links (i.e. links that point to other content on the same page) will provide a smooth scrolling experience rather than abruptly jumping to the destination content.

The plugin relies on the latest smooth scrolling techniques using CSS. A very fast and lightweight JavaScript polyfill (<1KB) is included to equally support older browsers, including Internet Explorer. So you can rest assured this plugin covers your userbase.

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

You can download the latest version from the [WordPress plugin repository](https://wordpress.org/plugins/fast-smooth-scroll/).

Please see the [plugin repository instructions](https://wordpress.org/plugins/fast-smooth-scroll/#installation) for detailed information on installation and usage.

## Contributions

If you have ideas to improve the plugin or to solve a bug, feel free to raise an issue or submit a pull request right here on GitHub. Please refer to the [contributing guidelines](https://github.com/felixarntz/fast-smooth-scroll/blob/main/CONTRIBUTING.md) to learn more and get started.

You can also contribute to the plugin by translating it. Simply visit [translate.wordpress.org](https://translate.wordpress.org/projects/wp-plugins/fast-smooth-scroll) to get started.
