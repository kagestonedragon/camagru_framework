<?php
if (!empty($ROUTER->location) && file_exists($ROUTER->location)) {
    require_once($ROUTER->location);
} else {
    echo "404";
}
