<?php

    namespace App\Http\Controllers;

    use App\CCTransaction;
    use App\Client;
    use App\ClientDevice;
    use App\Http\Requests\DataExportRequest;
    use App\Order;
    use App\Store;
    use Illuminate\Http\Request;
    use Maatwebsite\Excel\Facades\Excel;

    class DataExportController extends Controller
    {

        public function __construct()
        {
            ini_set('memory_limit', '256M');
            $this->middleware('care');
        }

        public function index()
        {
            return view('admin.report.export.index');
        }

        public function ccData(DataExportRequest $request)
        {
            $transactions = CCTransaction::with([
                'client',
                'client.city',
            ])
                ->whereBetween('created_at', [$request->begin, $request->end])
                ->get();

            $excel = Excel::create("CC-Avenue-Transactions [{$request->begin} to {$request->end}] ", function ($excel) use ($transactions) {
                $excel->sheet('Transactions', function ($sheet) use ($transactions) {
                    $sheet->loadView('admin.report.export.excel.ccdata', ['transactions' => $transactions]);
                });
            });

            return $excel->export('xls');
        }

        public function salesRegisterationsData(DataExportRequest $request)
        {
            if ($request->has('sales')) {
                $agents = Client::whereIn('id', $request->sales)->get();
            } else {
                $agents = Client::where('client_type', 'sales')->get();
            }

            $excel = Excel::create("Client-Reports [{$request->begin} to {$request->end}] ", function ($excel) use ($agents, $request) {
                foreach ($agents as $agent) {
                    $agent_name = substr($agent->name, 0, 5);
                    $excel->sheet("REF_{$agent->mobile}_{$agent_name}", function ($sheet) use ($agent, $request) {
                        $referrals = $agent->referredTo()
                            ->whereBetween('created_at', [$request->begin, $request->end])
                            ->get();
                        $sheet->loadView('admin.report.export.excel.clientData', ['clients' => $referrals]);
                    });
                }

            });

            return $excel->export('xls');
        }

        public function clientSQLData(DataExportRequest $request)
        {
            $pdo = \DB::getPdo();
            $statement = $pdo->prepare("SELECT * FROM registeration_reporting WHERE date(created_at) BETWEEN :begin AND :end");
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $statement->execute([
                ':begin' => $request->begin,
                ':end'   => $request->end,
            ]);

            $results = $statement->fetchAll();

            $excel = Excel::create("Registeration Report [{$request->begin} to {$request->end}]", function ($excel) use ($results) {
                $excel->sheet("Joinings", function ($sheet) use ($results) {
                    $sheet->fromArray($results, '-', 'A1', true);
                });
            });

            return $excel->download('xls');
        }

        public function storeOrderData(DataExportRequest $request)
        {
            $this->validate($request, [
                'store_id' => "required|exists:stores,id",
            ]);

            $store = Store::find($request->input('store_id'));

            $orders = Order::with(['client', 'deal'])
                ->whereIn('deal_id', $store->deals->pluck('id'))
                ->whereBetween('created_at', [$request->begin, $request->end])
                ->get();

            $excel = Excel::create("Report Store ({$store->name}, {$store->city->name}) Orders [{$request->begin} to {$request->end}] ", function ($excel) use ($orders, $store) {

                $excel->sheet('Orders', function ($sheet) use ($orders) {
                    $sheet->loadView('admin.report.export.excel.storeOrderData', ['orders' => $orders]);
                });
            });

            return $excel->export('xls');
        }

        public function storeDealData(Request $request)
        {
            $this->validate($request, [
                'store_id' => "required|exists:stores,id",
            ]);

            $store = Store::find($request->input('store_id'));

            $excel = Excel::create("Store ({$store->name}, {$store->city->name}) Deals", function ($excel) use ($store) {

                $excel->sheet('Deals', function ($sheet) use ($store) {
                    $sheet->loadView('admin.report.export.excel.dealData', ['deals' => $store->deals]);
                });

            });

            return $excel->export('xls');
        }

        public function bookletActivationSQLData(DataExportRequest $request)
        {
            $pdo = \DB::getPdo();

            $statement = $pdo->prepare("SELECT * FROM activation_reporting WHERE city_id = :city_id AND date(activation_date) BETWEEN :begin AND :end");
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $statement->execute([
                ':begin'   => $request->begin,
                ':end'     => $request->end,
                ':city_id' => $request->city_id,
            ]);

            $results = $statement->fetchAll();

            $excel = Excel::create("Booklet Activations [{$request->begin} to {$request->end}]", function ($excel) use ($results) {
                $excel->sheet("Data", function ($sheet) use ($results) {
                    $sheet->fromArray($results, '-', 'A1', true);
                });
            });

            return $excel->download('xls');
        }

        public function deviceRegData(DataExportRequest $request)
        {
            $registrations = ClientDevice::with(['client'])
                ->whereBetween('created_at', [$request->begin, $request->end])
                ->get();

            $excel = Excel::create("DeviceReg [{$request->begin} to {$request->end}] ", function ($excel) use ($registrations) {
                $excel->sheet('Devices', function ($sheet) use ($registrations) {
                    $sheet->loadView('admin.report.export.excel.devReg', ['regs' => $registrations]);
                });
            });

            return $excel->export('xls');
        }
    }
