<?php

class cAdmin {

    private $ID;
    private $NAME;
    private $SURNAME;
    private $EMAIL;
    private $USERNAME;

    /* Contructor */

    public function __construct($id, $name, $surname, $email, $username) {
        $this->ID = $id;
        $this->NAME = $name;
        $this->SURNAME = $surname;
        $this->EMAIL = $email;
        $this->USERNAME = $username;
    }

    public function getID() {
        return $this->ID;
    }

    public function getNAME() {
        return $this->NAME;
    }

    public function getSURNAME() {
        return $this->SURNAME;
    }

    public function getEMAIL() {
        return $this->EMAIL;
    }

    public function getUSERNAME() {
        return $this->USERNAME;
    }

    public function getAdminTableRow() {
        $ret = "<tr>";
        $ret .= "<td>$this->NAME</td>";
        $ret .= "<td>$this->SURNAME</td>";
        $ret .= "<td>$this->EMAIL</td>";
        $ret .= "<td>$this->USERNAME</td>";
        $ret .= "<td><div class='btn-group'><button type='button' class='btn btn-primary btn-sm dropdown-toggle' data-toggle='dropdown'>
        Action<span class='caret'></span></button>
        <ul class='dropdown-menu' role = 'menu'>
        <li><a href='./accountManagement.php?action=m&adminId=$this->ID'>Modify password</a></li>
        <li><a href='./accountManagement.php?action=d&adminId=$this->ID'>Delete account</a></li>
        </ul></div></td></tr>";
        /* Never show ROOT account. */
        if ($this->USERNAME != 'root' && $this->USERNAME != 'ROOT') {
            return $ret;
        }
    }

}
