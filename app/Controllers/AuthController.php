namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function processLogin()
    {
        $model = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $user = $model->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set(['user_id' => $user['usr_id'], 'isLoggedIn' => true]);
            return redirect()->to('/dashboard');
        }

        return redirect()->back()->with('error', 'Invalid email or password');
    }

    public function processRegister()
    {
        $model = new UserModel();
        $data = [
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];

        $model->save($data);
        return redirect()->to('/');
    }
}
