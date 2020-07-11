<?php

namespace App\Admin\Actions;

use App\Models\News;
use Encore\Admin\Actions\RowAction;
use Encore\Admin\Form;
use Illuminate\Database\Eloquent\Model;

class EditContent extends RowAction
{
    public $name = '编辑内容';

    public function handle(Model $model)
    {
        // $model ...

        return $this->response()->success('Success message.')->refresh();
    }

    protected function form()
    {
        $form = new Form(new News());

        $form->summernote('content');

        return $form;
    }

}
