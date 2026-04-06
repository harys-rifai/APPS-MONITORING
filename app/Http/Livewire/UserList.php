<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Corporate;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    public $showModal = false;
    public $showViewModal = false;
    public $userId = null;
    public $name = '';
    public $email = '';
    public $password = '';
    public $corporate_id = null;
    public $is_active = true;
    public $search = '';
    public $viewUser = null;
    public $corporates = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'nullable|string|min:8',
        'corporate_id' => 'required',
    ];

    public function mount()
    {
        $this->corporates = Corporate::where('is_active', true)->get();
    }

    public function render()
    {
        $adminUser = Auth::user();
        $adminCorporateId = $adminUser ? $adminUser->corporate_id : null;

        $users = User::with('corporate')
            ->when($adminCorporateId, function($query) use ($adminCorporateId) {
                return $query->where('corporate_id', $adminCorporateId);
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
            $this->corporate_id = $user->corporate_id;
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
        $user = User::with('corporate')->find($id);
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
        $this->corporate_id = null;
        $this->is_active = true;
    }

    public function save()
    {
        if ($this->userId) {
            $this->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $this->userId,
                'password' => 'nullable|string|min:8',
                'corporate_id' => 'required',
            ]);
        } else {
            $this->validate();
        }

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'corporate_id' => $this->corporate_id,
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

    public function toggleActive($id)
    {
        $user = User::find($id);
        $user->update(['is_active' => !$user->is_active]);
    }
}