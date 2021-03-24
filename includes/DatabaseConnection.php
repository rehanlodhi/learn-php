<?php
$pdo = new PDO('mysql:host=localhost;dbname=ntn;charset=utf8', 'rehanlodhi', 'dev101');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);