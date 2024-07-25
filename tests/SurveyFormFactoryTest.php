<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Nette\Application\UI\Form;
use PHPUnit\Framework\TestCase;
use App\UI\Survey\SurveyFormFactory;

final class SurveyFormFactoryTest extends TestCase
{
    public function testCreateForm(): void
    {
        $factory = new SurveyFormFactory();
        $form = $factory->create();

        // Ověření, zda je form typ Form
        $this->assertInstanceOf(Form::class, $form);

        // Kontrola, zda formulář obsahuje alespoň nějaké komponenty
        $this->assertNotEmpty($form->getControls(), 'Form should contain some controls.');

        // Kontrola, zda formulář obsahuje konkrétní pole, pokud víte, co má obsahovat
        $this->assertNotNull($form->getComponent('name'), 'Form should have a "name" component.');
        $this->assertNotNull($form->getComponent('comments'), 'Form should have a "comments" component.');
        $this->assertNotNull($form->getComponent('consent'), 'Form should have a "consent" component.');
        $this->assertNotNull($form->getComponent('interests'), 'Form should have a "interests" component.');
    }
}
