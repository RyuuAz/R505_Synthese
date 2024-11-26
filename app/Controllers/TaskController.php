namespace App\Controllers;

use App\Models\TaskModel;

class TaskController extends BaseController
{
    public function create()
    {
        return view('tasks/create');
    }

    public function store()
    {
        $model = new TaskModel();
        $data = [
            'usr_id' => session()->get('user_id'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'due_date' => $this->request->getPost('due_date'),
        ];

        $model->save($data);
        return redirect()->to('/dashboard');
    }

    public function edit($id)
    {
        $model = new TaskModel();
        $task = $model->find($id);
        return view('tasks/edit', ['task' => $task]);
    }

    public function update($id)
    {
        $model = new TaskModel();
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'due_date' => $this->request->getPost('due_date'),
        ];

        $model->update($id, $data);
        return redirect()->to('/dashboard');
    }
}
