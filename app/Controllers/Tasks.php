<?php

namespace App\Controllers;

use App\Models\TaskModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Tasks extends BaseController
{
    protected $helpers = ['form'];

    private const PER_PAGE = 10;

    private function isAdmin(): bool
    {
        return (bool) session()->get('is_admin');
    }


    private function findAllowed(int $id): array
    {
        $task = (new TaskModel())->find($id);

        if (! $task || (! $this->isAdmin() && (int) $task['user_id'] !== (int) session()->get('user_id'))) {
            throw PageNotFoundException::forPageNotFound();
        }
        return $task;
    }


    public function index()
    {
        $q     = trim((string) $this->request->getGet('q'));
        $page  = max(1, (int) $this->request->getGet('page'));
        $model = new TaskModel();

        if (! $this->isAdmin()) {
            $model->where('user_id', (int) session()->get('user_id'));
        }
        if ($q !== '') {
            $model->like('description', $q);
        }

        $total = $model->countAllResults(false);   
        $pages = max(1, (int) ceil($total / self::PER_PAGE));
        $page  = min($page, $pages);

        $tasks = $model->orderBy('created_at', 'DESC')
                       ->orderBy('id', 'DESC')
                       ->findAll(self::PER_PAGE, ($page - 1) * self::PER_PAGE);

        return view('tasks/index', [
            'tasks' => $tasks,
            'q'     => $q,
            'page'  => $page,
            'pages' => $pages,
        ]);
    }

    public function show(int $id)
    {
        return view('tasks/show', ['task' => $this->findAllowed($id)]);
    }


    public function create()
    {
        return view('tasks/form', [
            'title'  => lang('Tasks.new_title'),
            'action' => base_url('tasks/new'),
            'task'   => null,
        ]);
    }

    public function store()
    {
        $rules = ['description' => 'required|trim|min_length[3]|max_length[1000]'];

        if (! $this->validate($rules)) {
            return view('tasks/form', [
                'title'  => lang('Tasks.new_title'),
                'action' => base_url('tasks/new'),
                'task'   => null,
                'errors' => $this->validator->getErrors(),
            ]);
        }

        (new TaskModel())->insert([
            'description' => $this->request->getPost('description'),
            'user_id'     => (int) session()->get('user_id'),
        ]);

        return redirect()->to('tasks')->with('success', lang('Tasks.created'));
    }


    public function edit(int $id)
    {
        return view('tasks/form', [
            'title'  => lang('Tasks.edit_title'),
            'action' => base_url("tasks/{$id}/edit"),
            'task'   => $this->findAllowed($id),
        ]);
    }

    public function update(int $id)
    {
        $task  = $this->findAllowed($id);
        $rules = ['description' => 'required|trim|min_length[3]|max_length[1000]'];

        if (! $this->validate($rules)) {
            return view('tasks/form', [
                'title'  => lang('Tasks.edit_title'),
                'action' => base_url("tasks/{$id}/edit"),
                'task'   => $task,
                'errors' => $this->validator->getErrors(),
            ]);
        }

        (new TaskModel())->update($id, [
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to("tasks/{$id}")->with('success', lang('Tasks.updated'));
    }

    public function delete(int $id)
    {
        $this->findAllowed($id);
        (new TaskModel())->delete($id);

        return redirect()->to('tasks')->with('success', lang('Tasks.deleted'));
    }
}