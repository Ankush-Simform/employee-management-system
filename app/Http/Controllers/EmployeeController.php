<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request): mixed
    {
        $employees = $this->filtered($request)->paginate(10)->withQueryString();
        return $this->isApi($request) ? response()->json($employees) : view('employees.index', ['departments' => $request->user()->departments()->orderBy('name')->get()]);
    }

    public function data(Request $request): mixed
    {
        $query = $this->filtered($request);
        $total = $request->user()->employees()->count();
        $filtered = (clone $query)->count();
        $columns = ['name', 'email', 'phone', 'department_id', 'salary', 'joining_date', 'status'];
        $column = $columns[(int) $request->input('order.0.column', 0)] ?? 'name';
        $direction = $request->input('order.0.dir') === 'desc' ? 'desc' : 'asc';
        $employees = $query->orderBy($column, $direction)
            ->skip((int) $request->input('start', 0))
            ->take(min((int) $request->input('length', 10), 100))
            ->get();

        return response()->json([
            'draw' => (int) $request->input('draw', 0),
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $employees->map(fn (Employee $employee) => [
                'name' => $employee->name,
                'email' => $employee->email,
                'phone' => $employee->phone,
                'salary' => number_format((float) $employee->salary, 2),
                'joining_date' => $employee->joining_date->format('Y-m-d'),
                'department' => $employee->department->name,
                'status' => ucfirst($employee->status),
                'actions' => view('employees.partials.actions', compact('employee'))->render(),
            ]),
        ]);
    }

    public function create(Request $request): mixed
    {
        $this->authorize('manage-employees');
        return view('employees.create', ['departments' => $request->user()->departments()->where('status', 'active')->orderBy('name')->get()]);
    }

    public function store(StoreEmployeeRequest $request): mixed
    {
        $employee = $request->user()->employees()->create($request->validated());
        return $this->isApi($request) ? response()->json($employee->load('department'), 201) : redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function show(Request $request, Employee $employee): mixed
    {
        $this->authorize('view', $employee);
        $employee->load('department');
        return $this->isApi($request) ? response()->json($employee) : view('employees.show', compact('employee'));
    }

    public function edit(Request $request, Employee $employee): mixed
    {
        $this->authorize('update', $employee);
        return view('employees.edit', ['employee' => $employee, 'departments' => $request->user()->departments()->where('status', 'active')->orderBy('name')->get()]);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee): mixed
    {
        $employee->update($request->validated());
        return $this->isApi($request) ? response()->json($employee->fresh()->load('department')) : redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Request $request, Employee $employee): mixed
    {
        $this->authorize('delete', $employee);
        $employee->delete();
        return $this->isApi($request) ? response()->noContent() : redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    private function filtered(Request $request)
    {
        $search = trim((string) $request->input('search.value', $request->input('search')));
        return $request->user()->employees()->with('department')
            ->when($search, fn ($query) => $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%")))
            ->when($request->filled('department_id'), fn ($query) => $query->where('department_id', $request->integer('department_id')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->input('status')));
    }

    private function isApi(Request $request): bool { return $request->is('api/*') || $request->expectsJson(); }
}
