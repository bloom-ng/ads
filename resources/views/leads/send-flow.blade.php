<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloom Ads | Send WhatsApp Flow</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="max-w-lg mx-auto py-12 px-4">
        <h1 class="text-2xl font-bold mb-2">Send WhatsApp Flow</h1>
        <p class="text-gray-600 mb-8">Enter a phone number to send the configured WhatsApp template/flow. Use full international format (e.g., 2347081234567).</p>

        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('flows.send.submit') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="phones" class="block text-sm text-gray-700 mb-1">Phone number(s)</label>
                    <textarea id="phones" name="phones" rows="5" placeholder="2347081234567\n2348012345678\n2348098765432" class="w-full border rounded-md px-3 py-2">{{ old('phones') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Enter one or multiple numbers. Separate with commas, spaces, or new lines. Use full international format (e.g., 2347081234567).</p>
                    @error('phones')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    @error('phone')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('leads.index') }}" class="px-4 py-2 border rounded-md">Back to Leads</a>
                    <button type="submit" class="px-4 py-2 rounded-md bg-orange-500 text-white hover:bg-orange-600">Send Flow</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
