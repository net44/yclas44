<!-- Off-canvas menu for mobile -->
<div x-show="sidebarOpen" class="md:hidden">
    <div @click="sidebarOpen = false" x-show="sidebarOpen" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 transition-opacity ease-linear duration-300">
        <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
    </div>
    <div class="fixed inset-0 flex z-40">
        <div x-show="sidebarOpen" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="flex-1 flex flex-col max-w-xs w-full bg-blue-800 transform ease-in-out duration-300 ">
            <div class="absolute top-0 right-0 -mr-14 p-1">
                <button x-show="sidebarOpen" @click="sidebarOpen = false" class="flex items-center justify-center h-12 w-12 rounded-full focus:outline-none focus:bg-gray-600">
                <svg class="mb-2 font-medium leading-tight text-base w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                </button>
            </div>
            <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                <div class="flex-shrink-0 flex items-center px-4">
                    <svg class="h-8 w-auto" viewBox="0 0 344 344" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <path d="M101.406,18.054 L172.8,151.059 L242.023,17.708 C220.704,8.035 197.029,2.65 172.093,2.65 L172.093,2.65 C146.863,2.65 122.92,8.166 101.406,18.054 L101.406,18.054 Z M152.493,340.417 C158.926,341.159 165.465,341.538 172.093,341.538 L172.093,341.538 C265.675,341.538 341.537,265.676 341.537,172.095 L341.537,172.095 C341.537,130.851 326.803,93.05 302.311,63.668 L302.311,63.668 L152.493,340.417 Z M2.65,172.095 C2.65,232.536 34.294,285.585 81.922,315.578 L81.922,315.578 L129.612,229.921 L39.707,66.326 C16.517,95.314 2.65,132.084 2.65,172.095 L2.65,172.095 Z" fill="#76a9fa"></path>
                        </g>
                    </svg>
                    <span class="font-semibold ml-2 text-white flex items-center">
                        <?= __('Visit Your Website') ?>

                        <a href="<?=Route::url('default')?>" target="_blank">
                            <svg class="ml-1 h-4 w-auto" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    </span>
                </div>
                <?= View::factory('oc-panel/layouts/_nav') ?>
            </div>
            <div class="flex-shrink-0 flex border-t border-blue-700 p-4">
                <div x-data="{ open: false }" @keydown.window.escape="open = false" @click.away="open = false" class="flex-shrink-0 group block focus:outline-none relative w-full">
                    <div>
                        <button @click="open = !open" type="button"  class="text-left flex items-center">
                            <div>
                                <p class="text-sm leading-5 font-medium text-white">
                                    <?= $user->name ?>
                                </p>
                                <p class="text-xs leading-4 font-medium text-indigo-300 group-hover:text-indigo-100 group-focus:underline transition ease-in-out duration-150">
                                    <?= $user->email ?>
                                </p>
                            </div>
                        </button>
                    </div>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 mb-2 w-56 rounded-md shadow-lg" style="bottom: 100%;">
                        <div class="rounded-md bg-white shadow-xs">
                            <div class="py-1">
                                <a href="<?= Route::url('oc-panel', ['controller' => 'profile', 'action' => 'edit']) ?>" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"><?= __('Edit profile') ?></a>
                                <? if (Core::extra_features() OR Core::is_cloud()) : ?>
                                    <a href="https://yclas.com/panel/support/index" target="_blank" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"><?= __('Support') ?></a>
                                <? endif ?>
                                <a href="https://guides.yclas.com" target="_blank" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"><?= __('Documentation') ?></a>
                                <div class="border-t border-gray-100"></div>
                                <a href="<?= Route::url('oc-panel', ['directory' => 'user', 'controller' => 'auth', 'action' => 'logout']) ?>" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-shrink-0 w-14">
            <!-- Force sidebar to shrink to fit close icon -->
        </div>
    </div>
</div>
<!-- Static sidebar for desktop -->
<div class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64 border-r border-gray-200 bg-blue-800">
        <div class="h-0 flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
            <div class="flex items-center flex-shrink-0 px-4">
                <svg class="h-8 w-auto" viewBox="0 0 344 344" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <path d="M101.406,18.054 L172.8,151.059 L242.023,17.708 C220.704,8.035 197.029,2.65 172.093,2.65 L172.093,2.65 C146.863,2.65 122.92,8.166 101.406,18.054 L101.406,18.054 Z M152.493,340.417 C158.926,341.159 165.465,341.538 172.093,341.538 L172.093,341.538 C265.675,341.538 341.537,265.676 341.537,172.095 L341.537,172.095 C341.537,130.851 326.803,93.05 302.311,63.668 L302.311,63.668 L152.493,340.417 Z M2.65,172.095 C2.65,232.536 34.294,285.585 81.922,315.578 L81.922,315.578 L129.612,229.921 L39.707,66.326 C16.517,95.314 2.65,132.084 2.65,172.095 L2.65,172.095 Z" fill="#76a9fa"></path>
                    </g>
                </svg>
                <span class="font-semibold ml-2 text-white flex items-center">
                    <?= __('Visit Your Website') ?>

                    <a href="<?=Route::url('default')?>" target="_blank">
                        <svg class="ml-1 h-4 w-auto" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                </span>
            </div>
            <div class="flex-1">
                <?= View::factory('oc-panel/layouts/_nav') ?>
            </div>
        </div>
        <div class="flex-shrink-0 flex border-t border-blue-700 p-4">
            <div x-data="{ open: false }" @keydown.window.escape="open = false" @click.away="open = false" class="flex-shrink-0 group block focus:outline-none relative w-full">
                <div>
                    <button @click="open = !open" type="button"  class="text-left flex items-center">
                        <div>
                            <p class="text-sm leading-5 font-medium text-white">
                                <?= $user->name ?>
                            </p>
                            <p class="text-xs leading-4 font-medium text-blue-400 group-hover:text-blue-300 group-focus:underline transition ease-in-out duration-150">
                                <?= $user->email ?>
                            </p>
                        </div>
                    </button>
                </div>
                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 mb-2 w-56 rounded-md shadow-lg" style="bottom: 100%;">
                    <div class="rounded-md bg-white shadow-xs">
                        <div class="py-1">
                            <a href="<?= Route::url('oc-panel', ['controller' => 'profile', 'action' => 'edit']) ?>" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"><?= __('Edit profile') ?></a>
                            <? if (Core::extra_features() OR Core::is_cloud()) : ?>
                                <a href="https://yclas.com/panel/support/index" target="_blank" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"><?= __('Support') ?></a>
                            <? endif ?>
                            <a href="https://guides.yclas.com" target="_blank" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"><?= __('Documentation') ?></a>
                            <div class="border-t border-gray-100"></div>
                            <a href="<?= Route::url('oc-panel', ['directory' => 'user', 'controller' => 'auth', 'action' => 'logout']) ?>" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
