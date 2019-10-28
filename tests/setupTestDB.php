<?php

$mysql = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], '', $_ENV['DB_PORT']);
$mysql->query('DROP DATABASE IF EXISTS `' . $_ENV['DB_DATABASE'] . '`');
$mysql->query('CREATE DATABASE `' . $_ENV['DB_DATABASE'] . '`');