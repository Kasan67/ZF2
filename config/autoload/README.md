В этой папке нужно создать файл doctrine.local.php

с содержимым

<?php

return array(
    'doctrine' => array(
        'connection' => array(
            // default connection name
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => 'user',
                    'password' => 'password',
                    'dbname'   => 'zf2app',
                    'charset' => 'UTF8'
                )
            )
        )
    ),
);