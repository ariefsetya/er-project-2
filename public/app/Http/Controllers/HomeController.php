<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PollingQuestion;
use App\PollingResponse;
use App\PollingAnswer;
use App\PollingParticipant;
use App\Polling;
use App\Product;
use App\Presence;
use App\ProductResponse;
use App\Event;
use Auth;
use App\Mail\sendBarcode;
use DB;
use PDF;
use File;
use Validator;
use Mail;
use Session;
use App\Exports\ProductExport;
use App\Exports\QuizExport;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }
    public function polling_question($id)
    {
        $data['polling_question'] = PollingQuestion::where('event_id',Session::get('event_id'))->where('polling_id',$id)->get();
        return response()->json($data);
    }
    public function quiz_report($id)
    {
        $data['polling'] = Polling::where('event_id',Session::get('event_id'))->whereId($id)->first();
        $data['polling_participant'] = PollingParticipant::with(['invitation'])->where('event_id',Session::get('event_id'))->where('polling_id',$id)->get();
        // dd($data);
        return view('quiz_response.report')->with($data);
    }
    public function quiz_export_excel($id)
    {
        $polling = Polling::whereId($id)->first();
        $exporter = app()->makeWith(QuizExport::class, compact('id')); 
        return Excel::download($exporter,'laporan_polling_'.$polling->name.'.xlsx');
    }
    public function quiz_result($id)
    {
        $data['polling'] = Polling::where('event_id',Session::get('event_id'))->whereId($id)->first();
        return view('quiz_response.result')->with($data);
    }
    public function quiz_result_data($id)
    {
        $data['polling'] = Polling::whereId($id)->first();
        $data['polling_participant'] = PollingParticipant::with(['invitation'])->where('event_id',Session::get('event_id'))->where('polling_id',$id)->where('is_winner',1)->orderBy('id','asc')->get();

        return response()->json($data,200);
    }
    public function quiz_join($id)
    {
        $data['polling'] = Polling::where('event_id',Session::get('event_id'))->whereId($id)->first();
        return view('quiz_response.join')->with($data);
    }
    public function join_quiz(Request $r, $id)
    {
        $messages = [
            'name.required' => 'Nama harus diisi',
            'company.required' => 'Nama Dealer harus diisi',
        ];
        Validator::make($r->all(), [
            'name' => 'required',
            'company' => 'required'
        ],$messages)->validate();

        $user = \App\User::create(['event_id'=>Session::get('event_id'),'name'=>$r->input('name'), 'company'=>$r->input('company')]);
        Auth::loginUsingId($user->id);

        return redirect()->route('quiz_response',[$id]);
    }
    public function polling_response($id)
    {
        $data['polling'] = Polling::where('event_id',Session::get('event_id'))->whereId($id)->first();
        $data['polling_question'] = PollingQuestion::where('event_id',Session::get('event_id'))->where('polling_id',$id)->paginate(1);
        if(isset($data['polling_question'][0])){
        $data['polling_answer'] = PollingAnswer::where('event_id',Session::get('event_id'))->where('polling_question_id',$data['polling_question'][0]->id)->get();

            return view('polling_response.index')->with($data);
        }else{
            abort(404);
        }
    }
    public function screen()
    {
        $data['polling'] = Polling::where('event_id',Session::get('event_id'))->get();
        $arr = [];
        foreach ($data['polling'] as $key) {
            $arr[] = [
                'polling'=>$key,
                'question'=>PollingQuestion::where('event_id',Session::get('event_id'))->where('polling_id',$key->id)->get()
            ];
        }
        $data['result'] = $arr;
        return view('screen.index')->with($data);
    }
    public function quiz_response($id)
    {
        $data['polling'] = Polling::where('event_id',Session::get('event_id'))->whereId($id)->first();
        $data['polling_question'] = PollingQuestion::where('event_id',Session::get('event_id'))->where('polling_id',$id)->paginate(1);
        $data['polling_answer'] = PollingAnswer::where('event_id',Session::get('event_id'))->where('polling_question_id',$data['polling_question'][0]->id)->get();

        return view('quiz_response.index')->with($data);
    }
    public function admin()
    {
        return view('admin');
    }
    public function check_winner($polling_id = 0, $invitation_id = 0)
    {
        if($invitation_id > 0){
            $answer = PollingResponse::where('event_id',Session::get('event_id'))->where('invitation_id',$invitation_id)->where('polling_id',$polling_id)->count();
            $correct = PollingResponse::where('event_id',Session::get('event_id'))->where('is_winner',1)->where('invitation_id',$invitation_id)->where('polling_id',$polling_id)->count();
            $polques = PollingQuestion::where('event_id',Session::get('event_id'))->where('polling_id',$polling_id)->count();
            if($answer==$polques){
                if($correct==$polques){
                    PollingParticipant::create([
                        'event_id'=>Session::get('event_id'),
                        'invitation_id'=>$invitation_id,
                        'polling_id'=>$polling_id,
                        'is_winner'=>1
                    ]);

                    return true;
                }else{
                    PollingParticipant::create([
                        'event_id'=>Session::get('event_id'),
                        'invitation_id'=>$invitation_id,
                        'polling_id'=>$polling_id,
                        'is_winner'=>0
                    ]);
                    return false;
                }
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
            $polling_id = PollingQuestion::where('event_id',Session::get('event_id'))->whereId($polling_question_id)->first()->polling_id;
            if(PollingResponse::where('event_id',Session::get('event_id'))->where('polling_question_id',$polling_question_id)->where('polling_id',$polling_id)->where('uuid',\Session::get('uuid'))->exists()){
                $id = PollingResponse::where('event_id',Session::get('event_id'))->where('polling_question_id',$polling_question_id)->where('polling_id',$polling_id)->where('uuid',\Session::get('uuid'))->first()->id;
                $data = PollingResponse::where('event_id',Session::get('event_id'))->whereId($id)->first();
                $data->polling_answer_id = $polling_answer_id;
                $data->answer_text = PollingAnswer::where('event_id',Session::get('event_id'))->whereId($polling_answer_id)->first()->content;
                $data->save();

                \Session::put('polling_'.$polling_id,true);

                return response()->json(['message'=>'saved!'],200);
            }else{
                $data = new PollingResponse;
                $data->event_id = Session::get('event_id');
                $data->polling_id = $polling_id;
                $data->uuid = \Session::get('uuid');
                $data->polling_question_id = $polling_question_id;
                $data->polling_answer_id = $polling_answer_id;
                $data->answer_text = PollingAnswer::where('event_id',Session::get('event_id'))->whereId($polling_answer_id)->first()->content;
                $data->save();

                \Session::put('polling_'.$polling_id,true);

                return response()->json(['message'=>'saved!'],200);
            }
        }
    }
    public function select_quiz_response($polling_question_id = 0, $polling_answer_id = 0)
    {
        if($polling_question_id > 0 and $polling_answer_id > 0){
            if(PollingParticipant::where('event_id',Session::get('event_id'))->where('polling_id',PollingQuestion::where('event_id',Session::get('event_id'))->whereId($polling_question_id)->first()->polling_id)
                ->where('invitation_id',Auth::user()->id)->exists()){
                return response()->json(['message'=>'saved!','win'=>false],200);
            }else{ 
                if(PollingResponse::where('event_id',Session::get('event_id'))->where('polling_question_id',$polling_question_id)->where('polling_id',PollingQuestion::where('event_id',Session::get('event_id'))->whereId($polling_question_id)->first()->polling_id)->where('invitation_id',Auth::user()->id)->exists()){
                    $id = PollingResponse::where('event_id',Session::get('event_id'))->where('polling_question_id',$polling_question_id)->where('polling_id',PollingQuestion::where('event_id',Session::get('event_id'))->whereId($polling_question_id)->first()->polling_id)->where('invitation_id',Auth::user()->id)->first()->id;
                    $data = PollingResponse::where('event_id',Session::get('event_id'))->whereId($id)->first();
                    $data->polling_answer_id = $polling_answer_id;
                    $data->answer_text = PollingAnswer::where('event_id',Session::get('event_id'))->whereId($polling_answer_id)->first()->content;
                    $data->save();
                    
                    if(PollingAnswer::where('event_id',Session::get('event_id'))->where('is_correct',1)->where('polling_question_id',$polling_question_id)->first()->id==$polling_answer_id){
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
                    $data->event_id = Session::get('event_id');
                    $data->polling_id = PollingQuestion::whereId($polling_question_id)->first()->polling_id;
                    $data->invitation_id = Auth::user()->id;
                    $data->polling_question_id = $polling_question_id;
                    $data->polling_answer_id = $polling_answer_id;
                    $data->answer_text = PollingAnswer::whereId($polling_answer_id)->first()->content;
                    $data->save();
                    
                    if(PollingAnswer::where('event_id',Session::get('event_id'))->where('is_correct',1)->where('polling_question_id',$polling_question_id)->first()->id==$polling_answer_id){
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
    public function product_report()
    {
        $data['summary'] = Product::all();

        return view('product.report')->with($data);
    }
    public function product_chart($id)
    {
        $data['summary'] = ProductResponse::select(DB::raw('product_id, coalesce(sum(case when response_id=1 then 1 end),0) as yes,coalesce(sum(case when response_id=0 then 1 end),0) as no'))->with(['product'])->groupBy('product_id')->where('product_id',$id)->first();

        return view('product.chart')->with($data);
    }
    public function product_export_excel()
    {
        return Excel::download(new ProductExport, 'laporan_produk.xlsx');
    }
    public function downloadBarcode()
    {

        File::makeDirectory(public_path('/pdf/'.Session::get('event_id').'/'), $mode = 0777, true, true);
        $pdf = PDF::loadView('print_pdf',['status'=>'print'])->setPaper([0,0,360,640], 'potrait');

        $pdf->save(public_path('/pdf/'.Session::get('event_id').'/'.Auth::user()->name.'.pdf'));

        $img = new \Spatie\PdfToImage\Pdf(public_path('/pdf/'.Session::get('event_id').'/'.Auth::user()->name.'.pdf'));
        $img->saveImage(public_path('/pdf/'.Session::get('event_id').'/'.Auth::user()->name.'.jpg'));

        return response()->download(public_path('/pdf/'.Session::get('event_id').'/'.Auth::user()->name.'.jpg'));
    }
    public function sendEmailBarcode()
    {
        File::makeDirectory(public_path('/pdf/'.Session::get('event_id').'/'), $mode = 0777, true, true);
        $pdf = PDF::loadView('print_pdf',['status'=>'print'])->setPaper([0,0,360,640], 'potrait');
        $pdf->save(public_path('/pdf/'.Session::get('event_id').'/'.Auth::user()->name.'.pdf'));
        Mail::to(Auth::user()->email)->send(new sendBarcode());
        return redirect()->route('home')->with('success','sent');
    }
}
