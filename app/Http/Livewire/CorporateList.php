<?php

namespace App\Http\Livewire;

use App\Models\Corporate;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class CorporateList extends Component
{
    use WithPagination;

    public $showModal = false;
    public $showViewModal = false;
    public $corporateId = null;
    public $name = '';
    public $location = '';
    public $is_active = true;
    public $search = '';
    public $viewCorporate = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'location' => 'nullable|string|max:255',
    ];

    public function render()
    {
        $corporates = Corporate::where(function($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('location', 'like', '%' . $this->search . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        
        return view('livewire.corporate-list', compact('corporates'));
    }

    public function openModal($id = null)
    {
        if ($id) {
            $corporate = Corporate::find($id);
            $this->corporateId = $corporate->id;
            $this->name = $corporate->name;
            $this->location = $corporate->location ?? '';
            $this->is_active = $corporate->is_active;
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

    public function viewCorporate($id)
    {
        $corporate = Corporate::with(['users', 'servers', 'databases'])->find($id);
        if ($corporate) {
            $this->viewCorporate = $corporate;
            $this->showViewModal = true;
        }
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->viewCorporate = null;
    }

    public function resetFields()
    {
        $this->corporateId = null;
        $this->name = '';
        $this->location = '';
        $this->is_active = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->corporateId) {
            Corporate::find($this->corporateId)->update([
                'name' => $this->name,
                'location' => $this->location,
                'is_active' => $this->is_active,
            ]);
        } else {
            Corporate::create([
                'name' => $this->name,
                'location' => $this->location,
                'is_active' => $this->is_active,
                'created_by' => Auth::id(),
            ]);
        }

        $this->closeModal();
        session()->flash('message', 'Corporate saved successfully!');
    }

    public function delete($id)
    {
        Corporate::find($id)->delete();
        session()->flash('message', 'Corporate deleted successfully!');
    }

    public function toggleActive($id)
    {
        $corporate = Corporate::find($id);
        $corporate->update(['is_active' => !$corporate->is_active]);
    }
}