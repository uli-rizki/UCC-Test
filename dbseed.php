<?php
require 'bootstrap.php';

$statement = <<<EOS
    CREATE TABLE IF NOT EXISTS `vehicles` (
      `vehicle_id` int(5) NOT NULL,
      `name` varchar(100) NOT NULL,
      `engine_displacement` float NOT NULL,
      `engine_power` int(5) NOT NULL,
      `price` double NOT NULL,
      `location` varchar(100) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

    ALTER TABLE `vehicles` ADD PRIMARY KEY (`vehicle_id`);

    ALTER TABLE `vehicles`
      MODIFY `vehicle_id` int(5) NOT NULL AUTO_INCREMENT;
    COMMIT;
EOS;

try {
    $createTable = $dbConnection->exec($statement);
    echo "Success!\n";
} catch (\PDOException $e) {
    exit($e->getMessage());
}