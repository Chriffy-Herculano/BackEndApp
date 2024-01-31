<?php

interface IUserService
{
    public function storeOrUpdate($data);
    public function login($data);
}
