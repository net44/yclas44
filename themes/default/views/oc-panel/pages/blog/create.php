<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="md:flex md:items-center md:justify-between">
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
            <?= __('New blog post') ?>
        </h2>
    </div>
</div>

<div class="mt-8">
    <?= FORM::open(Route::url('oc-panel', ['controller' => 'blog', 'action' => 'create']), ['enctype' => 'multipart/form-data']) ?>
        <?= View::factory('oc-panel/pages/blog/_form', ['post' => $post, 'locale' => $locale, 'locales' => $locales]) ?>
    <?= FORM::close() ?>
</div>
