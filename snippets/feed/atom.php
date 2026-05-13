<?php
echo '<?xml version="1.0" encoding="utf-8"?>'; ?><feed xmlns="http://www.w3.org/2005/Atom">
    <title><?= \Kirby\Toolkit\Xml::encode($title) ?></title>
    <link href="<?= \Kirby\Toolkit\Xml::encode($link) ?>"/>
    <updated><?= \Kirby\Toolkit\Xml::encode(is_numeric($modified) ? date('r', (int) $modified) : $modified) ?></updated>
    <id><?= \Kirby\Toolkit\Xml::encode(str_replace(site()->url(), '', $link)) ?></id>
    <?php foreach ($items as $item) { ?>
    <entry>
        <title><?= \Kirby\Toolkit\Xml::encode($item->{$titlefield}()) ?></title>
        <link href="<?= \Kirby\Toolkit\Xml::encode($item->{$urlfield}()) ?>"/>
        <id><?= \Kirby\Toolkit\Xml::encode($item->{$idfield}()) ?></id>
        <updated><?= $datefield === 'modified' ? $item->modified('r', 'date') : date('r', $item->{$datefield}()->toTimestamp()) ?></updated>
        <summary><![CDATA[<?= $item->{$textfield}()->kirbytext() ?>]]></summary>
    </entry>
    <?php } ?>
</feed>
