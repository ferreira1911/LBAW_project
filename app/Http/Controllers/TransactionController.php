<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;

class TransactionController extends Controller
{
    /**
     * Mostra o histórico de transações do utilizador (o seu "extrato bancário").
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $type = $request->query('type');

        $query = Transaction::where(function($q) use ($user) {
            $q->where('buyer_id', $user->id)
              ->orWhere('seller_id', $user->id);
        });

        if ($type) {
            $query->where('type', $type);
        }

        $transactions = $query->with(['auction', 'buyer', 'seller'])
                              ->orderBy('date', 'desc')
                              ->paginate(15)
                              ->withQueryString();

        return view('pages.transactions.index', [
            'transactions' => $transactions,
            'currentType' => $type
        ]);
    }

    /**
     * Show the form to ADD credit.
     */
    public function createCredit()
    {
        $this->authorize('create', Transaction::class);
        return view('pages.transactions.create_credit');
    }

    /**
     * Process the ADD credit request (Redirect to Stripe).
     */
    public function storeCredit(Request $request)
    {
        $this->authorize('create', Transaction::class);
        
        $request->validate([
            'amount' => ['required', 'numeric', 'min:5', 'max:5000'],
        ]);

        $user = Auth::user();
        $amount = $request->amount;

        // CASHIER: Generates a Stripe Checkout Session for a one-off charge.
        // We multiply by 100 because Stripe expects cents (EUR).
        return $user->checkoutCharge($amount * 100, 'Wallet Deposit', 1, [
            'success_url' => route('credit.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('credit.cancel'),
        ]);
    }

    /**
     * Handle Stripe Success Callback.
     */
    public function successCredit(Request $request)
    {
        $user = Auth::user();
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('credit.create')->with('failure', 'Invalid payment session.');
        }

        try {
            // Validate the session directly with Stripe API
            $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId);

            if ($session->payment_status !== 'paid') {
                return redirect()->route('credit.create')->with('failure', 'Payment not confirmed.');
            }

            // Convert cents back to main currency unit
            $amount = $session->amount_total / 100;

            DB::transaction(function () use ($user, $amount, $sessionId) {
                // SECURITY: Check if we already processed this Stripe Session ID to prevent double spending
                $exists = Transaction::where('payment_reference', $sessionId)->exists();

                if (!$exists) {
                    // 1. Create the Transaction record
                    Transaction::create([
                        'amount' => $amount,
                        'status' => 'Completed',
                        'type' => 'add-credit',
                        'buyer_id' => $user->id,
                        'payment_reference' => $sessionId // Store Stripe ID for auditing
                    ]);

                    // 2. Add credit to user wallet
                    $user->increment('credit', $amount);
                }
            });

            return redirect()->route('users.show', $user)->with('success', 'Credit added successfully!');

        } catch (\Exception $e) {
            return redirect()->route('users.show', $user)->with('failure', 'Error verifying payment.');
        }
    }

    /**
     * Handle Stripe Cancel Callback.
     */
    public function cancelCredit()
    {
        return redirect()->route('credit.create')->with('warning', 'Payment cancelled.');
    }

    /**
     * Show the form to WITHDRAW credit.
     */
    public function createWithdrawal()
    {
        $this->authorize('create', Transaction::class);
        return view('pages.transactions.create_withdrawal'); 
    }

    /**
     * Process the WITHDRAWAL request (Simulation).
     */
    public function storeWithdrawal(Request $request)
    {
        $this->authorize('create', Transaction::class);
        $user = Auth::user();

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:10', 'max:' . $user->credit],
            'iban' => ['required', 'string', 'min:15', 'max:34'],
        ]);

        try {
            DB::transaction(function () use ($user, $validated) {
                Transaction::create([
                    'amount' => $validated['amount'],
                    'status' => 'Completed',
                    'type' => 'credit-withdrawal',
                    'buyer_id' => $user->id,
                    'payment_reference' => $validated['iban']
                ]);

                
                $user->decrement('credit', $validated['amount']);
                
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('failure', 'An error occurred while processing your request.');
        }

        return redirect()->route('users.show', Auth::user())->with('success', 'Withdrawal request submitted!');
    }

    /**
     * Filter transactions helper.
     */
    public function filter(Request $request)
    {
        $type = $request->input('type');
        return redirect()->route('transactions.index', ['type' => $type]);
    }
}