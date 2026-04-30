<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;
use App\Models\User;

use App\Models\Notification;

class ContactController extends Controller
{
public function submit(ContactRequest $request)
{
    try {

        $data = $request->validated();

        // save DB
        $contact = Contact::create($data);

        // send email
        Mail::to(config('mail.from.address'))
            ->send(new ContactMail($data)); // بهتر برای تست

        // get admins
        $admins = User::admins()->get();

        // create notification
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'contact',
                'title' => 'New Contact Message',
                'body' => 'Message from '.$data['name'],
                'is_read' => false,
            ]);
        }

        return back()->with('success', __('contact.form.success'));

    } catch (\Exception $e) {

        Log::error('Contact form error: '.$e->getMessage());

        return back()->with('error', __('contact.form.error'));
    }
}
}
