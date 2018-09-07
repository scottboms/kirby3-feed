<?php

use \Kirby\Toolkit\XML;

header('Content-Type:text/xml; charset=utf-8');

?>
<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom">

  <channel>
    <title><?= XML::encode($title) ?></title>
    <link><?= XML::encode($link) ?></link>
    <lastBuildDate><?= \date('r', $modified) ?></lastBuildDate>
    <atom:link href="<?= XML::encode($url) ?>" rel="self" type="application/rss+xml" />

    <?php if (!empty($description)): ?>
    <description><?= XML::encode($description) ?></description>
    <?php endif ?>

    <?php foreach ($items as $item): ?>
    <item>
      <title><?= XML::encode($item->title()) ?></title>
      <link><?= XML::encode($item->url()) ?></link>
      <guid><?= XML::encode($item->id()) ?></guid>
      <pubDate><?= $datefield == 'modified' ? $item->modified('r') : $item->date('r', $datefield) ?></pubDate>
      <description><![CDATA[<?= $item->{$textfield}()->kirbytext() ?>]]></description>
    </item>
    <?php endforeach ?>

  </channel>
</rss>