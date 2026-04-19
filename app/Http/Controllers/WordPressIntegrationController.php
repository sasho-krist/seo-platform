<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\WordpressConnection;
use App\Services\WordPressPublisher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WordPressIntegrationController extends Controller
{
    public function edit(Request $request): View
    {
        $connection = $request->user()->wordpressConnection;

        return view('wordpress.edit', compact('connection'));
    }

    public function update(Request $request): RedirectResponse
    {
        $existing = $request->user()->wordpressConnection;

        $data = $request->validate([
            'site_url' => ['required', 'url', 'max:512'],
            'username' => ['required', 'string', 'max:255'],
            'app_password' => [$existing ? 'nullable' : 'required', 'string', 'max:512'],
        ]);

        $payload = [
            'site_url' => rtrim($data['site_url'], '/'),
            'username' => $data['username'],
        ];

        if (! empty($data['app_password'])) {
            $payload['app_password'] = $data['app_password'];
        }

        WordpressConnection::updateOrCreate(
            ['user_id' => $request->user()->id],
            $payload
        );

        return back()->with('status', 'WordPress връзката е запазена.');
    }

    public function publish(Request $request, BlogPost $blogPost, WordPressPublisher $publisher): RedirectResponse
    {
        abort_if($blogPost->user_id !== $request->user()->id, 403);

        $connection = $request->user()->wordpressConnection;

        if (! $connection instanceof WordpressConnection) {
            return redirect()->route('wordpress.edit')->withErrors([
                'wp' => 'Първо задайте WordPress връзка с приложение парола.',
            ]);
        }

        try {
            if (! $publisher->validateConnection($connection)) {
                return back()->withErrors(['wp' => 'Невалидни данни за WordPress REST API.']);
            }

            $publisher->publish($blogPost, $connection);
        } catch (\Throwable $e) {
            return back()->withErrors(['wp' => $e->getMessage()]);
        }

        return back()->with('status', 'Публикувано в WordPress.');
    }
}
