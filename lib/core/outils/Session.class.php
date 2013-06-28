<?php

// cettte classe permet une gestion ("propre") des sessions
class Session {

    static $no_dataBase = true;
    private $name;
    private $value;

    /**
     * @name : __construct
     * @param : name : string => le nom de la session
     * @return : void
     * @desc : lors de la création de la session, si celle ci existe, elle est récupéré et detruite
     */
    public function __construct($name, $value = null, $regen = false) {
        if (isset($_SESSION[$name])) {
            $this->name = $name;

            $this->value = $_SESSION[$name];
            if ($value != null) {
                $this->value = $value;
                $_SESSION[$name] = $value;
            } else {
                $this->value = $_SESSION[$name];
            }

            if ($regen == false && $value == null) {
                unset($_SESSION[$name]);
            }
        } else {
            if ($value == null)
                $value = "";
            $_SESSION[$name] = $value;
            $this->name = $name;
            $this->value = $value;
        }
    }

    /**
     * @name : set
     * @param : $value : ??  => le contenue de la session
     * @return : void
     * @desc : on enregistre la valeur de la session
     */
    public function set($value) {
        $this->value = $value;
        $_SESSION[$this->name] = $value;
    }

    /**
     * @name : get
     * @param : void
     * @return : ?? => le contenue de la session
     * @desc : on récupère le contenue de la session
     */
    public function get() {
        return $this->value;
    }

    /**
     * @name : delete
     * @param : void
     * @return : void
     * @desc : detruit la session
     */
    public function delete() {
        unset($_SESSION[$this->name]);
    }

}
