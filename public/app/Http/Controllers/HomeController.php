<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PollingQuestion;
use App\PollingResponse;
use App\PollingAnswer;
use App\Polling;
use App\Product;
use App\ProductResponse;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
    public function quiz_result()
    {
        return view('quiz_response.result');
    }
    public function quiz_join($id)
    {
        return view('quiz_response.join')->with(['id'=>$id]);
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

                return response()->json(['message'=>'saved!','win'=>true,'response'=>$data,'user'=>Auth::user()],200);
            }else{
                $data = new PollingResponse;
                $data->event_id = 1;
                $data->polling_id = PollingQuestion::find($polling_question_id)->polling_id;
                $data->invitation_id = Auth::user()->id;
                $data->polling_question_id = $polling_question_id;
                $data->polling_answer_id = $polling_answer_id;
                $data->answer_text = PollingAnswer::find($polling_answer_id)->content;
                $data->save();

                $data->created_at = date("H:i:s",strtotime($data->created_at));

                return response()->json(['message'=>'saved!','win'=>true,'response'=>$data,'user'=>Auth::user()],200);
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
