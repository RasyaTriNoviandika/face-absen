<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('user')
            ->latest()
            ->paginate(10);
        
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        // Get users yang belum terhubung dengan employee
        $availableUsers = User::whereNull('employee_id')
            ->where('role', 'user')
            ->where('is_active', true)
            ->get();
        
        return view('admin.employees.create', compact('availableUsers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:employees',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees',
            'phone' => 'nullable|string',
            'department' => 'required|string',
            'position' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Upload photo
            if ($request->hasFile('photo')) {
                $validated['photo'] = $request->file('photo')->store('employees', 'public');
            }

            // Create employee
            $employee = Employee::create($validated);

            // ✅ TAMBAHKAN: Buat user otomatis untuk employee
            $user = User::create([
                'name' => $employee->name,
                'email' => $employee->email,
                'password' => Hash::make('password123'), // Password default
                'role' => 'user',
                'employee_id' => $employee->id,
                'is_active' => true,
            ]);

            DB::commit();

            return redirect()->route('admin.employees.index')
                ->with('success', 'Karyawan berhasil ditambahkan. Password default: password123');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if (isset($validated['photo'])) {
                Storage::disk('public')->delete($validated['photo']);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan karyawan: ' . $e->getMessage());
        }
    }

    public function show(Employee $employee)
    {
        $employee->load(['user', 'faceDescriptors']);
        
        $attendances = $employee->attendances()
            ->latest('date')
            ->latest('check_in')
            ->paginate(10);
            
        return view('admin.employees.show', compact('employee', 'attendances'));
    }

    public function edit(Employee $employee)
    {
        // Get users yang belum terhubung ATAU user yang sudah terhubung dengan employee ini
        $availableUsers = User::where(function($query) use ($employee) {
                $query->whereNull('employee_id')
                      ->orWhere('employee_id', $employee->id);
            })
            ->where('role', 'user')
            ->where('is_active', true)
            ->get();
        
        return view('admin.employees.edit', compact('employee', 'availableUsers'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:employees,nip,' . $employee->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'phone' => 'nullable|string',
            'department' => 'required|string',
            'position' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'user_id' => 'nullable|exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            // Upload new photo
            if ($request->hasFile('photo')) {
                // Delete old photo
                if ($employee->photo) {
                    Storage::disk('public')->delete($employee->photo);
                }
                $validated['photo'] = $request->file('photo')->store('employees', 'public');
            }

            // Update employee
            $employee->update($validated);

            // Update user link
            // Reset old user link
            User::where('employee_id', $employee->id)
                ->update(['employee_id' => null]);

            // Set new user link
            if ($request->filled('user_id')) {
                User::where('id', $request->user_id)
                    ->update(['employee_id' => $employee->id]);
            }

            DB::commit();

            return redirect()->route('admin.employees.index')
                ->with('success', 'Karyawan berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate karyawan: ' . $e->getMessage());
        }
    }

    public function destroy(Employee $employee)
    {
        DB::beginTransaction();
        try {
            // Delete photo
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }

            // Delete face descriptors dan foto
            foreach ($employee->faceDescriptors as $descriptor) {
                if ($descriptor->photo_path) {
                    Storage::disk('public')->delete($descriptor->photo_path);
                }
                $descriptor->delete();
            }

            // Reset user link
            User::where('employee_id', $employee->id)
                ->update(['employee_id' => null]);
            
            // Delete employee
            $employee->delete();

            DB::commit();

            return redirect()->route('admin.employees.index')
                ->with('success', 'Karyawan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Gagal menghapus karyawan: ' . $e->getMessage());
        }
    }

    // Halaman registrasi wajah
    public function registerFace(Employee $employee)
    {
        return view('admin.employees.register-face', compact('employee'));
    }
}