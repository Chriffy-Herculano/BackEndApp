<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService implements IUserService
{

    public function storeOrUpdate($data)
    {
        $where = ['email', '=', $data->email];
        if ($data->id) {
            $user = User::find($data->id);

            if (!$user) {
                return ['success' => false, 'msg' => 'Usuário não encontrado.'];
            }
            $where[] = ['id', '<>', $data->id];

        } else {
            $user = new User();
        }

        $jaExiste = User::query()->where($where)->first();

        if ($jaExiste) {
            return ['success' => false, 'msg' => 'E-mail inválido.'];
        }

        $user->name = $data->name;
        $user->email = $data->email;
        $user->password = bcrypt($data->password);
        $user->email_verified_at = null;
        $user->save();

        return ['success' => true, 'msg' => 'Salvo com suceso.'];
    }

    public function login($data)
    {
        $user = User::query()->where('email', $data->email)->first();
        if (!$user) {
            return ['success' => false, 'msg' => 'Dados inválidos.'];
        }
        if (Hash::check($data->password, $user->password)) {

            return ['success' => true, 'msg' => ''];
        } else {

            return ['success' => false, 'msg' => 'Dados inválidos.'];
        }
    }
}
