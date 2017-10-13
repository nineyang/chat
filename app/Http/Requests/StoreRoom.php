<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoom extends FormRequest
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
            'cover' => 'image|max:2048',
            'title' => 'required|max:32',
            'isPrivate' => 'required|boolean'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => '请输入房间标题',
            'title.max' => '最大不可超过32个字符',
            'isPrivate.required' => '请确定是否私密',
            'isPrivate.boolean' => '是否私密的格式不合法',
            'cover.image' => '文件格式不合法',
            'cover.max' => '文件不能超过2M',
        ];
    }
}
