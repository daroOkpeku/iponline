<?php

namespace App\Http\Controllers;

use App\Events\emailevent;
use App\Http\Requests\muitireq;
use App\Http\Requests\register;
use App\Http\Requests\signinreq;
use App\Http\Requests\valid;
use App\Http\Resources\purchaseresource;
use App\Models\Order;
use App\Models\purchase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class PostController extends Controller
{

            public function home(){
                return view('home');
            }


            public function allorders(){
               $orders = Order::all();
               return response()->json(['success'=>$orders]);
            }

            public function paystack_verify($ref){
                $sercrtKey = "sk_test_e459fbb80fa274bd0af7a6ff4266bdbc2265a933";
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.paystack.co/transaction/verify/$ref",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer $sercrtKey",
                    "Cache-Control: no-cache",
                ),
                ));

                $response = curl_exec($curl);
                return $response;

                $err = curl_error($curl);
                curl_close($curl);
                    }


                    public function muitplepayment(muitireq $request){
                        $data = json_decode($request->data);
                        //   dd($data);
                       foreach ($data as  $value) {
                             $purchase =  new purchase();
                             $purchase->orderid = $value->id;
                             $purchase->ref = $value->ref;
                             $purchase->userid = $value->userid;
                             $purchase->status ="purchased";
                             $purchase->save();
                       }
                       return response()->json(['success'=>'you have successfully purchased you goods']);
                      }

                      public function register(){
                        return view('register');
                      }


                      public function registerx(register $request){
                           User::create([
                            'name'=>$request->name,
                            'email'=>$request->email,
                            'type'=>'user',
                            'status'=>0,
                            'password'=>Hash::make($request->password)
                           ]);
                           event(new emailevent($request->name, $request->email));
                           return response()->json(['success'=>"you have successfully registered"]);
                      }

                      public function signin(){

                        return view('signin');
                      }

                      public function signinx(signinreq $request){
                        //
                        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password, 'status'=>1])){
                            Session::put('userdetail', auth()->user());
                           return response()->json([
                               'code'=>200,
                               'success'=>'you have logged in successfully',
                           ]);
                          }else{
                           return response()->json(['error'=>'please insert the correct password or email']);
                         }

                      }

                      public function admin(){
                        return view('admin');
                      }

                      public function adminx(Request $request){
                        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password, 'type'=>'admin'])){
                            Session::put('userdetail', auth()->user());
                           return response()->json([
                               'code'=>200,
                               'success'=>'you have logged in successfully',
                           ]);
                          }else{
                           return response()->json(['error'=>'please insert the correct password or email']);
                         }

                      }

                    public function checkemail($name, $email){
                      $user =  User::where(['name'=>$name, 'email'=>$email])->first();
                      if($user && $user->status == 0){
                         $user->status = 1;
                         $user->save();
                         return view("email_verification", ["status"=>$user->status]);
                      }else{
                        return view("email_verification", ["status"=>$user->status]);
                      }
                    }


                    public function logout(){
                        auth()->logout();
                        Session::invalidate();
                        Session::flush();
                        return redirect()->route('home');
                    }


                    public function admindashbord(){
                        if(Gate::allows("check-admin", auth()->user())){
                         return view('admindashboard');
                        }else{
                         return abort('403');
                        }
                    }

                    public function allpurchase( $page){
                        if(Gate::allows("check-admin", auth()->user())){
                       $ans =  intval($page);
                        $purchases = Purchase::all();
                      $data = purchaseresource::collection($purchases)->resolve();
                      $pagdata =  $this->paginate($data, 10, $ans);
                      return response()->json(['success'=>$pagdata]);
                        }else{
                            return abort('403');
                           }
                    }

                    public function searchproduct($search){

                        $product =  Order::search($search)->get();
                        return response()->json(['success'=>$product]);
                    }

                    public function adminproducts(){
                        if(Gate::allows("check-admin", auth()->user())){
                            return view('adminproduct');
                           }else{
                            return abort('403');
                           }
                    }

                    public function allproduct( $page){
                        if(Gate::allows("check-admin", auth()->user())){
                        $ans =  intval($page);
                         $order = Order::all()->toArray();
                       $pagdata =  $this->paginate($order, 10, $ans);
                       return response()->json(['success'=>$pagdata]);
                        }else{
                            return abort('403');
                           }
                     }


                     public function updatestatus(Request $request){
                        if(Gate::allows("check-admin", auth()->user())){
                            $id = intval($request->id);
                            $purchase = Purchase::find($id);
                            if($purchase){
                               $purchase->status = $request->status;
                               $purchase->save();
                               $purchases = Purchase::all();
                               $data = purchaseresource::collection($purchases)->resolve();
                               $pagdata =  $this->paginate($data, 10, 1);
                               return response()->json(['success'=>$pagdata]);
                            }
                        }else{
                            return abort('403');
                           }


                     }




}
