function requestView(params) {

    if (params.mainSelector != null) {

        showLoader(params.mainSelector);

    }

    return $.ajax({
        url: params.url,
        type: params.verb,
        data: params.data,
        success: function (view) {

        },
        error: function () {

            hideLoader(params.mainSelector);
            toastr.error('Server error: Try again later.');
        }
    });

}

function requestApi(params) {

    if (params.mainSelector != null) {

        showLoader(params.mainSelector);

    }

    return $.ajax({
        url: params.url,
        type: params.verb,
        dataType: 'json',
        data: params.data,
        jsonp: false,
        success: function (jsonObj) {

            if (!jsonObj.meta.success) {

                if (jsonObj.data.errors.type == 'validation') {

                    var errors = '';
                    for (var key in jsonObj.data.errors.array) {

                        if (jsonObj.data.errors.array.hasOwnProperty(key)) {

                            $(jsonObj.data.errors.array[key]).each(function (index, item) {

                                errors += item + '<br \>';
                            });
                        }
                    }
                    toastr.error(errors);
                } else {

                    toastr.error(jsonObj.data.errors.message);
                }

                hideLoader(params.mainSelector);
            }
        },
        error: function () {

            hideLoader(params.mainSelector);
            toastr.error('Server error: Try again later.');
        }
    });

}

function showLoader(selector) {

    var loaderHtml;

    $(selector).css({'height': '100%', 'position': 'relative', 'min-height': '80px'});

    loaderHtml = '<div class="loader"><img src="' + Data.base_assets_url + 'images/loader.gif" ></div>';

    $(selector).append(loaderHtml);
    $(selector + ' .loader').fadeIn();

}

function hideLoader(selector) {

    if ($(selector + ' .loader').length) {

        $(selector + ' .loader').fadeOut();
    }

}
var decodeEntities = (function () {
    // this prevents any overhead from creating the object each time
    var element = document.createElement('div');

    function decodeHTMLEntities(str) {
        if (str && typeof str === 'string') {
            // strip script/html tags
            str = str.replace(/<script[^>]*>([\S\s]*?)<\/script>/gmi, '');
            str = str.replace(/<\/?\w(?:[^"'>]|"[^"]*"|'[^']*')*>/gmi, '');
            element.innerHTML = str;
            str = element.textContent;
            element.textContent = '';
        }

        return str;
    }

    return decodeHTMLEntities;
})();
function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}
var _e = function (string) {

    return htmlEntities(string.trim());
}
$.fn.serializeObject = function ()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
$.fn.scrollView = function () {
    return this.each(function () {
        $('html, body').animate({
            scrollTop: $(this).offset().top
        }, 1000);
    });
}
function backToDash() {
    window.location.hash = '#';
}