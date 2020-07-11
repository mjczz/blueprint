<?php

namespace App\Admin\Controllers;

use App\Models\News;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class NewsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'News';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new News());

        $grid->column('id', __('Id'));
        $grid->column('title', __('标题'));
        $grid->column('publish_status', __('发布状态'))->switch(options('publish_status'));
        $grid->column('news_top', __('置顶'))->switch(options('news_top'));
        $grid->column('news_recommend', __('推荐'))->switch(options('news_recommend'));
        $grid->column('news_type', __('属性'))->using(options('news_type'));
        $grid->column('sort', __('排序'))->editable();
        $grid->column('published_at', __('发布时间'))->editable('datetime');;
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));

        $grid->actions(function ($actions) {
            $actions->disableDelete();
        });

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('title', '标题');
            $filter->like('content', '内容');
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
        $show = new Show(News::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('标题'));
        $show->field('publish_status', __('是否发布'))->using(options('publish_status'));
        $show->field('news_top', __('置顶'))->using(options('news_top'));
        $show->field('news_recommend', __('News recommend'))->using(options('news_recommend'));
        $show->field('news_type', __('属性'))->using(options('news_type'));
        $show->field('sort', __('排序'));
        $show->field('published_at', __('发布时间'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('更新时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new News());

        $form->text('title', __('标题'));
        $form->editor('content');
        $form->switch('publish_status', __('是否发布'))->default(0);
        $form->switch('news_top', __('置顶'))->default(0);
        $form->switch('news_recommend', __('News recommend'))->default(0);
        $form->switch('news_type', __('属性'))->default(0);
        $form->number('sort', __('排序'))->default(100);
        $form->datetime('published_at', __('发布时间'));

        return $form;
    }
}
