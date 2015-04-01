<?php // phpinfo() ?>

<?php
if (function_exists('sqlsrv_query')) {
    echo "Toimii.<br />\n";
} else {
    echo "Ei toimi.<br />\n";
}
?>