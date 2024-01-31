<?php

namespace App\Http\Controllers\User;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use IUserService;
use function response;

class UserController extends \App\Http\Controllers\Controller
{
    private $userService;

    public function __constructor(IUserService $userService)
    {
        $this->userService = $userService;
    }

    public function storeOrUpdate(Request $request)
    {

        // Verifique se o email já existe no banco de dados
        $existingCustomer = User::where('email', $request->email)->first();

        if ($existingCustomer && (!$request->id || $existingCustomer->id !== $request->id)) {
            return response()->json(['success' => false, 'msg' => 'Este email já está em uso.']);
        }

        if ($request->id) {
            $customer = User::find($request->id);

            if (!$customer) {
                return response()->json(['success' => false, 'msg' => 'Usuário não encontrado.']);
            }
        } else {
            $customer = new User();
        }

        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->password = bcrypt($request->password);
        $customer->save();

        return response()->json(['success' => true, 'msg' => 'Salvo com sucesso.']);
    }

    public function login(Request $request)
    {
        $customer = User::query()->where('email', $request->email)->first();

        if (!$customer) {
            return response()->json(['success' => false, 'msg' => 'E-mail não encontrado.'], 404);
        }

        if (Hash::check($request->password, $customer->password)) {
            return response()->json(['success' => true, 'customer_id' => $customer->id, 'msg' => 'Autenticação bem-sucedida.']);
        } else {
            return response()->json(['success' => false, 'msg' => 'Senha incorreta.']);
        }
    }

    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        $existingCustomer = User::where('email', $email)->exists();

        return response()->json(['exists' => $existingCustomer]);
    }
}
