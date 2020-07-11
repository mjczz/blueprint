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
            'publish_status' => 'required|integer|gt:0',
            'news_top' => 'required|integer|gt:0',
            'news_recommend' => 'required|integer|gt:0',
            'news_type' => 'required|integer|gt:0',
            'sort' => 'required|integer|gt:0',
            'published_at' => '',
        ];
    }
}
