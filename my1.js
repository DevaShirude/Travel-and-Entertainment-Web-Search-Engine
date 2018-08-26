
/*var http = require('http');

http.createServer(function (req, res) {
    res.writeHead(200, {'Content-Type': 'text/html'});
    res.end('Hello World!');
}).listen(8080);*/




var express = require('express')
var app = express()
var port = process.env.PORT || 8080;

var bodyParser = require('body-parser');
var request = require('request');
app.use(bodyParser.json()); // support json encoded bodies
app.use(bodyParser.urlencoded({ extended: true })); // support encoded bodies



app.post('/search', function IamHere(req, res) {
    var keyword = req.body.keyword;
    var category = req.body.category;
    var distance = req.body.distance;
    var location = req.body.location;

    $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=" . urlencode($searchit);
        $url .= "&radius=" . urlencode($distance);
        $url .= "&type=" . str_replace("+","_",urlencode($category));
        $url .= "&keyword=" . urlencode($keyword);
        $url .= "&key=AIzaSyCQW4VI0NUiYGGl1ALco25AZS0Z_iHRF6E";



  
  res.send('I have come till here!')
})

function S


app.listen(8000, function () {
  console.log('Example app listening on port 8000!')
})




