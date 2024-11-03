<?php

namespace App\Repositories;

use App\Models\Account;

class AccountRepository 
{
    protected $model;

    public function __construct(Account $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function findAccount($account)
    {
        return $this->model->where('account', $account)->first();
    }

    public function findAccount2(string $value)
    {
        return $this->model->where('email', $value)->first();
    }
}