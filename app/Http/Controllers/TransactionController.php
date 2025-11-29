<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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
     * Mostra o formulário para ADICIONAR crédito.
     */
    public function createCredit()
    {
        $this->authorize('create', Transaction::class);
        return view('pages.transactions.create_credit'); // Ex: /wallet/add-credit
    }

    /**
     * Processa o formulário de ADICIONAR crédito.
     */
    public function storeCredit(Request $request)
    {
        
        $this->authorize('create', Transaction::class);
        
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:5', 'max:10000'], // Ex: Mínimo de 5€
            'card_name'   => ['nullable', 'string', 'max:255'],
            'card_number' => ['nullable', 'string', 'min:16', 'max:19'],
            'card_expiry' => ['nullable', 'string', 'min:5', 'max:5'],
            'card_cvc'    => ['nullable', 'string', 'min:3', 'max:4'],
        ]);

        $user = Auth::user();

        try {
            DB::transaction(function () use ($user, $validated) {
                // 1. Cria o registo da transação
                Transaction::create([
                    'amount' => $validated['amount'],
                    'status' => 'Completed',
                    'type' => 'add-credit', // Tipo hardcoded
                    'buyer_id' => $user->id,
                ]);

                // 2. Adiciona o crédito ao utilizador
                $user->increment('credit', $validated['amount']);
            });
        } catch (\Exception $e) {
            Log::error('Falha ao adicionar crédito', ['user' => $user->id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('failure', 'Ocorreu um erro ao processar o seu pedido.');
        }

        return redirect()->route('users.show',$user)->with('success', 'Crédito adicionado com sucesso!');
    }

    /**
     * Mostra o formulário para LEVANTAR crédito.
     */
    public function createWithdrawal()
    {
        $this->authorize('create', Transaction::class);
        return view('pages.transactions.create_withdrawal'); // Ex: /wallet/withdraw
    }

    /**
     * Processa o formulário de LEVANTAR crédito.
     */
    public function storeWithdrawal(Request $request)
    {
        $this->authorize('create', Transaction::class);
        $user = Auth::user();

        // Valida o pedido, garantindo que o utilizador tem crédito suficiente
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:10', 'max:' . $user->credit],
        ]);

        try {
            DB::transaction(function () use ($user, $validated) {
                Transaction::create([
                    'amount' => $validated['amount'],
                    'status' => 'Completed',
                    'type' => 'credit-withdrawal', // Tipo hardcoded
                    'buyer_id' => $user->id, // O "comprador" é quem recebe o dinheiro
                ]);

                
                $user->decrement('credit', $validated['amount']);
                
            });
        } catch (\Exception $e) {
            Log::error('Falha ao levantar crédito', ['user' => $user->id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('failure', 'Ocorreu um erro ao processar o seu pedido.');
        }

        return redirect()->route('users.show', Auth::user())->with('success', 'Pedido de levantamento submetido!');
    }

    /**
     * Mostra os detalhes de uma transação específica.
     */
    public function filter(Request $request)
    {
        $type = $request->input('type');
        return redirect()->route('transactions.index', ['type' => $type]);
    }
}