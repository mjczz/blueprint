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
        $grid->column('publish_status', __('发布'))->switch();
        $grid->column('news_top', __('置顶'))->switch();
        $grid->column('news_recommend', __('推荐'))->switch();
        $grid->column('news_type', __("属性"))->editable('select', options('news_type'));
        $grid->column('sort', __('排序'))->editable();
        $grid->column('published_at', __('发布时间'))->editable('datetime');;
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));

        $grid->actions(function ($actions) {
            $actions->disableDelete();
        });

        // 导出
        $grid->export(function ($export) {
            $export->filename('新闻列表'.date('Ymd').'.csv');

            $export->column('news_type', function ($value, $original) {
                return options('news_type')[$original] ?? '-';
            });

            $export->column('news_recommend', function ($value, $original) {
                return options('news_recommend')[$original] ?? '-';
            });

            $export->column('publish_status', function ($value, $original) {
                return options('publish_status')[$original] ?? '-';
            });

            $export->column('news_top', function ($value, $original) {
                return options('news_top')[$original] ?? '-';
            });
        });

        $grid->filter(function ($filter) {
            // 展开筛选
            $filter->expand();

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->column(1/2, function ($filter) {
                $filter->like('title', '标题');
                $filter->like('content', '内容');
                $filter->equal('news_type', '属性')->select(options('news_type'));
                $filter->between('published_at', '发布时间')->datetime();
            });

            $filter->column(1/2, function ($filter) {
                $filter->equal('news_top', '置顶')->select(options('news_top'));
                $filter->equal('publish_status', '发布')->select(options('publish_status'));
                $filter->equal('news_recommend', '推荐')->select(options('news_recommend'));
                $filter->between('created_at', '创建时间')->datetime();
            });
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
        $show->field('publish_status', __('发布'))->using(options('publish_status'));
        $show->field('news_top', __('置顶'))->using(options('news_top'));
        $show->field('news_recommend', __('推荐'))->using(options('news_recommend'));
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
        $form->switch('publish_status', __('发布'))->default(2);
        $form->switch('news_top', __('置顶'))->default(2);
        $form->switch('news_recommend', __('推荐'))->default(2);
        $form->select('news_type', __('属性'))->options(options('news_type'))->width("30px");
        $form->number('sort', __('排序'))->default(100);
        $form->datetime('published_at', __('发布时间'));

        return $form;
    }
}
