<?php

use Illuminate\Http\Request;
use App\Model\Cela;
use App\Model\Carceragem;
use App\Model\FaccaoClassificacao;
use App\Model\CargosFaccao;
use Illuminate\Support\Facades\DB;


/*Autenticação / logout*/
Route::get('/',['as'=>'login','uses'=>"AcessoController@login"]);
Route::get('/selectRole',['as'=>'selectRole','uses'=>"AcessoController@selectRole"]);
Route::post('/selectRole',['as'=>'selectRole.post','uses'=>"AcessoController@selectRolePost"]);

Route::get('/selectToken',['as'=>'selectToken','uses'=>"AcessoController@selectToken"]);
Route::post('/token',['as'=>'selectToken.token','uses'=>"AcessoController@token"]);


Route::post('/validaLogin',['as'=>'validaLogin','uses'=>"AcessoController@validaLogin"]);
Route::get('logout', ['as' => 'logout', 'uses' => 'AcessoController@logout']);

Route::get('/solicitaracesso',['as'=>'solicitaracesso','uses'=>"AcessoController@solicitaracesso"]);
Route::post('/solicitaracesso',['as'=>'solicitaracesso.salvar','uses'=>"AcessoController@solicitaracessoSalvar"]);
Route::get('/solicitaracessocidades/{idEstado}',['as'=>'solicitaracesso.cidades','uses'=>"AcessoController@cidades"]);

Route::get('/carceragem-sub', function(Request $request){
    $unid_id = $request->get('unid_id');
    $carceragens = Carceragem::where('unidade_id', '=', $unid_id )->get();
    return Response::json($carceragens);
});
//ROTAS COMBOBOX
Route::get('/celas-sub', function(Request $request){
    $carc_id = $request->get('carc_id');
    $celas = Cela::where('carceragem_id', '=', $carc_id )->get();
    return Response::json($celas);
});

//ROTAS COMBOBOX
Route::get('/classificacao', function(Request $request){
    $class_id = $request->get('class_id');
    $class = FaccaoClassificacao::where('possivel_id', '=', $class_id)->get();
    return Response::json($class);
});

Auth::routes();

//MIDDLEWARE DE PROTEÇÃO DO SISTEMA
Route::group(['middleware'=>'auth'], function() {


    Route::get('code/{id}', ['as' => 'valida.code', 'uses' => "AcessoController@code"]);

    /*principal do site*/
        Route::get('home',['as'=>'home','uses'=>"HomeController@index"]); //

        /*alterar senha*/
        Route::get('alterarPassword', ['as' => 'alterarPassword', 'uses' => 'AcessoController@alterarPassword']);
        Route::put('alterarPasswordSalvar', ['as' => 'alterarPasswordSalvar', 'uses' => 'AcessoController@alterarPasswordSalvar']);

    //MAPA
    Route::group(['prefix'=>'mapa'], function() {
        Route::get('index', ['as'=>'mapa.index', 'uses'=>'MapController@index']);
    });

    //RECAPTURA DE APENADO
    Route::group(['prefix'=>'foragidos'], function() {
        Route::get('index', ['as'=>'foragidos.index', 'uses'=>'ForagidosController@index']);
        Route::get('{id}/recaptura', ['as'=>'foragidos.recaptura', 'uses'=>'ForagidosController@recaptura']);
        Route::post('{id}/recapturaSalvar', ['as'=>'foragidos.recapturaSalvar', 'uses'=>'ForagidosController@recapturaSalvar']);
    });

    //CADASTRO DE APENADOS
        Route::group(['prefix'=>'apenados'], function() {
            Route::get('index', ['as' => 'apenados.index', 'uses' => "ApenadosController@index"]);

            Route::get('autocomplete', ['as' => 'apenados.autocomplete', 'uses' => "ApenadosController@autocomplete"]);


            Route::get('novo', ['as' => 'apenados.novo', 'uses' => "ApenadosController@novo"]);
            Route::post('salvar', ['as'=>'apenados.salvar', 'uses'=>'ApenadosController@salvar']);

            Route::get('{id}/selecionarOpcao', ['as'=>'apenados.selecionarOpcao', 'uses'=>'ApenadosController@selecionarOpcao']);


            Route::get('{id}/editar', ['as'=>'apenados.editar', 'uses'=>'ApenadosController@editar']);
            Route::put('{id}/update', ['as'=>'apenados.update', 'uses'=>'ApenadosController@update']);

            Route::get('{id}/novaentrada', ['as'=>'apenados.novaentrada', 'uses'=>'ApenadosController@novaentrada']);
            Route::post('{id}/novaentradaSalvar', ['as'=>'apenados.novaentradaSalvar', 'uses'=>'ApenadosController@novaentradaSalvar']);

            Route::get('{id}/recebimento', ['as'=>'apenados.recebimento', 'uses'=>'ApenadosController@recebimento']);
            Route::post('{id}/recebimentoSalvar', ['as'=>'apenados.recebimentoSalvar', 'uses'=>'ApenadosController@recebimentoSalvar']);

            Route::get('{id}/mudarcela', ['as'=>'apenados.mudarcela', 'uses'=>'ApenadosController@mudarcela']);
            Route::post('{id}/mudarcelaSalvar', ['as'=>'apenados.mudarcelaSalvar', 'uses'=>'ApenadosController@mudarcelaSalvar']);
            Route::get('{id}/mudarCeladestroy/{idApen}', ['as'=>'apenados.mudarCeladestroy', 'uses'=>'ApenadosController@mudarCeladestroy']);


            Route::get('{id}/alcunhas', ['as'=>'apenados.alcunhas', 'uses'=>'ApenadosController@alcunhas']);
            Route::post('{id}/alcunhasSalvar', ['as'=>'apenados.alcunhasSalvar', 'uses'=>'ApenadosController@alcunhasSalvar']);
            Route::get('{id}/alcunhaPrincipal/{idApen}', ['as'=>'apenados.alcunhaPrincipal', 'uses'=>'ApenadosController@alcunhaPrincipal']);
            Route::get('{id}/alcunhaDestroy/{idApen}', ['as'=>'apenados.alcunhaDestroy', 'uses'=>'ApenadosController@alcunhaDestroy']);

            Route::get('{id}/enderecos', ['as'=>'apenados.enderecos', 'uses'=>'ApenadosController@enderecos']);
            Route::post('{id}/enderecosSalvar', ['as'=>'apenados.enderecosSalvar', 'uses'=>'ApenadosController@enderecosSalvar']);
            Route::get('{id}/enderecosPrincipal', ['as'=>'apenados.enderecosPrincipal', 'uses'=>'ApenadosController@enderecosPrincipal']);

            Route::get('{id}/fotos', ['as'=>'apenados.fotos', 'uses'=>'ApenadosController@fotos']);
            Route::post('{id}/fotosSalvar', ['as'=>'apenados.fotosSalvar', 'uses'=>'ApenadosController@fotosSalvar']);
            Route::get('{id}/fotoPrincipal/{idApen}', ['as'=>'apenados.fotoPrincipal', 'uses'=>'ApenadosController@fotoPrincipal']);
            Route::get('{id}/fotoExcluir', ['as'=>'apenados.fotoExcluir', 'uses'=>'ApenadosController@fotoExcluir']);


            Route::get('{id}/incluirProcessos', ['as'=>'apenados.incluirProcessos', 'uses'=>'ApenadosController@incluirProcessos']);
            Route::post('{id}/incluirProcessosSalvar', ['as'=>'apenados.incluirProcessosSalvar', 'uses'=>'ApenadosController@incluirProcessosSalvar']);

            Route::get('{id}/registrarSaida', ['as'=>'apenados.registrarSaida', 'uses'=>'ApenadosController@registrarSaida']);
            Route::post('{id}/registrarSaidaSalvar', ['as'=>'apenados.registrarSaidaSalvar', 'uses'=>'ApenadosController@registrarSaidaSalvar']);

            Route::get('{id}/triagem', ['as'=>'apenados.triagem', 'uses'=>'ApenadosController@triagem']);
            Route::post('{id}/triagemSalvar', ['as'=>'apenados.triagemSalvar', 'uses'=>'ApenadosController@triagemSalvar']);
            Route::post('triagemBaixar', ['as'=>'apenados.triagemBaixar', 'uses'=>'ApenadosController@triagemBaixar']);

            Route::get('localizacao',['as'=>'apenados.localizacao','uses'=>"ApenadosController@localizacao"]);

            Route::get('{id}/informacoes', ['as'=>'apenados.informacoes', 'uses'=>'ApenadosController@informacoes']);
            Route::any('{idApen}/destroyInformacaoCadastro/{idInfo}', ['as'=>'apenados.destroyInformacaoCadastro', 'uses'=>'ApenadosController@destroyInformacaoCadastro']);

            Route::get('{id}/destroyApenado', ['as'=>'apenados.destroyApenado', 'uses'=>'ApenadosController@destroyApenado']);
            Route::get('{id}/destroy/{idAcao}', ['as'=>'apenados.destroy', 'uses'=>'ApenadosController@destroy']);

            //MODAL - INFORMAÇÕES DE ADICIONAIS DE APENADO
            Route::post('informacoes_inserir', ['as'=>'apenados.informacoes_inserir', 'uses'=>'ApenadosController@informacoes_inserir']);




        });


        //RELATÓRIO E PDF
        Route::group(['prefix'=>'relatorios'], function() {

                //UNIDADES
                Route::get('temporariasUnidade', ['as' => 'relatorios.temporariasUnidade', 'uses' => "RelatorioController@temporariasUnidade"]);
                Route::get('movimentacoesUnidade', ['as' => 'relatorios.movimentacoesUnidade', 'uses' => "RelatorioController@movimentacoesUnidade"]);
                Route::get('movimentacoesAdmin', ['as' => 'relatorios.movimentacoesAdmin', 'uses' => "RelatorioController@movimentacoesAdmin"]);

                //GERENCIAIS
                Route::get('{id}/integrantesFaccao_pdf', ['as' => 'relatorios.integrantesFaccao_pdf', 'uses' => "RelatorioController@integrantesFaccao_pdf"]);
                Route::get('capacidadeCelas', ['as' => 'relatorios.capacidadeCelas', 'uses' => "RelatorioController@capacidadeCelas"]);
                Route::get('recebimentoGeral', ['as' => 'relatorios.recebimentoGeral', 'uses' => "RelatorioController@recebimentoGeral"]);
                Route::post('fichaGeral', ['as'=>'relatorios.fichaGeral', 'uses'=>'RelatorioController@fichaGeral']);

                Route::get('buscaFaccionado', ['as'=>'relatorios.buscaFaccionado', 'uses'=>'RelatorioController@buscaFaccionado']);
                Route::get('faccionados', ['as'=>'relatorios.faccionados', 'uses'=>'RelatorioController@faccionados']);


        });


        //CERTIDOES - PDF
        Route::group(['prefix'=>'certidoes'], function() {
            //UNIDADES
            Route::get('index', ['as' => 'certidoes.index', 'uses' => "CertidoesController@index"]);
            Route::get('{id}/mostradados', ['as' => 'certidoes.mostradados', 'uses' => "CertidoesController@mostradados"]);
            Route::post('{idPreso}/emitir', ['as' => 'certidoes.emitir', 'uses' => "CertidoesController@emitir"]);

            Route::get('listar', ['as' => 'certidoes.listar', 'uses' => "CertidoesController@listar"]);
            Route::get('mostrar/{id}', ['as' => 'certidoes.mostrar', 'uses' => "CertidoesController@mostrar"]);

        });

        //LISTAGEM
        Route::group(['prefix'=>'listagem'], function() {
            Route::get('{id}/carceragem', ['as' => 'listagem.carceragem', 'uses' => "ListagemController@carceragem"]);
            Route::get('celas', ['as' => 'listagem.celas', 'uses' => "ListagemController@celas"]);
            Route::get('mapa', ['as' => 'listagem.mapa', 'uses' => "ListagemController@mapa"]);
            Route::get('geral', ['as' => 'listagem.geral', 'uses' => "ListagemController@geral"]);
            Route::get('recebimento', ['as' => 'listagem.recebimento', 'uses' => "ListagemController@recebimento"]);
            Route::get('fugitivos', ['as' => 'listagem.fugitivos', 'uses' => "ListagemController@fugitivos"]);
            Route::get('medidadisciplinar/{id?}', ['as' => 'listagem.medidadisciplinar', 'uses' => "ListagemController@medidadisciplinar"]);
            Route::get('triagem/{id?}', ['as' => 'listagem.triagem', 'uses' => "ListagemController@triagem"]);
            Route::get('transito/{id?}', ['as' => 'listagem.transito', 'uses' => "ListagemController@transito"]);

            Route::get('temporarias/{tipo?}', ['as' => 'listagem.temporarias', 'uses' => "ListagemController@temporarias"]);

            Route::any('exportarBaseTodos/{type}', ['as' => 'listagem.exportarBaseTodos', 'uses' => "ListagemController@exportarBaseTodos"]);

            Route::any('exportarBaseGeralExcel/{type}', ['as' => 'listagem.exportarBaseGeralExcel', 'uses' => "ListagemController@exportarBaseGeralExcel"]);
            Route::get('{id}/fichaCela', ['as'=>'listagem.fichaCela', 'uses'=>'ListagemController@fichaCela']);

        });

        //ANEXAR DOCUMENTOS APENADO
        Route::group(['prefix'=>'anexos'], function() {
            Route::get('{id}/index', ['as'=>'anexos.index','uses'=>'AnexosController@index']);
            Route::get('{id}/destroy/{idApen}', ['as'=>'anexos.destroy', 'uses'=>'AnexosController@destroy']);
            //MODAL ANEXAR
            Route::post('gravar', ['as'=>'anexos.gravar','uses'=>'AnexosController@gravar']);
        });

    //PRODUÇÃO DE CONHECIMENTO - RELATÓRIOS
    Route::group(['prefix'=>'producao'], function() {

        Route::get('index/{id?}', ['as'=>'producao.index','uses'=>'ProducaoController@index']);
        Route::get('novo',['as'=>'producao.novo','uses'=>"ProducaoController@novo"]);
        Route::post('salvar',['as'=>'producao.salvar','uses'=>"ProducaoController@salvar"]);
        Route::get('{id}/editar',['as'=>'producao.editar','uses'=>"ProducaoController@editar"]);
        Route::put('update/{id}',['as'=>'producao.update','uses'=>'ProducaoController@update']);
        Route::get('{id}/destroy', ['as'=>'producao.destroy', 'uses'=>'ProducaoController@destroy']);
        Route::get('{id}/imprimir', ['as' => 'producao.imprimir', 'uses' => "ProducaoController@imprimir"]);
        Route::get('{id}/visualizar', ['as' => 'producao.visualizar', 'uses' => "ProducaoController@visualizar"]);

        Route::get('resumo', ['as'=>'producao.resumo','uses'=>'ProducaoController@resumo']);
        Route::get('resumolista/{id?}', ['as'=>'producao.resumolista','uses'=>'ProducaoController@resumolista']);
        Route::get('exportar/zip', ['as' => 'producao.exportarZip', 'uses' => 'ProducaoController@exportarZip']);

    });




    //CADASTRO DE PRESOS FACCIONÁRIOS
        Route::group(['prefix'=>'faccaointegrantes'], function() {
            Route::get('index',['as'=>'faccaointegrantes.index','uses'=>"IntegrantesController@index"]);
            Route::get('{id}/incluir', ['as'=>'faccaointegrantes.incluir', 'uses'=>'IntegrantesController@incluir']);
            Route::post('salvar',['as'=>'faccaointegrantes.salvar','uses'=>"IntegrantesController@salvar"]);

            Route::get('{id}/incluirDados', ['as'=>'faccaointegrantes.incluirDados', 'uses'=>'IntegrantesController@incluirDados']);
            Route::post('incluirDadosSalvar',['as'=>'faccaointegrantes.incluirDadosSalvar','uses'=>"IntegrantesController@incluirDadosSalvar"]);

            Route::get('faccoes',['as'=>'faccaointegrantes.faccoes','uses'=>"IntegrantesController@faccoes"]);
            Route::get('{id}/listarporfaccao/{tipo?}',['as'=>'faccaointegrantes.listarporfaccao','uses'=>"IntegrantesController@listarporfaccao"]);
            Route::get('listar',['as'=>'faccaointegrantes.listar','uses'=>"IntegrantesController@listar"]);
            Route::get('{id}/editar', ['as'=>'faccaointegrantes.editar', 'uses'=>'IntegrantesController@editar']);
            Route::put('{id}/update', ['as'=>'faccaointegrantes.update', 'uses'=>'IntegrantesController@update']);

            Route::put('updateDadosFaccionado', ['as'=>'faccaointegrantes.updateDadosFaccionado', 'uses'=>'IntegrantesController@updateDadosFaccionado']);

            Route::get('{id}/anexos', ['as'=>'faccaointegrantes.anexos', 'uses'=>'IntegrantesController@anexos']);
            Route::post('anexos_salvar',['as'=>'faccaointegrantes.anexos_salvar','uses'=>"IntegrantesController@anexos_salvar"]);

            Route::post('fichaPrisional', ['as'=>'faccaointegrantes.fichaPrisional', 'uses'=>'IntegrantesController@fichaPrisional']);


            //INFORMAÇÕES DE DADOS FACCOES - INTEGRANTES - MATRICULA
            Route::post('SalvarMatricula',['as'=>'faccaointegrantes.SalvarMatricula','uses'=>"IntegrantesController@SalvarMatricula"]);
            Route::get('{id}/SituacaoMatricula/{idInt}', ['as'=>'faccaointegrantes.SituacaoMatricula', 'uses'=>'IntegrantesController@SituacaoMatricula']);
            Route::get('ExcluirMatricula/{id}', ['as'=>'faccaointegrantes.ExcluirMatricula', 'uses'=>'IntegrantesController@ExcluirMatricula']);

            //INFORMAÇÕES DE DADOS FACCOES - INTEGRANTES - NOME BATISMO
            Route::post('SalvarNomeBatismo',['as'=>'faccaointegrantes.SalvarNomeBatismo','uses'=>"IntegrantesController@SalvarNomeBatismo"]);
            Route::get('{id}/SituacaoNomeBatismo/{idInt}', ['as'=>'faccaointegrantes.SituacaoNomeBatismo', 'uses'=>'IntegrantesController@SituacaoNomeBatismo']);
            Route::get('ExcluirNomeBatismo/{id}', ['as'=>'faccaointegrantes.ExcluirNomeBatismo', 'uses'=>'IntegrantesController@ExcluirNomeBatismo']);

            //INFORMAÇÕES DE DADOS FACCOES - INTEGRANTES - LOCAL BATISMO
            Route::post('SalvarLocalBatismo',['as'=>'faccaointegrantes.SalvarLocalBatismo','uses'=>"IntegrantesController@SalvarLocalBatismo"]);
            Route::get('{id}/SituacaoLocalBatismo/{idInt}', ['as'=>'faccaointegrantes.SituacaoLocalBatismo', 'uses'=>'IntegrantesController@SituacaoLocalBatismo']);
            Route::get('ExcluirLocalBatismo/{id}', ['as'=>'faccaointegrantes.ExcluirLocalBatismo', 'uses'=>'IntegrantesController@ExcluirLocalBatismo']);

            //INFORMAÇÕES DE DADOS FACCOES - INTEGRANTES - QUEBRADA ORIGEM
            Route::post('SalvarQuebradaOrigem',['as'=>'faccaointegrantes.SalvarQuebradaOrigem','uses'=>"IntegrantesController@SalvarQuebradaOrigem"]);
            Route::get('{id}/SituacaoQuebradaOrigem/{idInt}', ['as'=>'faccaointegrantes.SituacaoQuebradaOrigem', 'uses'=>'IntegrantesController@SituacaoQuebradaOrigem']);
            Route::get('ExcluirQuebradaOrigem/{id}', ['as'=>'faccaointegrantes.ExcluirQuebradaOrigem', 'uses'=>'IntegrantesController@ExcluirQuebradaOrigem']);

            //INFORMAÇÕES DE DADOS FACCOES - INTEGRANTES - QUEBRADA ATUAL
            Route::post('SalvarQuebradaAtual',['as'=>'faccaointegrantes.SalvarQuebradaAtual','uses'=>"IntegrantesController@SalvarQuebradaAtual"]);
            Route::get('{id}/SituacaoQuebradaAtual/{idInt}', ['as'=>'faccaointegrantes.SituacaoQuebradaAtual', 'uses'=>'IntegrantesController@SituacaoQuebradaAtual']);
            Route::get('ExcluirQuebradaAtual/{id}', ['as'=>'faccaointegrantes.ExcluirQuebradaAtual', 'uses'=>'IntegrantesController@ExcluirQuebradaAtual']);

            //INFORMAÇÕES DE DADOS FACCOES - INTEGRANTES - CARGOS
            Route::post('SalvarCargo',['as'=>'faccaointegrantes.SalvarCargo','uses'=>"IntegrantesController@SalvarCargo"]);
            Route::get('{id}/SituacaoCargo/{idInt}', ['as'=>'faccaointegrantes.SituacaoCargo', 'uses'=>'IntegrantesController@SituacaoCargo']);
            Route::get('ExcluirCargo/{id}', ['as'=>'faccaointegrantes.ExcluirCargo', 'uses'=>'IntegrantesController@ExcluirCargo']);

            //INFORMAÇÕES DE DADOS FACCOES - INTEGRANTES - REFERENCIAS
            Route::post('SalvarReferencia',['as'=>'faccaointegrantes.SalvarReferencia','uses'=>"IntegrantesController@SalvarReferencia"]);
            Route::get('{id}/SituacaoReferencia/{idInt}', ['as'=>'faccaointegrantes.SituacaoReferencia', 'uses'=>'IntegrantesController@SituacaoReferencia']);
            Route::get('ExcluirReferencia/{id}', ['as'=>'faccaointegrantes.ExcluirReferencia', 'uses'=>'IntegrantesController@ExcluirReferencia']);

            //INFORMAÇÕES DE DADOS FACCOES - INTEGRANTES - TELEFONES
            Route::post('SalvarTelefone',['as'=>'faccaointegrantes.SalvarTelefone','uses'=>"IntegrantesController@SalvarTelefone"]);
            Route::get('{id}/SituacaoTelefone/{idInt}', ['as'=>'faccaointegrantes.SituacaoTelefone', 'uses'=>'IntegrantesController@SituacaoTelefone']);
            Route::get('ExcluirTelefone/{id}', ['as'=>'faccaointegrantes.ExcluirTelefone', 'uses'=>'IntegrantesController@ExcluirTelefone']);

            //INFORMAÇÕES DE DADOS FACCOES - INTEGRANTES - PADRINHOS Interno
            Route::post('SalvarPadrinhoInterno',['as'=>'faccaointegrantes.SalvarPadrinhoInterno','uses'=>"IntegrantesController@SalvarPadrinhoInterno"]);
            Route::get('SituacaoPadrinhoInterno/{id}', ['as'=>'faccaointegrantes.SituacaoPadrinhoInterno', 'uses'=>'IntegrantesController@SituacaoPadrinhoInterno']);
            Route::get('ExcluirPadrinhoInterno/{id}', ['as'=>'faccaointegrantes.ExcluirPadrinhoInterno', 'uses'=>'IntegrantesController@ExcluirPadrinhoInterno']);

            //INFORMAÇÕES DE DADOS FACCOES - INTEGRANTES - PADRINHOS Externo
            Route::post('SalvarPadrinhoExterno',['as'=>'faccaointegrantes.SalvarPadrinhoExterno','uses'=>"IntegrantesController@SalvarPadrinhoExterno"]);
            Route::get('SituacaoPadrinhoExterno/{id}', ['as'=>'faccaointegrantes.SituacaoPadrinhoExterno', 'uses'=>'IntegrantesController@SituacaoPadrinhoExterno']);
            Route::get('ExcluirPadrinhoExterno/{id}', ['as'=>'faccaointegrantes.ExcluirPadrinhoExterno', 'uses'=>'IntegrantesController@ExcluirPadrinhoExterno']);

            //INFORMAÇÕES DE DADOS FACCOES - INTEGRANTES - SALVAR CLASSIFICAÇÃO
            Route::post('SalvarClassificacao',['as'=>'faccaointegrantes.SalvarClassificacao','uses'=>"IntegrantesController@SalvarClassificacao"]);

            //MODAL - INFORMAÇÕES DE ADICIONAIS DE FACCAO
            Route::post('informacoes_inserir', ['as'=>'faccaointegrantes.informacoes_inserir', 'uses'=>'IntegrantesController@informacoes_inserir']);
            Route::any('{idApen}/destroyInformacaoFaccao/{idInfo}', ['as'=>'faccaointegrantes.destroyInformacaoFaccao', 'uses'=>'IntegrantesController@destroyInformacaoFaccao']);
            Route::any('{idApen}/destroyAnexoFaccao/{idAnexo}', ['as'=>'faccaointegrantes.destroyAnexoFaccao', 'uses'=>'IntegrantesController@destroyAnexoFaccao']);
            Route::post('cancelar',['as'=>'faccaointegrantes.cancelar','uses'=>"IntegrantesController@cancelar"]);
        });



    /* CADASTRO DE VISITANTES */
        Route::group(['prefix'=>'visitas'], function() {
            Route::get('mostrarapenados',['as'=>'visitas.mostrarapenados','uses'=>"VisitasController@mostrarapenados"]);
            Route::get('listarvisitantes',['as'=>'visitas.listarvisitantes','uses'=>"VisitasController@listarvisitantes"]);
            Route::get('{id}/mostrarvisitantes', ['as'=>'visitas.mostrarvisitantes', 'uses'=>'VisitasController@mostrarvisitantes']);


            Route::post('novo', ['as' => 'visitas.novo', 'uses' => "VisitasController@novo"]);
            Route::post('salvar', ['as'=>'visitas.salvar', 'uses'=>'VisitasController@salvar']);

            Route::get('{id}/incluirvisitantes', ['as'=>'visitas.incluirvisitantes', 'uses'=>'VisitasController@incluirvisitantes']);

            Route::get('{id}/detalhavisitas', ['as'=>'visitas.detalhavisitas', 'uses'=>'VisitasController@detalhavisitas']);
            // MODAL MODAL -------------------------------------
            Route::post('salvar',['as'=>'visitas.salvar','uses'=>"VisitasController@salvar"]);
            Route::post('visitas/visitas_update',['as'=>'visitas.visitas_update','uses'=>'VisitasController@visitas_update']);
            Route::post('cancelar',['as'=>'visitas.cancelar','uses'=>"VisitasController@cancelar"]);
        });

        /* CADASTRO DE ADVOGADOS */
        Route::group(['prefix'=>'advogados'], function() {
            Route::get('mostrarapenados',['as'=>'advogados.mostrarapenados','uses'=>"AdvogadosController@mostrarapenados"]);
            Route::get('listaradvogados',['as'=>'advogados.listaradvogados','uses'=>"AdvogadosController@listaradvogados"]);
            Route::get('{id}/mostraradvogados', ['as'=>'advogados.mostraradvogados', 'uses'=>'AdvogadosController@mostraradvogados']);
            Route::get('{id}/incluirvisitantes', ['as'=>'advogados.incluirvisitantes', 'uses'=>'AdvogadosController@incluirvisitantes']);
            Route::get('{id}/detalhaclientes', ['as'=>'advogados.detalhaclientes', 'uses'=>'AdvogadosController@detalhaclientes']);
            // MODAL MODAL -------------------------------------
            Route::post('salvar',['as'=>'advogados.salvar','uses'=>"AdvogadosController@salvar"]);
            Route::post('vincular',['as'=>'advogados.vincular','uses'=>"AdvogadosController@vincular"]);
            Route::post('visitas/advogados_update',['as'=>'advogados.advogados_update','uses'=>'AdvogadosController@advogados_update']);
            Route::post('cancelar',['as'=>'advogados.cancelar','uses'=>"AdvogadosController@cancelar"]);
        });


        /* CADASTRO DE PAD - PROCESSO ADMINISTRATIVO DISCIPLINAR*/
        Route::group(['prefix'=>'pad'], function() {
            Route::get('index',['as'=>'pad.index','uses'=>"PadController@index"]);
            Route::get('{id}/mostradados',['as'=>'pad.mostradados','uses'=>"PadController@mostradados"]);
            // MODAL MODAL -------------------------------------
            Route::post('salvar',['as'=>'pad.salvar','uses'=>"PadController@salvar"]);
            Route::post('update',['as'=>'pad.update','uses'=>'PadController@update']);
        });

        /* CADASTRO DE MEDIDA DISCIPLINAR - CASTIGO UNIDADE*/
        Route::group(['prefix'=>'medidadisciplinar'], function() {
            Route::get('index',['as'=>'medidadisciplinar.index','uses'=>"MedidaDisciplinarController@index"]);
            Route::get('{id}/mostradados',['as'=>'medidadisciplinar.mostradados','uses'=>"MedidaDisciplinarController@mostradados"]);
            // MODAL MODAL -------------------------------------
            Route::post('salvar',['as'=>'medidadisciplinar.salvar','uses'=>"MedidaDisciplinarController@salvar"]);
            Route::post('update',['as'=>'medidadisciplinar.update','uses'=>'MedidaDisciplinarController@update']);

            //Route::post('cancelar',['as'=>'medidadisciplinar.cancelar','uses'=>"MedidaDisciplinarController@cancelar"]);
        });

        /* CADASTRO DE SAÍDAS TEMPORÁRIAS E PERMISSÃO DE SAÍDA */
        Route::group(['prefix'=>'temporarias'], function() {
            Route::get('{id}/mostradados',['as'=>'temporarias.mostradados','uses'=>"TemporariasController@mostradados"]);
            Route::post('salvar',['as'=>'temporarias.salvar','uses'=>"TemporariasController@salvar"]);
            Route::get('{id}/editar',['as'=>'temporarias.editar','uses'=>"TemporariasController@editar"]);
            Route::post('update',['as'=>'temporarias.update','uses'=>'TemporariasController@update']);
        });

                    Route::group(['prefix'=>'faccaocadastro'], function() {
                        Route::get('index',['as'=>'faccaocadastro.index','uses'=>"FaccoesController@index"]);
                        Route::get('novo',['as'=>'faccaocadastro.novo','uses'=>"FaccoesController@novo"]);
                        Route::post('salvar',['as'=>'faccaocadastro.salvar','uses'=>"FaccoesController@salvar"]);
                        Route::get('{id}/editar', ['as'=>'faccaocadastro.editar', 'uses'=>'FaccoesController@editar']);
                        Route::put('{id}/update', ['as'=>'faccaocadastro.update', 'uses'=>'FaccoesController@update']);
                    });

                    Route::group(['prefix'=>'faccaocargo'], function() {
                        Route::get('index',['as'=>'faccaocargo.index','uses'=>"CargosFaccaoController@index"]);
                        Route::get('novo',['as'=>'faccaocargo.novo','uses'=>"CargosFaccaoController@novo"]);
                        Route::post('salvar',['as'=>'faccaocargo.salvar','uses'=>"CargosFaccaoController@salvar"]);
                        Route::get('{id}/editar', ['as'=>'faccaocargo.editar', 'uses'=>'CargosFaccaoController@editar']);
                        Route::put('{id}/update', ['as'=>'faccaocargo.update', 'uses'=>'CargosFaccaoController@update']);
                    });


                    Route::group(['prefix'=>'carceragens'], function() {
                        Route::get('index/{idUnidade}', ['as' => 'carceragens.index', 'uses' => "CarceragemController@Index"]);
                        Route::get('novo/{idUnidade}', ['as' => 'carceragens.novo', 'uses' => "CarceragemController@novo"]);
                        Route::post('salvar', ['as'=>'carceragens.salvar', 'uses'=>'CarceragemController@salvar']);
                        Route::get('{id}/editar/{idUnidade}', ['as'=>'carceragens.editar', 'uses'=>'CarceragemController@editar']);
                        Route::put('{id}/update/{idUnidade}', ['as'=>'carceragens.update', 'uses'=>'CarceragemController@update']);
                    //    Route::get('pesquisar',['as'=>'tipomodalidades.pesquisar','uses'=>'TipoModalidadesController@Pesquisar']);
                    });
                    Route::group(['prefix'=>'celas'], function() {
                        Route::get('index/{idCarceragem}', ['as' => 'celas.index', 'uses' => "CelaController@Index"]);
                        Route::get('novo/{idCarceragem}', ['as' => 'celas.novo', 'uses' => "CelaController@novo"]);
                        Route::post('salvar', ['as'=>'celas.salvar', 'uses'=>'CelaController@salvar']);
                        Route::get('{id}/editar/{idCarceragem}', ['as'=>'celas.editar', 'uses'=>'CelaController@editar']);
                        Route::put('{id}/update/{idCarceragem}', ['as'=>'celas.update', 'uses'=>'CelaController@update']);
                        Route::get('{id}/destroy/{idCarceragem}', ['as'=>'celas.destroy', 'uses'=>'CelaController@destroy']);
                    });
                    Route::group(['prefix'=>'unidadesprisionais'], function() {
                        Route::get('index', ['as' => 'unidadesprisionais.index', 'uses' => "UnidadesController@Index"]);
                        Route::get('novo', ['as' => 'unidadesprisionais.novo', 'uses' => "UnidadesController@novo"]);
                        Route::post('salvar', ['as'=>'unidadesprisionais.salvar', 'uses'=>'UnidadesController@salvar']);
                        Route::get('{id}/editar', ['as'=>'unidadesprisionais.editar', 'uses'=>'UnidadesController@editar']);
                        Route::put('{id}/update', ['as'=>'unidadesprisionais.update', 'uses'=>'UnidadesController@update']);
                    });
                    Route::group(['prefix'=>'regioes'], function() {
                        Route::get('index', ['as' => 'regioes.index', 'uses' => "RegioesController@Index"]);
                        Route::get('novo', ['as' => 'regioes.novo', 'uses' => "RegioesController@novo"]);
                        Route::post('salvar', ['as'=>'regioes.salvar', 'uses'=>'RegioesController@salvar']);
                        Route::get('{id}/editar', ['as'=>'regioes.editar', 'uses'=>'RegioesController@editar']);
                        Route::put('{id}/update', ['as'=>'regioes.update', 'uses'=>'RegioesController@update']);
                    });




    //GALERIA DE FOTOS
    Route::group(['prefix'=>'galeria'], function() {
        Route::get('galerias', ['as'=>'galerias', 'uses'=>'GaleriaController@galerias']);
        Route::get('novo', ['as'=>'galerias.novo', 'uses'=>'GaleriaController@novo']);
        Route::post('galeriaSalvar', ['as'=>'galerias.salvar', 'uses'=>'GaleriaController@salvar']);
        Route::get('{id}/galeriaExcluir', ['as'=>'galerias.excluir', 'uses'=>'GaleriaController@excluir']);
    });


//    Route::get('carceragem-sub/{idUnid}', ['as' => 'selectCarceragem', 'uses' => "CarceragemController@selectCarceragem"]);
//    Route::get('celas-sub/{idCarc}', ['as' => 'selectCelas', 'uses' => "CelaController@selectCelas"]);
    Route::get('cargo-sub/{idFac}', ['as' => 'selectCargos', 'uses' => "CargosFaccaoController@selectCargos"]);
    Route::get('padrinhos-sub/{idFac}', ['as' => 'selectPadrinhos', 'uses' => "IntegrantesController@selectPadrinhos"]);
//    Route::get('classificacao/{idFac}', ['as' => 'selectClassificacao', 'uses' => "IntegrantesController@selectClassificacao"]);


    /* Route::any('deploy', ['as' => 'deploy', 'uses' => 'AcessoController@deploy']); */

}); /*FIM AUTH*/

