<? if (Instagram::hasUserToken($ad->user)): ?>
    <? $medias = Instagram::getUserMedia($ad->user); ?>
    <div>
        <p class="text-center" style="font-size: 28px;"><a href="https://www.instagram.com/<?= $medias[0]->username ?>/"><i class="fab fa-instagram-square" style="font-size: 48px;"></i> <?= $medias[0]->username ?></a></p>
        <div class="row">
            <? foreach ($medias as $media) : ?>
                <div class="col-md-4">
                    <a href="<?= $media->permalink ?>"><img src="<?= $media->media_url ?>" class="img-responsive"></a>
                    <br>
                    <? if (isset($media->caption)) : ?>
                        <div class="caption">
                            <p><small><?= $media->caption ?></small></p>
                            <p class="text-muted"><small><?= $media->username ?> <br> <?= Date::format(date($media->timestamp), 'm-d-Y') ?></small></p>
                            <br>
                        </div>
                    <? endif ?>
                </div>
            <? endforeach ?>
        </div>
    </div>
<? endif ?>
