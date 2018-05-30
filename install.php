<?php
out(_('Creating the database table'));
$dbh = \FreePBX::Database();
try {
    $sql = "CREATE TABLE IF NOT EXISTS rapidcode(
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `number` BIGINT(20) UNSIGNED NOT NULL,
    `code` INT(10) NOT NULL,
    `label` VARCHAR(100) DEFAULT NULL);";
    $sth = $dbh->prepare($sql);
    $result = $sth->execute();
} catch (PDOException $e) {
    $result = $e->getMessage();
}
if ($result === true) {
    out(_('Table Created'));
} else {
    out(_('Something went wrong'));
    out($result);
}

// Register FeatureCode
$fcc = new featurecode('rapidcode', 'rapidcode');
$fcc->setDescription('Call Rapidcode');
$fcc->setDefault('*0');
$fcc->update();
unset($fcc);
