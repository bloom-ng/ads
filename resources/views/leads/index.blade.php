<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloom Ads | Leads</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto py-8 px-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Leads</h1>
            <a href="{{ route('flows.send.form') }}" class="inline-flex items-center px-4 py-2 rounded-md bg-orange-500 text-white hover:bg-orange-600">Send WhatsApp Flow</a>
        </div>

        <form method="GET" action="{{ route('leads.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-5 gap-3 bg-white p-4 rounded-lg shadow">
            <div>
                <label class="block text-sm text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border rounded-md px-3 py-2">
                    <option value="">All</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ ($filters['status'] ?? '') === $status ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-700 mb-1">Budget</label>
                <select name="budget" class="w-full border rounded-md px-3 py-2">
                    <option value="">All</option>
                    @foreach($budgets as $budget)
                        <option value="{{ $budget }}" {{ ($filters['budget'] ?? '') === $budget ? 'selected' : '' }}>{{ ucfirst(str_replace(['_','plus'], [' - ', '+'], $budget)) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-700 mb-1">Timeline</label>
                <select name="timeline" class="w-full border rounded-md px-3 py-2">
                    <option value="">All</option>
                    @foreach($timelines as $timeline)
                        <option value="{{ $timeline }}" {{ ($filters['timeline'] ?? '') === $timeline ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $timeline)) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-700 mb-1">Search</label>
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Client/Brand/Phone" class="w-full border rounded-md px-3 py-2" />
            </div>
            <div>
                <label class="block text-sm text-gray-700 mb-1">Per page</label>
                <select name="per_page" class="w-full border rounded-md px-3 py-2">
                    @foreach([10,20,50,100] as $n)
                        <option value="{{ $n }}" {{ (int)($filters['per_page'] ?? 20) === $n ? 'selected' : '' }}>{{ $n }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-5 flex gap-3 justify-end">
                <a href="{{ route('leads.index') }}" class="px-4 py-2 border rounded-md">Reset</a>
                <button type="submit" class="px-4 py-2 rounded-md bg-black text-white">Apply</button>
            </div>
        </form>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Created</th>
                        <th class="px-4 py-3 text-left">Client</th>
                        <th class="px-4 py-3 text-left">Brand</th>
                        <th class="px-4 py-3 text-left">Industry</th>
                        <th class="px-4 py-3 text-left">Services</th>
                        <th class="px-4 py-3 text-left">Budget</th>
                        <th class="px-4 py-3 text-left">Timeline</th>
                        <th class="px-4 py-3 text-left">Contact</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Tag</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                        <tr class="border-t">
                            <td class="px-4 py-3">{{ $lead->id }}</td>
                            <td class="px-4 py-3">{{ $lead->created_at?->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-3">{{ $lead->client_name ?? '' }}</td>
                            <td class="px-4 py-3">{{ $lead->brand_name ?? '' }}</td>
                            <td class="px-4 py-3">{{ $lead->industry_name ?? $lead->industry }}</td>
                            <td class="px-4 py-3">@php($sv=$lead->services) {{ is_array($sv) ? implode(', ', $sv) : ($sv ?? '') }}</td>
                            <td class="px-4 py-3">{{ $lead->budget_range ?? $lead->budget }}</td>
                            <td class="px-4 py-3">{{ $lead->timeline ?? '' }}</td>
                            <td class="px-4 py-3">{{ $lead->contact_method ?? '' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded text-xs {{ match($lead->status){ 'qualified'=>'bg-green-100 text-green-700', 'low_budget'=>'bg-yellow-100 text-yellow-700', 'not_ready'=>'bg-gray-100 text-gray-700', 'completed'=>'bg-blue-100 text-blue-700', default=>'bg-orange-100 text-orange-700'} }}">{{ ucfirst(str_replace('_',' ',$lead->status ?? '')) }}</span>
                            </td>
                            <td class="px-4 py-3">{{ $lead->tag ?? '' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-4 py-10 text-center text-gray-500">No leads found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $leads->links() }}</div>
    </div>
</body>
</html>
