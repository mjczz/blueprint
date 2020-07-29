<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:40',
            'content' => 'string',
            'publish_status' => 'integer|gt:0',
            'news_top' => 'integer|gt:0',
            'news_recommend' => 'integer|gt:0',
            'news_type' => 'integer|gt:0',
            'sort' => 'integer|gt:0',
            'published_at' => '',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '文章标题必填',
            'title.string' => '文章标题必须是字符串',
            'title.max' => '文章标题最长40个字',
            'publish_status.required' => '',
        ];
    }
}
