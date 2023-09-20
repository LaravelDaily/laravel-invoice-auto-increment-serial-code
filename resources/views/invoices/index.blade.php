<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Invoices List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <a href="{{ route('invoice.create') }}"
                       class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Create Invoice
                    </a>

                    <table class="table-fixed w-full mt-4">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">Invoice Number</th>
                            <th class="px-4 py-2">Invoice Date</th>
                            <th class="px-4 py-2">Customer Name</th>
                            <th class="px-4 py-2">Total Amount</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoices as $invoice)
                            <tr>
                                <td class="border px-4 py-2">{{ $invoice->serial }}</td>
                                <td class="border px-4 py-2">{{ $invoice->due_date }}</td>
                                <td class="border px-4 py-2">{{ $invoice->user->name }}</td>
                                <td class="border px-4 py-2">{{ $invoice->amount }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('invoice.edit', $invoice->id) }}"
                                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Edit
                                    </a>
                                    <form action="{{ route('invoice.destroy', $invoice->id) }}" method="POST"
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
