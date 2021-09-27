<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Tag;

class TagsController extends Controller
{
    public function index()
    {
        
        $tags = Tag::all();
        
        return view('admin.tags.index', [
            'tags' => $tags,
        ]);
    }
    
    public function add(Request $request)
    {
        return view('admin.tags.add', [
            
        ]);
    }
    
    public function insert(Request $request)
    {
        $formData = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:20', 'unique:tags,name'],
        ]);
        
        $newTag = new Tag();
        
        $newTag->fill($formData);
        $newTag->save();
        
        session()->flash('system_message', __('New tag has been added.'));
        
        return redirect()->route('admin.tags.index');
    }
    
    public function edit(Request $request, Tag $tag)
    {
        return view('admin.tags.edit', [
            'tag' => $tag,
        ]);
    }
    
    public function update(Request $request, Tag $tag)
    {
        $formData = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:20', Rule::unique('tags')->ignore($tag->id)],
        ]);
        
        $tag->fill($formData);
        $tag->save();
        
        session()->flash('system_message', __('Tag has been updated'));
        
        return redirect()->route('admin.tags.index');
    }
    
    public function delete(Request $request)
    {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:tags,id'],
        ]);
        
        $tag = Tag::findOrFail($formData['id']);
        
        //brisanje taga
        $tag->delete();
        
        //brisanje iz vezne tabele
        //odrzavanje relacija
        \DB::table('blog_post_tags')
                ->where('tag_id', '=', $tag->id)
                ->delete();
        
        session()->flash('system_message', __('Tag has been deleted'));
        
        return redirect()->route('admin.tags.index');
    }
}
