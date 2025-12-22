<?php
$cmd = '"C:\xampp\mysql\bin\mysqldump.exe" -u root shoe_store > ' .
       __DIR__.'/backups/backup_'.date('Y-m-d_H-i').'.sql';
system($cmd);
echo 'OK';