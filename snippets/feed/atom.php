<?php

use Kirby\Toolkit\Xml;

echo '<?xml version="1.0" encoding="utf-8"?>'; ?><feed xmlns="http://www.w3.org/2005/Atom">
    <title><?= Xml::encode($title) ?></title>
    <link href="<?= Xml::encode($link) ?>"/>
    <updated><?= Xml::encode(is_numeric($modified) ? date('r', (int) $modified) : $modified) ?></updated>
    <id><?= Xml::encode(str_replace(site()->url(), '', $link)) ?></id>
    <?php foreach ($items as $item) { ?>
    <entry>
        <title><?= Xml::encode($item->{$titlefield}()) ?></title>
        <link href="<?= Xml::encode($item->{$urlfield}()) ?>"/>
        <id><?= Xml::encode($item->{$idfield}()) ?></id>
        <updated><?= $datefield === 'modified' ? $item->modified('r', 'date') : date('r', $item->{$datefield}()->toTimestamp()) ?></updated>
        <summary><![CDATA[<?= $item->{$textfield}()->kirbytext() ?>]]></summary>
    </entry>
    <?php } ?>
</feed>
