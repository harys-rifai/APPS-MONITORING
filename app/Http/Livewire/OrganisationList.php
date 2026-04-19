<?php

namespace App\Http\Livewire;

use App\Models\Organisation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class OrganisationList extends Component
{
    use WithPagination;

    public $showModal = false;
    public $showViewModal = false;
    public $showDeleteModal = false;
    public $organisationId = null;
    public $name = '';
    public $location = '';
    public $is_active = true;
    public $loading = false;
    public $search = '';
    public $viewOrganisation = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'location' => 'nullable|string|max:255',
    ];

    public function render()
    {
$organisations = Organisation::where(function($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
        ->withCount(['users', 'servers', 'databases'])
->orderBy('created_at', 'desc')
->paginate(10);
        
        return view('livewire.organisation-list', compact('organisations'));
    }

    public function openModal($id = null)
    {
        if ($id) {
            $organisation = Organisation::find($id);
            if (!$organisation) {
                session()->flash('error', 'Organisation not found!');
                return;
            }
            $this->organisationId = $organisation->id;
            $this->name = $organisation->name;
        $this->is_active = $organisation->is_active;
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

    public function viewOrganisation($id)
    {
        $organisation = Organisation::with(['users', 'servers', 'databases'])->find($id);
        if (!$organisation) {
            session()->flash('error', 'Organisation not found!');
            return;
        }
        $this->viewOrganisation = $organisation;
        $this->showViewModal = true;
        $this->dispatch('modalOpened');
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->viewOrganisation = null;
        $this->dispatch('modalClosed');
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
        $this->loading = true;
        try {
            $this->validate();

            if ($this->organisationId) {
                Organisation::find($this->organisationId)->update([
                    'name' => $this->name,
                    'location' => $this->location,
                    'is_active' => $this->is_active,
                ]);
            } else {
                Organisation::create([
                    'name' => $this->name,
                    'location' => $this->location,
                    'is_active' => $this->is_active,
                    'created_by' => Auth::id(),
                ]);
            }

            $this->closeModal();
            session()->flash('message', 'organisation saved successfully!');
        } finally {
            $this->loading = false;
        }
    }

    public function delete($id)
    {
        Organisation::find($id)->delete();
        session()->flash('message', 'organisation deleted successfully!');
    }

    public function confirmDelete($id)
    {
        $this->organisationId = $id;
        $this->showDeleteModal = true;
        $this->dispatch('modalOpened');
    }

    public function cancelDelete()
    {
        $this->organisationId = null;
        $this->showDeleteModal = false;
        $this->dispatch('modalClosed');
    }

    public function executeDelete()
    {
        if ($this->organisationId) {
            Organisation::find($this->organisationId)->delete();
            session()->flash('message', 'organisation deleted successfully!');
        }
        $this->cancelDelete();
    }

    public function toggleActive($id)
    {
        $organisation = Organisation::find($id);
        $organisation->update(['is_active' => !$organisation->is_active]);
    }
}
