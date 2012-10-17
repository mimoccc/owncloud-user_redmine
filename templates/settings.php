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

            <label for="redmine_db_driver"><?php echo $l->t('DB Driver');?></label>
            <?php $db_driver = array('mysql' => 'MySQL', 'pgsql' => 'PostgreSQL');?>
            <select id="redmine_db_driver" name="redmine_db_driver">
                <?php foreach ($db_driver as $driver => $name): ?>
                    <?php echo $_['redmine_db_driver']; ?>
                    <?php if ($_['redmine_db_driver'] == $driver): ?>
                        <option selected="selected" value="<?php echo $driver; ?>"><?php echo $name; ?></option>
                    <?php else: ?>
                        <option value="<?php echo $driver; ?>"><?php echo $name; ?></option>
                    <?php endif ?>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label for="redmine_db_user"><?php echo $l->t('DB User');?></label>
            <input type="text" id="redmine_db_user" name="redmine_db_user" 
                value="<?php echo $_['redmine_db_user']; ?>" />

            <label for="redmine_db_password"><?php echo $l->t('DB Password');?></label>
            <input type="text" id="redmine_db_password" name="redmine_db_password" 
                value="<?php echo $_['redmine_db_password']; ?>" />
        </p>

        <input type="submit" value="Save" />
    </fieldset>
</form>
