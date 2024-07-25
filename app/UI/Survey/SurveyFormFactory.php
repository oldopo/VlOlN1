<?php

namespace App\UI\Survey;

use Nette\Application\UI\Form;

class SurveyFormFactory
{
    public function create(): Form
    {
        $form = new Form;

        $form->addText('name', 'Name:')
            ->setRequired('Please enter your name.');

        $form->addTextArea('comments', 'Comments:')
            ->setRequired('Please enter your comments.');

        $form->addCheckbox('consent', 'I agree with the terms and conditions.')
            ->setRequired('You must agree to the terms and conditions.');

        $form->addMultiSelect('interests', 'Interests:', [
            'sports' => 'Sports',
            'music' => 'Music',
            'reading' => 'Reading',
            'traveling' => 'Traveling',
            'technology' => 'Technology',
        ])
            ->setRequired('Please select at least one interest.');

        $form->addSubmit('send', 'Submit');

        return $form;
    }
}
