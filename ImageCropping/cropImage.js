var x = 0;
var y = 0;
var data;

jQuery(function() {
    var picture = $('#mypic');
    picture.guillotine({width: 250, height: 250});

    // Make sure the image is completely loaded before calling the plugin
    picture.one('load', function(){

        // Initialize plugin (with custom event)
        picture.guillotine({eventOnChange: 'guillotinechange'});

        // Display inital data
        data = picture.guillotine('getData');
        for(var key in data) { $('#'+key).html(data[key]); }

        // Bind button actions
        $('#rotate_left').click(function(){ picture.guillotine('rotateLeft'); });
        $('#rotate_right').click(function(){ picture.guillotine('rotateRight'); });
        $('#fit').click(function(){ picture.guillotine('fit'); });
        $('#zoom_in').click(function(){ picture.guillotine('zoomIn'); });
        $('#zoom_out').click(function(){ picture.guillotine('zoomOut'); });

        // Update data on change
        picture.on('guillotinechange', function(ev, data, action) {
            data.scale = parseFloat(data.scale.toFixed(4));
            for(var k in data) { $('#'+k).html(data[k]); }
        });
    });

    // Make sure the 'load' event is triggered at least once (for cached images)
    if (picture.prop('complete')) picture.trigger('load')
});

$(document).ready(function() {
    $("#subbtn").click(function() {
        for (var key in data) {
            console.log(data[key]);
            // scale - angle - x - y - w - h
        }
        // alert("hello");
        $.post("image.php", {
                scale: data["scale"],
                angle: data["angle"],
                x: data["x"],
                y: data["y"],
                w: data["w"],
                h: data["h"]
            },
            function(data, status) {
                $("#btnfeedback").html(data);
            }
        );
    });
});
