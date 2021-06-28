<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Tip;
use App\Models\Type;
use App\Models\Brand;
use App\Models\Modelo;
use App\Models\Version;
use App\Models\TipVersion;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class MainController extends Controller
{
    public function index()
    {
        try {

            $tips = \DB::table('tips')
                ->join('users', function ($join) {
                    $join->on('tips.user_id', '=', 'users.id')
                        ->where([['tips.active', '=', 1]]);
                })
                ->join('modelos', function ($join) {
                    $join->on('tips.modelo_id', '=', 'modelos.id')
                        ->where([['modelos.active', '=', 1]]);
                })
                ->join('brands', function ($join) {
                    $join->on('tips.brand_id', '=', 'brands.id')
                        ->where([['brands.active', '=', 1]]);
                })
                ->join('types', function ($join) {
                    $join->on('modelos.type_id', '=', 'types.id')
                        ->where([['types.active', '=', 1]]);
                })
                ->select('tips.*', 'users.name as writter', 'brands.name as brand', 'types.name as type', 'modelos.name as model')
                ->get();

            return view('index', compact('tips'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function registerStore(Request $request)
    {
        try {
            if (!Auth::check()) {
                $request->session()->flash('error', 'Tens de estar logado');
                if (session('error')) {
                    Alert::toast(session('error'), 'error');
                }
                return redirect()->route('etips.index');
            }
            $name = $request->input('model');

            $new = [
                'name' => $name,
                'slug' => Str::slug($name),
                'type_id' => Type::where('id', $request->input('type'))->first()->id,
            ];
            $result1 = Modelo::create($new);

            $name = $request->input('brand');
            $new = [
                'name' => $name,
                'slug' => Str::slug($name),
            ];

            $result = Brand::create($new);

            $new = [
                'modelo_id' => $result1->id,
                'brand_id' => $result->id,
                'user_id' => Auth::user()->id,
            ];

            $result = Tip::create($new);

            if ($request->input('version')) {
                $new = [
                    'name' => $request->input('version'),
                ];

                $result1 = Version::create($new);

                $new = [
                    'tip_id' => $result->id,
                    'version_id' => $result1->id,
                ];
                $result = TipVersion::create($new);
            }
            $request->session()->flash('success', 'Dica registada com sucesso');
            if (session('success')) {
                Alert::toast(session('success'), 'success');
            }
            return redirect()->back();
        } catch (\Exception $e) {
            $request->session()->flash('error', 'Ops! Verifique os dados e tenta novamente');
            if (session('error')) {
                Alert::toast(session('error'), 'error');
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateStore(Request $request, $id)
    {
        try {
            $id = decrypt($id);

            if (!Auth::check()) {
                $request->session()->flash('error', 'Tens de estar logado');
                if (session('error')) {
                    Alert::toast(session('error'), 'error');
                }
                return redirect()->route('etips.index');
            }

            $tip = Tip::where('id', $id)->first();

            $name = $request->input('model');

            $new = [
                'name' => $name,
                'slug' => Str::slug($name),
                'type_id' => Type::where('id', $request->input('type'))->first()->id,
            ];

            \DB::table('modelos')
                ->where('id', $tip->modelo_id)
                ->update($new);


            $name = $request->input('brand');

            $new = [
                'name' => $name,
                'slug' => Str::slug($name),
            ];

            \DB::table('brands')
                ->where('id', $tip->brand_id)
                ->update($new);

            if ($request->input('version')) {
                $new = [
                    'name' => $request->input('version'),
                ];

                $aux = TipVersion::Where('tip_id', $tip->id)->first();

                if ($aux) {
                    \DB::table('versions')
                        ->where('id', $aux->version_id)
                        ->update($new);
                } else {
                    $result1 = Version::create($new);
                    $new = [
                        'tip_id' => $tip->id,
                        'version_id' => $result1->id,
                    ];
                    TipVersion::create($new);
                }
            }
            $request->session()->flash('success', 'Dica actualizada com sucesso');
            if (session('success')) {
                Alert::toast(session('success'), 'success');
            }
            return redirect()->route('etips.mytips');
        } catch (\Exception $e) {
            $request->session()->flash('error', 'Ops! Verifique os dados e tenta novamente');
            if (session('error')) {
                Alert::toast(session('error'), 'error');
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function register()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Tens de estar logado');
            if (session('error')) {
                Alert::toast(session('error'), 'error');
            }
            return redirect()->route('etips.index');
        }
        return view('register');
    }

    public function update($id)
    {
        if (!Auth::check()) {
            session()->flash('error', 'Tens de estar logado');
            if (session('error')) {
                Alert::toast(session('error'), 'error');
            }
            return redirect()->route('etips.index');
        }

        $id = decrypt($id);
        $tip = \DB::table('tips')
            ->join('modelos', function ($join) use ($id) {
                $join->on('tips.modelo_id', '=', 'modelos.id')
                    ->where([['modelos.active', '=', 1], ['tips.id', '=', $id]]);
            })
            ->join('brands', function ($join) {
                $join->on('tips.brand_id', '=', 'brands.id')
                    ->where([['brands.active', '=', 1]]);
            })
            ->join('types', function ($join) {
                $join->on('modelos.type_id', '=', 'types.id')
                    ->where([['types.active', '=', 1]]);
            })
            ->select('tips.*', 'brands.name as brand', 'types.name as type',  'types.id as type_id', 'modelos.name as model')
            ->first();
        return view('update', compact('tip'));
    }

    public function remove($id)
    {
        try {
            if (!Auth::check()) {
                session()->flash('error', 'Tens de estar logado');
                if (session('error')) {
                    Alert::toast(session('error'), 'error');
                }
                return redirect()->route('etips.index');
            }

            $id = decrypt($id);
            $old_tip = Tip::where('id', $id)->first();

            $old_tip->active = 0;
            $old_tip->save();

            session()->flash('warning', 'Dica removida com sucesso');
            if (session('warning')) {
                Alert::toast(session('warning'), 'warning');
            }
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error', 'Ops! Verifique os dados e tenta novamente');
            if (session('error')) {
                Alert::toast(session('error'), 'error');
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function myTips()
    {
        try {
            if (!Auth::check()) {
                session()->flash('error', 'Tens de estar logado');
                if (session('error')) {
                    Alert::toast(session('error'), 'error');
                }
                return redirect()->route('etips.index');
            }
            $id = Auth::user()->id;

            $tips = \DB::table('tips')
                ->join('users', function ($join) use ($id) {
                    $join->on('tips.user_id', '=', 'users.id')
                        ->where([['tips.active', '=', 1], ['users.id', '=', $id]]);
                })
                ->join('modelos', function ($join) {
                    $join->on('tips.modelo_id', '=', 'modelos.id')
                        ->where([['modelos.active', '=', 1]]);
                })
                ->join('brands', function ($join) {
                    $join->on('tips.brand_id', '=', 'brands.id')
                        ->where([['brands.active', '=', 1]]);
                })
                ->join('types', function ($join) {
                    $join->on('modelos.type_id', '=', 'types.id')
                        ->where([['types.active', '=', 1]]);
                })
                ->select('tips.*', 'users.name as writter', 'brands.name as brand', 'types.name as type', 'modelos.name as model')
                ->get();

            return view('mytips', compact('tips'));
        } catch (\Exception $e) {
            session()->flash('error', 'Ops! Verifique os dados e tenta novamente');
            if (session('error')) {
                Alert::toast(session('error'), 'error');
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function login(Request $request)
    {
        try {

            $credentials = [
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ];

            if (Auth::attempt($credentials)) {
                Auth::logoutOtherDevices($request->input('password'));
                $user = auth()->user();
                Auth::login($user);

                $request->session()->flash('success', 'Seja bem-vindo(a), '. Auth::user()->name. '');
                if (session('success')) {
                    Alert::toast(session('success'), 'success');
                }
                return redirect()->back();
            }
            $request->session()->flash('error', 'Email ou senha incorreta');
            if (session('error')) {
                Alert::toast(session('error'), 'error');
            }
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function registerUser(Request $request)
    {
        try {
            $user = new User();

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();

            return response()->json($request);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('etips.index');
    }
}
