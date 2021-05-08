<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reserva;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Response;
use App\Mail\ReservacionEmail;
use App\Http\Resources\Reserva as ReservaResource;
use App\Jobs\SendEmailJob;
use Log;

class ReservaController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ReservaResource::collection(Reserva::all());
    }

    public function reservasBySala($id_sala,$mes){
        return ReservaResource::collection(Reserva::where('sala_id',$id_sala)->whereMonth('fecha', '=', $mes)->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $reservado = $this->horarioReservado($request);
        if($reservado){
            return response(['status'=>0,'message'=>'Reserva ocupada'])->setStatusCode(Response::HTTP_ACCEPTED);
        }else{
            $reserva = new Reserva;
            $reserva->fecha = $request->fecha;
            $reserva->hora_inicio = $request->hora_inicio;
            $reserva->hora_fin = $request->hora_fin;
            $reserva->motivo = $request->motivo;
            $reserva->sala_id = $request->sala_id;
            $reserva->user_id = $request->user_id;
            $reserva->save();
            if($reserva){
                //$email_enviado = $this->enviarNotificacion($reserva);
                return (new ReservaResource($reserva))->response()->setStatusCode(Response::HTTP_CREATED); 
            }
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $destroy = Reserva::destroy($id);
        if ($destroy){
            $data=[
                'status'=>'1',
                'msg'=>'success'
            ];
        
        }else{
        
            $data=[
                'status'=>'0',
                'msg'=>'fail'
            ];
        
        }

        return response()->json($data, 200); 

    }

    public function enviarNotificacion($reserva){
        /* $when = now()->addMinutes(1);
        Mail::to("mchoque@coboser.com")->later($when,new ReservacionEmail());
        dump('procesando');
        return 'Mensaje enviado'; */
        $email = new ReservacionEmail($reserva);
        //Log::info("Request cycle without Queues started");
        //$this->dispatch(new SendEmailJob());
        Mail::to(["fede.eer8@gmail.com","fede.eer8@gmail.com"])->send($email);
        //Log::info("Request cycle without Queues finished");
        if (Mail::failures()) {
            return false;
        }
        return true;
    }

    private function horarioReservado($request){
        $reservado = false;
        $reserva_inicial = Reserva::where('fecha',$request->fecha)
        ->where('sala_id',$request->sala_id)
        ->where('hora_inicio','<=',$request->hora_inicio)
        ->where('hora_fin','>=',$request->hora_inicio)
        ->count();
        if($reserva_inicial > 0){
            $reservado = true;
        }

        $reserva_final = Reserva::where('fecha',$request->fecha)
        ->where('sala_id',$request->sala_id)
        ->where('hora_inicio','<=',$request->hora_fin)
        ->where('hora_fin','>=',$request->hora_fin)
        ->count();
        if($reserva_final > 0){
            $reservado = true;
        }

        $reserva_inicial_final = Reserva::where('fecha',$request->fecha)
        ->where('sala_id',$request->sala_id)
        ->where('hora_inicio','>=',$request->hora_inicio)
        ->where('hora_fin','<=',$request->hora_fin)
        ->count();
        if($reserva_inicial_final > 0){
            $reservado = true;
        }

        return $reservado;

    }
}
