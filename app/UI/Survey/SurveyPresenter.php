<?php

declare(strict_types=1);

namespace App\UI\Survey;

use Nette;
use Nette\Application\UI\Form;

final class SurveyPresenter extends Nette\Application\UI\Presenter
{
    private Nette\Database\Context $database;
    private $surveyFormFactory;

    public function __construct(Nette\Database\Context $database, SurveyFormFactory $surveyFormFactory)
    {
        parent::__construct();
        $this->database = $database;
        $this->surveyFormFactory = $surveyFormFactory;
    }

    protected function createComponentSurveyForm(): Nette\Application\UI\Form
    {
        $form = $this->surveyFormFactory->create();

        $form->onSuccess[] = [$this, 'surveyFormSucceeded'];

        return $form;
    }

    public function surveyFormSucceeded(Nette\Application\UI\Form $form, $values): void
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

    public function renderResults($filter = null, $sort = null, $page = 1): void
    {
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
        $form->addText('filter', 'Name:')->setDefaultValue($this->getParameter('filter'));
        $form->addSubmit('submit', 'Filter');
        $form->onSuccess[] = function (Form $form, \stdClass $values): void {
            $this->redirect('results', [
                'filter' => $values->filter,
                'sort' => $this->getParameter('sort')
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
        ])->setDefaultValue($this->getParameter('sort'));
        $form->addSubmit('submit', 'Sort');
        $form->onSuccess[] = function (Form $form, \stdClass $values): void {
            $this->redirect('results', [
                'filter' => $this->getParameter('filter'),
                'sort' => $values->sort
            ]);
        };
        return $form;
    }

}
