CKEDITOR.dialog.add("ckawesomeDialog", function (e) {
    function h(a) {
        var b = e.fontawesomePath; 
        $.ajax( {
            url: b, 
            type:"get", 
            dataType:"html", 
            async: !1, 
            success: function (b) {
                var d = ".fa. .fa .fa-lg .fa-2x .fa-3x .fa-4x .fa-5x .fa-fw .fa-ul .fa-ul\x3e .fa-li .fa-border .fa-pull-left .fa-pull-right .fa-spin .fa-pulse .fa-rotate-90 .fa-rotate-180 .fa-rotate-270 .fa-flip-horizontal .fa-flip-vertical .fa-stack .fa-stack-1x .fa-stack-2x .fa-inverse".split(" "); 
                b = b.match(new RegExp(/\.[a-zA-Z_][\w-_]*[^\.\s\{#:\,;]/, "g"));
                b.sort(); 
                $.each(b, function (b, c) {
                    "fa" != c.substring(0, 3).substring(1) || 0< d.indexOf(c) || (c = c.substring(1), a.add(c, c))
                })
            }, 
            error: function (a, d) {
                alert("Error loading Font Awesome css: \n" + b)
            }
        })
    }
    function k(a, b, e, d) {
        var g = [], 
            c = b; 
        g.push(b); 
        d = 0< d? d:5; 
        for (b = 0; b< d; b++) c += e, g.push(c); 
        $.each(g, function (b, c) {
            a.add(c, c)
        })
    }
    function f(a) {
        if (!a.id) 
            return a.text; 
        var b = a.text.replace(/fa-|\.|\-/gi, " "); 
        return a = $('\x3cspan class\x3d"ckawesome_options"\x3e\x3ci class\x3d"fa ' + a.element.value + ' fa-fw"\x3e\x3c/i\x3e ' + b +"\x3c/span\x3e")
    } return {
        title: "Insert CKAwesome", 
        minWidth: 200, 
        minHeight: 200, 
        contents:[ 
        {
            id: "options",
            label: "Basic Settings", 
            elements: [ 
            {
                type: "select", 
                id: "ckawesomebox", 
                label: "Select font Awesome", 
                validate: CKEDITOR.dialog.validate.notEmpty("Font Awesome field cannot be empty."), 
                items:[[e.lang.common.notSet, ""]], 
                onLoad: function () {
                    h(this); 
                    var a = $("#" + this.getInputElement().getAttribute("id")); 
                    $(a).select2( {
                        width:"100%", templateResult:f, templateSelection:f
                    })
                }, 
                onShow:function () {
                    var a = $("#" + this.getInputElement().getAttribute("id"));
                    $(a).val("").trigger("change")
                }
            }, 
            {
                type:"select", 
                id:"textsize", 
                label:"Select  size", 
                items: [[e.lang.common.notSet, ""]], 
                onLoad: function (a) {
                    k(this, 8, 1, 42)
                }
            },
            {
                type:"hbox", 
                padding:0,
                widths:["80%", "20%"], 
                children: [ 
                {
                    id: "fontcolor", 
                    type:"text", 
                    label:"Select color", 
                    onChange:function (a) {
                        a = $("#" + this.getInputElement().getAttribute("id")); 
                        a.css("background-color", a.val())
                    }, 
                    onKeyUp:function (a) {
                        a = $("#" + this.getInputElement().getAttribute("id")); 
                        a.css("background-color", a.val())
                    }, 
                    onShow:function () {
                        $("#" + this.getInputElement().getAttribute("id")).css("background-color", "")
                    }
                }, 
                {
                    type:"button", 
                    id:"fontcolorChooser", "class":"colorChooser", 
                    label:"Color", 
                    style:"margin-left: 8px", 
                    onLoad:function () {
                        this.getElement().getParent().setStyle("vertical-align", "bottom")
                    }, 
                    onClick:function () {
                        e.getColorFromDialog(function (a) {
                            a && this.getDialog().getContentElement("options", "fontcolor").setValue(a); 
                            this.focus()
                        }, this)
                    }
                }]
            }]
        }], 
        onOk:function () {
            var a = e.document.createElement("span"), 
                b = this.getValueOf("options", "textsize"), 
                f = this.getValueOf("options", "fontcolor"), 
                d = "fa fa-fw " + this.getValueOf("options","ckawesomebox"), 
                b = ("" != b? "font-size: " + b + "px;":"") + ("" != f? "color: " + f + ";":""); 
            a.setAttribute("class", d); 
            b && a.setAttribute("style", b); 
            a.appendHtml("\x26nbsp;"); 
            e.insertElement(a)
        }
    }
});
