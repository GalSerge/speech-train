<?php
namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;


class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function getUser($username, $password)
    {
        $user = $this->userRepository->getByUsername($username);
        if (empty($user) || md5($password) != $user->password) {
            throw new \Exception('Неверный логин или пароль');
        }

        return $user;
    }

    public function getAllUsers()
    {
        $users = $this->userRepository->getUsers();
        return $users->toArray();
    }


    public function getUserById($id)
    {
        $user = $this->userRepository->getById($id);
        return $user->toArray();
    }

    public function createUser()
    {
        $user = $this->userRepository->create();
        return $user->id;
    }

    public function editUser(Request $request, $id)
    {
        $validate_data = $request->validate([
            'active' => 'boolean',
            'username' => 'required',
            'sname' => '',
            'fname' => '',
            'email' => '',
            'password' => '',
            'password2' => ''
        ]);

        if ($validate_data['password'] != '')
        {
            if (isset($validate_data['password']) &&
                isset($validate_data['password2']) &&
                $validate_data['password2'] != $validate_data['password'])
                throw new \ Exception('Пароли не совпадают');

            $validate_data['password'] = md5($validate_data['password']);
        }
        else
            unset($validate_data['password']);
        
        unset($validate_data['password2']);

        $this->userRepository->editUser($validate_data, $id);
    }
}