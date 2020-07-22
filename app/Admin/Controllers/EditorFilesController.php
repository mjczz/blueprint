<?php

namespace App\Admin\Controllers;

use App\Models\EditorFiles;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class EditorFilesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'EditorFiles';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new EditorFiles());

        $grid->column('id', __('Id'));
        $grid->column('path', __('Path'))->image(env("APP_URL"), '50', '50');
        $grid->column('created_at', __('创建时间'));

        // 全部关闭
        $grid->disableActions();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(EditorFiles::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('path', __('Path'));
        $show->field('created_at', __('创建时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new EditorFiles());

        $form->text('path', __('Path'));

        return $form;
    }
}
