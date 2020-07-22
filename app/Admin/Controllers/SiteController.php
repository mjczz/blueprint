<?php

namespace App\Admin\Controllers;

use App\Models\Site;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SiteController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '网站信息配置';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Site());

        $grid->column('id', __('Id'));
        $grid->column('title', __('标题'));
        $grid->column('keywords', __('关键词'));
        $grid->column('desc', __('描述'))->limit(10)->help('网站信息描述');
        $grid->column('copyright', __('版权信息'));
        $grid->column('icp', __('Icp'));
        $grid->column('external_traffic', __('External traffic'));

        // 禁用创建按钮
        $grid->disableCreateButton();

        // 禁用查询过滤器
        $grid->disableFilter();

        // 禁用导出数据按钮
        $grid->disableExport();

        // 禁用行选择checkbox
        $grid->disableRowSelector();

        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();

            // 去掉查看
            $actions->disableView();
        });

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
        $show = new Show(Site::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('标题'));
        $show->field('keywords', __('关键词'));
        $show->field('desc', __('描述'));
        $show->field('copyright', __('版权信息'));
        $show->field('icp', __('Icp'));
        $show->field('external_traffic', __('External traffic'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Site());

        $form->text('title', __('标题'));
        $form->text('keywords', __('关键词'));
        $form->editor('desc');
        $form->text('copyright', __('版权信息'));
        $form->text('icp', __('Icp'));
        $form->textarea('external_traffic', __('External traffic'));

        $form->tools(function (Form\Tools $tools) {
            // 去掉`删除`按钮
            $tools->disableDelete();

            // 去掉`查看`按钮
            $tools->disableView();
        });

        return $form;
    }
}
