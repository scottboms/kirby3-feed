<?= '<?xml version="1.0" encoding="utf-8"?>' ?><?php if ($xsl) {
    echo PHP_EOL.'<?xml-stylesheet type="text/xsl" href="sitemap.xsl" ?>';
} ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml"
        <?php if ($images) { ?>xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"<?php } ?>
        <?php if ($videos) { ?>xmlns:video="http://www.google.com/schemas/sitemap-video/1.1"<?php } ?>
>
  <?php foreach ($items as $item) { ?>
  <url>
    <loc><?= $item->{$urlfield}() ?></loc>
    <?php foreach (kirby()->languages() as $lang) { ?>
    <xhtml:link
      rel="alternate"
      hreflang="<?= $lang->code() ?>"
      href="<?= $item->{$urlfield}($lang->code()) ?>"/>
      <?php if ($lang->isDefault()) { ?><xhtml:link rel="alternate" href="<?= $item->{$urlfield}() ?>" hreflang="x-default" /><?php } ?>
    <?php } ?>
    <lastmod><?= date('c', $item->modified()) ?></lastmod>
    <?php if ($images) { ?>
    <?php foreach ($item->{$imagesfield}() as $image) {
        if ($image) { ?>
    <image:image>
      <image:loc><?= $image->url() ?></image:loc>
      <?php if ($image->{$imagetitlefield}()->isNotEmpty()) { ?><image:title><?= $image->{$imagetitlefield}() ?></image:title><?php } ?>
      <?php if ($image->{$imagecaptionfield}()->isNotEmpty()) { ?><image:caption><?= $image->{$imagecaptionfield}() ?></image:caption><?php } ?>
      <?php if ($image->{$imagelicensefield}()->isNotEmpty()) { ?><image:license><?= $image->{$imagelicensefield}() ?></image:license><?php } ?>
    </image:image>
    <?php }
        } ?>
    <?php } ?>
    <?php if ($videos) { ?>
    <?php foreach ($item->{$videosfield}() as $video) {
        if ($video) { ?>
    <video:video>
      <?php if ($video->{$videothumbnailfield}()->isNotEmpty()) { ?><video:thumbnail><?= $video->{$videothumbnailfield}() ?></video:thumbnail><?php } ?>
      <?php if ($video->{$videotitlefield}()->isNotEmpty()) { ?><video:title><?= \Kirby\Toolkit\Xml::encode($video->{$videotitlefield}()) ?></video:title><?php } ?>
      <?php if ($video->{$videodescriptionfield}()->isNotEmpty()) { ?><video:description><?= \Kirby\Toolkit\Xml::encode($video->{$videodescriptionfield}()) ?></video:description><?php } ?>
      <?php if (Str::contains($video->{$videourlfield}(), site()->url())) { ?><video:content_loc><?= $video->{$videourlfield}() ?></video:content_loc>
      <?php } else { ?><video:player_loc><?= $video->{$videourlfield}() ?></video:player_loc><?php } ?>
    </video:video>
    <?php }
        } ?>
    <?php } ?>
    </url>
  <?php } ?>
</urlset>
