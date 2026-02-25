<?php

// Dynamically include the requested admin sub-page file
$file = "pages/admin/{$sub}.php";

if (file_exists($file)) {
    include $file;
} else {
    include "pages/admin/index.php";
}