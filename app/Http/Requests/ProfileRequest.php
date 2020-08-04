<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
         $defaultRules = [
            'intro_self' => 'string',
            'prof_url' => 'url',
            'prof_image' => 'required',
        ];

         if(empty($this->intro_self)){
             unset($defaultRules['intro_self']);
         }
        if(empty($this->prof_url)){
            unset($defaultRules['prof_url']);
        }
        return $defaultRules;
    }

    public function messages()
    {
        return [
            'url' => 'urlにはhttp://を含めてください。',
            'required' => 'プロフィール画像を変更する、または変更しないをお選びください。',
        ];
    }
}
