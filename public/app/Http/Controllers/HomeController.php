<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PollingQuestion;
use App\PollingResponse;
use App\PollingAnswer;
use App\PollingParticipant;
use App\Polling;
use App\Product;
use App\ProductResponse;
use Auth;
use Validator;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
    public function quiz_result($id)
    {
        $data['polling'] = \App\Polling::find($id);
        return view('quiz_response.result')->with($data);;
    }
    public function quiz_join($id)
    {
        $data['polling'] = \App\Polling::find($id);
        return view('quiz_response.join')->with($data);
    }
    public function join_quiz(Request $r, $id)
    {
        $messages = [
            'name.required' => 'Nama harus diisi',
            'name.min' => 'Nama minimal :min karakter',
            'company.required' => 'Nama Dealer harus diisi',
            'company.min' => 'Nama Dealer minimal :min karakter',
        ];
        Validator::make($r->all(), [
            'name' => 'required|min:3',
            'company' => 'required|min:3'
        ],$messages)->validate();

        $user = \App\User::create(['name'=>$r->input('name'), 'company'=>$r->input('company')]);
        Auth::loginUsingId($user->id);

        return redirect()->route('quiz_response',[$id]);
    }
    public function polling_response($id)
    {
        $data['polling'] = \App\Polling::find($id);
        $data['polling_question'] = \App\PollingQuestion::where('polling_id',$id)->paginate(1);
        $data['polling_answer'] = \App\PollingAnswer::where('polling_question_id',$data['polling_question'][0]->id)->get();

        return view('polling_response.index')->with($data);
    }
    public function quiz_response($id)
    {
        $data['polling'] = \App\Polling::find($id);
        $data['polling_question'] = \App\PollingQuestion::where('polling_id',$id)->paginate(1);
        $data['polling_answer'] = \App\PollingAnswer::where('polling_question_id',$data['polling_question'][0]->id)->get();

        return view('quiz_response.index')->with($data);
    }
    public function admin()
    {
        return view('admin');
    }
    public function set_winner($response_id = 0, $invitation_id = 0)
    {
        if($response_id > 0 and $invitation_id > 0){
            $polres = PollingResponse::find($response_id);
            $polques = PollingQuestion::where('polling_id',$pol->polling_id)->count();
            if($polres->invitation_id==$invitation_id){
                
                $correct = 0;
                if(PollingResponse::where('invitation_id',$invitation_id)->count()==$polques){
                    foreach (PollingQuestion::where('polling_id',$pol->polling_id)->get() as $key) {
                        if(PollingResponse::where('question_id',$key->id)->where('invitation_id',$invitation_id)->first()->answer_id==PollingAnswer::where('question_id',$key->id)->where('is_correct',1)->first()->id){
                            $correct++;
                        }else{
                            return response()->json(['message'=>'saved!','win'=>false],200);
                        }
                    }
                }else{
                    return response()->json(['message'=>'saved!','win'=>false],200);
                }

                if($correct==$polques){
                    return response()->json(['message'=>'saved!','win'=>true],200);
                }
                
            }else{
                return response()->json(['message'=>'invitation not match','win'=>false],422);
            }
        }
    }
    public function check_winner($polling_id = 0, $invitation_id = 0)
    {
        if($invitation_id > 0){
            $answer = PollingResponse::where('invitation_id',$invitation_id)->where('polling_id',$polling_id)->count();
            $correct = PollingResponse::where('is_winner',1)->where('invitation_id',$invitation_id)->where('polling_id',$polling_id)->count();
            $polques = PollingQuestion::where('polling_id',$polling_id)->count();
            if($correct==$polques){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public function select_polling_response($polling_question_id = 0, $polling_answer_id = 0)
    {
        if($polling_question_id > 0 and $polling_answer_id > 0){
            if(PollingResponse::where('polling_question_id',$polling_question_id)->where('polling_id',PollingQuestion::find($polling_question_id)->polling_id)->where('uuid',\Session::get('uuid'))->exists()){
                $id = PollingResponse::where('polling_question_id',$polling_question_id)->where('polling_id',PollingQuestion::find($polling_question_id)->polling_id)->where('uuid',\Session::get('uuid'))->first()->id;
                $data = PollingResponse::find($id);
                $data->polling_answer_id = $polling_answer_id;
                $data->answer_text = PollingAnswer::find($polling_answer_id)->content;
                $data->save();

                return response()->json(['message'=>'saved!'],200);
            }else{
                $data = new PollingResponse;
                $data->event_id = 1;
                $data->polling_id = PollingQuestion::find($polling_question_id)->polling_id;
                $data->uuid = \Session::get('uuid');
                $data->polling_question_id = $polling_question_id;
                $data->polling_answer_id = $polling_answer_id;
                $data->answer_text = PollingAnswer::find($polling_answer_id)->content;
                $data->save();

                return response()->json(['message'=>'saved!'],200);
            }
        }
    }
    public function select_quiz_response($polling_question_id = 0, $polling_answer_id = 0)
    {
        if($polling_question_id > 0 and $polling_answer_id > 0){
            if(PollingResponse::where('polling_question_id',$polling_question_id)->where('polling_id',PollingQuestion::find($polling_question_id)->polling_id)->where('invitation_id',Auth::user()->id)->exists()){
                $id = PollingResponse::where('polling_question_id',$polling_question_id)->where('polling_id',PollingQuestion::find($polling_question_id)->polling_id)->where('invitation_id',Auth::user()->id)->first()->id;
                $data = PollingResponse::find($id);
                $data->polling_answer_id = $polling_answer_id;
                $data->answer_text = PollingAnswer::find($polling_answer_id)->content;
                $data->save();
                
                if(PollingAnswer::where('is_correct',1)->where('polling_question_id',$polling_question_id)->first()->id==$polling_answer_id){
                    $data->is_winner = 1;
                    $data->save();
                }
                
                if($this->check_winner($data->polling_id, Auth::user()->id)){
                    return response()->json(['message'=>'saved!','win'=>true,'data'=>$data,'user'=>Auth::user()],200);
                }else{
                    return response()->json(['message'=>'saved!','win'=>false],200);
                }
            }else{
                $data = new PollingResponse;
                $data->event_id = 1;
                $data->polling_id = PollingQuestion::find($polling_question_id)->polling_id;
                $data->invitation_id = Auth::user()->id;
                $data->polling_question_id = $polling_question_id;
                $data->polling_answer_id = $polling_answer_id;
                $data->answer_text = PollingAnswer::find($polling_answer_id)->content;
                $data->save();
                
                if(PollingAnswer::where('is_correct',1)->where('polling_question_id',$polling_question_id)->first()->id==$polling_answer_id){
                    $data->is_winner = 1;
                    $data->save();
                }

                if($this->check_winner($data->polling_id, Auth::user()->id)){
                    return response()->json(['message'=>'saved!','win'=>true,'data'=>$data,'user'=>Auth::user()],200);
                }else{
                    return response()->json(['message'=>'saved!','win'=>false],200);
                }
            }
        }
    }
    public function response_product($code = "", $response = "")
    {
        if($code !="" and $response != ""){
            if(Product::where('code',$code)->exists()){
                $pro = Product::where('code',$code)->first();

                $data = new ProductResponse;
                $data->product_id = $pro->id;
                $data->response_id = $response;
                $data->save();

                \Session::put($code,$response);
                
                return response()->json(['message'=>'saved!'],200);
            }else{
                return response()->json(['message'=>'product does not exists!'],200);
            }

        }
    }
}
