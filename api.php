<?php

require 'global.php';

echo make(isset($_GET['name']) ? $_GET['name'] : null);
