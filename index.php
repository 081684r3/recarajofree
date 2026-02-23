<?php
file_put_contents('debug_index.log', date('Y-m-d H:i:s') . ' - Index.php executed' . PHP_EOL, FILE_APPEND);
echo "Hello from Railway! PHP is working.";
?>
<html>
<body>
<h1>Test Page</h1>
<p>If you see this, the app is responding.</p>
</body>
</html>