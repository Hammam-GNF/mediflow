<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    Admin Dashboard
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Welcome back. Here's what's happening in your clinic today.
                </p>
            </div>

            <div class="text-sm text-slate-500">
                {{ now()->format('l, d F Y') }}
            </div>

        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Hero --}}

            <section
                class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-700 via-indigo-700 to-slate-800 text-white p-8 shadow-xl"
            >

                <div class="absolute right-0 top-0 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>

                <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">

                    <div>

                        <span
                            class="inline-flex items-center rounded-full bg-white/20 px-4 py-1 text-sm"
                        >
                            🏥 MediFlow Clinic Management System
                        </span>

                        <h1 class="mt-5 text-4xl font-bold leading-tight">

                            Good
                            {{ now()->hour < 12 ? 'Morning' : (now()->hour < 18 ? 'Afternoon' : 'Evening') }},
                            {{ auth()->user()->name }} 👋

                        </h1>

                        <p class="mt-4 max-w-2xl text-blue-100 leading-relaxed">

                            Monitor registrations, billing, cashier activity,
                            medical services, and SATUSEHAT synchronization
                            from one centralized dashboard.

                        </p>

                    </div>

                    <div
                        class="grid grid-cols-2 gap-4 text-center"
                    >

                        <div class="rounded-2xl bg-white/10 backdrop-blur p-5">

                            <p class="text-xs uppercase tracking-wider text-blue-100">
                                Today Revenue
                            </p>

                            <p class="mt-2 text-2xl font-bold">
                                Rp {{ number_format($todayRevenue) }}
                            </p>

                        </div>

                        <div class="rounded-2xl bg-white/10 backdrop-blur p-5">

                            <p class="text-xs uppercase tracking-wider text-blue-100">
                                Queue Today
                            </p>

                            <p class="mt-2 text-2xl font-bold">
                                {{ $todayQueue }}
                            </p>

                        </div>

                    </div>

                </div>

            </section>

            {{-- Quick Actions --}}

            <section>

                <div class="flex items-center justify-between mb-4">

                    <h3 class="text-lg font-semibold text-slate-800">
                        Quick Actions
                    </h3>

                    <span class="text-sm text-slate-500">
                        Frequently used shortcuts
                    </span>

                </div>

                <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">

                    <a
                        href="{{ route('admin.registrations.index') }}"
                        class="group rounded-2xl bg-white border border-slate-200 p-5 shadow-sm hover:shadow-lg hover:-translate-y-1 transition"
                    >
                        <div class="text-3xl">📝</div>

                        <h4 class="mt-4 font-semibold text-slate-800">
                            Registrations
                        </h4>

                        <p class="text-sm text-slate-500 mt-1">
                            Manage patient registrations
                        </p>
                    </a>

                    <a
                        href="{{ route('admin.patients.index') }}"
                        class="group rounded-2xl bg-white border border-slate-200 p-5 shadow-sm hover:shadow-lg hover:-translate-y-1 transition"
                    >
                        <div class="text-3xl">👥</div>

                        <h4 class="mt-4 font-semibold text-slate-800">
                            Patients
                        </h4>

                        <p class="text-sm text-slate-500 mt-1">
                            Patient management
                        </p>
                    </a>

                    <a
                        href="{{ route('admin.invoices.index') }}"
                        class="group rounded-2xl bg-white border border-slate-200 p-5 shadow-sm hover:shadow-lg hover:-translate-y-1 transition"
                    >
                        <div class="text-3xl">💳</div>

                        <h4 class="mt-4 font-semibold text-slate-800">
                            Billing
                        </h4>

                        <p class="text-sm text-slate-500 mt-1">
                            Invoice & Payment
                        </p>
                    </a>

                    <a
                        href="{{ route('admin.medications.index') }}"
                        class="group rounded-2xl bg-white border border-slate-200 p-5 shadow-sm hover:shadow-lg hover:-translate-y-1 transition"
                    >
                        <div class="text-3xl">💊</div>

                        <h4 class="mt-4 font-semibold text-slate-800">
                            Pharmacy
                        </h4>

                        <p class="text-sm text-slate-500 mt-1">
                            Medication inventory
                        </p>
                    </a>

                    <a
                        href="{{ route('admin.reports.financial') }}"
                        class="group rounded-2xl bg-white border border-slate-200 p-5 shadow-sm hover:shadow-lg hover:-translate-y-1 transition"
                    >
                        <div class="text-3xl">📊</div>

                        <h4 class="mt-4 font-semibold text-slate-800">
                            Reports
                        </h4>

                        <p class="text-sm text-slate-500 mt-1">
                            Financial overview
                        </p>
                    </a>

                </div>

            </section>

            {{-- KPI Cards --}}

            <section>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

                    <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-6">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-sm text-slate-500">
                                    Total Patients
                                </p>

                                <h2 class="mt-2 text-3xl font-bold text-slate-800">
                                    {{ $totalPatients }}
                                </h2>

                            </div>

                            <div class="text-4xl">
                                👥
                            </div>

                        </div>

                    </div>

                    <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-6">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-sm text-slate-500">
                                    Doctors
                                </p>

                                <h2 class="mt-2 text-3xl font-bold text-slate-800">
                                    {{ $totalDoctors }}
                                </h2>

                            </div>

                            <div class="text-4xl">
                                👨‍⚕️
                            </div>

                        </div>

                    </div>

                    <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-6">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-sm text-slate-500">
                                    Today's Registrations
                                </p>

                                <h2 class="mt-2 text-3xl font-bold text-slate-800">
                                    {{ $todayRegistrations }}
                                </h2>

                            </div>

                            <div class="text-4xl">
                                📝
                            </div>

                        </div>

                    </div>

                    <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-6">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-sm text-slate-500">
                                    Today's Queue
                                </p>

                                <h2 class="mt-2 text-3xl font-bold text-slate-800">
                                    {{ $todayQueue }}
                                </h2>

                            </div>

                            <div class="text-4xl">
                                🎫
                            </div>

                        </div>

                    </div>

                    <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-6">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-sm text-slate-500">
                                    Revenue Today
                                </p>

                                <h2 class="mt-2 text-3xl font-bold text-green-600">
                                    Rp {{ number_format($todayRevenue) }}
                                </h2>

                            </div>

                            <div class="text-4xl">
                                💰
                            </div>

                        </div>

                    </div>

                    <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-6">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-sm text-slate-500">
                                    Monthly Revenue
                                </p>

                                <h2 class="mt-2 text-3xl font-bold text-green-600">
                                    Rp {{ number_format($monthlyRevenue) }}
                                </h2>

                            </div>

                            <div class="text-4xl">
                                📈
                            </div>

                        </div>

                    </div>

                    <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-6">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-sm text-slate-500">
                                    Medical Records
                                </p>

                                <h2 class="mt-2 text-3xl font-bold text-slate-800">
                                    {{ $totalMedicalRecords }}
                                </h2>

                            </div>

                            <div class="text-4xl">
                                📋
                            </div>

                        </div>

                    </div>

                    <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-6">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-sm text-slate-500">
                                    Cashier Shift
                                </p>

                                <h2 class="mt-2 text-lg font-bold text-slate-800">
                                    {{ $currentShift ? 'OPEN' : 'CLOSED' }}
                                </h2>

                            </div>

                            <div class="text-4xl">
                                🏦
                            </div>

                        </div>

                    </div>

                </div>

            </section>

                        {{-- Cashier Shift --}}

            @if($currentShift)

                        <div class="bg-white rounded shadow p-6 mt-6">

                            <h2 class="text-xl font-bold mb-4">
                                Current Cashier Shift
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                                <div>

                                    <p class="text-gray-500 text-sm">
                                        Cashier
                                    </p>

                            <h3 class="mt-2 text-xl font-bold text-slate-800">
                                {{ $currentShift->cashier->name }}
                            </h3>

                        </div>

                        <div
                            class="rounded-2xl bg-slate-50 border border-slate-200 p-5"
                        >

                                    <p class="text-gray-500 text-sm">
                                        Opened At
                                    </p>

                            <h3 class="mt-2 text-xl font-bold text-slate-800">
                                {{ $currentShift->opened_at->format('d M Y H:i') }}
                            </h3>

                        </div>

                        <div
                            class="rounded-2xl bg-slate-50 border border-slate-200 p-5"
                        >

                                    <p class="text-gray-500 text-sm">
                                        Transactions
                                    </p>

                            <h3 class="mt-2 text-3xl font-bold text-blue-600">
                                {{ $currentShift->transaction_count }}
                            </h3>

                        </div>

                        <div
                            class="rounded-2xl bg-slate-50 border border-slate-200 p-5"
                        >

                                    <p class="text-gray-500 text-sm">
                                        Revenue
                                    </p>

                                    <p class="font-semibold">
                                        Rp {{ number_format($currentShift->revenue) }}
                                    </p>

                        </div>

                    </div>

                </section>

                    @endif

            {{-- SATUSEHAT Dashboard --}}

            <section>

                <div class="flex items-center justify-between mb-5">

                    <div>

                        <h2 class="text-2xl font-bold text-slate-800">
                            SATUSEHAT Dashboard
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Integration monitoring overview
                        </p>

                    </div>

                    <span
                        class="rounded-full bg-blue-100 px-4 py-2 text-sm font-semibold text-blue-700"
                    >
                        {{ $satusehatSuccessRate }}% Success
                    </span>

                </div>

                <div
                    class="grid grid-cols-2 xl:grid-cols-4 gap-6"
                >

                    <div
                        class="rounded-2xl bg-green-50 border border-green-200 p-6"
                    >

                        <div class="text-4xl">
                            ✅
                        </div>

                        <p class="mt-5 text-sm text-green-700">
                            Success
                        </p>

                        <h3 class="text-4xl font-bold text-green-700 mt-2">
                            {{ $satusehatSuccess }}
                        </h3>

                    </div>

                    <div
                        class="rounded-2xl bg-yellow-50 border border-yellow-200 p-6"
                    >

                        <div class="text-4xl">
                            ⏳
                        </div>

                        <p class="mt-5 text-sm text-yellow-700">
                            Pending
                        </p>

                        <h3 class="text-4xl font-bold text-yellow-700 mt-2">
                            {{ $satusehatPending }}
                        </h3>

                    </div>

                    <div
                        class="rounded-2xl bg-red-50 border border-red-200 p-6"
                    >

                        <div class="text-4xl">
                            ❌
                        </div>

                        <p class="mt-5 text-sm text-red-700">
                            Failed
                        </p>

                        <h3 class="text-4xl font-bold text-red-700 mt-2">
                            {{ $satusehatFailed }}
                        </h3>

                    </div>

                    <div
                        class="rounded-2xl bg-blue-50 border border-blue-200 p-6"
                    >

                        <div class="text-4xl">
                            📡
                        </div>

                        <p class="mt-5 text-sm text-blue-700">
                            Success Rate
                        </p>

                        <h3 class="text-4xl font-bold text-blue-700 mt-2">
                            {{ $satusehatSuccessRate }}%
                        </h3>

                        <div class="mt-5">

                            <div
                                class="w-full bg-blue-100 rounded-full h-2"
                            >

                                <div
                                    class="bg-blue-600 h-2 rounded-full"
                                    style="width: {{ $satusehatSuccessRate }}%"
                                ></div>

                            </div>

                        </div>

                    </div>

                </div>

            </section>

                        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">

                {{-- Failed SATUSEHAT --}}

                <section
                    class="rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden"
                >

                    <div
                        class="px-6 py-5 border-b border-slate-200 flex items-center justify-between"
                    >

                        <div>

                            <h2 class="text-xl font-bold text-slate-800">
                                Failed SATUSEHAT Synchronization
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                Registrations requiring retry
                            </p>

                        </div>

                        <span
                            class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700"
                        >
                            {{ $satusehatFailed }} Failed
                        </span>

                    </div>

                    <div class="overflow-x-auto">

                        <table class="min-w-full">

                            <thead
                                class="bg-slate-50 text-slate-600 text-sm"
                            >

                                <tr>

                                    <th class="px-6 py-3 text-left">
                                        Registration
                                    </th>

                                    <th class="px-6 py-3 text-left">
                                        Patient
                                    </th>

                                    <th class="px-6 py-3 text-left">
                                        Action
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($failedSatusehatRegistrations as $registration)

                                    <tr class="border-t">

                                        <td class="px-6 py-4">

                                            <div class="font-semibold">

                                                {{ $registration->registration_number }}

                                            </div>

                                            <div
                                                class="text-xs text-red-500 mt-1"
                                            >

                                                {{ Str::limit($registration->satusehat_error_message,50) }}

                                            </div>

                                        </td>

                                        <td class="px-6 py-4">

                                            {{ $registration->patient->name }}

                                        </td>

                                        <td class="px-6 py-4">

                                            <form
                                                method="POST"
                                                action="{{ route('admin.registrations.retry-satusehat',$registration) }}"
                                            >

                                                @csrf

                                                <button
                                                    class="rounded-xl bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 text-sm"
                                                >
                                                    Retry
                                                </button>

                                            </form>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="3"
                                            class="px-6 py-12 text-center text-slate-400"
                                        >

                                            🎉 No failed synchronization.

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </section>

                {{-- Recent Registrations --}}

                <section
                    class="rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden"
                >

                    <div
                        class="px-6 py-5 border-b border-slate-200"
                    >

                        <h2 class="text-xl font-bold text-slate-800">
                            Recent Registrations
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Latest patient registrations
                        </p>

                    </div>

                    <div class="divide-y divide-slate-100">

                        @forelse($recentRegistrations as $registration)

                            <div
                                class="px-6 py-4 flex items-center justify-between"
                            >

                                <div>

                                    <h3
                                        class="font-semibold text-slate-800"
                                    >
                                        {{ $registration->patient->name }}
                                    </h3>

                                    <p
                                        class="text-sm text-slate-500 mt-1"
                                    >
                                        {{ $registration->registration_number }}
                                    </p>

                                </div>

                                <div class="text-right">

                                    <div
                                        class="font-medium text-slate-700"
                                    >
                                        {{ $registration->doctor->user->name }}
                                    </div>

                                </div>

                            </div>

                        @empty

                            <div
                                class="p-10 text-center text-slate-400"
                            >

                                No registrations yet.

                            </div>

                        @endforelse

                    </div>

                </section>

            </div>

            {{-- Recent Payments --}}

            <section
                class="rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden"
            >

                <div
                    class="px-6 py-5 border-b border-slate-200"
                >

                    <h2 class="text-xl font-bold text-slate-800">
                        Recent Payments
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Latest completed payments
                    </p>

                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full">

                        <thead
                            class="bg-slate-50 text-slate-600"
                        >

                            <tr>

                                <th class="px-6 py-3 text-left">
                                    Payment
                                </th>

                                <th class="px-6 py-3 text-left">
                                    Patient
                                </th>

                                <th class="px-6 py-3 text-right">
                                    Amount
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($recentPayments as $payment)

                                <tr class="border-t">

                                    <td class="px-6 py-4 font-medium">

                                        {{ $payment->payment_number }}

                                    </td>

                                    <td class="px-6 py-4">

                                        {{ $payment->invoice->registration->patient->name }}

                                    </td>

                                    <td
                                        class="px-6 py-4 text-right font-bold text-green-600"
                                    >

                                        Rp {{ number_format($payment->amount) }}

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="3"
                                        class="px-6 py-12 text-center text-slate-400"
                                    >

                                        No payments found.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </section>

        </div>
    </div>

    <x-modal
        name="open-cashier-shift"
        focusable
    >

        <form
            method="POST"
            action="{{ route('admin.cashier-shifts.open') }}"
            class="p-6"
        >

            @csrf

            <h2 class="text-lg font-semibold">
                Open Cashier Shift
            </h2>

            <div class="mt-6 space-y-4">

                <div>

                    <label class="block text-sm font-medium mb-1">
                        Opening Balance
                    </label>

                    <input
                        type="number"
                        name="opening_balance"
                        step="0.01"
                        min="0"
                        required
                        class="w-full rounded border-gray-300"
                    >

                    <p class="text-xs text-gray-500 mt-1">
                        Enter the starting cash available in the cashier drawer.
                    </p>

                </div>

                <div>

                    <label class="block text-sm font-medium mb-1">
                        Notes
                    </label>

                    <textarea
                        name="notes"
                        rows="3"
                        class="w-full rounded border-gray-300"
                    ></textarea>

                </div>

            </div>

            <div class="mt-6 flex justify-end gap-2">

                <x-secondary-button
                    type="button"
                    x-on:click="$dispatch('close')"
                >
                    Cancel
                </x-secondary-button>

                <x-primary-button>
                    Open Shift
                </x-primary-button>

            </div>

        </form>

    </x-modal>

</x-app-layout>