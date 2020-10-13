<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate as Gate;

class InvitationRequest extends FormRequest
{
    protected $errorBag = 'invitation';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('invite',$this->route('project')); 
        //return Gate::allows('invite',$this->route('project'));
        
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'=>'required|exists:users,email'
            ];
    }

    public function messages()
{
    return [
        'email.exists'=>'The invited member should have a valid familyboard account'
    ];
}
}
