@extends('layouts.front', [
    'title' => 'Kanka MCP',
    'metaDescription' => 'Connect Claude, ChatGPT, or other AI assistants to your Kanka worlds with full-text lore search and safe draft tools.',
    'skipPerf' => true,
])

@section('content')
    <section class="bg-purple text-white">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-6 py-16 lg:py-20">
            <span class="font-semibold uppercase tracking-wider text-light">Model Context Protocol</span>
            <h1>Kanka MCP</h1>
            <p class="max-w-3xl text-lg text-light">Connect Claude, ChatGPT, or other compatible AI assistants directly to your Kanka worlds. Search full-text lore, explore relationships, and draft new entries or session notes with your Kanka permissions intact.</p>
            <div class="flex flex-wrap items-center gap-4">
                <a href="#connect" class="btn-round">Connect an assistant</a>
                <span class="text-sm text-light">Included with <a href="{{ route('settings.subscription') }}" class="underline font-semibold">Wyvern and Elemental</a> plans.</span>
            </div>
        </div>
    </section>

    <main class="mx-auto flex max-w-7xl flex-col gap-12 px-5 py-12 text-dark gap-8">
        <section class="grid gap-8 md:grid-cols-2">
            <article class="flex flex-col gap-4 rounded-lg border border-base-300 p-6">
                <h2>What it does</h2>
                <p>Kanka MCP lets compatible AI clients search and draft inside the worlds you belong to. Kanka does not host or train any AI model; your chosen client and provider process the conversation.</p>
                <ul class="list-disc space-y-2 pl-5">
                    <li>Run full-text search across entity descriptions, articles, and properties, or look up entries by name.</li>
                    <li>Read full entry dossiers, character details, linked locations, tags, races, families, and relationships.</li>
                    <li>Draft new entries, add articles/session notes, and link entities with relations.</li>
                </ul>
            </article>
            <article class="flex flex-col gap-4 rounded-lg border border-base-300 p-6">
                <h2>Permission-aware &amp; safe by design</h2>
                <p>Your assistant can only read and create what your Kanka account has permission to access. Private and hidden entries stay protected by Kanka permissions.</p>
                <p>Write tools are strictly additive — they cannot delete or overwrite your existing lore, and new drafts created by campaign admins default to private/admin-only until you review and publish them.</p>
            </article>
        </section>

        <section id="connect" class="flex scroll-mt-8 flex-col gap-6">
            <div class="flex flex-col gap-2">
                <h2>Connect your assistant</h2>
                <p>Requires an active <a href="{{ route('settings.subscription') }}" class="underline font-semibold">Wyvern or Elemental</a> subscription. Use the MCP server URL <code class="rounded bg-base-200 px-2 py-1">{{ url('/mcp') }}</code> as a remote/HTTP MCP server in your client, then complete the Kanka sign-in and authorization prompt.</p>
            </div>
            <div class="grid gap-6 md:grid-cols-3">
                <article class="flex flex-col gap-3 rounded-lg border border-base-300 p-6">
                    <h3>Claude</h3>
                    <p>Add a custom remote MCP connector using the URL above in Claude.ai or Claude Desktop, then sign in with your Kanka account to authorize access.</p>
                    <a class="underline" href="https://support.anthropic.com/en/articles/11175166-getting-started-with-custom-connectors-using-remote-mcp">Claude remote MCP guide</a>
                </article>
                <article class="flex flex-col gap-3 rounded-lg border border-base-300 p-6">
                    <h3>ChatGPT</h3>
                    <p>Add the URL above as a remote MCP server / connector in ChatGPT settings (where MCP connectors are supported), then authorize your Kanka account.</p>
                    <a class="underline" href="https://platform.openai.com/docs/mcp">OpenAI MCP documentation</a>
                </article>
                <article class="flex flex-col gap-3 rounded-lg border border-base-300 p-6">
                    <h3>Codex, OpenCode &amp; Other Clients</h3>
                    <p>Configure the URL above as a streamable HTTP MCP server in Codex, OpenCode, Cursor, or any compatible MCP client and complete the OAuth flow.</p>
                    <a class="underline" href="https://developers.openai.com/codex/mcp/">Codex MCP documentation</a>
                </article>
            </div>
            <p class="text-sm">Client setup screens and supported remote transports vary. If your client requires a local command instead of a remote URL, it may need an MCP relay.</p>
        </section>

        <section class="flex flex-col gap-6" id="how">
            <h2>How to use it</h2>
            <ol class="list-decimal space-y-3 pl-6">
                <li>Ask the assistant to list your Kanka worlds, or name the world you want to use.</li>
                <li>Search your lore by topic or entry name, then inspect properties, articles, or relationships.</li>
                <li>Ask the assistant to draft new NPCs, locations, or session notes — new drafts default to private for admins so you can review them in Kanka first.</li>
            </ol>
            <div class="grid gap-2 rounded-lg">
                <p><strong>Examples</strong></p>
                <ul class="list-disc space-y-2 pl-5">
                    <li>“Search my world for mentions of the Obsidian Pact and summarize what we know.”</li>
                    <li>“Check Adam Morley’s articles and relationships to see who he owes gold to.”</li>
                    <li>“Draft a private NPC named Captain Vane in my world based on our session notes.”</li>
                    <li>“Add a ‘Session 14 Recap’ article to the Silverkeep location.”</li>
                </ul>
            </div>
        </section>

        <aside class="rounded-lg border border-base-300 p-6" id="privacy">
            <h2 class="mb-3">Privacy reminder</h2>
            <p>Information returned to an MCP client is handled by that client and its configured model provider. Review their privacy policies before connecting. You can revoke Kanka access anytime from your account's <a href="https://app.kanka.io/settings/api" class="underline">API settings</a>.</p>
            <p class="mt-3">Kanka records daily counts of MCP tool calls to understand how often each tool is used. These counts do not include account information, tool arguments, campaign or entity IDs, or returned content, and are deleted after 30 days.</p>
        </aside>
    </main>
@endsection
