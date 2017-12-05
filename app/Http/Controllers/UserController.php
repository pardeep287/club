<?php

    namespace App\Http\Controllers;

    use App\Client;
    use App\Deal;
    use App\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Image;

    class UserController extends Controller
    {
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('auth', ['except' => ['mobile', 'transactionsOnly']]);
            $this->middleware('admin');
        }

        public function index()
        {
            $users = User::all();

            return view('admin.user.index', compact(['users']));
        }

        public function add(Request $request)
        {


            $this->validate($request, [
                'name'       => "required|max:100",
                'email'      => "required|email|unique:users,email",
                "password"   => "required|confirmed|min:6|max:35",
                "mobile"     => "required|min:10|max:16",
                "auth_level" => "required",
            ]);

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(512, 512)->save(public_path(User::$avatar_path . $filename), 100);
            } else {
                $filename = "jbuser.png";
            }


            User::create([
                'name'       => $request->name,
                'email'      => $request->email,
                'password'   => bcrypt($request->password),
                'auth_level' => $request->auth_level,
                'mobile'     => $request->mobile,
                'avatar'     => $filename,
            ]);

            return back();
        }

        public function edit(Request $request)
        {

            $user = User::find($request->id);

            $emailValidation = "required|email";
            if ($user->email !== $request->email) {
                $emailValidation .= "|unique:users,email";
            }

            $this->validate($request, [
                'name'       => "required|max:100",
                'email'      => $emailValidation,
                "auth_level" => "required",
            ]);

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(512, 512)->save(public_path(User::$avatar_path . $filename), 100);
            } else {
                $filename = $user->avatar;
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->auth_level = $request->auth_level;
            $user->avatar = $filename;
            $user->mobile = $request->mobile;

            $user->save();

            return back()->with([
                'message' => "User Updated",
            ]);
        }

        public function password_change(Request $request)
        {
            $user = auth()->user();
            $rr[] = $request->all();
            $rr[] = $user;

            if (Auth::attempt(['email' => "$user->email", 'password' => "$request->old_password"])) {
                $this->validate($request, [
                    "password" => "required|min:6|max:42|confirmed",
                ]);

                $user->password = bcrypt($request->password);

                $user->save();

                return back()->with([
                    "message" => "Password Changed",
                ]);
            } else {
                return back()->withErrors([
                    "old_pass" => "Incorrect Password",
                ]);
            }
        }

        public function password_reset(Request $request)
        {
            $this->validate($request, [
                'id' => "required|exists:users,id",
            ]);

            $c = User::where('id', $request->input('id'))
                ->limit(1)
                ->update([
                    'password' => bcrypt('312925'),
                ]);

            return back()->with([
                'message' => "Password RESET Code: {$c}",
            ]);
        }

        public function mobile(Request $request)
        {
            $client = Client::mobile($request->mobile);
            $deal = Deal::find($request->deal);
            $res['client'] = $client;
            $res['deal'] = $deal;
            $res['allowed'] = true;
            if (empty($client->transactions)) {
                return $res;
            }

            $date = date('Y-m-d');
            $used = $client->deal($request->deal);
            $client_limit_daily = $client->deal_count($deal->id, $date);

            $res['transactions'] = $used;
            $res['today'] = $client_limit_daily;
            $res['daily_limit'] = $deal->daily_limit;

            $res['allowed'] = false;


            $re['used_total'] = $used;
            $re['used_today'] = $client_limit_daily;
            $re['deal_qty'] = $deal->quantity;
            $re['deal_daily'] = $deal->daily_limit;

            if ($client_limit_daily <= $deal->daily_limit && $used < $deal->quantity) {
                $limit_today = $deal->daily_limit - $client_limit_daily;
                $res['limit'] = $limit_today;
                if ($limit_today >= 1) {
                    $res['allowed'] = true;
                }
            }

            return $res;
        }

        public function transactionsOnly(Request $request)
        {
            $client = Client::where('mobile', $request->mobile)->get()[0];
            if (empty($client->transactions)) {
                return view('admin.table.transaction', compact(['client']));
            } else {
                return view('admin.table.notransaction');
            }
        }
    }