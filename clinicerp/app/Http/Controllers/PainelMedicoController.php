<?php
namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Anamnese;
use App\Models\Exame;
use App\Models\ExameSolicitado;
use App\Models\Medico;
use App\Models\Prescricao;
use App\Models\Prontuario;
use App\Services\Hl7MllpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PainelMedicoController extends Controller
{
    private function medicoLogado(): Medico { return Medico::where('user_id', auth()->id())->firstOrFail(); }

    public function index(): View {
        $medico = $this->medicoLogado();
        $agendamentos = Agendamento::with('paciente')->where('medico_id', $medico->id)->orderBy('data_hora')->get();
        $exames = Exame::orderBy('descricao')->get();
        $solicitacoes = ExameSolicitado::where('medico_id', $medico->id)->latest()->get();
        return view('medico.painel', compact('medico','agendamentos','exames','solicitacoes'));
    }

    public function salvarProntuario(Request $request): RedirectResponse {
        $medico = $this->medicoLogado();
        $data = $request->validate(['agendamento_id'=>'required|exists:agendamentos,id','queixa_principal'=>'required','historico'=>'nullable','sinais_vitais'=>'nullable','diagnostico'=>'nullable','conduta'=>'nullable','observacoes'=>'nullable']);
        $data['medico_id'] = $medico->id;
        Prontuario::updateOrCreate(['agendamento_id'=>$data['agendamento_id']], $data);
        return back()->with('status','Prontuário salvo.');
    }

    public function salvarAnamnesePrescricao(Request $request): RedirectResponse {
        $medico = $this->medicoLogado();
        $data = $request->validate(['agendamento_id'=>'required|exists:agendamentos,id','dados'=>'required','medicamentos'=>'required']);
        Anamnese::updateOrCreate(['agendamento_id'=>$data['agendamento_id']], ['medico_id'=>$medico->id, 'dados'=>$data['dados']]);
        Prescricao::updateOrCreate(['agendamento_id'=>$data['agendamento_id']], ['medico_id'=>$medico->id, 'medicamentos'=>$data['medicamentos']]);
        return back()->with('status','Anamnese e prescrição salvas.');
    }

    public function solicitarExame(Request $request, Hl7MllpService $hl7): RedirectResponse {
        $medico = $this->medicoLogado();
        $data = $request->validate(['agendamento_id'=>'required|exists:agendamentos,id','exame_id'=>'required|exists:exames,id','agendado_para'=>'required|date']);
        $ag = Agendamento::with('paciente')->findOrFail($data['agendamento_id']);
        $exame = Exame::findOrFail($data['exame_id']);
        $pedido = 'PED'.now()->format('YmdHis');
        $hl7Message = "MSH|^~\\&|MEU_ERP|CLINICA|DCM4CHEE|PACS|".now()->format('YmdHis')."||ORM^O01|{$pedido}|P|2.5\n".
            "PID|||{$ag->paciente->id}||".strtoupper(str_replace(' ','^',$ag->paciente->nome))."\nPV1||O\nORC|NW|{$pedido}\n".
            "OBR|1|{$pedido}||{$exame->codigo}^{$exame->descricao}|||".date('YmdHi', strtotime($data['agendado_para']));

        $ack = '';
        try { $ack = $hl7->sendOrm(env('DCM4CHEE_HOST','localhost'), (int) env('DCM4CHEE_HL7_PORT',2575), $hl7Message); } catch (\Throwable $e) { $ack = $e->getMessage(); }

        ExameSolicitado::create(['agendamento_id'=>$ag->id,'medico_id'=>$medico->id,'paciente_id'=>$ag->paciente_id,'exame_id'=>$exame->id,'numero_pedido'=>$pedido,'agendado_para'=>$data['agendado_para'],'status'=>'aguardando resultado','hl7_ack'=>$ack]);
        return back()->with('status','Exame solicitado ao DCM4CHEE.');
    }
}
