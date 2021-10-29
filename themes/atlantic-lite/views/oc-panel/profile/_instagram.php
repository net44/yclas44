<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">
            <?=_e('Instagram Connect')?>
        </h5>

        <p class="text-muted">
            <?= _e('Once connected, your instagram feed will be shown on your listing page.')?>
        </p>

        <p>
            <?if ($user->instagram_token != ''):?>
                Instagram connected.
                <br><br>
                Reconnect:
                <br>
            <?endif?>

            <a class="btn btn-primary" href="<?= Instagram::loginUrl() ?>">
                <?= _e('Connect with Instagram') ?>
            </a>
        </p>
    </div>
</div>
