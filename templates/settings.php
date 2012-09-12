<form id="redmine" action="#" method="post">
    <fieldset class="personalblock">
        <legend><strong>Redmine</strong></legend>
        <p>
            <label for="redmine_db_host"><?php echo $l->t('DB Host');?></label>
            <input type="text" id="redmine_db_host" name="redmine_db_host"
                value="<?php echo $_['redmine_db_host']; ?>" />

            <label for="redmine_db_name"><?php echo $l->t('DB Name');?></label>
            <input type="text" id="redmine_db_name" name="redmine_db_name" 
                value="<?php echo $_['redmine_db_name']; ?>" />
        </p>

        <p>
            <label for="redmine_db_user"><?php echo $l->t('DB User');?></label>
            <input type="text" id="redmine_db_user" name="redmine_db_user" 
                value="<?php echo $_['redmine_db_user']; ?>" />

            <label for="redmine_db_password"><?php echo $l->t('DB Password');?></label>
            <input type="password" id="redmine_db_password" name="redmine_db_password" 
                value="<?php echo $_['redmine_db_password']; ?>" />
        </p>

        <input type="submit" value="Save" />
    </fieldset>
</form>
