<?php

/**
 * ownCloud
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

class OC_User_Redmine extends OC_User_Backend {
    protected $redmine_db_host;
    protected $redmine_db_name;
    protected $redmine_db_user;
    protected $redmine_db_password;
    protected $db;
    protected $db_conn;

    function __construct() {
        $this->db_conn = false;
        $this->redmine_db_host = OC_Appconfig::getValue('user_redmine', 'redmine_db_host','');
        $this->redmine_db_name = OC_Appconfig::getValue('user_redmine', 'redmine_db_name','');
        $this->redmine_db_user = OC_Appconfig::getValue('user_redmine', 'redmine_db_user','');
        $this->redmine_db_password = OC_Appconfig::getValue('user_redmine', 'redmine_db_password','');

        $errorlevel = error_reporting();
        error_reporting($errorlevel & ~E_WARNING);
        $this->db = new mysqli($this->redmine_db_host, $this->redmine_db_user, $this->redmine_db_password, $this->redmine_db_name);
        error_reporting($errorlevel);
        if ($this->db->connect_errno) {
            OC_Log::write('OC_User_Redmine',
                'OC_User_Redmine, Failed to connect to redmine database: ' . $this->db->connect_error,
                OC_Log::ERROR);
            return false;
        }
        $this->db_conn = true;
    }

    /**
     * @brief Set email address
     * @param $uid The username
     */
    private function setEmail($uid) {
        if (!$this->db_conn) {
            return false;
        }

        $result = $this->db->query('SELECT mail FROM users WHERE login = "'. $this->db->real_escape_string($uid) .'"');
        $email = $result->fetch_assoc();
        $email = $email['mail'];
        OC_Preferences::setValue($uid, 'settings', 'email', $email);
    }

    /**
     * @brief Check if the password is correct
     * @param $uid The username
     * @param $password The password
     * @returns true/false
     */
    public function checkPassword($uid, $password){
        if (!$this->db_conn) {
            return false;
        }

        $query = 'SELECT login FROM users WHERE login = "' . $this->db->real_escape_string($uid) . '"';
        $query .= ' AND hashed_password = SHA1(CONCAT(salt, SHA1("' . $this->db->real_escape_string($password) . '")))';
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();

        if ($row) {
            $this->setEmail($uid);
            return $row['login'];
        }
        return false;
    }

    /**
     * @brief Get a list of all users
     * @returns array with all uids
     *
     * Get a list of all users
     */
    public function getUsers() {
        $users = array();
        if (!$this->db_conn) {
            return $users;
        }

        $result = $this->db->query('SELECT login FROM users WHERE status < 3');
        while ($row = $result->fetch_assoc()) {
            if(!empty($row['login'])) {
                $users[] = $row['login'];
            }
        }
        sort($users);
        return $users;
    }

    /**
     * @brief check if a user exists
     * @param string $uid the username
     * @return boolean
     */
    public function userExists($uid) {
        if (!$this->db_conn) {
            return false;
        }

        $result = $this->db->query('SELECT login FROM users WHERE login = "'. $this->db->real_escape_string($uid) .'" AND status < 3');
        return $result->num_rows > 0;
    }
}
