
var Device = {
    
    ui : null, 
    model : {
        tasks : null, 
        forms : null, 
        tables : null, 
        actions : null, 
        conditions : null
    }, 
    controller : null, 
    taskManager : null, 
    language : "en",
    translations : null,
    
    init : function (ui, language) {
        if (language == undefined) {
            this.language = language;
        }
        this.ui = ui;
        this.loadModel();
    }, 
    
    translation : function (key, params) {
        if (key == undefined) {
            return this.getTranslations(Device.language);
        }
        if (params != undefined && !(params instanceof Map)) {
            this.getTranslations(Device.language)[key] = value;
        }
        var value = key;
        var translations = this.getTranslations(Device.language);
        if (translations[key] != undefined) {
            value = translations[key];
        }
        if (params != undefined) {
            value = this.replaceParams(value);
        }
        return value;
    }, 
    
    getTranslations : function (language) {
        if (this.translations == null) {
            this.translations = {language : {}};
        }
        if (this.translations[Device.language] == undefined) {
            return {};
        }
        return this.translations[Device.language];
    }, 
    
    loadModel : function () {
        this.model = {
            tasks : ModelDAO.generate(TaskDataObject), 
            forms : ModelDAO.generate(FormDataObject), 
            tables : ModelDAO.generate(TableDataObject), 
            actions : ModelDAO.generate(ActionDataObject), 
            conditions : ModelDAO.generate(ConditionDataObject)
        };
    }
};

$.widget("custom.serveyEditor", {
    
    // default options
    options: {
    	width : "100%",
    	height : "800px",
    	model : null, 
    	language : Device.language
    },
    
    // the constructor
    _create: function () {
        
        this.element
            .addClass("serveyEditor")
            .disableSelection();
        
        Device.init(this, this.options.language);
        
        this.attach();
        
        this._refresh();
    },
    
    // called when created, and later when changing options
    _refresh : function () {
        
        this._trigger("refreshEvent");
    },

    // revert modifications here
    _destroy : function () {
        
        this.element
            .empty()
            .removeClass("serveyEditor")
            .enableSelection();
    },

    // _setOptions is called with a hash of all options that are changing
    _setOptions : function () {
        
        this._superApply(arguments);
        this._refresh();
    },

    // _setOption is called for each individual option that is changing
    _setOption : function (key, value) {
        
        switch (key) {
            case "width":
                this.element.css({width : this.options.width});
                break;
            case "height":
                this.element.css({height : this.options.height});
                break;
            default:
                this._super(key, value);
        }
    },
    
    completeAttach : function () {
    },
    
    /* servey editor ui methods */
    
    showView : function (viewState) {
        
        if (viewState.left != undefined) {
            this.element.find(".left").empty().append(viewState.left);
        }
        if (viewState.right != undefined) {
            this.element.find(".right").empty().append(viewState.right);
        }
        if (viewState.center != undefined) {
            this.element.find(".center").empty().append(viewState.center);
        }
    }, 
    
    getTree : function (nodes, onClick) {
        
        var rootNode = null;
        
        function parseNodes (nodes) {
            
            var ul = $("<ul>")
            $.each(nodes, function(index,node){
                ul.append(
                    $("<il>").append([
                        $("<a>")
                            .text(node.name)
                            .data(node.data),
                        parseNodes(nodes.children)
                    ])
                );
            });
            return ul;
        }
        
        function setNodeState (node, open, selected) {
            
            if (open) {
                node.parent("li").addClass("jstree-open");
            }
            if (selected) {
                node.first("a").addClass("jstree-clicked");
            }
            if (node.parent() != rootNode) {
                setNodeState(node.parent("<li>"), true, false);
            }
        }
        
        return $(parseNodes(nodes)).jstree({ 
            "plugins" : ["themes","html_data","ui"] 
        }).bind("select_node.jstree", function (event, data) {
            data.rslt.obj.data.onClick();
        });
        
    }, 
    
    getNodeEditorNodes : function (items) {
        
        var nodes = {};
        $.each(items, function(index,object){
            nodes.push({
                name : object.name, 
                data : object, 
                children : this.getNodeEditorNodes(object.getChildren()), 
                onClick : function(data){
                    Device.ui.showView(object.getEditor());
                }
            });
        });
        return this.getTree(nodes);
    },
    
    getNodeEditorTree : function (items) {
        
        return this.getTree(this.getNodeEditorNodes(items));
    },
    
    getStatisticsMenu : function () {
        
        return {};
    },
    
    attachFeaturesPanel : function (parent) {
        
        parent.append([
            $("<h3>").text(Device.translation("features.forms")),
            $("<div>").append(this.getNodeEditorTree(Device.model.forms.getAll())),
            $("<h3>").text(Device.translation("features.actions")),
            $("<div>").append(this.getNodeEditorTree(Device.model.actions.getAll())),
            $("<h3>").text(Device.translation("features.conditions")),
            $("<div>").append(this.getNodeEditorTree(Device.model.conditions.getAll())),
            $("<h3>").text(Device.translation("features.tasks")),
            $("<div>").append(this.getNodeEditorTree(Device.model.tasks.getAll())),
            $("<h3>").text(Device.translation("features.model")),
            $("<div>").append(this.getNodeEditorTree(Device.model.tables.getAll())),
            $("<h3>").text(Device.translation("features.statistics")),
            $("<div>").append(this.getStatisticsMenu()),
        ]).accordion({
            heightStyle: "fill",
            active : 0
        });
    }, 
    
    attach : function () {
        
        // template
        this.element.append([
            $("<div>", {"class":"right"}), 
            $("<div>", {"class":"rightSplitter"}), 
            $("<div>", {"class":"left"}), 
            $("<div>", {"class":"leftSplitter"}), 
            $("<div>", {"class":"center"}), 
            $("<div>", {"class":"clearBoth"})
        ]);
        
        // init template
        this.element.find('.left').draggable({    
            axis: 'x',
            containment: '.serveyEditor',
            drag: function(event, ui) {
                $('.left').css({
                    "width" : ui.position.left + 'px'
                });
                $('.center').css({ 
                    "left" : ui.position.left + 3 + 'px'
                });
            },
            refreshPositions: true,
            scroll: false
        });
        
        this.element.find('.right').draggable({    
            axis: 'x',
            containment: '.serveyEditor',
            drag: function(event, ui) {
                $('.right').css({
                    "width" : ui.position.left + 'px'
                });
                $('.center').css({ 
                    "right" : ui.position.left - 3 + 'px'
                });
            },
            refreshPositions: true,
            scroll: false
        });
        
        // initial view state
        this.attachFeaturesPanel(this.element.find(".left"));
        /*this.showView({
            center : StatisticsView.getView()
        });*/
        
        this.completeAttach();
    },
    
    completeAttach : function () {
        
    }
    
});