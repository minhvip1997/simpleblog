<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user()->can_post()) {
            return true;
          }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
            {
                return [
                    'body' =>'required',
                    
                ];
            }
            case 'PUT':
            {
                return [
                    'body' => 'required',                  
                ];
            }
            default: break;
        }
    }
}
