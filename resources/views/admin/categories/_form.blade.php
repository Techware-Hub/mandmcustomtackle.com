@csrf
@if($category->exists) @method('PUT') @endif
<div class="admin-card grid gap-5 rounded-lg border border-slate-800 bg-slate-900 p-6">
    <label>Name<input name="name" value="{{ old('name', $category->name) }}" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2" required></label>
    <label>Slug<input name="slug" value="{{ old('slug', $category->slug) }}" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"></label>
    <label>Description<textarea name="description" rows="4" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2">{{ old('description', $category->description) }}</textarea></label>
    <label>Image<input name="image" type="file" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"></label>
    <label>Status<select name="status" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"><option value="active" @selected(old('status', $category->status) === 'active')>Active</option><option value="inactive" @selected(old('status', $category->status) === 'inactive')>Inactive</option></select></label>
    <button class="rounded-lg bg-sky-500 px-5 py-2 font-bold text-slate-950">Save Category</button>
</div>
