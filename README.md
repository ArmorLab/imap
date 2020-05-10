# PHP imap

[![License](https://img.shields.io/github/license/ArmorLab/imap)](LICENSE)
[![Build status](https://img.shields.io/travis/ArmorLab/imap/master)](https://travis-ci.org/ArmorLab/imap)
[![Version](https://img.shields.io/github/v/release/ArmorLab/imap?label=version)](https://packagist.org/packages/armorlab/imap)
[![Release date](https://img.shields.io/github/release-date/ArmorLab/imap)](https://github.com/ArmorLab/imap/releases)
[![PHP version](https://img.shields.io/travis/php-v/ArmorLab/imap?color=blueviolet)](https://travis-ci.org/ArmorLab/imap)
[![Maintainability](https://img.shields.io/codeclimate/maintainability-percentage/ArmorLab/imap)](https://codeclimate.com/github/ArmorLab/imap)
[![Code coverage](https://img.shields.io/codecov/c/github/ArmorLab/imap)](https://codecov.io/gh/ArmorLab/imap)

Library for manage mailboxes and emails in PHP

## Usage

```php
$connection = new \ArmorLab\Driver\Connection('imap.google.com', 993);

$imapDriver = new \ArmorLab\Driver\ImapDriver($connection);
$imapDriver->login('login', 'password');

//list active folders from mailbox
$folders = $imapDriver->getActiveFolders();
```
