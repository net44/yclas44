<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Panel_Integrations_Instagram extends Auth_Controller {

    public function action_index()
    {
        $this->template->title = __('Instagram');

        $validation = $this->validation();

        if($this->request->post() AND $validation->check())
        {
            Model_Config::set_value('advertisement', 'instagram', Core::post('is_active') ?? 0);
            Model_Config::set_value('advertisement', 'instagram_app_id', Core::post('instagram_app_id'));
            Model_Config::set_value('advertisement', 'instagram_app_secret', Core::post('instagram_app_secret'));

            Alert::set(Alert::SUCCESS, __('Configuration updated'));

            $this->redirect(Route::url('oc-panel/integrations', ['controller' => 'instagram']));
        }

        return $this->template->content = View::factory('oc-panel/pages/integrations/instagram', [
            'errors' => $validation->errors('validation'),
            'is_active' => (bool) Core::config('advertisement.instagram')
        ]);
    }

    private function validation()
    {
        $validation = Validation::factory($this->request->post());

        if ((bool) Core::post('is_active') ?? 0)
        {
            $validation->rule('instagram_app_id', 'not_empty')
                ->rule('instagram_app_secret', 'not_empty');
        }

        return $validation;
    }
}
