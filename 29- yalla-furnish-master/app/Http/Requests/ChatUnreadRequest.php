<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatUnreadRequest extends FormRequest
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
            'showroom_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'type' =>  'required|numeric'
        ];
    }
}
