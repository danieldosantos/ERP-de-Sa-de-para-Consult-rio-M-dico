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
use Illuminate\Http\JsonResponse;

class PainelMedicoController extends Controller
{
    private function medicoLogado(): Medico { return Medico::where('user_id', auth()->id())->firstOrFail(); }

    public function index(): View {
        $medico = $this->medicoLogado();
        $agendamentos = Agendamento::with('paciente')->where('medico_id', $medico->id)->orderBy('data_hora')->get();
        if (Exame::count() === 0) {
            (new \Database\Seeders\ExameSeeder())->run();
        }

        $exames = Exame::orderBy('descricao')->get();
        $solicitacoes = ExameSolicitado::where('medico_id', $medico->id)->latest()->get();
        return view('medico.painel', compact('medico','agendamentos','exames','solicitacoes'));
    }

    public function salvarProntuario(Request $request): RedirectResponse|JsonResponse {
        $medico = $this->medicoLogado();
        $data = $request->validate(['agendamento_id'=>'required|exists:agendamentos,id','queixa_principal'=>'required','historico'=>'nullable','sinais_vitais'=>'nullable','diagnostico'=>'nullable','conduta'=>'nullable','observacoes'=>'nullable']);
        $data['medico_id'] = $medico->id;
        Prontuario::updateOrCreate(['agendamento_id'=>$data['agendamento_id']], $data);
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Prontuário salvo.']);
        }

        return back()->with('status','Prontuário salvo.');
    }

    public function salvarAnamnesePrescricao(Request $request): RedirectResponse|JsonResponse {
        $medico = $this->medicoLogado();
        $data = $request->validate(['agendamento_id'=>'required|exists:agendamentos,id','dados'=>'required','medicamentos'=>'required']);
        Anamnese::updateOrCreate(['agendamento_id'=>$data['agendamento_id']], ['medico_id'=>$medico->id, 'dados'=>$data['dados']]);
        Prescricao::updateOrCreate(['agendamento_id'=>$data['agendamento_id']], ['medico_id'=>$medico->id, 'medicamentos'=>$data['medicamentos']]);
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Anamnese e prescrição salvas.']);
        }

        return back()->with('status','Anamnese e prescrição salvas.');
    }

    public function solicitarExame(Request $request, Hl7MllpService $hl7): RedirectResponse|JsonResponse {
        $medico = $this->medicoLogado();
        $data = $request->validate([
            'agendamento_id'=>'required|exists:agendamentos,id',
            'exame_ids'=>'required|array|min:1',
            'exame_ids.*'=>'required|exists:exames,id',
            'agendado_para'=>'required|date'
        ]);
        $ag = Agendamento::with('paciente')->findOrFail($data['agendamento_id']);
        $exames = Exame::whereIn('id', $data['exame_ids'])->get()->keyBy('id');

        foreach ($data['exame_ids'] as $index => $exameId) {
            $exame = $exames[$exameId];
            $pedido = 'PED'.now()->format('YmdHis').str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT);
            $accession = 'ACC'.now()->format('YmdHis').str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT);
            $stationAeTitle = env('DCM4CHEE_STATION_AE_TITLE', 'SCHEDULEDSTATION');
            $modality = $exame->modalidade ?: env('DCM4CHEE_MODALITY_DEFAULT', 'CR');
            $scheduledDateTime = date('YmdHi', strtotime($data['agendado_para']));

            $hl7Message = "MSH|^~\\&|ERP|CLINICA|DCM4CHEE|PACS|".now()->format('YmdHis')."||ORM^O01|{$pedido}|P|2.5\r".
                "PID|||{$ag->paciente->id}||".strtoupper(str_replace(' ','^',$ag->paciente->nome))."\r".
                "PV1||O\r".
                "ORC|NW|{$pedido}|||SC|||||||||||||{$stationAeTitle}\r".
                "OBR|1|{$pedido}|{$accession}|{$exame->codigo}^{$exame->descricao}^L|||{$scheduledDateTime}|||||||||||{$accession}||||||{$modality}";

            $ack = '';
            try { $ack = $hl7->sendOrm(env('DCM4CHEE_HOST','localhost'), (int) env('DCM4CHEE_HL7_PORT',2575), $hl7Message); } catch (\Throwable $e) { $ack = $e->getMessage(); }

            ExameSolicitado::create(['agendamento_id'=>$ag->id,'medico_id'=>$medico->id,'paciente_id'=>$ag->paciente_id,'exame_id'=>$exame->id,'numero_pedido'=>$pedido,'agendado_para'=>$data['agendado_para'],'status'=>'aguardando resultado','hl7_ack'=>$ack]);
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Exame(s) solicitado(s) ao DCM4CHEE.']);
        }

        return back()->with('status','Exame(s) solicitado(s) ao DCM4CHEE.');
    }
}
