<?php

include 'header.php';

// Load the main class
require_once "Table.php";

$table_progress = new HTML_Table();


    $dir = new DirectoryIterator("/mnt/sda1/www/HomeFinance/downloaded/progress");
    $counter = 1;
    foreach ($dir as $fileinfo) 
    {
        if (!$fileinfo->isDot())
        {
            $file_name = $fileinfo->getPathname();
            $line = '';

            $f = fopen( $file_name, 'r');
            $cursor = -1;

            fseek($f, $cursor, SEEK_END);
            $char = fgetc($f);

            /**
             * Trim trailing newline chars of the file
             */
            while ($char === "\n" || $char === "\r") 
            {
                fseek($f, $cursor--, SEEK_END);
                $char = fgetc($f);
            }

            /**
             * Read until the start of file or first newline char
             */
            while ($char !== false && $char !== "\n" && $char !== "\r")
            {
                /**
                 * Prepend the new char
                 */
                $line = $char . $line;
                fseek($f, $cursor--, SEEK_END);
                $char = fgetc($f);
            
            }
            $table_progress->addRow(array (0 => $counter, 1 => $line));
            ++$counter;
        }
    }
  
  
echo $table_progress->toHtml();

?>

</body>
</html>