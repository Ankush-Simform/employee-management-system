<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DepartmentController extends Controller
{
    public function index(Request $request): mixed
    {
        $departments = $request->user()->departments()->withCount('employees')->latest()->paginate(10);
        return $this->isApi($request) ? response()->json($departments) : view('departments.index', compact('departments'));
    }

    public function create(): mixed
    {
        $this->authorize('manage-departments');
        return view('departments.create');
    }

    public function store(StoreDepartmentRequest $request): mixed
    {
        $department = $request->user()->departments()->create($request->validated());
        return $this->isApi($request)
            ? response()->json($department, 201)
            : redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function show(Request $request, Department $department): mixed
    {
        $this->authorize('view', $department);
        $department->loadCount('employees');
        return $this->isApi($request) ? response()->json($department) : view('departments.show', compact('department'));
    }

    public function edit(Department $department): mixed
    {
        $this->authorize('update', $department);
        return view('departments.edit', compact('department'));
    }

    public function update(UpdateDepartmentRequest $request, Department $department): mixed
    {
        $department->update($request->validated());
        return $this->isApi($request)
            ? response()->json($department->fresh())
            : redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Request $request, Department $department): mixed
    {
        $this->authorize('delete', $department);
        if ($department->employees()->exists()) {
            $message = 'Move or delete this department’s employees before deleting it.';
            return $this->isApi($request) ? response()->json(['message' => $message], 422) : back()->with('error', $message);
        }
        $department->delete();
        return $this->isApi($request) ? response()->noContent() : redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }

    private function isApi(Request $request): bool { return $request->is('api/*') || $request->expectsJson(); }
}
