<?php

namespace App\Http\Livewire;

use App\Models\AuditLog;
use Livewire\Component;
use Livewire\WithPagination;

class AuditLogList extends Component
{
    use WithPagination;

    public $showViewModal = false;
    public $selectedLog = null;
    public $search = '';
    public $entityType = '';
    public $action = '';
    public $dateFrom = '';
    public $dateTo = '';

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $query = AuditLog::query()
            ->with('user')
            ->when($this->search, fn($q) => $q->where('entity_type', 'like', "%{$this->search}%"))
            ->when($this->entityType, fn($q) => $q->where('entity_type', $this->entityType))
            ->when($this->action, fn($q) => $q->where('action', $this->action))
            ->when($this->dateFrom, fn($q) => $q->where('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($q) => $q->where('created_at', '<=', $this->dateTo . ' 23:59:59'));

        return view('livewire.audit-log-list', [
            'logs' => $query->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'entityType', 'action', 'dateFrom', 'dateTo']);
    }

    public function viewLog($id)
    {
        $log = AuditLog::with('user')->find($id);
        if (!$log) {
            session()->flash('error', 'Log not found!');
            return;
        }
        $this->selectedLog = $log;
        $this->showViewModal = true;
        $this->dispatch('modalOpened');
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->selectedLog = null;
        $this->dispatch('modalClosed');
    }
}
