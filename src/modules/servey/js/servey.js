
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

var TableFeildDataObject = {
    name : null,
    description : null,
    type : null, 
    length : null, 
    index : null,
    increment : null,
    nullAllowed : null, 
    relationTable : null, 
    relationType : null
};

var TableDataObject = {
    name : null,
    description : null,
    feilds : null
}

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
        this.showView({
            center : StatisticsView.getView()
        });
        
        this.completeAttach();
    }
    
});


/* Database */


var ModelQuery = {
    url : null,
    onComplete : null,
    execute : function () {
        $.getJSON(this.url,this.onComplete);
    }
}

var DataRepository = {
    "name" : null,
    "url" : null,
    "save" : function (object, onComplete) {
        $.extend({},ModelQuery,{
            "url" : this.getQueryUrl("json",JSON.stringify({
                "command" : "update", 
                "table" : object.getTableName(),
                "objects" : object
            })),
            "onComplete" : onComplete
        }).execute();
    },
    "create" : function (object, onComplete) {
        $.extend({},ModelQuery,{
            "url" : this.getQueryUrl("json",JSON.stringify({
                "command" : "insert", 
                "table" : object.getTableName(),
                "objects" : object
            })),
            "onComplete" : onComplete
        }).execute();
    },
    "delete" : function (object, onComplete) {
        $.extend({},ModelQuery,{
            "url" : this.getQueryUrl("json",JSON.stringify({
                "command" : "delete", 
                "table" : object.getTableName(),
                "condition" : {"id":object.id}
            })),
            "onComplete" : onComplete
        }).execute();
    },
    "select" : function (table, condition, onComplete) {
        $.extend({},ModelQuery,{
            "url" : this.getQueryUrl("json",JSON.stringify({
                "command" : "select", 
                "table" : table.getTableName(),
                "condition" : condition
            })),
            "onComplete" : onComplete
        }).execute();
    },
    "getQueryUrl" : function (type, data) {
        return this.url+"action=database&type="+type+"&data="+data;
    }
};

var MappingLoader = {
    load : function (mapping) {
        
    }
};

var ModelDAO = {
    type : null, 
    generate : function (type) {
        var dao = $.extend({}, ModelDAO, this.generateAllFeildMethods(type));
        dao.type = type;
        return dao;
    },
    generateAllFeildMethods : function (type) {
        return {};
    },
    getAll : function (onComplete) {
        return DataRepository.select(this.type.getTableName(), null, onComplete);
    },
    getById : function (id, onComplete) {
        return DataRepository.select(this.type.getTableName(), this.type.getIdFeildName()+"="+id, onComplete);
    }
};

var ModelDataObject = {
    "getTableName": null,
    "getDataTypes": null,
    "getFeilds" : null,
    "getIdFeildName" : function () {
        return "uid";
    },
    "save" : function (onComplete) {
        if (this.id == null) {
            DataRepository.insert(this,onComplete);
        } else {
            DataRepository.update(this,onComplete);
        }
    },
    "delete" : function (onComplete) {
        DataRepository.delete(this,onComplete);
    },
    "loadMapping" : function (mapping) {
        var that = this;
        $(mapping).find("table").each(function(index,object){
            that.loadTableMapping(object);
        });
    },
    "loadVariables" : function () {
        
    },
    "doseTableExist" : function (name) {
        
        return 
    ,
    "createTable" : function () {
        DataRepository.create()
    },
    "loadTableMapping" : function (mapping) {
        
        
        
        
        this.name = $(object).find("name");
        if (!DataModel::hasTable(this.name)) {
            DataModel::createTable(mapping);
        }
        
        var feilds = {};
        
        
        
        this.type = $(object).find("type");
        
        
        function createFeild (name, type, length, relationTable, relationType, index, nullAllowed) {
            
        }
        
        var column = this.getColumn();
        mapping.find("column").each(function(index, column){
            var name = column.find("name");
            if (name != undefined) {
                column.name = name;
            }
            var type = column.find("type");
            if (type != undefined) {
                column.type = type;
            }
            var length = column.find("type");
            if (length != undefined) {
                column.length = length;
            }
            var relationTable = column.find("relationTable");
            if (relationTable != undefined) {
                column.relationTable = relationTable;
            }
            var relationType = column.find("relationType");
            if (relationType != undefined) {
                column.relationType = relationType;
            }
            var index = column.find("index");
            if (index != undefined) {
                column.index = colum;
            }
            var nullAllowed = column.find("nullAllowed");
            if (nullAllowed != undefined) {
                column.nullAllowed = Boolean(nullAllowed);
            }
            columns []= column;
        });
        
        
        var name = mapping.attr("name");
        var dataTypes = that.getDataTypes();
        dataTypes[name] = $.extend({},{
            "getTableName": function (){
                return name;
            },
            "getFeilds" : function (){
                return feilds;
            },
            "getIdFeildName" : function (){
                
            }
        });
    },
    
};


/* Taskmanager */


var Task = {
    
    
    
    
};

var TaskManager = {
    
    
    
    
};

var RecipientFilter = {
    
    conditions : null, 
    
    getRecipients : function (amount) {
        
        
    }
};

var MessageTemplate = {
    
    name : null,
    message : null, 
    
    /*
    replaces the tokens in the template with the values in data.
    */
    parseTemplate : function (data) {
        
        var matches = this.message.match(/\$\{(.*)\}/), match;
        for (var i=0; match = matches.next(); i++) {
            
            match = match.substr(2,-1);
        }
        
        message.replace();
    }
    
    /*
    
    */
};

var TemplateTokenReplacer = {
    
    
};


/* Conditions */


var Criteria = {
    
    or : function (conditions) {
        return $.extend({}, this.default_criterion, this.default_or, {"conditions" : conditions});
    },
    
    and : function (conditions) {
        return $.extend({}, this.default_criterion, this.default_and, {"conditions" : conditions});
    },
    
    expression : function (conditions) {
        return $.extend({}, this.default_criterion, this.default_expression, {"conditions" : conditions});
    },
    
    default_criterion : {
        type : null,
        evaluate : null
    }, 
    
    default_or : {
        type : "or", 
        conditions : null, 
        sqlSymbol : " or ", 
        jsSymbol : " || "
    },
    
    default_and : {
        type : "and", 
        conditions : null, 
        sqlSymbol : " and ", 
        jsSymbol : " && "
    }, 
    
    default_expression : {
        type : "expression", 
        string : null, 
        getVariables : function () {
            
        },
        replaceVariable : function (oldName, newName) {
            
        }
    }
}

var ConditionDataObject = {
    
};

var ConditionObject = {
    
    name : null,
    tasks : null, 
    actions : null, 
    conditions : null,
    criteria : null
};

var ConditionEditor = {
    
    getEditor : function (item) {
        
        var conditionEditor = $("<div>").append([
            $("<h3>").text(Device.translation("condition.criteria.title")), 
            $("<p>").text(Device.translation("condition.criteria.description")), 
            this.getConditionEditor(item.criteria), 
            $("<h3>").text(Device.translation("condition.tasks.title")), 
            $("<p>").text(Device.translation("condition.tasks.description")), 
            this.getTaskListEditor(item.tasks), 
            $("<h3>").text(Device.translation("condition.actions.title")), 
            $("<p>").text(Device.translation("condition.actions.description")), 
            this.getActionListEditor(item.tasks), 
            $("<h3>").text(Device.translation("condition.conditions.title")), 
            $("<p>").text(Device.translation("condition.conditions.description")), 
            this.getConditionListEditor(item.conditions)
        ]);
        
        var formEditor = $("<div>").formEditor(), 
            formEditorControls = $("<div>").formEditorControls(formEditor);
        
        var viewState = {
            center : {
                formEditor
            }, right : {
                formEditorControls
            }
        };
        
        return viewState;
    }, 
    
    getListItem : function (item) {
        
        return $("<div>").append([
            $("<div>").text(item.name), 
            $("<button>").button({
                "label" : "edit",
                "click" : function (e) {
                    
                }
            }), 
            $("<button>").button()
        ]);
    }, 
    
    getConditionEditor : function (item) {
        
        return $("<div>").append(this.parseCriteria(item));
    }, 
    
    parseCriteria : function (item) {
        
        switch (item.type) {
            case Criteria.or.type:
                return this.getOrEditor(item);
            case Criteria.and.type:
                return this.getAndEditor(item);
            case Criteria.expression.type:
                return this.getExpressionEditor(item);
        }
    },
    
    getAndEditor : function (item) {
        
        var editor = $("<div>").append([
            $("<label>").text(Device.translation("condition.or.label")), 
            $("<button>").button({
                label : Device.translation("common.delete"), 
                click : function (e) {
                    $(this).parent("div").blindOut();
                }
            })
        ]);
        if (item.condition != null && item.condition.size() > 0) {
            $.each(item.conditions, function(index, object){
                this.parseCriteria(object);
            });
        } else {
            editor.text(Device.translation("condition.and.none"));
        }
        return editor;
    }, 
    
    getOrEditor : function (item) {
        
        var editor = $("<div>").append(
            $("<label>").text(Device.translation("condition.or.label"))
        );
        if (item.condition != null && item.condition.size() > 0) {
            $.each(item.conditions, function(index, object){
                this.parseCriteria(object);
            });
        } else {
            editor.text(Device.translation("condition.or.none"));
        }
        return editor;
    },
    
    getExpressionEditor : function (item) {
        
        var editor = $("<div>").append(
            $("<label>").text(Device.translation("condition.condition.label"))
        );
        if (item.condition != null && item.condition.size() > 0) {
            editor.append(
                $("<div>").text(item.expression)
            )
        } else {
            editor.text(Device.translation("condition.condition.none"));
        }
        return editor;
    }
    
};


/* Froms */


var FormDataObject = {
    
};


var FormFeildObject = {
    
    "name"          : null,
    "value"         : null,
    "label"         : null,
    "description"   : null,
    "validator"     : null,
    "maxLength"     : null,
    "minLength"     : null,
    "required"      : null,
    "styleClass"    : null,
    "typeName"      : null,
    "inputName"     : null
};

var FormObject = {
    
    name : null, 
    description : null,
    feilds : null
    
};

var FormEditor = {
    
    getEditor : function (item) {
        
        var formEditor = $("<div>").formEditor({
            feilds: feilds,
            onChange : function (feilds) {
                
            }
        }), 
        
        formEditorControls = $("<div>").formEditorControls(formEditor);
        
        var viewState = {
            center : {
                formEditor
            },
            right : {
                formEditorControls
            }
        };
        
        return viewState;
    }, 
    
    getListItem : function (item) {
        
        return $("<div>").append([
            $("<div>").text(item.name), 
            $("<button>").button({
                "label" : "edit",
                "click" : function (e) {
                    
                }
            }), 
            $("<button>").button({
                "label" : "delete",
                "click" : function (e) {
                    
                }
            })
        ]);
    }
};


/* Actions */


var ActionDataObject = {
    
};

var ActionEditor = {
    
    getActionTypes : function () {
        return {
            "save" : {
                value : null,
                getEditor : function () {
                    // where to save feilds
                }
            }, 
            "callurl" : {
                value : null,
                getEditor : function () {
                    return $("<div>").append($("<label>"), $("<input>"));
                }
            }, 
            "upload file" : {
                
            }, 
            "download file" : {
                
            }, 
            "send email" : {
                
            }, 
            "sms" : {
                
            }, 
            "command" : {
                
            }
        };
    },
    
    getActionOptions : function () {
        var options = [];
        $.each(this.getActionTypes(),function(index,object){
            options.push(object);
        });
        return options;
    },
    
    getEditor : function (item) {
        // save form, callurl, upload file, send email, sms, command,  
        var taskEditor = $("<div>").append([
            $("<h1>").text(Device.translation("tasks.heading")),
            $("<p>").text(Device.translation("tasks.description")),
            $("<h3>").text(Device.translation("tasks.heading")),
            $("<p>").text(Device.translation("tasks.description")),
            $("<div>").append([
                $("<div>").append([
                    $("<label>").text(Device.translation("actions.action")),
                    $("<select>").append(this.getActionOptions()).val(item.name)
                ]),
                $("<div>").append([
                    $("<label>").text(Device.translation("actions.parameters")),
                    $("<input>").val(item.frequency)
                ])
            ])
        ]);
        
        var conditionsList = $("<div>");
        $.each(item.conditions, function(index,object){
            conditionsList.append(
                $("<div>").append([
                    $("<div>").val(object.name),
                    $("<button>").button({
                        "label" : Device.translation("tasks.conditions.remove"),
                        "click" : function (e) {
                            
                        }
                    })
                ])
            );
        });
        
        var actionsList = $("<div>");
        $.each(item.actions, function(index,object){
            actionsList.append(
                $("<div>").append([
                    $("<div>").val(object.name),
                    $("<button>").button({
                        "label" : Device.translation("tasks.actions.remove"),
                        "click" : function (e) {
                            
                        }
                    })
                ])
            );
        });
        
        taskEditor.append([
            $("<h3>").text(Device.translation("tasks.conditions.title")),
            $("<p>").text(Device.translation("tasks.conditions.description")),
            conditionsList,
            $("<h3>").text(Device.translation("tasks.actions.title")),
            $("<p>").text(Device.translation("tasks.actions.description")),
            actionsList
        ]);
        
        var viewState = {
            center : {
                taskEditor
            },
            right : {
            }
        };
        
        return viewState;
    },
    
    getListItem : function (item) {
        
        return $("<div>").append([
            $("<div>").text(item.name), 
            $("<div>").text(item.frequency),
            $("<button>").button({
                "label" : "edit",
                "click" : function (e) {
                    
                }
            }), 
            $("<button>").button({
                "label" : "delete",
                "click" : function (e) {
                    
                }
            })
        ]);
    }
};


/* Tasks */


var TaskDataObject = {
    
    name : null,
    description : null,
    frequency : null,
    conditions : null,
    actions : null
};

var TaskEditor = {
    
    getEditor : function (item) {
        
        var taskEditor = $("<div>").append([
            $("<h1>").text(Device.translation("tasks.heading")),
            $("<p>").text(Device.translation("tasks.description")),
            $("<div>").append([
                $("<div>").append([
                    $("<label>").text(Device.translation("tasks.name")),
                    $("<input>").val(item.name)
                ]),
                $("<div>").append([
                    $("<label>").text(Device.translation("tasks.description")),
                    $("<textarea>").text(item.description)
                ]),
                $("<div>").append([
                    $("<label>").text(Device.translation("tasks.frequency")),
                    $("<select>").val(item.frequency)
                ])
            ])
        ]);
        
        var conditionsList = $("<div>");
        $.each(item.conditions, function(index,object){
            conditionsList.append(
                $("<div>").append([
                    $("<div>").val(object.name),
                    $("<button>").button({
                        "label" : Device.translation("tasks.conditions.remove"),
                        "click" : function (e) {
                            
                        }
                    })
                ])
            );
        });
        
        var actionsList = $("<div>");
        $.each(item.actions, function(index,object){
            actionsList.append(
                $("<div>").append([
                    $("<div>").val(object.name),
                    $("<button>").button({
                        "label" : Device.translation("tasks.actions.remove"),
                        "click" : function (e) {
                            
                        }
                    })
                ])
            );
        });
        
        taskEditor.append([
            $("<h3>").text(Device.translation("tasks.conditions.title")),
            $("<p>").text(Device.translation("tasks.conditions.description")),
            conditionsList,
            $("<h3>").text(Device.translation("tasks.actions.title")),
            $("<p>").text(Device.translation("tasks.actions.description")),
            actionsList
        ]);
        
        var viewState = {
            center : {
                taskEditor
            },
            right : {
            }
        };
        
        return viewState;
    },
    
    getListItem : function (item) {
        
        return $("<div>").append([
            $("<div>").text(item.name), 
            $("<div>").text(item.frequency),
            $("<button>").button({
                "label" : "edit",
                "click" : function (e) {
                    
                }
            }), 
            $("<button>").button({
                "label" : "delete",
                "click" : function (e) {
                    
                }
            })
        ]);
    }
};

/* Statistics */

var StatisticsView = {
    
    getView : function () {
        
        var panel = $("<div>").append([
            $("<h1>").text(Device.translation("statistics.heading")),
            $("<p>").text(Device.translation("statistics.description"))
        ]);
        
        return panel;
    }
}

/* Tables *




*/