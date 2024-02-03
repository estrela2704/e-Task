<?php
namespace etask\Interfaces;

use etask\Models\User;

interface IUserDAO
{
    public function __construct($conn);
    public function buildUser($userDATA);
    public function create(User $user);
    public function update(User $user);
    public function findById($id);
    public function findByEmail($email);
    public function findByToken($token);

}