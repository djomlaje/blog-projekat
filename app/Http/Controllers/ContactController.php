<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactFormEmail;
use App\Models\BlogPostCategory;
use App\Models\Blog;

class ContactController extends Controller
{
    public function index()
    {
        //footer, kategorije
        $footerCategories = BlogPostCategory::query()
                ->orderBy('priority', 'DESC')
                ->take(4)
                ->get();
        
        $newestFooterBlogPosts = Blog::where('status', '=', '1')
                ->orderBy('created_at', 'desc')
                ->take(3)->get();   
        
        
        return view('front.contact.index', [
            'footerCategories' => $footerCategories,
            'blogs' => $newestFooterBlogPosts
        ]);
    }
    
    public function sendMessage(Request $request)
    {
        $formData = $request->validate([
            //validation rules
            'your_name' => ['required', 'string', 'min:2'],
            'your_email' => ['required', 'email'],
            'message' => ['required', 'string', 'min:50', 'max:255'],
            'g-recaptcha-response' => ['required', 'recaptcha']
        ]);
        
        \Mail::to('mladen.dragic1993@gmail.com')->send(new ContactFormEmail(
            $formData['your_email'],
            $formData['your_name'],
            $formData['message']
        ));
        
        session()->flash( // kratotrajan upis u sesiju, gubi se u narednom requestu
            'system_message',
            __('We have recieved your message, we will contact you soon!')
        );
        
        //going back page
        return redirect()->back();
    }
}
