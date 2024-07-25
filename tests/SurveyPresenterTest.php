<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Nette\Application\UI\Presenter;
use Nette\Bootstrap\Configurator;
use Nette\Database\Context;
use PHPUnit\Framework\TestCase;
use App\UI\Survey\SurveyPresenter;
use App\UI\Survey\SurveyFormFactory;

final class SurveyPresenterTest extends TestCase
{
    private SurveyPresenter $surveyPresenter;

    protected function setUp(): void
    {
        $configurator = new Configurator;
        $configurator->setTempDirectory(__DIR__ . '/../temp');
        $configurator->addConfig(__DIR__ . '/../config/common.neon');
        $configurator->addConfig(__DIR__ . '/../config/config.neon');
        $configurator->addConfig(__DIR__ . '/../config/config.local.neon');
        $container = $configurator->createContainer();

        $database = $container->getByType(Context::class);
        $surveyFormFactory = $container->getByType(SurveyFormFactory::class);

        $this->surveyPresenter = new SurveyPresenter($database, $surveyFormFactory);
    }

    public function testSurveyPresenterCanBeCreated(): void
    {
        $this->assertInstanceOf(SurveyPresenter::class, $this->surveyPresenter);
    }

    public function testRenderResults(): void
    {
        // Overenie, ze sablona existuje a obsahuje nejaky obsah
        $this->assertTrue(isset($this->surveyPresenter->template));

        // nedari sa mi pripojit pri testovani k databaze, s pripojenim k testovaci databaze se otestuje content
//        $this->surveyPresenter->renderResults();
//        $this->assertNotEmpty($this->surveyPresenter->template->content ?? '');
    }
}
