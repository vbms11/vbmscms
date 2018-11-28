<?php

class ShowOfferView extends UIView {
    
    function process () {
        
    }
    
    function view () {
        
        ?>
        <form method="post" action="<?php echo parent::link(RegisterView); ?>">
            <h1><?php echo Translations::get("authentication.title"); ?></h1>
            <p><?php echo Translations::get("authentication.description"); ?></p>
            <button type="submit"><?php echo Translations::get("authentication.register"); ?></button>
        </form>
        <?php
    }
}

?>