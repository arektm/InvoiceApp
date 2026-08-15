<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $today = now()->startOfDay();
        $monthStart = now()->startOfMonth();
        $yearStart = now()->startOfYear();

        /*
        |--------------------------------------------------------------------------
        | Invoice payment status
        |--------------------------------------------------------------------------
        */

        $paidInvoices = Invoice::where('status', 'paid')->count();

        $unpaidInvoices = Invoice::where('status', 'unpaid')
            ->count();
        $overdueInvoices = Invoice::where('status', 'unpaid')
            ->whereDate('due_date', '<', $today)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Total invoices
        |--------------------------------------------------------------------------
        */

        $invoiceCount = Invoice::count();
        $invoicesCancelled = Invoice::where('status', 'cancelled')->count();
        $invoiceCount = $invoiceCount - $invoicesCancelled;

        /*
        |--------------------------------------------------------------------------
        | Payment status percentages
        |--------------------------------------------------------------------------
        |
        | Overdue is a subset of unpaid invoices.
        | For the pie chart we therefore split unpaid into:
        |
        | Paid
        | Unpaid (not overdue)
        | Overdue
        |
        */

        $regularUnpaidInvoices = max(
            0,
            $unpaidInvoices - $overdueInvoices
        );

        $paymentStatusTotal =
            $paidInvoices +
            $regularUnpaidInvoices +
            $overdueInvoices;

        $paymentStatus = [
            'paid' => $paidInvoices,
            'unpaid' => $regularUnpaidInvoices,
            'overdue' => $overdueInvoices,
        ];

        $paymentStatusPercentages = [
            'paid' => $paymentStatusTotal > 0
                ? round(($paidInvoices / $paymentStatusTotal) * 100, 1)
                : 0,

            'unpaid' => $paymentStatusTotal > 0
                ? round(($regularUnpaidInvoices / $paymentStatusTotal) * 100, 1)
                : 0,

            'overdue' => $paymentStatusTotal > 0
                ? round(($overdueInvoices / $paymentStatusTotal) * 100, 1)
                : 0,
        ];

        /*
        |--------------------------------------------------------------------------
        | Recent invoices
        |--------------------------------------------------------------------------
        */

        $recentInvoices = Invoice::with('client')
            ->latest('issue_date')
            ->limit(5)
            ->get([
                'id',
                'invoice_number',
                'client_id',
                'issue_date',
                'due_date',
                'total_gross',
                'status',
            ]);

        return Inertia::render('Dashboard', [
            'invoiceCount' => $invoiceCount,

            'paymentStatus' => $paymentStatus,

            'paymentStatusPercentages' => $paymentStatusPercentages,

            'recentInvoices' => $recentInvoices,

            'cancelledInvoices' => $invoicesCancelled,
        ]);
    }
}
