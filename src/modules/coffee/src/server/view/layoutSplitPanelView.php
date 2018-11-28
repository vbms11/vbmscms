<?php

class SplitPanelView extends UIView {
    
    static $action_login = "login";
    static $action_saveDatabase = "saveDatabase";
    static $action_saveAdmin = "saveAdmin";
    static $action_saveTerms = "saveTerms";
    static $action_start = "start";
    
    function process () {
        
        RegisterView::process();
        
        switch (self::getAction()) {
            case self::$action_viewDatabase:
                break;
        }
    }
    
    function view () {
        
        switch (self::getAction()) {
            case self::$action_configure:
                $this->viewConfigure();
                break;
            default:
                $this->viewDefault();
        }
    }
    
    function css () {
        <?php
        .splitPanel {
            display: table;
        }
        .splitPanel div  {
            display: table-cell;
        }
        .splitPanel expandSize {
            width: 99%;
        }
        .splitPanel contractSize {
            width: 1%;
        }
        .splitPanel contantSize {
        }
        .splitPanel autoSize {
            width: auto;
        }
        ?>
    }
    
    function viewConfigure () {
        
        ?>
        <form method="post" action="<?php echo self::link(self::$action_configure); ?>">
            <h1><?php echo Translations::get("splitPanel.welcome.title"); ?></h1>
            <p><?php echo Translations::get("splitPanel.welcome.description"); ?></p>
            <hr/>
            <button type="submit"><?php echo Translations::get("splitPanel.welcome.next"); ?></button>
        </form>
        <?php
    }
    
    function viewDefault () {
        
        $panels = parent::getChildren();
        ?>
        <div class="splitPanel" style="<?php echo parent::param("width"); ?>">
            <?php
            foreach ($panels as $panel => $name) {
                
                ?><div><?php $this->renderPanel($panel); ?></div><?php
            }
            ?>
        </div>
        <?php
    }
    
    function renderPanel ($panel) {
        
        parent::render($panel);
    }
    
}

?>