<div class="md:flex md:items-center md:justify-between">
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
            <?= __('Auto locate') ?>
        </h2>
    </div>
</div>

<?= Form::open(Route::url('oc-panel/addons', ['controller' => 'autolocate'])) ?>
    <div class="bg-white shadow sm:rounded-lg mt-8">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-base leading-5 font-medium text-gray-900">
                <?= __('Enable Auto locate') ?>
            </h3>
            <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                <div class="max-w-xl text-sm leading-5 text-gray-500">
                    <p>
                        <?= __('Get the geographical position of a user. Requires setting up SSL on your website.') ?>
                    </p>
                </div>
                <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                    <?=FORM::checkbox('is_active', 1, (bool) Core::post('is_active', $is_active), ['class' => 'form-checkbox h-6 w-6 text-blue-600 bg-gray-100 transition duration-150 ease-in-out', 'disabled'])?>
                </div>
            </div>
            <div class="mt-5 sm:flex sm:items-center">
                <span class="mt-3 w-ful inline-flex rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <? if ($is_active) : ?>
                        <?= Form::hidden('is_active', 0) ?>
                        <?= Form::button('submit', __('Disable'), ['type'=>'submit', 'class'=>'w-full inline-flex items-center justify-center px-4 py-2 border border-transparent font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150 sm:w-auto sm:text-sm sm:leading-5'])?>
                    <? else : ?> 
                        <?= Form::hidden('is_active', 1) ?>
                        <?= Form::button('submit', __('Enable'), ['type'=>'submit', 'class'=>'w-full inline-flex items-center justify-center px-4 py-2 border border-transparent font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150 sm:w-auto sm:text-sm sm:leading-5'])?>
                    <? endif ?>
                </span>
            </div>
        </div>
    </div>
<?= Form::close() ?>
