// Simple JavaScript Templating
// John Resig - http://ejohn.org/ - MIT Licensed
(function() {

    var Resig = {
        templateCache: {},
        htmlCache: {},
        elementCache: {}
    };

    this.Resig = Resig;


    Resig.tmpl = function(str, data) {
        var fn;
        if(/^[A-Za-z0-9\-_]+$/.test(str)){
            // se é um id
            fn = Resig.templateCache[str] = Resig.templateCache[str] || Resig.tmpl(document.getElementById(str).innerHTML);

        }else{
            fn = Function("obj",
                "var p=[],print=function(){p.push.apply(p,arguments);};" +
                // Introduce the data as local variables using with(){}
                "with(obj){p.push('" +
                // Convert the template into pure JavaScript
                str
                .replace(/[\r\t\n]/g, " ")
                .split("<%").join("\t")
                .replace(/((^|%>)[^\t]*)'/g, "$1\r")
                .replace(/\t=(.*?)%>/g, "',$1,'")
                .split("\t").join("');")
                .split("%>").join("p.push('")
                .split("\r").join("\\'")
                + "');}return p.join('');");
        }

        // Provide some basic currying to the user
        return data ? fn(data) : fn;
    };

    Resig.render = function (template, data, useCache){
        if(useCache && data.id && Resig.htmlCache[template] && Resig.htmlCache[template][data.id])
            return Resig.htmlCache[template][data.id];

        if(useCache)
            Resig.htmlCache[template] = Resig.htmlCache[template] || {};

        var html = this.tmpl(template, data);

        if(useCache && data.id)
            Resig.htmlCache[template][data.id] = html;

        return html;
    };

    Resig.renderElement = function(template, data, useCache){
        if(useCache && data.id && Resig.elementCache[template] && Resig.elementCache[template][data.id])
            return Resig.elementCache[template][data.id];

        if(useCache)
            Resig.elementCache[template] = Resig.elementCache[template] || {};

        var div = document.createElement('div');

        div.innerHTML = Resig.render(template, data);

        if(useCache && data.id)
            Resig.elementCache[template][data.id] = div.firstElementChild;

        return div.firstElementChild;
    };

})();
