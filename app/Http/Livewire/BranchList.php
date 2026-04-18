<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use App\Models\Organisation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class BranchList extends Component
{
    use WithPagination;

    public $showModal = false;
    public $showViewModal = false;
    public $showDeleteModal = false;
    public $branchId = null;
    public $name = '';
    public $location = '';
    public $is_active = true;
    public $loading = false;
    public $search = '';
    public $viewBranch = null;
    public $organisation_id = null;
    public $organisations = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'location' => 'nullable|string|max:255',
        'organisation_id' => 'required|exists:organisations,id',
    ];

    public function mount()
    {
        $this->organisations = Organisation::where('is_active', true)->get();
    }

    public function render()
    {
        $user = Auth::user();
        $userOrganisationId = $user ? $user->organisation_id : null;

        $branches = Branch::when($userOrganisationId, function ($query) use ($userOrganisationId) {
                return $query->where('organisation_id', $userOrganisationId);
            })
            ->where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('location', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
->simplePaginate(10);
        
        return view('livewire.branch-list', compact('branches'));
    }

    public function openModal($id = null)
    {
        if ($id) {
            $branch = Branch::find($id);
            if (!$branch) {
                session()->flash('error', 'Branch not found!');
                return;
            }
            $this->branchId = $branch->id;
            $this->organisation_id = $branch->organisation_id;
            $this->name = $branch->name;
            $this->location = $branch->location ?? '';
            $this->is_active = $branch->is_active;
        } else {
            $this->resetFields();
        }
        $this->showModal = true;
        $this->dispatch('modalOpened');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetFields();
        $this->dispatch('modalClosed');
    }

    public function viewBranch($id)
    {
        $branch = Branch::with(['users', 'servers', 'databases'])->find($id);
        if (!$branch) {
            session()->flash('error', 'Branch not found!');
            return;
        }
        $this->viewBranch = $branch;
        $this->showViewModal = true;
        $this->dispatch('modalOpened');
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->viewBranch = null;
        $this->dispatch('modalClosed');
    }

    public function resetFields()
    {
        $this->branchId = null;
        $this->name = '';
        $this->location = '';
        $this->is_active = true;
        $this->organisation_id = null;
    }

    public function save()
    {
        $this->loading = true;
        try {
            $this->validate();

            if ($this->branchId) {
                Branch::find($this->branchId)->update([
                    'name' => $this->name,
                    'location' => $this->location,
                    'is_active' => $this->is_active,
                    'organisation_id' => $this->organisation_id,
                ]);
            } else {
                Branch::create([
                    'name' => $this->name,
                    'location' => $this->location,
                    'is_active' => $this->is_active,
                    'organisation_id' => $this->organisation_id,
                    'created_by' => Auth::id(),
                ]);
            }

            $this->closeModal();
            session()->flash('message', 'Branch saved successfully!');
        } finally {
            $this->loading = false;
        }
    }

    public function delete($id)
    {
        Branch::find($id)->delete();
        session()->flash('message', 'Branch deleted successfully!');
    }

    public function confirmDelete($id)
    {
        $this->branchId = $id;
        $this->showDeleteModal = true;
        $this->dispatch('modalOpened');
    }

    public function cancelDelete()
    {
        $this->branchId = null;
        $this->showDeleteModal = false;
        $this->dispatch('modalClosed');
    }

    public function executeDelete()
    {
        if ($this->branchId) {
            Branch::find($this->branchId)->delete();
            session()->flash('message', 'Branch deleted successfully!');
        }
        $this->cancelDelete();
    }

    public function toggleActive($id)
    {
        $branch = Branch::find($id);
        $branch->update(['is_active' => !$branch->is_active]);
    }
}
