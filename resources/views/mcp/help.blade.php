@extends('layouts.front', [
    'title' => 'Kanka MCP',
    'metaDescription' => 'Connect an AI assistant to your Kanka worlds using read-only MCP tools.',
    'skipPerf' => true,
])

@section('content')
    <section class="bg-purple text-white">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-6 py-16 lg:py-20">
            <span class="font-semibold uppercase tracking-wider text-light">Model Context Protocol</span>
            <h1>Kanka MCP</h1>
            <p class="max-w-3xl text-lg text-light">Connect an AI assistant to your Kanka worlds. Ask questions about your campaign and let your assistant find relevant, permission-aware information directly from Kanka.</p>
            <div class="flex flex-wrap gap-4">
                <a href="#connect" class="btn-round">Connect an assistant</a>
            </div>
        </div>
    </section>

    <main class="mx-auto flex max-w-7xl flex-col gap-12 px-5 py-12 text-dark gap-8">
        <section class="grid gap-8 md:grid-cols-2">
            <article class="flex flex-col gap-4 rounded-lg border border-base-300 p-6">
                <h2>What it does</h2>
                <p>Kanka MCP is a read-only connection that lets compatible AI clients look up worlds and campaign entries on your behalf. Kanka does not host the AI model; your chosen client and provider process the conversation.</p>
                <ul class="list-disc space-y-2 pl-5">
                    <li>List worlds you belong to and search visible entries by name.</li>
                    <li>Read an entry resource with its entry, description, status, character details, linked locations, tags, races and families.</li>
                    <li>Read visible properties and articles, and browse visible entry relationships.</li>
                </ul>
            </article>
            <article class="flex flex-col gap-4 rounded-lg border border-base-300 p-6">
                <h2>Read-only by design</h2>
                <p>The assistant can read information your Kanka account can access. It cannot create, edit, delete, or otherwise change anything in your worlds.</p>
                <p>Private and hidden data is controlled by Kanka permissions. Missing information means it was not found in accessible content. It doesn't prove something is false. Full-text search across entries and articles is not currently available.</p>
            </article>
        </section>

        <section id="connect" class="flex scroll-mt-8 flex-col gap-6" id="connect">
            <div class="flex flex-col gap-2">
                <h2>Connect your assistant</h2>
                <p>Use the MCP server URL <code class="rounded bg-base-200 px-2 py-1">{{ url('/mcp') }}</code>. Add it as a remote/HTTP MCP server in your client, then complete the Kanka sign-in and authorization prompt.</p>
            </div>
            <div class="grid gap-6 md:grid-cols-3">
                <article class="flex flex-col gap-3 rounded-lg border border-base-300 p-6">
                    <h3>OpenCode</h3>
                    <p>Open your OpenCode MCP settings and add a remote server using the URL above. Save the configuration and authorize the Kanka connection when prompted.</p>
                    <a class="underline" href="https://opencode.ai/docs/mcp-servers/">OpenCode MCP documentation</a>
                </article>
                <article class="flex flex-col gap-3 rounded-lg border border-base-300 p-6">
                    <h3>Codex</h3>
                    <p>Add the URL as a remote MCP server in Codex. You can configure it from the Codex CLI or your Codex configuration, then sign in when the OAuth flow opens.</p>
                    <a class="underline" href="https://developers.openai.com/codex/mcp/">Codex MCP documentation</a>
                </article>
                <article class="flex flex-col gap-3 rounded-lg border border-base-300 p-6">
                    <h3>Claude</h3>
                    <p>Add a remote MCP connector with the URL above in a Claude client that supports remote MCP servers, then authorize Kanka.</p>
                    <a class="underline" href="https://docs.anthropic.com/en/docs/claude-code/mcp">Claude MCP documentation</a>
                </article>
            </div>
            <p class="text-sm">Client setup screens and supported remote transports vary. If your client requires a local command instead of a remote URL, it may need an MCP relay or may not support this server yet.</p>
        </section>

        <section class="flex flex-col gap-6" id="how">
            <h2>How to use it</h2>
            <ol class="list-decimal space-y-3 pl-6">
                <li>Ask the assistant to list your Kanka worlds, or name the world you want to use.</li>
                <li>Search by entry name, then ask a question about the matching character, location, organisation, or other entry.</li>
                <li>For detailed questions, ask it to check the entry's properties, articles, or relationships and cite which source supports the answer.</li>
                <li>If more than one entry matches, tell the assistant which one you mean.</li>
            </ol>
            <div class="grid gap-2 rounded-lg">
                <p><strong>Examples</strong></p>
                <ul class="list-disc space-y-2 pl-5">
                    <li>“Find Adam Morley in my world and tell me what age is recorded.”</li>
                    <li>“What class and HP are listed in Adam’s properties?”</li>
                    <li>“Check Adam’s articles for where he grew up. Quote the relevant articles.”</li>
                    <li>“Which locations, races, and families are linked to this character?”</li>
                </ul>
            </div>
        </section>

        <aside class="rounded-lg border border-base-300 p-6" id="privacy">
            <h2 class="mb-3">Privacy reminder</h2>
            <p>Information returned to an MCP client is handled by that client and its configured model provider. Review their privacy policies before connecting. You can revoke Kanka access from your account's <a href="https://app.kanka.io/settings/api">API settings</a>.</p>
        </aside>
    </main>
@endsection
