<?php

declare(strict_types=1);

namespace App\UI\Survey;

use Nette;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

final class SurveyPresenter extends Nette\Application\UI\Presenter
{
    private Nette\Database\Context $database;
    private SurveyFormFactory $surveyFormFactory;

    public function __construct(Nette\Database\Context $database, SurveyFormFactory $surveyFormFactory)
    {
        parent::__construct();
        $this->database = $database;
        $this->surveyFormFactory = $surveyFormFactory;
    }

    protected function createComponentSurveyForm(): Form
    {
        $form = $this->surveyFormFactory->create();

        $form->onSuccess[] = [$this, 'surveyFormSucceeded'];

        return $form;
    }

    public function surveyFormSucceeded(Form $form, ArrayHash $values): void
    {
        $this->database->table('surveys')->insert([
            'name' => $values->name,
            'comments' => $values->comments,
            'consent' => $values->consent,
            'interests' => implode(',', $values->interests),
        ]);

        $this->flashMessage('Survey was successfully submitted.');
        $this->redirect('this');
    }

    public function renderResults(): void
    {
        $section = $this->session->getSection('search');
        $filter = $section->filter ?? '';
        $sort = $section->sort ?? 'name';
        $page = $this->getParameter('page') ?? 1;

        $query = $this->database->table('surveys');

        if ($filter) {
            $query->where('name LIKE ?', "%$filter%");
        }

        if ($sort) {
            $query->order($sort);
        }

        $paginator = new Nette\Utils\Paginator;
        $paginator->setItemsPerPage(5);
        $paginator->setPage($page);
        $paginator->setItemCount($query->count());

        $this->template->paginator = $paginator;
        $this->template->surveys = $query->limit($paginator->getLength(), $paginator->getOffset())->fetchAll();
        $this->template->filter = $filter;
        $this->template->sort = $sort;
    }

    protected function createComponentFilterForm(): Form
    {
        $form = new Form;
        $form->addText('filter', 'Name:')->setDefaultValue($this->session->getSection('search')->filter ?? '');
        $form->addSubmit('submit', 'Filter');
        $form->onSuccess[] = function (Form $form, ArrayHash $values): void {
            $this->session->getSection('search')->filter = $values->filter;
            $this->redirect('results', [
                'page' => $this->getParameter('page')
            ]);
        };
        return $form;
    }

    protected function createComponentSortForm(): Form
    {
        $form = new Form;
        $form->addSelect('sort', 'Sort by:', [
            'name' => 'Name',
            'created_at' => 'Created At'
        ])->setDefaultValue($this->session->getSection('search')->sort ?? 'name');
        $form->addSubmit('submit', 'Sort');
        $form->onSuccess[] = function (Form $form, ArrayHash $values): void {
            $this->session->getSection('search')->sort = $values->sort;
            $this->redirect('results', [
                'page' => $this->getParameter('page')
            ]);
        };
        return $form;
    }
}
