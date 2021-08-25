<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="md:flex md:items-center md:justify-between">
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
            <?= __('Locations') ?>
        </h2>

        <div class="mt-1 sm:mt-0">
            <?= View::factory('oc-panel/components/learn-more', ['url' => 'https://guides.yclas.com/#/Settings-location']) ?>
        </div>
    </div>
    <div class="mt-4 flex md:mt-0 md:ml-4 border-r pr-4">
        <span class="mr-3 shadow-sm rounded-md">
            <?= FORM::open(Route::url('oc-panel', ['controller'=>'location', 'action' => 'search']), ['method' => 'GET'])?>
                <input type="text" name="q" id="search" class="block form-text w-full py-2 px-3 py-0 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="<?=__('Search')?>" value="<?= Core::get('q') ?>" minlength="3">
            <?= FORM::close()?>
        </span>
    </div>
    <div class="mt-4 flex md:mt-0 md:ml-4">
        <span class="ml-3 shadow-sm rounded-md">
            <a href="<?=Route::url('oc-panel',['controller'=>'location','action'=>'geonames'])?><?=Core::get('id_location') ? '?id_location='.HTML::chars(Core::get('id_location')) : NULL?>" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out">
                <?= __('Import Geonames Locations') ?>
            </a>
        </span>
        <span class="ml-3 shadow-sm rounded-md">
            <a href="<?=Route::url('oc-panel',['controller'=>'location','action'=>'create'])?><?=Core::get('id_location') ? '?id_location_parent='.HTML::chars(Core::get('id_location')) : NULL?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-700 active:bg-blue-700 transition duration-150 ease-in-out">
                <?= __('New location') ?>
            </a>
        </span>
    </div>
</div>

<div class="bg-white overflow-hidden shadow rounded-lg mt-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="sortable divide-y divide-gray-200">
            <? foreach ($locs as $key => $location): ?>
                <? $last_item = $key === count($locs) - 1 ?>
                <li>
                    <a href="<?= Route::url('oc-panel',['controller'=>'location','action'=>'index'])?>?id_location=<?=$location->id_location ?>" class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="min-w-0 flex-1 flex items-center">
                                <div class="min-w-0 flex-1 pr-4 md:grid md:grid-cols-2 md:gap-4 items-center">
                                    <div>
                                        <div class="text-sm leading-5 text-gray-900 truncate"><?=$location->name?></div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                </li>
            <? endforeach ?>
        </ul>
    </div>
</div>
