<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
// this related to polymorphic
class CommentUpdateRequest extends FormRequest
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
           'id' => 'required|integer|min:1|digits_between: 1,6', 
           'body' => 'required|min:3|max:1000'
        ];
    }
}
