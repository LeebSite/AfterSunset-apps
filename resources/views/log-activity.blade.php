@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-10">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 dark:text-white">Log Aktivitas</h1>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-600">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 border-b border-gray-300 dark:border-gray-600">
                            No
                        </th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 border-b border-gray-300 dark:border-gray-600">
                            Name
                        </th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 border-b border-gray-300 dark:border-gray-600">
                            Role
                        </th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 border-b border-gray-300 dark:border-gray-600">
                            Deskripsi Aktivitas
                        </th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 border-b border-gray-300 dark:border-gray-600">
                            Waktu Tanggal
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($logs as $log)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300 text-sm">
                            {{ $loop->iteration + ($logs->currentPage() - 1) * $logs->perPage() }}
                        </td>
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300 text-sm">
                            {{ $log->user_name }}
                        </td>
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300 text-sm">
                            {{ ucfirst($log->user_role) }}
                        </td>
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300 text-sm">
                            {{ $log->activity_description }}
                        </td>
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300 text-sm">
                            {{ $log->created_at->format('Y-m-d H:i:s') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-3 text-center text-gray-700 dark:text-gray-300">
                            No logs available
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-6">
            {{ $logs->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
