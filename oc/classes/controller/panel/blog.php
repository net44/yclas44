<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Panel_Blog extends Auth_Crud {

	/**
	 * @var $_index_fields ORM fields shown in index
	 */
    protected $_index_fields = ['title', 'created', 'status'];

	/**
	 * @var $_orm_model ORM model name
	 */
	protected $_orm_model = 'post';

	/**
     *
     * Loads a basic list info
     * @param string $view template to render
     */
    public function action_index($view = NULL)
    {
        $locale = Core::get('locale', core::config('i18n.locale'));

        $this->template->title = __('Blog');

        $posts = (new Model_Post())->where('id_forum', 'IS', NULL);

        if (Core::config('general.multilingual') AND $locale !== 'all')
        {
            $posts->where('locale', '=', $locale);
        }

        $pagination = Pagination::factory([
            'view' => 'oc-panel/crud/pagination',
            'total_items' => $posts->count_all(),
            //'items_per_page' => 10// @todo from config?,
        ])->route_params([
            'controller' => $this->request->controller(),
            'action' => $this->request->action(),
        ]);

        $pagination->title(__('Blog'));

        $posts = $posts->order_by('created','desc')
            ->limit($pagination->items_per_page)
            ->offset($pagination->offset)
            ->find_all();

        return $this->render('oc-panel/pages/blog/index', [
            'posts' => $posts,
            'locales' => i18n::get_selectable_languages(),
            'locale' => $locale,
            'pagination'=> $pagination->render()
        ]);
    }


    /**
     * CRUD controller: CREATE
     */
    public function action_create()
    {
        $post = new Model_Post();
        $locale = Core::get('locale', core::config('i18n.locale'));

        if($this->request->post())
        {
            $post->id_user = $this->user->id_user;
            $post->title = Core::post('title');
            $post->locale = Core::post('locale');
            $post->seotitle = Core::post('seotitle') ?? $post->gen_seotitle(Core::post('title'));
            $post->description = Kohana::$_POST_ORIG['description'];
            $post->status = Core::post('status') ?? 0;

            try
            {
                $post->save();

                Alert::set(Alert::SUCCESS, __('Blog post created').'. '.__('Please to see the changes delete the cache')
                    .'<br><a class="btn btn-primary btn-mini" href="'.Route::url('oc-panel',array('controller'=>'tools','action'=>'cache')).'?force=1">'
                    .__('Delete cache').'</a>');
            }
            catch (Exception $e)
            {
                Alert::set(Alert::ERROR, $e->getMessage());
            }

            HTTP::redirect(Route::url('oc-panel', ['controller' => 'blog']) . '?locale=' . $locale);
        }

        $this->template->content = View::factory('oc-panel/pages/blog/create', [
            'post' => $post,
            'locale' => $locale,
            'locales' => i18n::get_selectable_languages(),
        ]);
    }


    /**
     * CRUD controller: UPDATE
     */
    public function action_update()
    {
        $post = new Model_Post($this->request->param('id'));

        if (! $post->loaded())
        {
            throw HTTP_Exception::factory(404, __('Page not found'));
        }

        if($this->request->post())
        {
            $post->locale = Core::post('locale');
            $post->title = Core::post('title');
            $post->description = Kohana::$_POST_ORIG['description'];
            $post->seotitle = Core::post('seotitle');
            $post->status = Core::post('status') ?? 0;

            try
            {
                $post->save();

                Alert::set(Alert::SUCCESS, __('Blog post updated'));
            }
            catch (Exception $e)
            {
                Alert::set(Alert::ERROR, $e->getMessage());
            }

            HTTP::redirect(Route::url('oc-panel', [
                'controller' => 'blog',
                'action' => 'update',
                'id' => $post->id_post
            ]));
        }

        $this->template->content = View::factory('oc-panel/pages/blog/update', [
            'post' => $post,
            'locale' => $post->locale,
            'locales' => i18n::get_selectable_languages(),
        ]);
    }

    public function action_delete()
    {
        $page = new Model_Post($this->request->param('id'));

        if (! $page->loaded())
        {
            throw HTTP_Exception::factory(404, __('Page not found'));
        }

        try
        {
            $page->delete();
        }
        catch (Exception $e)
        {
            Alert::set(Alert::ERROR, $e->getMessage());
        }

        HTTP::redirect(Route::url('oc-panel', ['controller' => 'blog']));
    }
}
