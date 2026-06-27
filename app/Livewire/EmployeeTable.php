<?php

namespace App\Livewire;

use App\Models\Division;
use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortField = 'nik';
    public string $sortDirection = 'asc';
    public string $filterDivision = '';
    public string $filterStatus = '';

    public bool $showCreateModal = false;
    public bool $showEditModal = false;
    public bool $showPreview = false;
    public ?int $editId = null;
    public int $step = 1;

    public string $nik = '';
    public string $nama = '';
    public string $tempat_lahir = '';
    public string $tanggal_lahir = '';
    public string $jenis_kelamin = '';
    public string $alamat = '';
    public string $status = 'aktif';

    public string $position = '';
    public string $division_id = '';
    public string $atasan = '';
    public string $tanggal_masuk = '';
    public string $jenis_karyawan = '';
    public string $lokasi_kerja = '';

    public string $no_hp = '';
    public string $email = '';
    public string $no_kontak_darurat1 = '';
    public string $hubungan_darurat1 = '';
    public string $no_kontak_darurat2 = '';
    public string $hubungan_darurat2 = '';
    public string $no_bpjs = '';

    public string $tanggal_resign = '';
    public string $catatan = '';

    protected $updatesQueryString = ['search'];

    protected function rules(): array
    {
        return [
            'nik' => ['required', 'string', 'max:30'],
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif,resign',
            'position' => 'nullable|string|max:255',
            'division_id' => 'nullable|exists:divisions,id',
            'atasan' => 'nullable|string|max:255',
            'tanggal_masuk' => 'nullable|date',
            'jenis_karyawan' => 'nullable|string|max:30',
            'lokasi_kerja' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'no_kontak_darurat1' => 'nullable|string|max:30',
            'hubungan_darurat1' => 'nullable|string|max:50',
            'no_kontak_darurat2' => 'nullable|string|max:30',
            'hubungan_darurat2' => 'nullable|string|max:50',
            'no_bpjs' => 'nullable|string|max:30',
            'tanggal_resign' => 'nullable|date',
            'catatan' => 'nullable|string',
        ];
    }

    protected function messages(): array
    {
        return [
            'nik.required' => 'NIK wajib diisi.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'nama.required' => 'Nama wajib diisi.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
            'status.required' => 'Status wajib dipilih.',
            'division_id.exists' => 'Divisi tidak ditemukan.',
        
        ];
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->step = 1;
        $this->showCreateModal = true;
    }

    public function openEditModal(int $id): void
    {
        $emp = Employee::findOrFail($id);
        $this->editId = $emp->id;
        $this->nik = $emp->nik;
        $this->nama = $emp->nama;
        $this->tempat_lahir = $emp->tempat_lahir ?? '';
        $this->tanggal_lahir = $emp->tanggal_lahir?->format('Y-m-d') ?? '';
        $this->jenis_kelamin = $emp->jenis_kelamin ?? '';
        $this->alamat = $emp->alamat ?? '';
        $this->status = $emp->status;
        $this->position = $emp->position ?? '';
        $this->division_id = (string) ($emp->division_id ?? '');
        $this->atasan = $emp->atasan ?? '';
        $this->tanggal_masuk = $emp->tanggal_masuk?->format('Y-m-d') ?? '';
        $this->jenis_karyawan = $emp->jenis_karyawan ?? '';
        $this->lokasi_kerja = $emp->lokasi_kerja ?? '';
        $this->no_hp = $emp->no_hp ?? '';
        $this->email = $emp->email ?? '';
        $this->no_kontak_darurat1 = $emp->no_kontak_darurat1 ?? '';
        $this->hubungan_darurat1 = $emp->hubungan_darurat1 ?? '';
        $this->no_kontak_darurat2 = $emp->no_kontak_darurat2 ?? '';
        $this->hubungan_darurat2 = $emp->hubungan_darurat2 ?? '';
        $this->no_bpjs = $emp->no_bpjs ?? '';
        $this->tanggal_resign = $emp->tanggal_resign?->format('Y-m-d') ?? '';
        $this->catatan = $emp->catatan ?? '';
        $this->step = 1;
        $this->showEditModal = true;
    }

    public function closeModal(): void
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showPreview = false;
        $this->editId = null;
        $this->step = 1;
        $this->resetErrorBag();
    }

    public function nextStep(): void
    {
        $this->step++;
    }

    public function prevStep(): void
    {
        $this->step--;
    }

    public function goToStep(int $step): void
    {
        $this->step = $step;
    }

    public function confirmPreview(): void
    {
        $this->validate($this->rules());
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showPreview = true;
    }

    public function backToForm(): void
    {
        $this->showPreview = false;
        if ($this->editId) {
            $this->showEditModal = true;
        } else {
            $this->showCreateModal = true;
        }
    }

    public function save(): void
    {
        $rules = $this->rules();
        $rules['nik'] = ['required', 'string', 'max:30', 'unique:employees,nik'];
        $this->validate($rules);

        Employee::create($this->buildData());

        $this->closeModal();
        $this->dispatch('notify', type: 'success', message: 'Karyawan berhasil ditambahkan.');
    }

    public function update(): void
    {
        $emp = Employee::findOrFail($this->editId);

        $rules = $this->rules();
        $rules['nik'] = ['required', 'string', 'max:30', 'unique:employees,nik,' . $this->editId];
        $this->validate($rules);

        $emp->update($this->buildData());

        $this->closeModal();
        $this->dispatch('notify', type: 'success', message: 'Data karyawan berhasil diperbarui.');
    }

    public function delete(int $id): void
    {
        Employee::findOrFail($id)->delete();
        $this->dispatch('notify', type: 'success', message: 'Karyawan berhasil dihapus.');
    }

    public function render()
    {
        $employees = Employee::with('division')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nik', 'like', "%{$this->search}%")
                      ->orWhere('nama', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%")
                      ->orWhere('no_hp', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filterDivision, function ($query) {
                $query->where('division_id', $this->filterDivision);
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $divisions = Division::where('is_active', true)->orderBy('nama')->get();
        return view('livewire.employee-table', [
            'employees' => $employees,
            'divisions' => $divisions,
        ]);
    }

    private function buildData(): array
    {
        return [
            'nik' => $this->nik,
            'nama' => $this->nama,
            'email' => $this->email ?: null,
            'no_hp' => $this->no_hp ?: null,
            'alamat' => $this->alamat ?: null,
            'tempat_lahir' => $this->tempat_lahir ?: null,
            'tanggal_lahir' => $this->tanggal_lahir ?: null,
            'jenis_kelamin' => $this->jenis_kelamin ?: null,
            'division_id' => $this->division_id ?: null,
            'position' => $this->position ?: null,
            'atasan' => $this->atasan ?: null,
            'jenis_karyawan' => $this->jenis_karyawan ?: null,
            'lokasi_kerja' => $this->lokasi_kerja ?: null,
            'no_kontak_darurat1' => $this->no_kontak_darurat1 ?: null,
            'hubungan_darurat1' => $this->hubungan_darurat1 ?: null,
            'no_kontak_darurat2' => $this->no_kontak_darurat2 ?: null,
            'hubungan_darurat2' => $this->hubungan_darurat2 ?: null,
            'no_bpjs' => $this->no_bpjs ?: null,
            'status' => $this->status,
            'tanggal_masuk' => $this->tanggal_masuk ?: null,
            'tanggal_resign' => $this->tanggal_resign ?: null,
            'catatan' => $this->catatan ?: null,
        ];
    }

    private function resetForm(): void
    {
        $this->editId = null;
        $this->nik = '';
        $this->nama = '';
        $this->tempat_lahir = '';
        $this->tanggal_lahir = '';
        $this->jenis_kelamin = '';
        $this->alamat = '';
        $this->status = 'aktif';
        $this->position = '';
        $this->division_id = '';
        $this->atasan = '';
        $this->tanggal_masuk = '';
        $this->jenis_karyawan = '';
        $this->lokasi_kerja = '';
        $this->no_hp = '';
        $this->email = '';
        $this->no_kontak_darurat1 = '';
        $this->hubungan_darurat1 = '';
        $this->no_kontak_darurat2 = '';
        $this->hubungan_darurat2 = '';
        $this->no_bpjs = '';
        $this->tanggal_resign = '';
        $this->catatan = '';
        $this->step = 1;
        $this->resetErrorBag();
    }
}
