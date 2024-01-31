<?php

use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerService implements ICustomerService
{

    public function storeOrUpdate($data)
    {
        $where = ['email', '=', $data->email];
        if ($data->id) {
            $customer = Customer::find($data->id);

            if (!$customer) {
                return ['success' => false, 'msg' => 'Usuário não encontrado.'];
            }
            $where[] = ['id', '<>', $data->id];

        } else {
            $customer = new Customer();
        }

        $jaExiste = Customer::query()->where($where)->first();

        if ($jaExiste) {
            return ['success' => false, 'msg' => 'E-mail inválido.'];
        }

        $customer->name = $data->name;
        $customer->email = $data->email;
        $customer->password = bcrypt($data->password);
        $customer->save();

        return ['success' => true, 'msg' => 'Salvo com suceso.'];
    }

    public function login($data)
    {
        $customer = Customer::query()->where('email', $data->email)->first();
        if (!$customer) {
            return ['success' => false, 'msg' => 'Dados inválidos.'];
        }
        if (Hash::check($data->password, $customer->password)) {

            return ['success' => true, 'msg' => ''];
        } else {

            return ['success' => false, 'msg' => 'Dados inválidos.'];
        }
    }

    public function test()
    {
        $data = [
            'message' => 'Esta é uma resposta de teste em JSON!',
            'status' => 'success',
        ];

        return $data;
    }
}
