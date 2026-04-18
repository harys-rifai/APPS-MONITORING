<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\organisation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    public $showModal = false;
    public $showViewModal = false;
    public $showDeleteModal = false;
    public $userId = null;
    public $name = '';
    public $email = '';
    public $password = '';
    public $organisation_id = null;
    public $is_active = true;
    public $search = '';
    public $viewUser = null;
    public $organisations = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'nullable|string|min:8',
        'organisation_id' => 'required',
    ];

    public function mount()
    {
        $this->organisations = organisation::where('is_active', true)->get();
    }

    public function render()
    {
        $adminUser = Auth::user();
        $adminorganisationId = $adminUser ? $adminUser->organisation_id : null;

        $users = User::with('organisation')
            ->when($adminorganisationId, function($query) use ($adminorganisationId) {
                return $query->where('organisation_id', $adminorganisationId);
            })
            ->where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
        
        return view('livewire.user-list', compact('users'));
    }

    public function openModal($id = null)
    {
        if ($id) {
            $user = User::find($id);
            $this->userId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->organisation_id = $user->organisation_id;
            $this->is_active = $user->is_active;
        } else {
            $this->resetFields();
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetFields();
    }

    public function viewUser($id)
    {
        $user = User::with('organisation')->find($id);
        if ($user) {
            $this->viewUser = $user;
            $this->showViewModal = true;
        }
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->viewUser = null;
    }

    public function resetFields()
    {
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->organisation_id = null;
        $this->is_active = true;
    }

    public function save()
    {
        if ($this->userId) {
            $this->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $this->userId,
                'password' => 'nullable|string|min:8',
                'organisation_id' => 'required',
            ]);
        } else {
            $this->validate();
        }

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'organisation_id' => $this->organisation_id,
            'is_active' => $this->is_active,
        ];

        if ($this->password) {
            $data['password'] = $this->password;
        }

        if ($this->userId) {
            User::find($this->userId)->update($data);
        } else {
            User::create($data);
        }

        $this->closeModal();
        session()->flash('message', 'User saved successfully!');
    }

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('message', 'User deleted successfully!');
    }

    public function confirmDelete($id)
    {
        $this->userId = $id;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->userId = null;
        $this->showDeleteModal = false;
    }

    public function executeDelete()
    {
        if ($this->userId) {
            User::find($this->userId)->delete();
            session()->flash('message', 'User deleted successfully!');
        }
        $this->cancelDelete();
    }

    public function toggleActive($id)
    {
        $user = User::find($id);
        $user->update(['is_active' => !$user->is_active]);
    }
}
