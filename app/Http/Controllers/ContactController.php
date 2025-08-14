<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Menampilkan halaman formulir kontak.
     */
    public function show()
    {
        return view('themes.xylo.contact');
    }

    /**
     * Mengirim email dari formulir kontak.
     */
    public function send(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            Mail::to('amsindo.pwt@gmail.com')->send(new ContactFormMail($validatedData));
            return redirect()->route('contact')->with('success', 'Pesan Anda telah berhasil dikirim. Kami akan segera menghubungi Anda.');
        } catch (\Exception $e) {
            Log::error('Contact form mail sending failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Maaf, terjadi kesalahan saat mengirim pesan. Silakan coba lagi nanti.')->withInput();
        }
    }
}