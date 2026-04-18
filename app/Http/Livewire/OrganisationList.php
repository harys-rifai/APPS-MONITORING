<?php

namespace App\Http\Livewire;

use App\Models\organisation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class organisationList extends Component
{
    use WithPagination;

    public $showModal = false;
    public $showViewModal = false;
    public $showDeleteModal = false;
    public $organisationId = null;
    public $name = '';
    public $location = '';
    public $is_active = true;
    public $search = '';
    public $vieworganisation = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'location' => 'nullable|string|max:255',
    ];

    public function render()
    {
        $organisations = organisation::where(function($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('location', 'like', '%' . $this->search . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        
        return view('livewire.organisation-list', compact('organisations'));
    }

    public function openModal($id = null)
    {
        if ($id) {
            $organisation = organisation::find($id);
            $this->organisationId = $organisation->id;
            $this->name = $organisation->name;
            $this->location = $organisation->location ?? '';
            $this->is_active = $organisation->is_active;
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

    public function vieworganisation($id)
    {
        $organisation = organisation::with(['users', 'servers', 'databases'])->find($id);
        if ($organisation) {
            $this->vieworganisation = $organisation;
            $this->showViewModal = true;
        }
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->vieworganisation = null;
    }

    public function resetFields()
    {
        $this->organisationId = null;
        $this->name = '';
        $this->location = '';
        $this->is_active = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->organisationId) {
            organisation::find($this->organisationId)->update([
                'name' => $this->name,
                'location' => $this->location,
                'is_active' => $this->is_active,
            ]);
        } else {
            organisation::create([
                'name' => $this->name,
                'location' => $this->location,
                'is_active' => $this->is_active,
                'created_by' => Auth::id(),
            ]);
        }

        $this->closeModal();
        session()->flash('message', 'organisation saved successfully!');
    }

    public function delete($id)
    {
        organisation::find($id)->delete();
        session()->flash('message', 'organisation deleted successfully!');
    }

    public function confirmDelete($id)
    {
        $this->organisationId = $id;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->organisationId = null;
        $this->showDeleteModal = false;
    }

    public function executeDelete()
    {
        if ($this->organisationId) {
            organisation::find($this->organisationId)->delete();
            session()->flash('message', 'organisation deleted successfully!');
        }
        $this->cancelDelete();
    }

    public function toggleActive($id)
    {
        $organisation = organisation::find($id);
        $organisation->update(['is_active' => !$organisation->is_active]);
    }
}
