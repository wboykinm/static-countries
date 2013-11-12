# Mapbox Vignettes
<em>Motto: Hay una manera mejor hacer esto en Node.</em>

## Point
Someone was interested in an endpoint that allowed you to type in a country name and get back a static image from the Mapbox API, without fiddling around with bounding boxes or centroid coordinates or optimal zoom levels. So this. Who might make use of this? Journalists, Aid workers, and HTML-savvy high school students working on term papers.

[Some Examples](http://wboykinm.github.io/static-countries/)

## Useage
Good lord, it's PHP. I'm very sorry about that. But you build a URL and it spits back an image. Pretty simple. The URL takes the following variables as query strings:
* ```name``` Country name, piece of a country name, whatever
* ```mapid``` Map ID, obtained from [your mapbox tileset](https://www.mapbox.com/developers/api-overview/#API.overview)
* ```width``` Desired image width in pixels
* ```height``` Desired image height in pixels

The URL construction looks like this:

```. . ./vignette.php?name=canada&mapid=examples.map-zr0njcqy&width=600&height=400```

This will return a 600X400px png image focused on Canada using the tileset "examples.map-zr0njcqy" (which is watermarked; use your own tiles).

## Source

You are welcome to use my server endpoint for fiddling/testing. For instance, this: 

http://dev.geosprocket.com/mapbox/vignette.php?name=bolivia&mapid=examples.map-zr0njcqy&width=300&height=300

Returns this:

<img src="http://dev.geosprocket.com/mapbox/vignette.php?name=bolivia&mapid=examples.map-zr0njcqy&width=300&height=300"/>

HOWEVER . . . I have not put a lot of juice into this server, so I strongly discourage you from using it in a production environment. 

### Another Caveat
Web Mercator projection is entirely unsuited to realistically representing polar-leaning countries like Russia, Canada and New Zealand. For that I recommend D3 and a tasty orthographic projection [like this](http://bl.ocks.org/wboykinm/7425298)

## To-Do
* Add a mask to bring focus to the country in question. More likely with a Canvas-based halo than a vector layer.
* Beef up the Database to include all levels of admin feature. CartoDB is currently backing this beast.
* Rewrite in Javascript. I mean, seriously? PHP?