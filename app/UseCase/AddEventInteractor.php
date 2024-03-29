<?php

namespace App\UseCase;



use App\Domain\Event\Contracts\IEventRepository;
use App\Domain\Event\UseCases\AddEvent\Request\AddEventInputPort;
use App\Domain\Event\UseCases\AddEvent\Request\AddEventRequestModel;
use App\Domain\Event\UseCases\AddEvent\Response\AddEventOutputPort;
use App\Domain\Shared\ViewModel;
use App\Persistense\Repositories\EventRepository;
use App\Presenter\Adaprters\Presenters\AddEventPresenter;
use App\Presenter\Adaprters\ViewModels\JsonViewModel;

use function App\app;

class AddEventInteractor implements AddEventInputPort
{
    private readonly IEventRepository $repository;
    private readonly AddEventOutputPort $outputPort;
    public function __construct()
    {
        $this->repository = new EventRepository();
        $this->outputPort = new AddEventPresenter();
    }
    public function add(AddEventRequestModel $model):ViewModel
    {
        
        try{
            
            $result  =  $this->repository->create([
                'title'         => $model->getTitle(),
                'start_data'    => $model->getStartData(),
                'end_ate'       => $model->getEndAt(),
                'bg_color'      => $model->getBgColor(),
                'border_color'  => $model->getBorderColor(),
                'every_day'     => $model->getEveryDay(),
                'created_at'    => $model->getCreatedAt(),
                'updated_at'    => $model->getUpdatedAt(),
            ]);
            return $this->outputPort->success('Success');
        }catch(\Exception $er){
            return $this->outputPort->error($er->getMessage());
        }
    }
}