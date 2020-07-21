<?php
namespace User\Form;

use Laminas\Form\Form;
use Laminas\InputFilter;
use Laminas\Validator\ValidatorChain;
use Laminas\Validator\StringLength;
use Laminas\Filter\FilterChain;
use Laminas\Filter\StripTags;
use Laminas\Filter\StringTrim;

class LoginForm extends Form
{
    public function __construct()
    {
        parent::__construct();

        $this->setAttribute('method', 'post');

        $this->add([
            'name' => 'username',
            'type' => 'text',
            'attributes' => [
                'id' => 'identity',
                'maxlength' => 30,
                'placeholder' => 'Username',
                'class' => 'form-control',
                'required' => ''
            ],
            'options' => [
                'label' => 'Username : '
            ]
        ]);

        $this->add([
            'name' => 'password',
            'type' => 'password',
            'attributes' => [
                'id' => 'credential',
                'maxlength' => 30,
                'placeholder' => 'Password',
                'class' => 'form-control',
                'required' => ''
            ],
            'options' => [
                'label' => 'Password : '
            ]
        ]);

        $this->add([
            'name' => 'csrf_token',
            'type' => 'hidden',
            'attributes' => [
                'id' => 'token'
            ]
        ]);

        $this->add([
            'name' => 'redirect',
            'type' => 'hidden',
            'attributes' => [
                'id' => 'redirect'
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'button',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Submit',
                'id' => 'login-submit-button',
                'class' => 'btn btn-outline-info btn-block'
            ],
            'options' => [
                'label' => 'Login'
            ]
        ]);

        $this->setInputFilter($this->createInputFilter());
    }

    public function createInputFilter()
    {
        $inputFilter = new InputFilter\InputFilter();

        $usernameValidator = new ValidatorChain();
        $usernameValidator->attach(new StringLength([
            'min' => 6,
            'max' => 30
        ]));
        $usernameFilter = new FilterChain();
        $usernameFilter->attach(new StripTags())->attach(new StringTrim());

        // username
        $username = new InputFilter\Input('username');
        $username->setRequired(true);
        $username->setFilterChain($usernameFilter);
        $username->setValidatorChain($usernameValidator);
        $inputFilter->add($username);

        // password
        $password = new InputFilter\Input('password');
        $password->setRequired(true);
        $inputFilter->add($password);

        // csrf_token
        $token = new InputFilter\Input('csrf_token');
        $token->setRequired(true);
        $inputFilter->add($token);

        return $inputFilter;
    }
}
