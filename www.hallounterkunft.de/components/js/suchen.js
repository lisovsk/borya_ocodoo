
// var changeStrGet = debounce(, 250);
var flagViewMap = false;
function changeStrGet (targetElem) {
    var name = $(targetElem).attr("name"),
    regExpRep = new RegExp(name + "=" + "[^&]*"),
    value = $(targetElem).val() || $(targetElem).attr("value");
    strGet = strGet.replace(regExpRep, name + "=" + value);
    console.log(strGet);
    getAjaxData("inc/inc-suchen/search-response.inc.php", strGet, '.js-ajax-data');
}
function changeStrGetNoReload (targetElem) {
    var name = $(targetElem).attr("name"),
    regExpRep = new RegExp(name + "=" + "[^&]*"),
    value = $(targetElem).val() || $(targetElem).attr("value");
    strGet = strGet.replace(regExpRep, name + "=" + value);
    console.log(strGet);
}
function getAjaxData(file, strGet, setAjaxDataSelec) {
    var req = new XMLHttpRequest();
    req.onreadystatechange = function(){
      if (req.readyState != 4) return;
      if(window.innerWidth >= 768) {
        var loader = '<div class="col-lg-8 col-sm-7"><div style="margin:50px auto 0 auto; width:130px;"><img src="images/loading.gif"/></div></div>';
        $(setAjaxDataSelec).html(loader);
      }
      setTimeout(function () {
        var responseText = String(req.responseText);
        $(setAjaxDataSelec).html(responseText);
        if(flagViewMap && dataForMapJSON.length != undefined)
          initializeMap();
      }, 250);
    };
    req.open("GET", file + strGet, true);
    req.send(null);
}
function initializeMap () {
 view = "map";
 var mapCan = document.getElementById("map_can");
 var options = {
     'zoom':15,
     'mapTypeId': google.maps.MapTypeId.ROADMAP
 };
var map = new google.maps.Map(mapCan, options);
 map.addListener('zoom_changed', function() {
    $(".js-map-mark__container").fadeIn(200).next().fadeOut(100);
  });
window.flagColor = {};
latLongPos = [];
 var geocoder = new google.maps.Geocoder();
 var mapCordsLoc = [];
 function codeAddress(location, price, ortName, ortUrl, strFetchArt, srcApartment, url, title, userName, userAvtar, userUrl, userReiting, lati, lngi){
          if (lati && lngi) {
             var labelContent = '<div  class="map-mark__container js-map-mark__container" ><div class="map-mark__markers js-map-mark__markers"><span class="map-mark__price">' + price + '</span></div><div class="map-mark__triangl"></div></div><div class="map-mark__container_active" style="display: none;"><div class="map-mark__markers map-mark__markers_active"><div class="map-mark__wr-img"><a href="'+ url +'" onclick="location.href =\'' + url + '\'" class="map-mark__title-link"><img src="' + srcApartment + '" alt="" class="map-mark__img" /></a></div><div class="map-mark__wr-data"><div class="map-mark__title"><a href="'+ url +'" onclick="location.href =\'' + url + '\'" class="map-mark__title-link">'+  title +'</a></div><div class="map-mark__wr-user"><a href="'+ userUrl +'" onclick="location.href =\'' + userUrl + '\'" class="map-mark__user-link"><img src="' + userAvtar + '" alt="" class="map-mark__user-img" /></a><div class="map-mark__user-text">' + strFetchArt + ' in <a href="' + ortUrl + '" onclick="location.href =\'' + ortUrl + '\'"  class="map-mark__city-link"><span class="map-mark__city">'+ ortName +'</span></a> von <span class="map-mark__user-name"><a href="' + userUrl + '" onclick="location.href =\'' + userUrl + '\'" class="map-mark__user-link">'+ userName +'</a></span></div></div><div class="map-mark__reiting">' + userReiting + '</div></div><span class="map-mark__price map-mark__price_active">' + price + '</span><span onclick="$(this).closest(\'.map-mark__container_active\').fadeOut(600); $(this).closest(\'.map-mark__container_active\').prev().fadeIn(600);";  class="map-mark_close"><i class="fa fa-times" aria-hidden="true"></i></span></div><div class="map-mark__triangl map-mark__triangl_active"></div></div></div>';
             var div = document.createElement('div');
             div.classList.add("labels__child");
             div.innerHTML = labelContent;
             var visetedItem = {};
             $(div).on("click", ".js-map-mark__container", function () {
                var index = $(this).index(".js-map-mark__container");
                $(this).find(".map-mark__markers").animate({backgroundColor: "#3a3c3c"}, 60).next().animate({borderTopColor: "#3a3c3c"}, 60);
                map.panTo(new google.maps.LatLng({lat: latLongPos[index].lat, lng: latLongPos[index].lng}));
                $(".map-mark__container").fadeIn(25); $(".map-mark__container_active").fadeOut(25);
                $(this).fadeOut(); $(this).next().fadeIn(25);
                $(".labels__child").css("z-index", "1000003");
                $(this).parent().css("z-index", "9999999");
             });

             var myCenter = new google.maps.LatLng(lati, lngi);
             mapCordsLoc.push(myCenter);
             latLongPos.push({lat: lati, lng: lngi});
              var marker = new MarkerWithLabel({
                position: myCenter,
                map: map,
                draggable: false,
                raiseOnDrag: false,
                labelContent: div,
                labelAnchor: new google.maps.Point(0, 0),
                labelClass: "labels", // the CSS class for the label
                zIndex: 1111111,
                labelInBackground: false
              });
          } else {
             console.log('Geocode was not successful');
           }; 
  }
  // var codeAddressOnce = once(codeAddress);
  if (dataForMapJSON) {
    for (var i = 0; i < dataForMapJSON.length; i++) {
       var address = dataForMapJSON[i].strasse + ", " + dataForMapJSON[i].ortName;
       var price = dataForMapJSON[i].price;
       var ortName = dataForMapJSON[i].ortName;
       var ortUrl = dataForMapJSON[i].ortUrl;
       var strFetchArt = dataForMapJSON[i].strFetchArt;
       var srcApartment = dataForMapJSON[i].srcApartment;
       var title = dataForMapJSON[i].title;
       var url = dataForMapJSON[i].url;
       var userName = dataForMapJSON[i].userName;
       var userAvtar = dataForMapJSON[i].userAvtar;
       var userUrl = dataForMapJSON[i].userUrl;
       var userReiting = dataForMapJSON[i].userReiting;
       var latitude = parseFloat(dataForMapJSON[i].latitude);
       var longitude = parseFloat(dataForMapJSON[i].longitude);

       codeAddress(address, price, ortName, ortUrl, strFetchArt, srcApartment, url, title, userName, userAvtar, userUrl, userReiting, latitude, longitude);
    }
  }
  var latlngbounds = new google.maps.LatLngBounds();
  for ( var i=0; i<mapCordsLoc.length; i++ ){
       latlngbounds.extend(mapCordsLoc[i]);
  }
  map.setCenter( latlngbounds.getCenter(), map.fitBounds(latlngbounds));
}
    var strGet = "";
    var input = $(".js-get-param [name], [name=order]").filter( ':input' );
    input.each(function( index ) {
        var name = $( this ).attr("name");
        var value = $( this ).val();
        strGet += name + "=" + value + "&";
    });
    strGet = "?" + strGet.substring(0, strGet.length - 1);
    strGet = strGet + "&seite=0";
    strGet += "&view=items";
    console.log(strGet);
    
    input.on("change", input, function (e) {
        var target = e.target;
        changeStrGet (target);
    });
   $("body").on("mouseup", function (e) {
    // var div = $(".js-mouseup");
        // if (!div.is(e.target) && div.has(e.target).length === 0) {
            var index = $(".ui-state-active").index(".ui-slider-handle");
            if(index !== -1)
                changeStrGet( "#" + $(".slider-handle-c").eq(index).attr("id") );
        // }
   });
   $("body").on("click", function (event) {
        var target = event.target;
        var strG = $(target).attr("data-pag");
        if (strG) {
            // strG = strG + "&" + $(".small").attr("name") + "=" + $(".small").val();
            changeStrGet(target);
        }
   });
    function debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };
    function once(fn, context) { 
        var result;

        return function() { 
            if(fn) {
                result = fn.apply(context || this, arguments);
                fn = null;
            }

            return result;
        };
    }


    $('#myTabs a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
    })





    //start custom-google*/
    $(document).ready(function () {
        // var initMapOnce = once(initializeMap);
        $("body").on("click", ".js-map-inicialize", function () {
            setTimeout(function () {
              if (dataForMapJSON.length != undefined)
                initializeMap();
            }, 250);
        });
        // console.log(dataForMapJSON);
    });
    
    // var repaintedMarked = debounce(function () {  
    //   console.log(flagColor);
    //   for (var key in flagColor) {
    //     // $(".js-map-mark__markers").eq(key).css({"background": "#3a3c3c"}).next().css({"borderTopColor": "#3a3c3c"});
    //     $(".js-map-mark__markers").eq(key).addClass("map-mark__markers_visited").next().addClass("map-mark__triangl_visited");
    //   }
    // }, 100);
    // $("#map_can").on("DOMSubtreeModified", function () {
    //     repaintedMarked();
    // });
    $("body").on("click", ".js-tab-content", function (e) {
        $(".map-mark__container_active").fadeOut(600);
        $('.map-mark__container').fadeIn(600);
    });
    //end custom-google*/

    //start mobile-google*/
    var filterStatus = false;
    $("body").on("click", ".js-search-nav-mobile__filter", function (e) {
      filterStatus = true;
      $(".saerch").show();
      $(".js-ajax-data").hide();
      $(".search-nav-mobile").hide();
      scrollToElem ($("legend"));
    });

    $("body").on("click", ".js-search-nav-mobile__map", function (e) {
      filterStatus = false;
      view = "map";
      $(".saerch").hide();
      $(".js-ajax-data").show();
      $("#profile-tab").click();
      $(this).hide();
      $(".js-search-nav-mobile__results").show();
      scrollToElem ($("legend"));
    });
    $("body").on("click", ".js-search-nav-mobile__results", function (e) {
      filterStatus = false;
      view = "items";
      $(".saerch").hide();
      $(".js-ajax-data").show();
      $("#home-tab").click();
      $(this).hide();
      $(".js-search-nav-mobile__map").show();
      scrollToElem ($("legend"));
    });

    $(".js-button-search").click(function () {
        filterStatus = false;
        $(".js-ajax-data").show();
        $(".saerch").hide();
        $(".search-nav-mobile").show();
         if (view === "map" && dataForMapJSON.length != undefined) {
          setTimeout(function () {
              initializeMap();
          }, 250);
         }
        scrollToElem ($("legend"));
    });
    $("body").on("click", "#home-tab", function () {
      view = "items";
    });

    $(window).on("resize", function () {
      if (view === "map") {
        $(".js-search-nav-mobile__map").hide();
        $(".js-search-nav-mobile__results").show();
      } else if (view === "items") {
        $(".js-search-nav-mobile__map").show();
        $(".js-search-nav-mobile__results").hide();
      }
        if (window.innerWidth >= 768) {
          $(".js-ajax-data").show();
          $(".saerch").show();
          $(".search-nav-mobile").hide();
        } else {
          $(".search-nav-mobile").show();
          if(filterStatus) {
            $(".js-ajax-data").hide();
            $(".saerch").show();
          } else {
            $(".js-ajax-data").show();
            $(".saerch").hide();
          }
        }
    });

    $("body").on("click", "#home-tab", function () {
      $(".small").show();
      changeStrGetNoReload (this);
    });
    $("body").on("click", "#profile-tab", function () {
      $(".small").hide();
      changeStrGetNoReload (this);
    });
    function scrollToElem (elem) {
      $('html, body').animate({
          scrollTop: elem.offset().top
      }, 500);
    }