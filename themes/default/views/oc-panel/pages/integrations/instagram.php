<div class="md:flex md:items-center md:justify-between">
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
            <?= __('Instagram') ?>
        </h2>
    </div>
</div>

<? if (! empty($errors)) : ?>
    <div class="mt-8">
        <?= View::factory('oc-panel/components/form-errors', ['errors' => $errors]) ?>
    </div>
<? endif ?>

<?= Form::open(Route::url('oc-panel/integrations', ['controller' => 'instagram'])) ?>
    <div class="bg-white shadow sm:rounded-lg mt-8">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-base leading-5 font-medium text-gray-900">
                <?= __('Enable Instagram') ?>
            </h3>
            <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                <div class="max-w-xl text-sm leading-5 text-gray-500">
                    <p>
                        <?= __('The Instagram integration flow will require your users connect their instagram account on the edit profile page. Once it\'s connected, the instagram feed we will be shown on their listing page.') ?>
                    </p>
                </div>
                <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                    <?=FORM::checkbox('is_active', 1, (bool) Core::post('is_active', $is_active), ['class' => 'form-checkbox h-6 w-6 text-blue-600 bg-gray-100 transition duration-150 ease-in-out'])?>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-200 pt-8">
                <div class="grid grid-cols-1 row-gap-6 col-gap-4 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <?= FORM::label('instagram_app_id', __('App ID'), array('class'=>'block text-sm font-medium leading-5 text-gray-700'))?>
                        <div class="mt-1 rounded-md shadow-sm">
                            <?= FORM::input('instagram_app_id', Core::post('instagram_app_id', Core::config('advertisement.instagram_app_id')), [
                                'class' => 'form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5',
                            ])?>
                        </div>
                    </div>
                    <div class="sm:col-span-4">
                        <?= FORM::label('instagram_app_secret', __('App Secret'), array('class'=>'block text-sm font-medium leading-5 text-gray-700'))?>
                        <div class="mt-1 rounded-md shadow-sm">
                            <?= FORM::input('instagram_app_secret', Core::post('instagram_app_secret', Core::config('advertisement.instagram_app_secret')), [
                                'class' => 'form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5',
                            ])?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-200 pt-5">
                <span class="inline-flex rounded-md shadow-sm">
                    <?=FORM::button('submit', __('Save'), ['type'=>'submit', 'class'=>'inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition duration-150 ease-in-out'])?>
                </span>
            </div>
        </div>
    </div>
<?= Form::close() ?>
