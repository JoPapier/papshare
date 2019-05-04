<?php

require_once 'class/Cfg.php';
session_destroy();
header('Location:connexion.php');
