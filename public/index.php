<?php

declare(strict_types=1);

include __DIR__ . '/../config/bootstrap.php';

use ArmorLab\Driver\SocketImapDriver;

echo '<html><head><meta charset="UTF-8" /><title>Mailbox</title></head><body>';

$imapDriver = new SocketImapDriver(
    \constant('IMAP_HOST'), 
    \constant('IMAP_PORT'),
    \constant('IMAP_TIMEOUT')
);

$imapDriver->login(\constant('IMAP_LOGIN'), \constant('IMAP_PASSWORD'));

$folders = $imapDriver->getAllFolders();
echo '<pre>';
var_dump($folders);
echo '</pre>';

$folders = $imapDriver->getActiveFolders();
echo '<pre>';
var_dump($folders);
echo '</pre>';

$imapDriver->selectFolder("INBOX.spam   ");

//'SINCE ' . date('j-M-Y', time() - 60 * 60 * 24 * 3)
$messages = $imapDriver->search('ALL');

echo '<pre>';
var_dump($messages);
echo '</pre>';

echo '</body></html>';
