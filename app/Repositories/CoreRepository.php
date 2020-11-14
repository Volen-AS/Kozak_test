<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;

/**
 *Class CareRepository
 *
 *@package App\Repositoies
 *
 * repository works with the entity
 * can issue a data set
 * can't create/edit entity
 */

abstract class CoreRepository
{
    /**
     *@var Model
     */
    protected $model;

    /**
     *CoreRepository constructor
     */
    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    /**
     *@return mixed
     */
    abstract protected function getModelClass();

    /**
     *@return Model|Application|mixed
     */
    protected function startConditions()
    {
        return clone $this->model;
    }
}
