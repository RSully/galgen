# galgen

A simple PHP gallery generator with minimal configuration. The idea is simple: run it against a directory and get a page you can hit via the browser to view images.

The support for "themes" is minimal, but usable.

## Theming

Themes are just a directory containing the following:

- `static/` a folder of any static assets that are required (js, css, images)
- `config.json` a config file
- `index.php` the main logic, which gets our code injected into

Our injected code makes a few variables visible that you can do whatever you wish with:

- `$images` an array of image paths for the gallery
- `$image` the current image, if applicable (from the `image` querystring parameter)
- `$title` the name of the gallery

## License

The images in the example folder are from [NASA](http://www.nasa.gov/centers/armstrong/multimedia/imagegallery/B-52/).

The original code in this project is licensed under the MIT license.
