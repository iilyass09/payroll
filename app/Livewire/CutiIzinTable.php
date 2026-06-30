<?php

namespace App\Livewire;

use App\Models\LeaveRequest;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class CutiIzinTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterJenis = '';
    public string $filterStatus = '';

    public bool $showPengajuanModal = false;
    public string $pengajuanJenis = 'cuti_tahunan';
    public string $pengajuanTanggalMulai = '';
    public string $pengajuanTanggalSelesai = '';
    public string $pengajuanKeterangan = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openPengajuanModal(): void
    {
        $this->showPengajuanModal = true;
        $this->pengajuanJenis = 'cuti_tahunan';
        $this->pengajuanTanggalMulai = '';
        $this->pengajuanTanggalSelesai = '';
        $this->pengajuanKeterangan = '';
        $this->resetErrorBag();
    }

    public function closePengajuanModal(): void
    {
        $this->showPengajuanModal = false;
        $this->resetErrorBag();
    }

    public function submitPengajuan(): void
    {
        $this->validate([
            'pengajuanJenis' => ['required', 'in:cuti_tahunan,izin'],
            'pengajuanTanggalMulai' => ['required', 'date'],
            'pengajuanTanggalSelesai' => ['required', 'date', 'after_or_equal:pengajuanTanggalMulai'],
            'pengajuanKeterangan' => ['required', 'string', 'max:1000'],
        ]);

        $user = auth()->user();
        $employee = $user->employee;

        if (!$employee) {
            $this->dispatch('notify', type: 'error', message: 'Akun Anda tidak terhubung ke data karyawan.');
            return;
        }

        $mulai = \Carbon\Carbon::parse($this->pengajuanTanggalMulai);
        $selesai = \Carbon\Carbon::parse($this->pengajuanTanggalSelesai);
        $durasi = $mulai->diffInDays($selesai) + 1;

        $atasan = $this->getAtasan($employee);

        LeaveRequest::create([
            'employee_id' => $employee->id,
            'atasan_id' => $atasan?->id,
            'jenis' => $this->pengajuanJenis,
            'tanggal_mulai' => $this->pengajuanTanggalMulai,
            'tanggal_selesai' => $this->pengajuanTanggalSelesai,
            'durasi' => $durasi . ' hari',
            'keterangan' => $this->pengajuanKeterangan,
            'persetujuan_koor' => 'menunggu',
            'persetujuan_hr' => 'menunggu',
        ]);

        $this->closePengajuanModal();
        $this->dispatch('notify', type: 'success', message: 'Pengajuan berhasil dikirim.');
    }

    public function setujui(int $id, string $level): void
    {
        $lr = LeaveRequest::with('employee')->findOrFail($id);
        $this->authorizeApproval($lr, $level);
        $lr->update([$level => 'disetujui']);
        $this->dispatch('notify', type: 'success', message: 'Pengajuan disetujui.');
    }

    public function tolak(int $id, string $level): void
    {
        $lr = LeaveRequest::with('employee')->findOrFail($id);
        $this->authorizeApproval($lr, $level);
        $lr->update([$level => 'ditolak']);
        $this->dispatch('notify', type: 'success', message: 'Pengajuan ditolak.');
    }

    private function authorizeApproval(LeaveRequest $lr, string $level): void
    {
        $user = auth()->user();

        if ($level === 'persetujuan_koor') {
            $userEmployee = $user->employee;
            if (!$userEmployee || $userEmployee->id !== $lr->atasan_id) {
                abort(403, 'Hanya atasan yang dapat menyetujui pengajuan ini.');
            }
        } elseif ($level === 'persetujuan_hr') {
            if ($user->id !== 4 && !$this->isHr($user)) {
                abort(403, 'Hanya Yuliana Sventy yang dapat menyetujui persetujuan HR.');
            }
        } else {
            abort(403);
        }
    }

    public function hapus(int $id): void
    {
        $user = auth()->user();
        $employee = $user->employee;

        if (!$employee) {
            $this->dispatch('notify', type: 'error', message: 'Akun Anda tidak terhubung ke data karyawan.');
            return;
        }

        $lr = LeaveRequest::where('id', $id)->where('employee_id', $employee->id)->first();

        if (!$lr) {
            $this->dispatch('notify', type: 'error', message: 'Data tidak ditemukan.');
            return;
        }

        if ($lr->persetujuan_koor !== 'menunggu' && $lr->persetujuan_hr !== 'menunggu') {
            $this->dispatch('notify', type: 'error', message: 'Hanya pengajuan yang masih menunggu yang dapat dihapus.');
            return;
        }

        $lr->delete();
        $this->dispatch('notify', type: 'success', message: 'Pengajuan berhasil dihapus.');
    }

    public function hapusAdmin(int $id): void
    {
        Gate::authorize('delete-data');
        LeaveRequest::findOrFail($id)->delete();
        $this->dispatch('notify', type: 'success', message: 'Pengajuan berhasil dihapus.');
    }

    public function render()
    {
        $user = auth()->user();
        $userEmployee = $user->employee;

        if ($user->isKaryawan()) {
            $employee = $userEmployee;

            if (!$employee) {
                $leaveRequests = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);

                return view('livewire.cuti-izin-table', [
                    'karyawanView' => true,
                    'employee' => null,
                    'totalPengajuanSaya' => 0,
                    'totalCutiSaya' => 0,
                    'totalIzinSaya' => 0,
                    'menungguCuti' => 0,
                    'menungguIzin' => 0,
                    'sisaCuti' => 0,
                    'jatahCuti' => 12,
                    'leaveRequests' => $leaveRequests,
                ]);
            }

            $totalPengajuanSaya = LeaveRequest::where('employee_id', $employee->id)->count();
            $totalCutiSaya = LeaveRequest::where('employee_id', $employee->id)->where('jenis', 'cuti_tahunan')->count();
            $totalIzinSaya = LeaveRequest::where('employee_id', $employee->id)->where('jenis', 'izin')->count();
            $menungguCuti = LeaveRequest::where('employee_id', $employee->id)
                ->where('jenis', 'cuti_tahunan')
                ->where(function ($q) {
                    $q->where('persetujuan_koor', 'menunggu')
                      ->orWhere('persetujuan_hr', 'menunggu');
                })->count();
            $menungguIzin = LeaveRequest::where('employee_id', $employee->id)
                ->where('jenis', 'izin')
                ->where(function ($q) {
                    $q->where('persetujuan_koor', 'menunggu')
                      ->orWhere('persetujuan_hr', 'menunggu');
                })->count();

            $jatahCuti = 12;
            $usedCuti = LeaveRequest::where('employee_id', $employee->id)
                ->where('jenis', 'cuti_tahunan')
                ->whereYear('tanggal_mulai', now()->year)
                ->where('persetujuan_koor', 'disetujui')
                ->where('persetujuan_hr', 'disetujui')
                ->get()
                ->sum(fn($lr) => (int) filter_var($lr->durasi, FILTER_SANITIZE_NUMBER_INT));
            $sisaCuti = max(0, $jatahCuti - $usedCuti);

            $leaveRequests = LeaveRequest::with('employee', 'atasan')
                ->where('employee_id', $employee->id)
                ->when($this->filterJenis, function ($query) {
                    $query->where('jenis', $this->filterJenis);
                })
                ->latest()
                ->paginate(10);

            return view('livewire.cuti-izin-table', compact(
                'employee', 'totalPengajuanSaya', 'totalCutiSaya', 'totalIzinSaya', 'menungguCuti', 'menungguIzin', 'leaveRequests', 'sisaCuti', 'jatahCuti'
            ))->with('karyawanView', true);
        }

        $isDireksi = $user->isDireksi();
        $isHr = $userEmployee && in_array($userEmployee->position, [
            'Human Resource Generalist', 'Admin HR', 'Admin GA', 'OB'
        ]);
        $lihatSemua = $user->id === 4 || $isHr || $isDireksi;

        $totalPengajuan = LeaveRequest::count();
        $totalCuti = LeaveRequest::where('jenis', 'cuti_tahunan')->count();
        $totalIzin = LeaveRequest::where('jenis', 'izin')->count();
        $menunggu = LeaveRequest::where('persetujuan_koor', 'menunggu')->orWhere('persetujuan_hr', 'menunggu')->count();

        $leaveRequests = LeaveRequest::with('employee', 'atasan')
            ->when($userEmployee && !$lihatSemua, function ($query) use ($userEmployee) {
                $query->where('atasan_id', $userEmployee->id);
            })
            ->when($this->search, function ($query) {
                $query->whereHas('employee', function ($q) {
                    $q->where('nama', 'like', "%{$this->search}%")
                      ->orWhere('nik', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filterJenis, function ($query) {
                $query->where('jenis', $this->filterJenis);
            })
            ->when($this->filterStatus, function ($query) {
                $query->where(function ($q) {
                    $q->where('persetujuan_koor', $this->filterStatus)
                      ->orWhere('persetujuan_hr', $this->filterStatus);
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.cuti-izin-table', compact(
            'leaveRequests', 'totalPengajuan', 'totalCuti', 'totalIzin', 'menunggu', 'userEmployee', 'isHr', 'user'
        ))->with('karyawanView', false);
    }

    private function getAtasan(Employee $employee): ?Employee
    {
        $position = Position::where('nama', $employee->position)->first();
        if (!$position || !$position->parent_id) return null;

        $current = $position->parent;
        while ($current) {
            $atasan = Employee::where('position', $current->nama)->first();
            if ($atasan) return $atasan;
            $current = $current->parent;
        }

        return null;
    }

    private function isHr($user): bool
    {
        $emp = $user->employee;
        if (!$emp) return false;
        return in_array($emp->position, [
            'Human Resource Generalist', 'Admin HR', 'Admin GA', 'OB'
        ]);
    }
}
