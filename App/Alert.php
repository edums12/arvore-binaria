<?php

class Alert
{
    public function __construct($name, $alert)
    {
        $_SESSION[$name] = $alert;
    }
}