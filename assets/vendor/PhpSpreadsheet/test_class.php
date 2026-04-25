<?php
require 'autoload_ps.php';

if (class_exists('PhpOffice\\PhpSpreadsheet\\IOFactory')) {
    echo "✅ IOFactory encontrada";
} else {
    echo "❌ IOFactory NO encontrada";
}