namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    public function profile()
    {
        $model = new UserModel();
        $user = $model->find(session()->get('user_id'));
        return view('user/profile', ['user' => $user]);
    }

    public function updateProfile()
    {
        $model = new UserModel();
        $data = [
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];

        $model->update(session()->get('user_id'), $data);
        return redirect()->to('/profile');
    }
}
