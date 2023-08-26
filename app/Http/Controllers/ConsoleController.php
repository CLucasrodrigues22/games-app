<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConsoleRequest;
use App\Http\Requests\UpdateConsoleRequest;
use App\Models\Console;
use Illuminate\Http\Request;
use App\Repositories\ConsoleRepository;
use Illuminate\Support\Facades\Storage;

class ConsoleController extends Controller
{
    protected $console;

    public function __construct(Console $console)
    {
        $this->console = $console;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $consoleRepository = new ConsoleRepository($this->console);

            if ($request->has('atributos_games')) {
                $atributos_games = 'games:id,' . $request->atributos_games;
                $consoleRepository->selectAtributosRegistrosRelacionados($atributos_games);
            } else {
                $consoleRepository->selectAtributosRegistrosRelacionados('games');
            }

            // filtro multiplo
            if ($request->has('filtro')) {
                $consoleRepository->filtro($request->filtro);
            }

            // condição caso exista o atributo atributos na url
            if ($request->has('atributos')) {
                $consoleRepository->selectAtributos($request->atributos);
            }

            // condição caso exista o parametro de paginação
            if ($request->has('all')) {
                return response()->json($consoleRepository->getResultado(), 200);
            } else {
                return response()->json($consoleRepository->getResultadoPaginado(3), 200);
            }
        } catch (\PDOException $e) {
            return response()->json(['msg' => 'Erro: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConsoleRequest $request)
    {
        try {
            $request->validate($this->console->rules(), $this->console->feedback());
            $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('imagens/consoles', 'public');
            $console = Console::create([
                'nome' => $request->nome,
                'marca' => $request->marca,
                'controles' => $request->controles,
                'armazenamento' => $request->armazenamento,
                'tipo_midia' => $request->tipo_midia,
                'imagem' => $imagem_urn
            ]);

            return response()->json(['msg' => 'Console foi inserido com sucesso!', $console], 201);
        } catch (\PDOException $e) {
            return response()->json(['msg' => 'Erro: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $console = $this->console->find($id);
            if ($console === null) {
                return response()->json(['erro' => 'Console pesquisado não existe.'], 404);
            }
            return response()->json($console, 200);
        } catch (\PDOException $e) {
            return response()->json(['msg' => 'Erro: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConsoleRequest $request, $id)
    {
        try {
            $console = $this->console->find($id);

            // valida se o console existe no banco
            if ($console === null) {
                return response()->json(['erro' => 'Impossível realizar a atualização. O console solicitado não existe'], 404);
            }
            if ($request->method() === 'PATCH') {

                $regrasDinamicas = array();

                //percorrendo todas as regras definidas no Model
                foreach ($console->rules() as $input => $regra) {

                    //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
                    if (array_key_exists($input, $request->all())) {
                        $regrasDinamicas[$input] = $regra;
                    }
                }

                $request->validate($regrasDinamicas, $console->feedback());
            } else {
                $request->validate($console->rules(), $console->feedback());
            }

            //preenchendo o objeto $console com todos os dados do request
            $console->fill($request->all());
            //se a imagem foi encaminhada na requisição
            if ($request->file('imagem')) {
                $imgConsole = $this->console->find($id);
                //remove o arquivo antigo
                Storage::disk('public')->delete($imgConsole->imagem);
                $imagem = $request->file('imagem');
                $imagem_urn = $imagem->store('imagens/consoles', 'public');
                $console->imagem = $imagem_urn;
            }

            $console->save();
            return response()->json(['msg' => 'Console foi editado com sucesso!', $console], 200);
        } catch (\PDOException $e) {
            return response()->json(['msg' => 'Erro: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $console = $this->console->find($id);

        try {
            if ($console === null) {
                return response()->json(['msg' => 'Erro, console não existe em nosso banco'], 404);
            }

            $console->delete();

            // remove imagem antiga caso ele exista
            Storage::disk('public')->delete($console->imagem);

            return response()->json(['msg' => 'Console foi excluido com sucesso!'], 200);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000' && strpos($e->getMessage(), '1451') !== false) {
                return response()->json(['msg' => 'Não é possível excluir este console porque ele tem jogos relacionados.'], 500);
            } else {
                return response()->json(['msg' => 'Erro: ' . $e->getMessage()], 500);
            }
        }
    }
}
