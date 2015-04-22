/**
 * Plugin's jquery functions
 * Version 2.17
 */
 
 /** Get the pre-defined map style (id is a number between 1-30 inclusive, representing the id of the map style) **/
 function getStyleString(id) {
    var mapstyle;
    switch (id) {
    case '1':
        mapstyle = [{"stylers":[{"featureType":"all"}]}];
        break;
    case '2':
        mapstyle = [{"stylers":[{"featureType":"all"},{"saturation":-100},{"gamma":0.50},{"lightness":30}]}];
        break;
    case '3':
        mapstyle = [{"stylers":[{"invert_lightness":true},{"visibility":"on"}]}];
        break;
    case '4':
        mapstyle = [{"stylers":[{"invert_lightness":true},{"hue":"#0000b0"},{"saturation":-30}]}];
        break;
    case '5':
        mapstyle = [{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]},{"featureType":"landscape","stylers":[{"color":"#f2e5d4"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"administrative","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"road"},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{},{"featureType":"road","stylers":[{"lightness":20}]}];
        break;
    case '6':
        mapstyle = [{"stylers":[{"lightness":10},{"gamma":1.2},{"saturation":-20},{"visibility":"on"},{"weight":0.1},{"hue":"#00ccff"}]}];
        break;
    case '7':
        mapstyle = [{"stylers":[{"saturation":-20},{"visibility":"on"},{"hue":"#00ccff"},{"invert_lightness":true},{"lightness":5}]}];
        break;
    case '8':
        mapstyle = [{"stylers":[{"saturation":-20},{"visibility":"on"},{"lightness":5},{"hue":"#ff004c"},{"gamma":1.45}]}];
        break;
    case '9':
        mapstyle = [{"featureType":"water","stylers":[{"color":"#021019"}]},{"featureType":"landscape","stylers":[{"color":"#08304b"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#0c4152"},{"lightness":5}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#0b434f"},{"lightness":25}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"color":"#0b3d51"},{"lightness":16}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#000000"},{"lightness":13}]},{"featureType":"transit","stylers":[{"color":"#146474"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#144b53"},{"lightness":14},{"weight":1.4}]}];
        break;
    case '10':
        mapstyle = [{"stylers":[{"visibility":"on"},{"saturation":-30},{"hue":"#ccff00"},{"lightness":-20},{"gamma":1},{"weight":0.1},{"invert_lightness":true}]}];
        break;
    case '11':
        mapstyle = [{"stylers":[{"hue":"#00ccff"},{"saturation":5},{"lightness":-20}]}];
        break;
    case '12':
        mapstyle = [{"featureType":"road","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"hue":149},{"saturation":-78},{"lightness":0}]},{"featureType":"road.highway","stylers":[{"hue":-31},{"saturation":-40},{"lightness":2.8}]},{"featureType":"poi","elementType":"label","stylers":[{"visibility":"off"}]},{"featureType":"landscape","stylers":[{"hue":163},{"saturation":-26},{"lightness":-1.1}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"hue":3},{"saturation":-24.24},{"lightness":-38.57}]}];
        break;
    case '13':
        mapstyle = [{"stylers":[{"gamma":1.58},{"saturation":30},{"weight":0.1}]}];
        break;
    case '14':
        mapstyle = [{"stylers":[{"invert_lightness":true},{"weight":0.1},{"hue":"#00ffa2"},{"visibility":"on"},{"saturation":-120},{"lightness":10},{"gamma":1.2}]}];
        break;
    case '15':
        mapstyle = [{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#00ccff"},{"weight":0.1},{"saturation":80}]},{"featureType":"road.local","elementType": "geometry","stylers":[{"visibility":"on"},{"lightness":30}]},{"featureType":"transit","stylers":[{"hue":"#0077ff"},{"lightness":100},{"color":"#141480"},{"visibility":"simplified"},{ "saturation":-30},{"gamma":0.96},{"invert_lightness":true}]},{"featureType":"administrative.neighborhood","stylers":[{"invert_lightness":true},{"visibility":"on"}]},{"featureType": "road.highway.controlled_access","stylers":[{"visibility":"simplified"}]},{"featureType":"road.local","stylers":[{"weight":0.1}]},{"featureType":"road.local","stylers":[{ "visibility":"off"}]},{"featureType":"administrative","stylers":[{"invert_lightness":true},{"hue":"#00ff66"},{"saturation":30},{"lightness":-20},{"gamma":1.91}]},{"stylers":[{ "weight":0.1}]}];
        break;
    case '16':
        mapstyle = [{"featureType":"road","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"visibility":"off"}]},{"featureType":"administrative","stylers":[{ "weight":0.1}]}];
        break;
    case '17':
        mapstyle = [{"stylers":[{"hue":"#ffd500"},{"lightness":-30}]}];
        break;
    case '18':
        mapstyle = [{"featureType":"road","stylers":[{"hue":"#e6ff00"}]},{"featureType":"road","stylers":[{"visibility":"on" },{"weight":0.1},{"lightness":10},{"gamma":0.96}]},{ "featureType":"administrative","elementType":"labels.icon","stylers":[{"visibility":"simplified"},{"weight":0.1}]},{"stylers":[{"hue":"#0019ff"},{"lightness":10},{"gamma":0.96}]},{ "stylers":[{"gamma":0.96},{"weight":0.1}]},{"featureType":"administrative","stylers":[{"color":"#328080"}]}];
        break;
    case '19':
        mapstyle = [{"featureType":"road","stylers":[{"lightness":-10},{"weight":0.1},{"hue":"#008000"}]},{"stylers":[{"saturation":30},{"lightness":-10}]}];
        break;
    case '20':
        mapstyle = [{"stylers":[{"visibility":"on"},{"weight":0.1},{"hue":"#005eff"},{"lightness":-10},{"gamma":1.2}]}];
        break;
    case '21':
        mapstyle = [{"featureType":"water","elementType":"geometry","stylers":[{"visibility":"on"},{"color":"#aee2e0"}]},{"featureType":"landscape","elementType":"geometry.fill","stylers":[{"color":"#abce83"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"color":"#769E72"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#7B8758"}]},{"featureType":"poi","elementType":"labels.text.stroke","stylers":[{"color":"#EBF4A4"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#8dab68"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#5B5B3F"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ABCE83"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#A4C67D"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#9BBF72"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#EBF4A4"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"#87ae79"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#7f2200"},{"visibility":"off"}]},{"featureType":"administrative","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"},{"visibility":"on"},{"weight":4.1}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#495421"}]},{"featureType":"administrative.neighborhood","elementType":"labels","stylers":[{"visibility":"off"}]}];
        break;
    case '22':
        mapstyle = [{"featureType":"administrative","stylers":[{"visibility":"off"}]},{"featureType":"poi","stylers":[{"visibility":"simplified"}]},{"featureType":"road","stylers":[{"visibility":"simplified"}]},{"featureType":"water","stylers":[{"visibility":"simplified"}]},{"featureType":"transit","stylers":[{"visibility":"simplified"}]},{"featureType":"landscape","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"visibility":"off"}]},{"featureType":"road.local","stylers":[{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"water","stylers":[{"color":"#84afa3"},{"lightness":52}]},{"stylers":[{"saturation":-77}]},{"featureType":"road"}];
        break;
    case '23':
        mapstyle = [{"featureType":"water","elementType":"all","stylers":[{"hue":"#87bcba"},{"saturation":-37},{"lightness":-17},{"visibility":"on"}]},{"featureType":"landscape","elementType":"all","stylers":[]},{"featureType":"landscape.man_made","elementType":"all","stylers":[{"hue":"#4f6b46"},{"saturation":-23},{"lightness":-61},{"visibility":"on"}]},{"featureType":"road","elementType":"all","stylers":[{"hue":"#d38bc8"},{"saturation":-55},{"lightness":13},{"visibility":"on"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"hue":"#ffa200"},{"saturation":100},{"lightness":-22},{"visibility":"on"}]},{"featureType":"road.local","elementType":"all","stylers":[{"hue":"#d38bc8"},{"saturation":-55},{"lightness":-31},{"visibility":"on"}]},{"featureType":"transit","elementType":"all","stylers":[{"hue":"#f69d94"},{"saturation":84},{"lightness":9},{"visibility":"on"}]},{"featureType":"administrative","elementType":"all","stylers":[{"hue":"#d38bc8"},{"saturation":45},{"lightness":36},{"visibility":"on"}]},{"featureType":"administrative.country","elementType":"all","stylers":[{"hue":"#d38bc8"},{"saturation":45},{"lightness":36},{"visibility":"on"}]},{"featureType":"administrative.land_parcel","elementType":"all","stylers":[{"hue":"#d38bc8"},{"saturation":45},{"lightness":36},{"visibility":"on"}]},{"featureType":"poi.government","elementType":"all","stylers":[{"hue":"#d38bc8"},{"saturation":35},{"lightness":-19},{"visibility":"on"}]},{"featureType":"poi.school","elementType":"all","stylers":[{"hue":"#d38bc8"},{"saturation":-6},{"lightness":-17},{"visibility":"on"}]},{"featureType":"poi.park","elementType":"all","stylers":[{"hue":"#b2ba70"},{"saturation":-19},{"lightness":-25},{"visibility":"on"}]}];
        break;
    case '24':
        mapstyle = [{"featureType":"water","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":-78},{"lightness":67},{"visibility":"simplified"}]},{"featureType":"landscape","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"simplified"}]},{"featureType":"poi","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"off"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"hue":"#e9ebed"},{"saturation":-90},{"lightness":-8},{"visibility":"simplified"}]},{"featureType":"transit","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":10},{"lightness":69},{"visibility":"on"}]},{"featureType":"administrative.locality","elementType":"all","stylers":[{"hue":"#2c2e33"},{"saturation":7},{"lightness":19},{"visibility":"on"}]},{"featureType":"road","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":-2},{"visibility":"simplified"}]}];
        break;
    case '25':
        mapstyle = [{"stylers":[{"saturation":-100},{"gamma":1}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.place_of_worship","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"poi.place_of_worship","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"water","stylers":[{"visibility":"on"},{"saturation":50},{"gamma":0},{"hue":"#50a5d1"}]},{"featureType":"administrative.neighborhood","elementType":"labels.text.fill","stylers":[{"color":"#333333"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"weight":0.5},{"color":"#333333"}]},{"featureType":"transit.station","elementType":"labels.icon","stylers":[{"gamma":1},{"saturation":50}]}];
        break;
    case '26':
        mapstyle = [{"featureType":"water","stylers":[{"color":"#46bcec"},{"visibility":"on"}]},{"featureType":"landscape","stylers":[{"color":"#f2f2f2"}]},{"featureType":"road","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]}];
        break;
    case '27':
        mapstyle = [{"featureType":"water","elementType":"all","stylers":[{"hue":"#1CB2BD"},{"saturation":53},{"lightness":-44},{"visibility":"on"}]},{"featureType":"road","elementType":"all","stylers":[{"hue":"#1CB2BD"},{"saturation":40}]},{"featureType":"landscape","elementType":"all","stylers":[{"hue":"#BBDC00"},{"saturation":80},{"lightness":-20},{"visibility":"on"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"on"}]}];
        break;
    case '28':
        mapstyle = [{"featureType":"administrative","stylers":[{"visibility":"off"}]},{"featureType":"poi","stylers":[{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"simplified"}]},{"featureType":"water","stylers":[{"visibility":"simplified"}]},{"featureType":"transit","stylers":[{"visibility":"simplified"}]},{"featureType":"landscape","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"visibility":"off"}]},{"featureType":"road.local","stylers":[{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"water","stylers":[{"color":"#84afa3"},{"lightness":52}]},{"stylers":[{"saturation":-17},{"gamma":0.36}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#3f518c"}]}];
        break;
    case '29':
        mapstyle = [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#193341"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#2c5a71"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#29768a"},{"lightness":-37}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#3e606f"},{"weight":2},{"gamma":0.84}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"weight":0.6},{"color":"#1a3541"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#2c5a71"}]}];
        break;
    case '30':
        mapstyle = [{"featureType":"landscape","stylers":[{"hue":"#00dd00"}]},{"featureType":"road","stylers":[{"hue":"#dd0000"}]},{"featureType":"water","stylers":[{"hue":"#000040"}]},{"featureType":"poi.park","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","stylers":[{"hue":"#ffff00"}]},{"featureType":"road.local","stylers":[{"visibility":"off"}]}];
        break;
    case 'default':
        mapstyle = [{"stylers":[{"featureType":"all"}]}];
        break;
    default:
    }
    return mapstyle;
}
 
 /** Get the type of the map: roadmap, satellite, terrain or hybrid**/
function getMapType(string) {
    var mapType;
    switch (string.toUpperCase()) {
    case 'ROADMAP':
        mapType = google.maps.MapTypeId.ROADMAP;
        break;
    case 'SATELLITE':
        mapType = google.maps.MapTypeId.SATELLITE;
        break;
    case 'TERRAIN':
        mapType = google.maps.MapTypeId.TERRAIN;
        break;
    case 'HYBRID':
        mapType = google.maps.MapTypeId.HYBRID;
        break;
    default:
        mapType = google.maps.MapTypeId.ROADMAP;
    }
    return mapType;
}
/** Select the text inside the given element **/
function selectText(element) {
    var doc = document
        , text = doc.getElementById(element)
        , range, selection
    ;    
    if (doc.body.createTextRange) {
        range = document.body.createTextRange();
        range.moveToElementText(text);
        range.select();
    } else if (window.getSelection) {
        selection = window.getSelection();        
        range = document.createRange();
        range.selectNodeContents(text);
        selection.removeAllRanges();
        selection.addRange(range);
    }
}

/** Update the map live preview according to settings **/
function updateMap(pluginurl) {
    var address = jQuery("#address").val();
    var description = jQuery("#pdescription").val();
    if (jQuery("#pdescription").val().trim().length == 0) {
        jQuery("#pdescription").val(jQuery("#address").val())
    }
    if (jQuery("#center").val().trim().length == 0) {
        var lat = null;
        var lng = null
    } else {
        var center = jQuery("#center").val().split(",");
        var lat = center[0];
        var lng = center[1]
    }
    if (jQuery("input[id=color]:checked").val() != "custom") {
        var icon = jQuery("input[id=color]:checked").val();
        var iconUrl = pluginurl + "/responsive-maps-plugin/includes/icons/" + icon + ".png";
    } 

    var shadowUrl = pluginurl + "/responsive-maps-plugin/includes/icons/shadow.png";
    var styles = getStyleString(jQuery("#style").val());
    var zoom = parseInt(jQuery("select#zoom").val());
    var mapdiv = jQuery("#responsive_map");
    var maptype = getMapType(jQuery("select#type").val());
    var panControl = Boolean(jQuery("select#panControl").val());
    var zoomControl = Boolean(jQuery("select#zoomControl").val());
    var pdraggable = Boolean(jQuery("select#draggable").val());
    var prefresh = Boolean(jQuery("select#refresh").val());
    var pscrollwheel = Boolean(jQuery("select#scrollwheel").val());
    var mapTypeControl = Boolean(jQuery("select#typeControl").val());
    var scaleControl = Boolean(jQuery("select#scaleControl").val());
    var streetViewControl = Boolean(jQuery("select#streetControl").val());
    var width = jQuery("#width").val() + jQuery("select#widthm").val();
    var height = jQuery("#height").val() + jQuery("select#heightm").val();
    var pancontrol = (panControl == "") ? "no" : "yes";
    var zoomcontrol = (zoomControl == "") ? "no" : "yes";
    var draggable = (pdraggable == "") ? "no" : "yes";
    var refresh = (prefresh == "") ? "no" : "yes";
    var scrollwheel = (pscrollwheel == "") ? "no" : "yes";
    var typecontrol = (mapTypeControl == "") ? "no" : "yes";
    var scalecontrol = (scaleControl == "") ? "no" : "yes";
    var streetcontrol = (streetViewControl == "") ? "no" : "yes";
    var popup = "no";
    var addresses = address.split("|");
    var descriptions = description.split("|");
    
    // The array with custom icons
    if (jQuery("#iconurl").val().trim().length != 0) {
        var icons = jQuery("#iconurl").val().split("|");
    }
    
    var markers = '[';
    var iconsGenerated = '';
    for (var i = 0; i < addresses.length; i++) {
        var addr = addresses[i].replace(new RegExp("'", "g"), "\'");
        var descr = descriptions[i];
        var showPopup = false;
        if (addresses.length > 1) {
            popup = "no";
            jQuery("select#popup").val("")
        } else {
            var showPopup = Boolean(jQuery("select#popup").val());
            popup = (jQuery("select#popup").val() == "") ? "no" : "yes"
        } if (descr == null || descr.trim().length == 0) {
            descr = addr
        }
        descr = descr.replace(new RegExp("\"", "g"), "\'").replace(new RegExp("\n", "g"), " ");
        // Replace in the html code the {br} expression with < br >  tag
        descr =  descr.replace(new RegExp("{br}", "g"), "<br>"); 
        var directionstext = jQuery("#directions").val();
        
        // The custom icon
        if (jQuery("input[id=color]:checked").val() != "custom") {
            var icon = jQuery("input[id=color]:checked").val();
            var iconUrl = pluginurl + "/responsive-maps-plugin/includes/icons/" + icon + ".png";
            iconsGenerated += icon;
        } else { 
            icon = jQuery("#iconurl").val();
            iconUrl = icons[i];
            iconsGenerated += iconUrl;
        }
        
        // Add icon separator if not the last icon
        if (i != addresses.length - 1) {
            iconsGenerated += ' | ';
        }
        
        var html = '<strong>' + descr + '<br><a target=\'_blank\' href=\'http://maps.google.com/?daddr=' + encodeURIComponent(addr).replace(new RegExp("'", "g"), "&#39;") + '\'>' + directionstext + '</a></strong>';
        if (i > 0) markers += ",";
        markers += '{' + '"address": "' + addr + '",' + '"html": "' + html + '",' + '"popup": ' + showPopup + ',' + '"flat": true, "icon": {"image": "' + iconUrl + '",' + '"iconsize": [56, 50], "shadow": "' + shadowUrl + '",' + '"shadowsize": [56, 50], "shadowanchor": null}}';
    }
    markers += ']';
    mapdiv.gMapResp({
        maptype: maptype,
        zoom: zoom,
        markers: jQuery.parseJSON(markers),
        panControl: panControl,
        zoomControl: zoomControl,
        draggable: pdraggable,
        mapTypeControl: mapTypeControl,
        scaleControl: scaleControl,
        streetViewControl: streetViewControl,
        overviewMapControl: true,
        styles: styles,
        scrollwheel: pscrollwheel,
        latitude: lat,
        longitude: lng
    });
    var parsedDescription = jQuery("#pdescription").val().replace(new RegExp("\"", "g"), "\'").replace(new RegExp("<", "g"), "&lt;").replace(new RegExp(">", "g"), "&gt;");
    jQuery("#shortcode").html('[res_map address="' + address + '" description="' + parsedDescription + '" directionstext="' + directionstext + '" icon="' + iconsGenerated + '" style="' + jQuery("#style").val() + '" pancontrol="' + pancontrol + '" scalecontrol="' + scalecontrol + '" typecontrol="' + typecontrol + '" streetcontrol="' + streetcontrol + '" zoom="' + zoom + '" zoomcontrol="' + zoomcontrol + '" draggable="' + draggable + '" scrollwheel="' + scrollwheel + '" width="' + width + '" height="' + height + '" maptype="' + maptype + '" popup="' + popup + '" center="' + jQuery("#center").val() + '" refresh="' + refresh + '"]')
}