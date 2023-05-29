<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;
use Carbon\Carbon;

class DatabaseQueries
{
  public function userLoggin($username, $password)
  {
    return DB::connection('os')
      ->table('InovaSistemas_Usuario')
      ->select('UsuarioID as id', 'UsuarioNome as name')
      ->where('UsuarioLogin', '=', $username)
      ->where('UsuarioSenha', '=', $password)
      ->get();
  }

  public function searchStoresForActivation($search, $order)
  {
    $search = (!$search) ? '' : $search;

    switch ($order) {
      case 'prioridade':
        $order = "EmpresaPrioridade";
        break;
      case 'vencimento':
        $order = 'ValidacaoDataProximaPromocao';
        break;
      default:
        $order = 'EmpresaNomeFantasia';
        break;
    }

    return DB::connection('admin')
      ->table('InovaAutomacao_PlanoValidacaoPagamento')
      ->join('InovaAutomacao_Plano', 'InovaAutomacao_PlanoValidacaoPagamento.PlanoID', '=', 'InovaAutomacao_Plano.PlanoID')
      ->join('InovaAutomacao_PlanoDesconto', 'InovaAutomacao_PlanoValidacaoPagamento.PlanoDescontoID', '=', 'InovaAutomacao_PlanoDesconto.DescontoID')
      ->leftJoin('InovaAutomacao_PlanoValidacao', function (JoinClause $join) {
        $join->on('InovaAutomacao_PlanoValidacaoPagamento.EmpresaID', '=', 'InovaAutomacao_PlanoValidacao.EmpresaID')
          ->on('InovaAutomacao_PlanoValidacaoPagamento.PagamentoID', '=', 'InovaAutomacao_PlanoValidacao.PagamentoID');
      })
      ->join('InovaAutomacao_Empresa as a', 'InovaAutomacao_PlanoValidacaoPagamento.EmpresaID', '=', 'a.EmpresaID')
      ->select(
        'InovaAutomacao_PlanoValidacaoPagamento.EmpresaID as id',
        'EmpresaNomeFantasia as trade_name',
        'EmpresaCNPJ as document_number',
        'EmpresaPrioridade as priority',
        'ValidacaoDataProximaPromocao as validation_next_date_promotion',
        DB::raw('(select EstacaoSerieHD as serial from InovaAutomacao_EmpresaEstacao where InovaAutomacao_EmpresaEstacao.EmpresaID = a.EmpresaID limit 1) as serial')
      )
      ->where('EmpresaNomeFantasia', 'like', '%' . $search . '%')
      ->orWhere('EmpresaCNPJ', 'like', '%' . $search . '%')
      ->orderBy($order)
      ->get();
  }

  public function keyDetails($store)
  {
    return DB::connection('admin')
      ->table('InovaAutomacao_EmpresaEstacao')
      ->select('EmpresaID as id', 'EstacaoID as station_id', 'EstacaoDescricao as description', 'EstacaoSerieHD as serial', 'EstacaoFlagServidor as server')
      ->where('EstacaoFlagServidor', '=', '1')
      ->where('EmpresaID', '=', $store)
      ->get();
  }

  public function selectSerialNumberBySubscription($subscription_id)
  {
    return DB::connection('admin')
      ->table('InovaAutomacao_Empresa')
      ->join('InovaAutomacao_EmpresaEstacao', 'InovaAutomacao_EmpresaEstacao.EmpresaID', '=', 'InovaAutomacao_Empresa.EmpresaID')
      ->where('InovaAutomacao_Empresa.EmpresaPagarmeAssinatura', '=', $subscription_id)
      ->where('InovaAutomacao_EmpresaEstacao.EstacaoFlagServidor', '=', true)
      ->select('InovaAutomacao_EmpresaEstacao.EstacaoSerieHD as serial')
      ->limit(1)
      ->get();
  }

  public function countClientsEntry()
  {
    return DB::connection('admin')
      ->table('InovaAutomacao_Empresa as a')
      ->join('InovaAutomacao_PlanoValidacao as b', 'b.EmpresaID', '=', 'a.EmpresaID')
      ->where('b.ValidacaoData', '>', '2023-05-01 00:00:00')
      ->select(
        'b.ValidacaoData',
        DB::raw('count(*) as count'),
        DB::raw("(select count(*)
      from InovaAutomacao_Empresa
      inner join InovaAutomacao_PlanoValidacao on InovaAutomacao_PlanoValidacao.EmpresaID = InovaAutomacao_Empresa.EmpresaID
      where InovaAutomacao_PlanoValidacao.ValidacaoData < b.ValidacaoData)
      as sum")
      )
      ->groupBy('b.ValidacaoData')
      ->orderBy('b.ValidacaoData')
      ->get();
  }

  public function storeActivationDetails($id)
  {
    return DB::connection('admin')
      ->table('InovaAutomacao_PlanoValidacaoPagamento')
      ->join('InovaAutomacao_Plano', 'InovaAutomacao_PlanoValidacaoPagamento.PlanoID', '=', 'InovaAutomacao_Plano.PlanoID')
      ->join('InovaAutomacao_PlanoDesconto', 'InovaAutomacao_PlanoValidacaoPagamento.PlanoDescontoID', '=', 'InovaAutomacao_PlanoDesconto.DescontoID')
      ->leftJoin('InovaAutomacao_PlanoValidacao', function (JoinClause $join) {
        $join->on('InovaAutomacao_PlanoValidacaoPagamento.EmpresaID', '=', 'InovaAutomacao_PlanoValidacao.EmpresaID')
          ->on('InovaAutomacao_PlanoValidacaoPagamento.PagamentoID', '=', 'InovaAutomacao_PlanoValidacao.PagamentoID');
      })
      ->join('InovaAutomacao_Empresa', 'InovaAutomacao_PlanoValidacaoPagamento.EmpresaID', '=', 'InovaAutomacao_Empresa.EmpresaID')
      ->select(
        'InovaAutomacao_PlanoValidacaoPagamento.EmpresaID as id',
        'InovaAutomacao_PlanoValidacaoPagamento.PagamentoID as payment',
        'InovaAutomacao_PlanoValidacao.ValidacaoID as validation',
        'FuncionarioID',
        'PagamentoData',
        'InovaAutomacao_PlanoValidacaoPagamento.PlanoID',
        'PlanoDescontoID',
        'EmpresaPrioridade as priority',
        'PagamentoValor',
        'PagamentoCodPromo',
        'PagamentoPercentualDesconto',
        'PagamentoValorPago',
        'PagamentoStatus',
        'PagamentoDataRetorno',
        'PlanoDescricao',
        'DescontoDescricao',
        'ValidacaoData',
        'ValidacaoDataProxima',
        'ValidacaoDataProximaPromocao as next_date_validation',
        'EmpresaRamoAtividade as line_of_business',
        'EmpresaNomeFantasia as trade_name',
        'EmpresaCNPJ as document_number',
        'PagamentoTipo',
        'EmpresaPlano as plan',
        'EmpresaTipoPagto as cycle',
        'EmpresaValorPagto as amount',
        'EmpresaMesRenovacao1 as renew_1',
        'EmpresaMesRenovacao2 as renew_2',
        'EmpresaDataRenovacao as renew_date',
        'EmpresaPlanoPagarmeID as pagarme',
        'EmpresaPagarmeStatus as pagarme_status',
        'EmpresaPagarmeEmail as pagarme_email',
        'EmpresaPagarmeDocumento as pagarme_document',
      )
      ->where('InovaAutomacao_PlanoValidacaoPagamento.EmpresaID', '=', $id)
      ->get();
  }

  public function pagarmePlan($id)
  {
    return DB::connection('admin')
      ->table('InovaAutomacao_Planos')
      ->where('PlanoPagarmeID', '=', $id)
      ->select('PlanoDiasTeste as free_trial', 'PlanoValor as amount', 'PlanoCiclo as cycle')
      ->get();
  }

  public function lineOfBusiness()
  {
    return DB::connection('admin')
      ->table('InovaAutomacao_RamoAtividade')
      ->select('ramoid as id', 'ramodescricao as description')
      ->orderBy('ramodescricao')
      ->get();
  }

  public function linkedStores($document_number)
  {
    return DB::connection('os')
      ->table('ClientesInova')
      ->select('ClienteLojas as stores')
      ->whereRaw("REPLACE(REPLACE(REPLACE(ClienteCNPJ, '.', ''), '-', ''), '/', '') = REPLACE(REPLACE(REPLACE('$document_number', '.', ''), '-', ''), '/', '')")
      ->get();
  }

  public function linkedStore($id)
  {
    return DB::connection('admin')
      ->table('InovaAutomacao_Empresa')
      ->select('EmpresaID as id', 'EmpresaNomeFantasia as trade_name', 'EmpresaCNPJ as document_number')
      ->where('EmpresaID', '=', $id)
      ->get();
  }

  public function stations($id)
  {
    return DB::connection('admin')
      ->table('InovaAutomacao_EmpresaEstacao')
      ->select('EmpresaID as id', 'EstacaoID as station_id', 'EstacaoDescricao as description', 'EstacaoSerieHD as serial', 'EstacaoFlagServidor as server')
      ->where('EmpresaID', '=', $id)
      ->get();
  }

  public function getStation($store_id, $id)
  {
    return DB::connection('admin')
      ->table('InovaAutomacao_EmpresaEstacao')
      ->select('EmpresaID as id', 'EstacaoID as station_id', 'EstacaoDescricao as description', 'EstacaoSerieHD as serial', 'EstacaoFlagServidor as server')
      ->where('EmpresaID', '=', $store_id)
      ->where('EstacaoID', '=', $id)
      ->get();
  }

  public function nextPromotionalValidationDate($id, $validate_next_date_promotion)
  {
    return DB::connection('admin')
      ->table('InovaAutomacao_PlanoValidacao')
      ->where('EmpresaID', '=', $id)
      ->update(['ValidacaoDataProximaPromocao' => $validate_next_date_promotion]);
  }

  public function updateKeyDetailsStore($id, $trade_name, $document_number, $line_of_business, $plan, $cycle, $amount, $renew_1, $renew_2, $renew_day, $priority, $email, $document)
  {
    return DB::connection('admin')
      ->table('InovaAutomacao_Empresa')
      ->where('EmpresaID', '=', $id)
      ->update([
        'EmpresaNomeFantasia' => $trade_name,
        'EmpresaCNPJ' => $document_number,
        'EmpresaRamoAtividade' => $line_of_business,
        'EmpresaPlano' => $plan,
        'EmpresaTipoPagto' => $cycle,
        'EmpresaValorPagto' => $amount,
        'EmpresaMesRenovacao1' => ($renew_1) ? $renew_1 : null,
        'EmpresaMesRenovacao2' => ($renew_2) ? $renew_2 : null,
        'EmpresaDataRenovacao' => $renew_day,
        'EmpresaPrioridade' => $priority,
        'EmpresaPagarmeEmail' => $email,
        'EmpresaPagarmeDocumento' => $document
      ]);
  }

  public function createPlan($id, $document_number, $cycle, $amount, $free_trial)
  {
    return DB::connection('admin')
      ->table('InovaAutomacao_Planos')
      ->insert([
        'PlanoStatus' => true,
        'PlanoCiclo' => $cycle,
        'PlanoValor' => $amount,
        'PlanoNome' => $document_number . ' - R$ ' . $amount . ' - ' . $cycle,
        'PlanoDiasTeste' => $free_trial,
        'PlanoPagarMeID' => $id
      ]);
  }

  public function updateSubscription($id, $plan, $subscription, $status)
  {
    return DB::connection('admin')
      ->table('InovaAutomacao_Empresa')
      ->where('EmpresaID', '=', $id)
      ->update([
        'EmpresaPlanoPagarmeID' => $plan,
        'EmpresaPagarmeAssinatura' => $subscription,
        'EmpresaPagarmeStatus' => true
      ]);
  }

  public function cancelSubscription($id)
  {
    return DB::connection('admin')
      ->table('InovaAutomacao_Empresa')
      ->where('EmpresaID', '=', $id)
      ->update([
        'EmpresaPagarmeStatus' => false
      ]);
  }

  public function getSubscriptionByDocument($document)
  {
    return DB::connection('admin')
      ->table('InovaAutomacao_Empresa')
      ->join('InovaAutomacao_Planos', 'PlanoPagarMeID', '=', 'InovaAutomacao_Empresa.EmpresaPlanoPagarmeID')
      ->select(
        DB::raw('ifnull(EmpresaPagarmeAssinatura, 0) as subscription_id'),
        DB::raw('ifnull(EmpresaPagarmeStatus, 1) as subscription_status'),
        DB::raw('ifnull(PlanoCiclo, 1) as subscription_cycle'),
        DB::raw('ifnull(PlanoValor, 1) as subscription_amount')
      )
      ->where('EmpresaPagarmeDocumento', '=', $document)
      ->orWhere('EmpresaCNPJ', '=', $document)
      ->get();
  }

  public function getSubscription($id)
  {
    return DB::connection('admin')
      ->table('InovaAutomacao_Empresa')
      ->join('InovaAutomacao_Planos', 'PlanoPagarMeID', '=', 'InovaAutomacao_Empresa.EmpresaPlanoPagarmeID')
      ->select(
        DB::raw('ifnull(EmpresaPagarmeAssinatura, 0) as subscription_id'),
        DB::raw('ifnull(EmpresaPagarmeStatus, 1) as subscription_status'),
        DB::raw('ifnull(PlanoCiclo, 1) as subscription_cycle'),
        DB::raw('ifnull(PlanoValor, 1) as subscription_amount')
      )
      ->where('EmpresaID', '=', $id)
      ->get();
  }

  public function updatePriorityOS($document_number, $plan, $amount, $cycle, $priority)
  {
    switch ($cycle) {
      case 'Mensal':
        $cycle = 1;
        break;
      case 'Trimestral':
        $cycle = 3;
        break;
      case 'Semestral':
        $cycle = 6;
        break;
      default:
        $cycle = 12;
        break;
    }

    return DB::connection('os')
      ->table('ClientesInova')
      ->whereRaw("REPLACE(REPLACE(REPLACE(ClienteCNPJ, '.', ''), '-', ''), '/', '') = '$document_number'")
      ->update([
        'ClienteValorPlan' => $plan,
        'ClienteValor' => $amount,
        'ClienteValorCiclo' => $cycle,
        'ClientePrioridade' => $priority,
      ]);
  }

  public function createNewStation($store_id, $name, $serial, $server)
  {
    $server = ($server == 'true') ? 1 : 0;

    return DB::connection('admin')
      ->table('InovaAutomacao_EmpresaEstacao')
      ->insert([
        'EmpresaID' => $store_id,
        'EstacaoDescricao' => $name,
        'EstacaoSerieHD' => $serial,
        'EstacaoFlagServidor' => $server,
      ]);
  }

  public function updateStation($store_id, $name, $serial, $server, $station_id)
  {
    $server = ($server == 'true') ? 1 : 0;

    return DB::connection('admin')
      ->table('InovaAutomacao_EmpresaEstacao')
      ->where('EstacaoID', '=', $station_id)
      ->where('EmpresaID', '=', $store_id)
      ->update([
        'EstacaoDescricao' => $name,
        'EstacaoSerieHD' => $serial,
        'EstacaoFlagServidor' => $server,
      ]);
  }

  public function deleteStation($store_id, $station_id)
  {
    return DB::connection('admin')
      ->table('InovaAutomacao_EmpresaEstacao')
      ->where('EstacaoID', '=', $station_id)
      ->where('EmpresaID', '=', $store_id)
      ->delete();
  }

  public function createStore($params)
  {
    $current_date = Carbon::now();
    $current_date_validation = Carbon::createFromFormat('Y-m-d H:i:s', $current_date);
    //$current_date_validation_next_promotion = Carbon::createFromFormat('Y-m-d', $current_date);

    foreach ($params as $param) {
      DB::connection('admin')
        ->table('InovaAutomacao_Empresa')
        ->insert([
          'EmpresaNomeFantasia' => $param['trade_name'],
          'EmpresaRazaoSocial' => $param['trade_name'],
          'EmpresaCNPJ' => $param['document_number'],
          'EmpresaTelefone' => '',
          'EmpresaCelular' => '',
          'EmpresaEndereco' => '',
          'EmpresaNumero' => '0',
          'EmpresaBairro' => '',
          'EmpresaCidade' => '',
          'EmpresaUF' => 'SP',
          'EmpresaCep' => '',
          'EmpresaObs' => null,
          'EmpresaLogo' => '',
          'EmpresaEmail' => '',
          'EmpresaSite' => '',
          'EmpresaCNAE' => null,
          'EmpresaCCM' => null,
          'EmpresaCTR' => null,
          'EmpresaIE' => null,
          'EmpresaPlanoID' => '1',
          'EmpresaDropbox' => '',
          'EmpresaPlano' => $param['plan'],
          'EmpresaTipoPagto' => $param['cycle'],
          'EmpresaValorPagto' => $param['amount'],
          'EmpresaDataRenovacao' => $param['renew_day'],
          'EmpresaPrioridade' => $param['priority'],
          'EmpresaMesRenovacao1' => $param['renew_1'],
          'EmpresaMesRenovacao2' => $param['renew_2'],
          'EmpresaRamoAtividade' => $param['line_of_business']
        ]);

      $store = DB::connection('admin')
        ->table('InovaAutomacao_Empresa')
        ->select('EmpresaID as id')
        ->where('EmpresaNomeFantasia', '=', $param['trade_name'])
        ->where('EmpresaCNPJ', '=', $param['document_number'])
        ->get();

      DB::connection('admin')
        ->table('InovaAutomacao_PlanoValidacao')
        ->insert([
          'EmpresaID' => $store[0]->id,
          'PagamentoID' => '1',
          'ValidacaoID' => '1',
          'ValidacaoData' => $current_date_validation,
          'ValidacaoDataProxima' => explode(' ', $current_date_validation)[0],
          'ValidacaoDataProximaPromocao' => $param['due_date'],
          'ValidacaoUsuarioIDPromocao' => '1'
        ]);

      DB::connection('admin')
        ->table('InovaAutomacao_PlanoValidacaoPagamento')
        ->insert([
          'EmpresaID' => $store[0]->id,
          'PagamentoID' => '1',
          'FuncionarioID' => '1',
          'PlanoID' => '1',
          'PlanoDescontoID' => '1',
          'PagamentoValor' => '0.00',
          'PagamentoCodPromo' => 'DEGUSTACAO',
          'PagamentoPercentualDesconto' => '0.00',
          'PagamentoValorPago' => '0.00',
          'PagamentoStatus' => '2',
          'PagamentoStatusPagSeguro' => 'DEGUSTACAO',
          'PagamentoDataRetorno' => $current_date_validation,
          'PagamentoTipo' => 'DEGUSTACAO',
          'PagamentoDescontoConcedido' => '0.00'
        ]);
    }

    return true;
  }

  public function users()
  {
    return DB::connection('os')
      ->table('InovaSistemas_Usuario')
      ->where('UsuarioStatus', '=', true)
      ->where('UsuarioMaster', '=', false)
      ->select('UsuarioID as id', 'UsuarioNome as name')
      ->get();
  }

  public function user($id)
  {
    return DB::connection('os')
      ->table('InovaSistemas_Usuario')
      ->where('UsuarioStatus', '=', true)
      ->where('UsuarioMaster', '=', false)
      ->where('UsuarioID', '=', $id)
      ->select('UsuarioID as id', 'UsuarioNome as name')
      ->get();
  }

  public function vacations($search, $name)
  {
    return DB::connection('os')
      ->table('InovaAutomacao_ColaboradorFerias')
      ->where('ferias_observacao', 'like', '%' . $search . '%')
      ->where('ferias_colaborador', 'like', '%' . $name . '%')
      ->select(
        'ferias_id as id',
        'ferias_data_inicio as start_date',
        'ferias_data_fim as end_date',
        'ferias_colaborador as collaborator',
        'ferias_observacao as observations',
        'ferias_dias as days'
      )
      ->orderBy('ferias_data_inicio')
      ->get();
  }

  public function vacation($id)
  {
    return DB::connection('os')
      ->table('InovaAutomacao_ColaboradorFerias')
      ->where('ferias_id', '=', $id)
      ->select(
        'ferias_id as id',
        'ferias_data_inicio as start_date',
        'ferias_data_fim as end_date',
        'ferias_colaborador as collaborator',
        'ferias_observacao as observations',
        'ferias_dias as days'
      )
      ->get();
  }

  public function createVacation($params)
  {
    foreach ($params as $param) {
      return DB::connection('os')
        ->table('InovaAutomacao_ColaboradorFerias')
        ->insert([
          'ferias_colaborador' => $param['collaborator'],
          'ferias_data_inicio' => $param['start_date'] . ' 00:00:00',
          'ferias_data_fim' => $param['end_date'] . ' 23:59:59',
          'ferias_dias' => $param['days'],
          'ferias_observacao' => $param['observations']
        ]);
    }
  }

  public function updateVacation($params)
  {
    foreach ($params as $param) {
      return DB::connection('os')
        ->table('InovaAutomacao_ColaboradorFerias')
        ->where('ferias_id', '=', $param['id'])
        ->update([
          'ferias_colaborador' => $param['collaborator'],
          'ferias_data_inicio' => $param['start_date'] . ' 00:00:00',
          'ferias_data_fim' => $param['end_date'] . ' 23:59:59',
          'ferias_dias' => $param['days'],
          'ferias_observacao' => $param['observations']
        ]);
    }
  }

  public function deleteVacation($id)
  {
    return DB::connection('os')
      ->table('InovaAutomacao_ColaboradorFerias')
      ->where('ferias_id', '=', $id)
      ->delete();
  }

  public function getPunchedClock($id, $start_date, $end_date)
  {
    $start_date = dateFormatISO($start_date) . ' 00:00:00';
    $end_date = dateFormatISO($end_date) . ' 23:59:59';

    return DB::connection('os')
      ->table('controleponto')
      ->join('InovaSistemas_Usuario', 'UsuarioID', '=', 'controleusuario')
      ->where('controleusuario', '=', $id)
      ->whereBetween('controleinicio', [
        $start_date,
        $end_date
      ])
      ->select(
        'controle as id',
        'UsuarioNome as name',
        'controleinicio as start',
        'controleempresa as company',
        DB::raw('ifnull(controlefim, "") as end'),
      )
      ->orderByDesc('controle')
      ->get();
  }

  public function updatePunchedClock($id, $start_date, $end_date)
  {
    $current_date = Carbon::now();
    $current_date = Carbon::createFromFormat('Y-m-d H:i:s', $current_date);

    return DB::connection('os')
      ->table('controleponto')
      ->where('controle', '=', $id)
      ->update([
        'controleinicio' => $start_date,
        'controlefim' => $end_date,
        'controlealterado' => true,
        'controledataalterado' => $current_date
      ]);
  }

  public function selectStoresWithSubscription()
  {
    return DB::connection('admin')
      ->table('InovaAutomacao_Empresa')
      ->where('EmpresaPagarmeStatus', '=', true)
      ->select('EmpresaID as id', 'EmpresaPagarmeAssinatura as subscription_id', 'EmpresaCNPJ as document_number')
      ->get();
  }

  /*public function selectKeyAccess($document_number)
  {
    return DB::connection('key')
      ->table('chaveacesso')
      ->select('chaveiid as id')
      ->where('chavecnpj', '=', $document_number)
      ->get();
  }*/

  /*public function updateKeyAcess($id, $current_period_end)
  {
    return DB::connection('key')
      ->table('chaveacesso')
      ->where('chaveiid', '=', $id)
      ->where('chavedatavalidacao', '!=', $current_period_end)
      ->update([
        'chaverecebido' => false,
        'chavedatavalidacao' => $current_period_end
      ]);
  }*/

  public function updateSubscriptionStatus($subscription_id, $status)
  {
    return DB::connection('admin')
      ->table('InovaAutomacao_Empresa')
      ->where('EmpresaPagarmeAssinatura', '=', $subscription_id)
      ->update([
        'EmpresaPagarmeStatus' => $status
      ]);
  }

  public function selectSubscriptionEmail($subscription_id)
  {
    return DB::connection('admin')
      ->table('InovaAutomacao_Empresa')
      ->where('EmpresaPagarmeAssinatura', '=', $subscription_id)
      ->select('EmpresaPagarmeEmail as email', 'EmpresaCNPJ as document_number', 'EmpresaID as id')
      ->get();
  }

  public function insertPayload($text)
  {
    return DB::connection('admin')
      ->table('retorno')
      ->insert([
        'Payload' => $text
      ]);
  }

  public function selectClientStatus()
  {
    return DB::connection('os')
      ->table('InovaSistemas_StatusCliente')
      ->select('statusID as id', 'statusDescricao as name', 'statusAbreviacao as abbreviation')
      ->get();
  }

  public function selectClientsOS($search, $type)
  {
    return DB::connection('os')
      ->table('ClientesInova')
      ->whereRaw("cast(ClienteTipo as char(50)) like '%$type%'")

      ->where(function ($query) use ($search) {

        $query->where('NomeEmpresa', 'like', "%$search%")
          ->orWhere('Contato1', 'like', "%$search%")
          ->orWhere('Telefone1', 'like', "%$search%")
          ->orWhere('ClienteCNPJ', 'like', "%$search%");
      })

      ->leftJoin('InovaSistemas_Produtos', 'ClientesInova.ProdutoID', '=', 'InovaSistemas_Produtos.ProdutoID')
      ->select(
        'NumeroEmpresa as id',
        'NomeEmpresa as trade_name',
        'ClienteCNPJ as document_number',
        'ProdutoDescricao as product',
        'ClienteTipo as type',
        'Contato1 as contact',
        'Telefone1 as phone',
      )
      ->orderBy('NomeEmpresa')
      ->get();
  }

  public function selectClientOS($id)
  {
    return DB::connection('os')
      ->table('ClientesInova')
      ->where('NumeroEmpresa', '=', $id)
      ->select(
        'ClienteBairro as neighborhood',
        'ClienteCNPJ as document_number',
        'ClienteCep as zipcode',
        'ClienteCidade as city',
        'ClienteEndNumero as house_number',
        'ClienteIE as state_registration',
        'ClienteRazaoSocial as corporate_name',
        'ClienteTipo as type',
        'ClienteUF as state',
        'Contato1 as contact',
        'Email1 as email',
        'Endereco as address',
        'NomeEmpresa as trade_name',
        'ProdutoID as product_id',
        'Telefone1 as phone',
        'data_cadastro as entered_at',
      )
      ->get();
  }

  public function selectProducts()
  {
    return DB::connection('os')
      ->table('InovaSistemas_Produtos')
      ->select(
        'ProdutoID as id',
        'ProdutoDescricao as name',
        'ProdutoBanco as bank'
      )
      ->get();
  }

  public function updateStoreOS($params)
  {
    return DB::connection('os')
      ->table('ClientesInova')
      ->where('NumeroEmpresa', '=', $params[0]['id'])
      ->update([
        'ClienteBairro' => $params[0]['neighborhood'],
        'ClienteCNPJ' => $params[0]['document_number'],
        'ClienteCep' => $params[0]['zipcode'],
        'ClienteCidade' => $params[0]['city'],
        'ClienteEndNumero' => $params[0]['house_number'],
        'ClienteIE' => $params[0]['state_registration'],
        'ClienteRazaoSocial' => $params[0]['corporate_name'],
        'ClienteTipo' => $params[0]['situation'],
        'ClienteUF' => $params[0]['state'],
        'Contato1' => $params[0]['responsible'],
        'Email1' => $params[0]['email'],
        'Endereco' => $params[0]['address'],
        'NomeEmpresa' => $params[0]['trade_name'],
        'ProdutoID' => $params[0]['product'],
        'Telefone1' => $params[0]['phone'],
        'data_cadastro' => $params[0]['entered_at'],
      ]);
  }

  public function insertStoreOS($params)
  {
    return DB::connection('os')
      ->table('ClientesInova')
      ->insert([
        'ClienteBairro' => $params[0]['neighborhood'],
        'ClienteCNPJ' => $params[0]['document_number'],
        'ClienteCep' => $params[0]['zipcode'],
        'ClienteCidade' => $params[0]['city'],
        'ClienteEndNumero' => $params[0]['house_number'],
        'ClienteIE' => $params[0]['state_registration'],
        'ClienteRazaoSocial' => $params[0]['corporate_name'],
        'ClienteTipo' => $params[0]['situation'],
        'ClienteUF' => $params[0]['state'],
        'Contato1' => $params[0]['responsible'],
        'Email1' => $params[0]['email'],
        'Endereco' => $params[0]['address'],
        'NomeEmpresa' => $params[0]['trade_name'],
        'ProdutoID' => $params[0]['product'],
        'Telefone1' => $params[0]['phone'],
        'data_cadastro' => $params[0]['entered_at'],
      ]);
  }

  public function countDelayedPayments()
  {
    $current_date = Carbon::now();
    $current_date_validation = Carbon::createFromFormat('Y-m-d H:i:s', $current_date);

    return DB::connection('admin')
      ->table('InovaAutomacao_PlanoValidacao')
      ->whereBetween('ValidacaoDataProximaPromocao', [
        dateFormatISO(dateFormat($current_date_validation)) . ' 00:00:00',
        dateFormatISO(dateFormat($current_date_validation)) . ' 23:59:59'
      ])
      ->selectRaw('count(*) as count')
      ->get();
  }

  public function sumDelayedPayments()
  {
    $current_date = Carbon::now();
    $current_date_validation = Carbon::createFromFormat('Y-m-d H:i:s', $current_date)->format('Y');

    return DB::connection('admin')
      ->table('InovaAutomacao_Empresa')
      ->join('InovaAutomacao_PlanoValidacao', 'InovaAutomacao_PlanoValidacao.EmpresaID', '=', 'InovaAutomacao_Empresa.EmpresaID')
      ->whereBetween('ValidacaoDataProximaPromocao', [
        "$current_date_validation-01-01 01:01:01",
        "$current_date_validation-12-31 23:59:59"
      ])
      ->where('InovaAutomacao_Empresa.EmpresaValorPagto', '>', 0)
      ->selectRaw('InovaAutomacao_PlanoValidacao.ValidacaoDataProximaPromocao as date, sum(InovaAutomacao_Empresa.EmpresaValorPagto) as value')
      ->groupBy('InovaAutomacao_PlanoValidacao.ValidacaoDataProximaPromocao')
      ->get();
  }

  public function selectCompanyData()
  {
    $current_date = Carbon::now();
    $current_date_validation = Carbon::createFromFormat('Y-m-d H:i:s', $current_date)->format('Y');

    return DB::connection('os')
      ->table('EmpresaDados')
      ->whereBetween('empresaPeriodo', [
        "$current_date_validation-01-01",
        "$current_date_validation-12-31"
      ])
      ->select('empresaPeriodo as period', 'empresaFaturamentoTotalinova as money_in', 'empresaDespesasTotal as money_out')
      ->get();
  }

  /*public function chaveOS($document_number, $trade_name, $date)
  {
    $select = DB::connection('key')
    ->table('chaveacesso')
    ->where('chavecnpj', '=', somenteNumeros($document_number))
    ->select('chaveiid as id')
    ->get();

    if (isset($select[0])) {
      if ($select[0]->id) {
        return DB::connection('key')
          ->table('chaveacesso')
          ->where('chaveiid', '=', $select[0]->id)
          ->update([
            'chavedatavalidacao' => $date . ' 00:00:00',
            'chaveempresa' => $trade_name,
            'chaverecebido' => false
          ]);
      } else {
        return DB::connection('key')
          ->table('chaveacesso')
          ->insert([
            'chavecnpj' => somenteNumeros($document_number),
            'chavedatavalidacao' => $date . ' 00:00:00',
            'chaveempresa' => $trade_name,
            'chaverecebido' => false
          ]);
      }
    } else {
      return DB::connection('key')
        ->table('chaveacesso')
        ->insert([
          'chavecnpj' => somenteNumeros($document_number),
          'chavedatavalidacao' => $date . ' 00:00:00',
          'chaveempresa' => $trade_name,
          'chaverecebido' => false
        ]);
    }
  }*/
}
