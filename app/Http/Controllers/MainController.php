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
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    public function index()
    {
        try {
            $filterBrand = $filterType = $filterVersion = $filterModel = 'todas';
            $filterResult = -1;
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
                    $join->on('modelos.brand_id', '=', 'brands.id')
                        ->where([['brands.active', '=', 1]]);
                })
                ->join('types', function ($join) {
                    $join->on('modelos.type_id', '=', 'types.id')
                        ->where([['types.active', '=', 1]]);
                })
                ->select('tips.*', 'users.name as writter', 'brands.name as brand', 'types.name as type', 'modelos.name as model')
                ->orderBy('tips.id', 'desc')
                ->get();

            return view('index', compact('tips', 'filterResult', 'filterType', 'filterBrand', 'filterModel', 'filterVersion'));
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

            $validator = Validator::make($request->all(), [
                'type' => 'required',
                'model' => 'required',
                'brand' => 'required',
            ], [
                'type.required' => 'Preenche o campo tipo',
                'model.required' => 'Preenche o campo modelo',
                'brand.required' => 'Preenche o campo marca',
            ]);

            if ($validator->fails()) {
                session()->flash('error', 'Dica não cadastrada. Verifique os dados e tenta novamente');
                if (session('error')) {
                    Alert::toast(session('error'), 'error');
                }
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $new = [
                'name' => $request->input('model'),
                'slug' => Str::slug($request->input('name')),
                'type_id' => Type::where('id', $request->input('type'))->first()->id,
                'brand_id' => Brand::where('id', $request->input('brand'))->first()->id,
            ];

            $result = Modelo::create($new);

            $new = [
                'modelo_id' => $result->id,
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

            $validator = Validator::make($request->all(), [
                'type' => 'required',
                'model' => 'required',
                'brand' => 'required',
            ], [
                'type.required' => 'Preenche o campo tipo',
                'model.required' => 'Preenche o campo modelo',
                'brand.required' => 'Preenche o campo marca',
            ]);

            if ($validator->fails()) {
                session()->flash('error', 'Dica não actualizada. Verifique os dados e tenta novamente');
                if (session('error')) {
                    Alert::toast(session('error'), 'error');
                }
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $tip = Tip::where('id', $id)->first();

            $name = $request->input('model');

            $new = [
                'name' => $name,
                'slug' => Str::slug($name),
                'type_id' => Type::where('id', $request->input('type'))->first()->id,
                'brand_id' => Brand::where('id', $request->input('brand'))->first()->id,
            ];

            \DB::table('modelos')
                ->where('id', $tip->modelo_id)
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
                $join->on('modelos.brand_id', '=', 'brands.id')
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
                    $join->on('modelos.brand_id', '=', 'brands.id')
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


            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ], [
                'password.required' => 'Preenche o campo senha',
                'email.required' => 'Preenche o campo email',
                'email.email' => 'Informa email válido',
            ]);

            if ($validator->fails()) {
                session()->flash('error', 'Ops! Verifique os dados e tenta novamente');
                if (session('error')) {
                    Alert::toast(session('error'), 'error');
                }
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            if (Auth::attempt($credentials)) {
                Auth::logoutOtherDevices($request->input('password'));
                $user = auth()->user();
                Auth::login($user);

                $request->session()->flash('success', 'Seja bem-vindo(a), ' . Auth::user()->name . '');
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

    
    public function filterByBrand($slug)
    {
        try {
            $filterBrand = $slug;
            $filterType = $filterVersion = $filterModel = 'todas';

            $tips = \DB::table('tips')
                ->join('users', function ($join) {
                    $join->on('tips.user_id', '=', 'users.id')
                        ->where([['tips.active', '=', 1]]);
                })
                ->join('modelos', function ($join) {
                    $join->on('tips.modelo_id', '=', 'modelos.id')
                        ->where([['modelos.active', '=', 1]]);
                })
                ->join('brands', function ($join) use ($slug) {
                    $join->on('modelos.brand_id', '=', 'brands.id')
                        ->where([['brands.active', '=', 1], ['brands.slug', '=', $slug]]);
                })
                ->join('types', function ($join) {
                    $join->on('modelos.type_id', '=', 'types.id')
                        ->where([['types.active', '=', 1]]);
                })
                ->select('tips.*', 'users.name as writter', 'brands.name as brand', 'types.name as type', 'modelos.name as model')
                ->orderBy('tips.id', 'desc')
                ->get();

            $filterResult = count($tips);

            session()->flash('success', 'Filtro aplicado com sucesso');
            if (session('success')) {
                Alert::toast(session('success'), 'success');
            }
            return view('index', compact('tips', 'filterResult', 'filterType', 'filterBrand', 'filterModel', 'filterVersion'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function filterByModel($slug)
    {
        try {
            $filterModel = $slug;
            $filterType = $filterVersion = $filterBrand = 'todas';

            $tips = \DB::table('tips')
                ->join('users', function ($join) {
                    $join->on('tips.user_id', '=', 'users.id')
                        ->where([['tips.active', '=', 1]]);
                })
                ->join('modelos', function ($join)  use ($slug) {
                    $join->on('tips.modelo_id', '=', 'modelos.id')
                        ->where([['modelos.active', '=', 1], ['modelos.slug', '=', $slug]]);
                })
                ->join('brands', function ($join){
                    $join->on('modelos.brand_id', '=', 'brands.id')
                        ->where([['brands.active', '=', 1]]);
                })
                ->join('types', function ($join) {
                    $join->on('modelos.type_id', '=', 'types.id')
                        ->where([['types.active', '=', 1]]);
                })
                ->select('tips.*', 'users.name as writter', 'brands.name as brand', 'types.name as type', 'modelos.name as model')
                ->orderBy('tips.id', 'desc')
                ->get();

            $filterResult = count($tips);

            session()->flash('success', 'Filtro aplicado com sucesso');
            if (session('success')) {
                Alert::toast(session('success'), 'success');
            }
            return view('index', compact('tips', 'filterResult', 'filterType', 'filterBrand', 'filterModel', 'filterVersion'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    public function filterByVersion($name)
    {
        try {
            $filterVersion= $name;
            $filterType = $filterModel = $filterBrand = 'todas';

            $tips = \DB::table('tips')
                ->join('users', function ($join) {
                    $join->on('tips.user_id', '=', 'users.id')
                        ->where([['tips.active', '=', 1]]);
                })
                ->join('modelos', function ($join){
                    $join->on('tips.modelo_id', '=', 'modelos.id')
                        ->where([['modelos.active', '=', 1]]);
                })
                ->join('tip_versions', function ($join){
                    $join->on('tips.id', '=', 'tip_versions.tip_id')
                        ->where([['tips.active', '=', 1]]);
                })
                ->join('versions', function ($join)  use ($name) {
                    $join->on('tip_versions.version_id', '=', 'versions.id')
                        ->where([['versions.name', '=', $name]]);
                })
                ->join('brands', function ($join){
                    $join->on('modelos.brand_id', '=', 'brands.id')
                        ->where([['brands.active', '=', 1]]);
                })
                ->join('types', function ($join) {
                    $join->on('modelos.type_id', '=', 'types.id')
                        ->where([['types.active', '=', 1]]);
                })
                ->select('tips.*', 'users.name as writter', 'brands.name as brand', 'types.name as type', 'modelos.name as model')
                ->orderBy('tips.id', 'desc')
                ->get();

            $filterResult = count($tips);

            session()->flash('success', 'Filtro aplicado com sucesso');
            if (session('success')) {
                Alert::toast(session('success'), 'success');
            }
            return view('index', compact('tips', 'filterResult', 'filterType', 'filterBrand', 'filterModel', 'filterVersion'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function filterByType($slug)
    {
        try {
            $filterType = $slug;
            $filterBrand = $filterVersion = $filterModel = 'todas';

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
                    $join->on('modelos.brand_id', '=', 'brands.id')
                        ->where([['brands.active', '=', 1]]);
                })
                ->join('types', function ($join) use ($slug) {
                    $join->on('modelos.type_id', '=', 'types.id')
                        ->where([['types.active', '=', 1], ['types.slug', '=', $slug]]);
                })
                ->select('tips.*', 'users.name as writter', 'brands.name as brand', 'types.name as type', 'modelos.name as model')
                ->orderBy('tips.id', 'desc')
                ->get();

            $filterResult = count($tips);

            session()->flash('success', 'Filtro aplicado com sucesso');
            if (session('success')) {
                Alert::toast(session('success'), 'success');
            }
            return view('index', compact('tips', 'filterResult', 'filterType', 'filterBrand', 'filterModel', 'filterVersion'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function registerUser(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
            ], [
                'name.required' => 'Preenche o campo nome',
                'name.min' => 'Nome deve ter no mínimo 3 caracteres',
                'email.required' => 'Preenche o campo email',
                'email.unique' => 'Este email já está sendo utilizado',
                'email.email' => 'Informa email válido',
                'password.required' => 'Preenche o campo senha',
                'password.min' => 'Senha deve ter no mínimo 6 caracteres',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $user = new User();

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return response()->json($request);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('etips.index');
    }
}
