<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGamesRequest;
use App\Http\Requests\UpdateGamesRequest;
use App\Repositories\GamesRepository;
use App\Models\Games;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GamesController extends Controller
{
    protected $games;

    public function __construct(Games $games)
    {
        $this->games = $games;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $gamesRepository = new GamesRepository($this->games);

            if ($request->has('atributos_console')) {
                $atributos_console = 'console:id,' . $request->atributos_console;
                $gamesRepository->selectAtributosRegistrosRelacionados($atributos_console);
            } else {
                $gamesRepository->selectAtributosRegistrosRelacionados('console');
            }

            // filtro multiplo
            if ($request->has('filtro')) {
                $gamesRepository->filtro($request->filtro);
            }

            // condição caso exista o atributo atributos na url
            if ($request->has('atributos')) {
                $gamesRepository->selectAtributos($request->atributos);
            }

            // condição caso exista o parametro de paginação
            if ($request->has('all')) {
                return response()->json($gamesRepository->getResultado(), 200);
            } else {
                return response()->json($gamesRepository->getResultadoPaginado(6), 200);
            }
        } catch (\PDOException $e) {
            return response()->json(['msg' => 'Erro: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGamesRequest $request)
    {
        try {
            $request->validate($this->games->rules(), $this->games->feedback());
            $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('imagens/games', 'public');
            $game = Games::create([
                'console_id' => $request->console_id,
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'desenvolvedora' => $request->desenvolvedora,
                'data_lancamento' => $request->data_lancamento,
                'imagem' => $imagem_urn
            ]);

            return response()->json(['msg' => 'Jogo ' . $game->nome . 'foi inserido com sucesso!', $game], 201);
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
            $game = $this->games->find($id);
            if ($game === null) {
                return response()->json(['erro' => 'O jogo pesquisado não existe.'], 404);
            }
            return response()->json($game, 200);
        } catch (\PDOException $e) {
            return response()->json(['msg' => 'Erro: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGamesRequest $request, $id)
    {
        try {
            $game = $this->games->find($id);
            // valida se o console existe no banco
            if ($game === null) {
                return response()->json(['erro' => 'Impossível realizar a atualização. O jogo solicitado não existe'], 404);
            }
            if ($request->method() === 'PATCH') {

                $regrasDinamicas = array();

                //percorrendo todas as regras definidas no Model
                foreach ($game->rules() as $input => $regra) {

                    //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
                    if (array_key_exists($input, $request->all())) {
                        $regrasDinamicas[$input] = $regra;
                    }
                }

                $request->validate($regrasDinamicas, $game->feedback());
            } else {
                $request->validate($game->rules(), $game->feedback());
            }

            //preenchendo o objeto $game com todos os dados do request
            $game->fill($request->all());

            //se a imagem foi encaminhada na requisição
            if ($request->file('imagem')) {
                $imgGame = $this->games->find($id);
                //remove o arquivo antigo
                Storage::disk('public')->delete($imgGame->imagem);
                $imagem = $request->file('imagem');
                $imagem_urn = $imagem->store('imagens/games', 'public');
                $game->imagem = $imagem_urn;
            }

            $game->save();
            return response()->json(['msg' => 'O jogo ' . $game->nome . ' foi editado com sucesso!', $game], 200);
        } catch (\PDOException $e) {
            return response();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $game = $this->games->find($id);

        try {
            if ($game === null) {
                return response()->json(['msg' => 'Erro, o jogo não existe em nosso banco'], 404);
            }

            $game->delete();

            // remove imagem antiga caso ele exista
            Storage::disk('public')->delete($game->imagem);

            return response()->json(['msg' => 'Jogo ' . $game->nome . ' foi excluido com sucesso!'], 200);
        } catch (\PDOException $e) {
            return response()->json(['msg' => 'Erro: ' . $e->getMessage()], 500);
        }
    }
}
