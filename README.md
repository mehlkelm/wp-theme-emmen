# Emmen

An image-light WordPress blog theme in the Swiss / International Typographic Style. Strict grid, Helvetica, generous whitespace, configurable accent. Runs [stefan.pauwels.ch](https://stefan.pauwels.ch) and [zoziapps.ch](https://zoziapps.ch).

## Installation

Download `emmen.zip` from the [latest release](https://github.com/mehlkelm/wp-theme-emmen/releases/latest) and upload it under Appearance > Themes > Add New > Upload Theme. The accent colours are set per site under Appearance > Customize > Accent Colors.

## Updates

The theme checks this repository's releases and offers new versions through the normal WordPress theme update screen. No plugin is needed.

## Releasing

1. Bump `Version:` in `style.css` and commit.
2. Tag it: `git tag v1.2.0 && git push --tags`.
3. The release workflow builds `emmen.zip` and attaches it to a GitHub release. Sites pick it up on their next update check.

## Site-specific styles

`product-pages.css` and `product-pages-editor.css` hold the product pages on zoziapps.ch. Every rule is scoped to those pages and does nothing elsewhere.

## License

GPL-2.0-or-later.
