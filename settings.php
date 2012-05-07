<?php

/**
 * ownCloud - user_redmine
 *
 * @author Steffen Zieger
 * @copyright 2012 Steffen Zieger <me@saz.sh>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */
$params = array(
    'redmine_db_host',
    'redmine_db_user',
    'redmine_db_password',
    'redmine_db_name'
);

if ($_POST) {
    foreach($params as $param){
        if(isset($_POST[$param])){
            OC_Appconfig::setValue('user_redmine', $param, $_POST[$param]);
        }
    }
}

// fill template
$tmpl = new OC_Template( 'user_redmine', 'settings');
foreach($params as $param){
    $value = OC_Appconfig::getValue('user_redmine', $param,'');
    $tmpl->assign($param, $value);
}

return $tmpl->fetchPage();
