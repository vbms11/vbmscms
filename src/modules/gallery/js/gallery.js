
var slideshowIntervalId = {};

// slideshow view
function centerImage (img) {
    img.css("top", -((img.height() / 2) - (img.parent("div").height() / 2)));
}

// refreses the numbers to show witch image is being displayed
function refreshSlideshowNumbers (containerSelector) {
    var images = $(containerSelector+" img");
    $(containerSelector+" .slideshowNumber").each(function (index,object) {
        $(object).removeClass("slideshowNumberSelected");
        if ($(images.get(index)).css("display") == "block") {
            $(object).addClass("slideshowNumberSelected");
        }
    });
}

// swaps the current image with the next image
function swapImages (containerSelector,current,nextImage) {
    centerImage(nextImage);
    nextImage.css("z-index", 2);
    current.css("z-index", 1);
    nextImage.fadeIn(1000, function () {
        current.css("display", "none");
        nextImage.css("display", "block");
        refreshSlideshowNumbers(containerSelector);
    });
    return false;
}

// swap current image to next image
function animateSlideshow (selector) {
    var first = null;
    var current = null;
    var imgLen = $(selector+" img").length;
    $(selector+" img").each(function (index,object) {
        if (index == 0) {
            first = $(object);
        }
        if (current != null) {
            swapImages(selector,current,$(object));
            return false;
        }
        if (current == null && $(object).css("display") == "block") {
            current = $(object);
            if (index == imgLen-1) {
                swapImages(selector,current,first);
                return false;
            }
        }
    });
}

// start slideshow timer
function startSlideshow (selector, timeMillis) {
    slideshowIntervalId[selector] = window.setInterval("animateSlideshow('"+selector+"');", timeMillis);
}

function getCurrentImage (containerSelector) {
    var retObj = null;
    $(containerSelector+" img").each(function (index,object) {
        if ($(object).css("display") == "block") {
            retObj = $(object);
        }
    });
    return retObj;
}

// set whitch image should be shown
function slideshowSetImage (containerSelector, index) {
    window.clearInterval(slideshowIntervalId[containerSelector]);
    swapImages(containerSelector,getCurrentImage(containerSelector), $($(containerSelector+" img").get(index)));
}


// init the slideshow
function initSlideshow (containerSelector, timeMillis) {

    // when element resizes find current image and center it
    $(containerSelector).resize(function () {
        $(containerSelector+" img").each(function (index,object) {
            if ($(object).css("display") == "block") {
                centerImage($(object));
            }
        });
    });

    // setup slideshow and show first image
    var len = $(containerSelector+" img").length + 1;
    $(containerSelector+" img").each(function (index, object) {
        var img = $(object);
        img.css("z-index", 1);
        if (index == 0) {
            img.css("display","block");
            img.css("z-index", 2);
            centerImage(img);
            refreshSlideshowNumbers();
            startSlideshow(containerSelector,timeMillis);
        }
    });

    // set up slideshow paging
    $(containerSelector+" .slideshowNumber").each(function (index,object) {
        $(object).click(function () {
            slideshowSetImage(containerSelector,index);
        });
    });
}












/* old

var pos;
var images;
var elId;
var delay = 10000;

function startSlideshow (imageArray) {
    images = imageArray;
    pos = 0;
    nextImage();
}

function nextImage () {
    
    var el = $("#"+elId);;
    
    // load image
    var img = new Image();
    $(img).load(function () {
        
        // calculate size of image
        var imageWidth = $(this).width();
        var imageHeight = $(this).height();
        var whRatio = imageWidth / imageHeight;
        var bgwhRatio =  el.innerWidth() / el.innerHeight();
        if (whRatio > bgwhRatio) {
            imageWidth = el.innerWidth();
            imageHeight = el.innerWidth() * whRatio;
        } else {
            imageWidth = el.innerHeight() / whRatio;
            imageHeight = el.innerHeight();
        }
        
        // start fade
        $(this).css('display','none');
        $(el).append(this);
        $(this).fadeIn();
        
        // schedule next image transition
        window.setTimeout("nextImage()", delay);
        
    }).error(function () {
        
    });
    img.src = images[pos];
    pos++;
}

function stopSlideshow () {
    
}

function resize () {
    
}
*/