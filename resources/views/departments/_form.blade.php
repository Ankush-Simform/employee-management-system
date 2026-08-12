@csrf
@if(isset($department)) @method('PUT') @endif
<div class="space-y-5">
    <div><label class="block text-sm font-medium">Name</label><input class="mt-1 w-full rounded border-gray-300" name="name" value="{{ old('name', $department->name ?? '') }}" required maxlength="100"><x-input-error :messages="$errors->get('name')" class="mt-1" /></div>
    <div><label class="block text-sm font-medium">Description</label><textarea class="mt-1 w-full rounded border-gray-300" name="description" rows="4" maxlength="1000">{{ old('description', $department->description ?? '') }}</textarea><x-input-error :messages="$errors->get('description')" class="mt-1" /></div>
    <div><label class="block text-sm font-medium">Status</label><select class="mt-1 w-full rounded border-gray-300" name="status" required><option value="active" @selected(old('status', $department->status ?? 'active') === 'active')>Active</option><option value="inactive" @selected(old('status', $department->status ?? 'active') === 'inactive')>Inactive</option></select></div>
    <div class="flex gap-3"><button class="rounded bg-indigo-600 px-4 py-2 font-semibold text-white">Save department</button><a href="{{ route('departments.index') }}" class="rounded border px-4 py-2">Cancel</a></div>
</div>
