<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Division;
use App\Models\Employee;
use App\Models\EmployeeContract;
use App\Models\EmployeeDocument;
use App\Models\PositionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Employee::count(),
            'aktif' => Employee::where('status', 'aktif')->count(),
            'divisi' => Division::count(),
        ];

        return view('employees.index', compact('stats'));
    }

    public function create()
    {
        return redirect()->route('hris.employees.index');
    }

    public function store(StoreEmployeeRequest $request)
    {
        Employee::create($request->validated());

        return redirect()->route('hris.employees.index')
            ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function show(Employee $employee)
    {
        $employee->load(['division', 'documents', 'contracts', 'positionHistories']);

        $divisions = Division::orderBy('nama')->get();
        $jenisDokumenList = ['KTP', 'KK', 'NPWP', 'Ijazah', 'Sertifikat', 'Kontrak', 'SK', 'Lainnya'];

        return view('employees.show', compact('employee', 'divisions', 'jenisDokumenList'));
    }

    public function edit(Employee $employee)
    {
        return redirect()->route('hris.employees.index');
    }

    public function update(StoreEmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->validated());

        if ($request->input('_redirect') === 'show') {
            return redirect()->route('hris.employees.show', $employee)
                ->with('success', 'Data karyawan berhasil diperbarui.');
        }

        return redirect()->route('hris.employees.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function uploadPhoto(Request $request, Employee $employee)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('foto');
        $filename = $employee->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('employees', $filename, 'public');

        $employee->update(['foto' => $filename]);

        return redirect()->route('hris.employees.show', $employee)
            ->with('success', 'Foto berhasil diperbarui.');
    }

    public function storeDocument(Request $request, Employee $employee)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'jenis_dokumen' => 'required|string|max:100',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $file = $request->file('file');
        $filename = $employee->id . '_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('documents', $filename, 'public');

        EmployeeDocument::create([
            'employee_id' => $employee->id,
            'nama_dokumen' => $request->nama_dokumen,
            'jenis_dokumen' => $request->jenis_dokumen,
            'file' => $filename,
            'keterangan' => $request->keterangan,
        ]);

        return redirect(route('hris.employees.show', $employee) . '#dokumen')
            ->with('doc_success', 'Dokumen berhasil ditambahkan.');
    }

    public function downloadDocument(Employee $employee, EmployeeDocument $document)
    {
        $filePath = 'documents/' . $document->file;

        if (!Storage::disk('public')->exists($filePath)) {
            return redirect()->route('hris.employees.show', $employee)
                ->with('error', 'File dokumen tidak ditemukan.');
        }

        return Storage::disk('public')->download($filePath, $document->nama_dokumen . '.' . pathinfo($document->file, PATHINFO_EXTENSION));
    }

    public function destroyDocument(Employee $employee, EmployeeDocument $document)
    {
        $filePath = 'documents/' . $document->file;

        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        $document->delete();

        return redirect(route('hris.employees.show', $employee) . '#dokumen')
            ->with('doc_success', 'Dokumen berhasil dihapus.');
    }

    public function storeContract(Request $request, Employee $employee)
    {
        $request->validate([
            'jenis_kontrak' => 'required|string|max:100',
            'posisi' => 'required|string|max:255',
            'atasan' => 'nullable|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
            'keterangan' => 'nullable|string|max:500',
        ]);

        EmployeeContract::create([
            'employee_id' => $employee->id,
            'jenis_kontrak' => $request->jenis_kontrak,
            'posisi' => $request->posisi,
            'atasan' => $request->atasan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'status' => 'berlaku',
            'keterangan' => $request->keterangan,
        ]);

        return redirect(route('hris.employees.show', $employee) . '#kontrak')
            ->with('contract_success', 'Kontrak berhasil ditambahkan.');
    }

    public function getContract(Employee $employee, EmployeeContract $contract)
    {
        return response()->json($contract);
    }

    public function destroyContract(Employee $employee, EmployeeContract $contract)
    {
        $contract->delete();

        return redirect(route('hris.employees.show', $employee) . '#kontrak')
            ->with('contract_success', 'Kontrak berhasil dihapus.');
    }

    public function storePositionHistory(Request $request, Employee $employee)
    {
        $request->validate([
            'jabatan' => 'required|string|max:255',
            'divisi' => 'required|string|max:255',
            'atasan' => 'nullable|string|max:255',
            'mulai' => 'required|date',
            'selesai' => 'nullable|date',
            'status' => 'required|in:Aktif,Selesai',
        ]);

        PositionHistory::create([
            'employee_id' => $employee->id,
            'jabatan' => $request->jabatan,
            'divisi' => $request->divisi,
            'atasan' => $request->atasan,
            'mulai' => $request->mulai,
            'selesai' => $request->selesai,
            'status' => $request->status,
        ]);

        return redirect(route('hris.employees.show', $employee) . '#jabatan')
            ->with('position_success', 'Riwayat jabatan berhasil ditambahkan.');
    }

    public function destroyPositionHistory(Employee $employee, PositionHistory $positionHistory)
    {
        $positionHistory->delete();

        return redirect(route('hris.employees.show', $employee) . '#jabatan')
            ->with('position_success', 'Riwayat jabatan berhasil dihapus.');
    }

    public function updateContract(Request $request, Employee $employee, EmployeeContract $contract)
    {
        $request->validate([
            'jenis_kontrak' => 'required|string|max:100',
            'posisi' => 'required|string|max:255',
            'atasan' => 'nullable|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $contract->update([
            'jenis_kontrak' => $request->jenis_kontrak,
            'posisi' => $request->posisi,
            'atasan' => $request->atasan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'keterangan' => $request->keterangan,
        ]);

        return redirect(route('hris.employees.show', $employee) . '#kontrak')
            ->with('contract_success', 'Kontrak berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('hris.employees.index')
            ->with('success', 'Karyawan berhasil dihapus.');
    }
}
