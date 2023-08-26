<template>
  <div>
    <main>
      <section class="py-5 text-center container">
        <div class="row py-lg-5">
          <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">Games</h1>
            <p class="lead text-body-secondary">
              Aqui você pode gerenciar todos os jogos, como inserir um novo e
              editar.
            </p>
            <p>
              <button
                class="btn btn-primary my-2 m-1"
                data-bs-toggle="modal"
                data-bs-target="#inserirGame"
              >
                Inserir um Jogo
              </button>
              <a href="/console" class="btn btn-secondary my-2 m-1"
                >Ver Consoles cadastrados</a
              >
            </p>
          </div>
        </div>
      </section>

      <div class="album py-5 bg-body-tertiary">
        <div class="container">
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
            <div
              v-for="(obj, chave) in this.games.data"
              :key="chave"
              class="col mb-5"
            >
              <div class="card shadow-sm">
                <img
                  :src="'/storage/' + obj.imagem"
                  class="card-img-top"
                  style="width: 300px; height: 411px; margin: 0 3.5rem 0 3.5rem"
                />
                <div class="card-body">
                  <h5 class="card-text">
                    <strong>{{ obj.nome }}</strong>
                  </h5>
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <div class="btn-group">
                      <button
                        type="button"
                        class="btn btn-sm btn-outline-info m-1"
                        data-bs-toggle="modal"
                        data-bs-target="#vizualizarGame"
                        @click="setStore(obj, this.games.data)"
                      >
                        Vizualizar
                      </button>
                      <button
                        type="button"
                        class="btn btn-sm btn-outline-warning m-1"
                        data-bs-toggle="modal"
                        data-bs-target="#editarGame"
                        @click="setStore(obj, this.games.data)"
                      >
                        Editar
                      </button>
                      <button
                        type="button"
                        class="btn btn-sm btn-outline-danger m-1"
                        data-bs-toggle="modal"
                        data-bs-target="#excluirConsole"
                        @click="setStore(obj, this.games.data)"
                      >
                        Excluir
                      </button>
                    </div>
                    <small
                      class="text-body-secondary"
                      style="margin-left: 15%"
                      >{{ $filters.tempoDeCriacao(obj.created_at) }}</small
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <div class="container">
      <nav aria-label="Page navigation example">
        <ul class="pagination d-flex justify-content-center">
          <li
            :class="li.active ? 'page-item active' : 'page-item'"
            v-for="(li, key) in games.links"
            :key="key"
            @click="paginacao(li)"
          >
            <a class="page-link" v-html="li.label"></a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
  <!-- Modal Inserir -->
  <div
    class="modal fade"
    id="inserirGame"
    tabindex="-1"
    aria-labelledby="inserirGameLabel"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="inserirGameLabel">
            Inserir novo jogo
          </h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div :class="style" role="alert"></div>
          <div>
            <div class="col-auto">
              <label for="inputName" class="col-form-label"
                >Console Compativel</label
              >
            </div>
            <div class="col-auto">
              <select class="form-select" v-model="console_id">
                <option
                  v-for="(item, key) in this.consoles.data"
                  :key="key"
                  :value="item['id']"
                >
                  {{ item["nome"] }}
                </option>
              </select>
            </div>
            <div class="col-auto">
              <span id="nameHelpLine" class="form-text">
                Selecione um console compativel
              </span>
            </div>
            <div class="col-auto">
              <label for="inputName" class="col-form-label">Nome do jogo</label>
            </div>
            <div class="col-auto">
              <input
                type="text"
                id="inputName"
                class="form-control"
                aria-describedby="nameHelpLine"
                placeholder="Ex: Skyrim"
                v-model="nome"
                required
              />
            </div>
            <div class="col-auto">
              <span id="nameHelpLine" class="form-text">
                Digite o nome do jogo
              </span>
            </div>
          </div>
          <div>
            <div class="col-auto">
              <label for="inputdesenvolvedora" class="col-form-label"
                >Desenvolvedora</label
              >
            </div>
            <div class="col-auto">
              <input
                type="text"
                id="inputdesenvolvedora"
                class="form-control"
                aria-describedby="desenvolvedoraHelpLine"
                placeholder="Ex: Santa Monica"
                v-model="desenvolvedora"
                required
              />
            </div>
            <div class="col-auto">
              <span id="desenvolvedoraHelpLine" class="form-text">
                Digite a desenvolvedora do jogo
              </span>
            </div>
          </div>
          <div>
            <div class="col-auto">
              <label for="inputLancamento" class="col-form-label"
                >Data de Lançamento</label
              >
            </div>
            <div class="col-auto">
              <input
                type="date"
                class="form-control"
                id="inputLancamento"
                aria-describedby="inputLancamentoHelp"
                v-model="data_lancamento"
                required
              />
            </div>
            <div class="col-auto">
              <span id="controleHelpLine" class="form-text">
                Insira a data de laçamento do jogo
              </span>
            </div>
          </div>
          <div>
            <div class="col-auto">
              <label for="inputDescricao" class="col-form-label"
                >Descrição do jogo</label
              >
            </div>
            <div class="col-auto">
              <textarea
                class="form-control"
                aria-label="With textarea"
                v-model="descricao"
                required
              ></textarea>
            </div>
            <div class="col-auto">
              <span id="controleHelpLine" class="form-text">
                Insira a data de laçamento do jogo
              </span>
            </div>
          </div>
          <div>
            <div class="col-auto">
              <label for="inputImagem" class="col-form-label">Imagem</label>
            </div>
            <div class="col-auto">
              <input
                type="file"
                id="inputImagem"
                class="form-control"
                aria-describedby="nameHelpLine"
                @change="carregarImagem($event)"
                required
              />
            </div>
            <div class="col-auto">
              <span id="nameHelpLine" class="form-text">
                Imagem do console (*.png)
              </span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            Fechar
          </button>
          <button type="button" class="btn btn-success" @click="salvarGame()">
            Salvar
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Vizualizar -->
  <div
    class="modal fade"
    id="vizualizarGame"
    tabindex="-1"
    aria-labelledby="vizualizarGameLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="vizualizarGameLabel">
            Dados do Jogo
          </h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="imgGame">
              <img
                :src="'storage/' + $store.state.item.imagem"
                alt="Capa do jogo"
                v-if="$store.state.item.imagem"
                style="width: 15rem; margin: 0 7rem 0 7rem"
              />
            </div>
            <div class="card-body">
              <h3>
                Game
                <strong
                  >{{ $store.state.item.marca }}
                  {{ $store.state.item.nome }}</strong
                >
              </h3>
              <ul>
                <li>
                  Descrição:
                  <strong>{{ $store.state.item.descricao }}</strong>
                </li>
                <li>
                  Desenvolvedora:
                  <strong>{{ $store.state.item.desenvolvedora }}</strong>
                </li>
                <li>
                  Data de Lançamento:
                  <strong>{{ $store.state.item.data_lancamento }}</strong>
                </li>
              </ul>
              <h4 class="mt-3" v-if="$store.state.item.console != ''">
                Consoles Compativeis:
              </h4>
              <div class="imgGame">
                <img
                  :src="'storage/' + $store.state.item.console?.imagem"
                  alt="Capa do jogo"
                  v-if="$store.state.item.imagem"
                  style="width: 15rem; margin: 0 7rem 0 7rem"
                />
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            Fechar
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Edição -->
  <div
    class="modal fade"
    id="editarGame"
    tabindex="-1"
    aria-labelledby="editarGameLabel"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editarGameLabel">
            Atualizar dados do jogo
          </h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div :class="style" role="alert"></div>
          <div>
            <div class="col-auto">
              <label for="inputName" class="col-form-label"
                >Console Compativel</label
              >
            </div>
            <div class="col-auto">
              <select
                class="form-select"
                v-model="$store.state.item.console_id"
              >
                <option
                  v-for="(item, key) in consoles.data"
                  :key="key"
                  :value="item['id']"
                >
                  {{ item["nome"] }}
                </option>
              </select>
            </div>
            <div class="col-auto">
              <span id="nameHelpLine" class="form-text">
                Selecione um console compativel
              </span>
            </div>
            <div class="col-auto">
              <label for="inputName" class="col-form-label">Nome do jogo</label>
            </div>
            <div class="col-auto">
              <input
                type="text"
                id="inputName"
                class="form-control"
                aria-describedby="nameHelpLine"
                placeholder="Ex: Skyrim"
                v-model="$store.state.item.nome"
                required
              />
            </div>
            <div class="col-auto">
              <span id="nameHelpLine" class="form-text">
                Digite o nome do jogo
              </span>
            </div>
          </div>
          <div>
            <div class="col-auto">
              <label for="inputdesenvolvedora" class="col-form-label"
                >Desenvolvedora</label
              >
            </div>
            <div class="col-auto">
              <input
                type="text"
                id="inputdesenvolvedora"
                class="form-control"
                aria-describedby="desenvolvedoraHelpLine"
                placeholder="Ex: Santa Monica"
                v-model="$store.state.item.desenvolvedora"
                required
              />
            </div>
            <div class="col-auto">
              <span id="desenvolvedoraHelpLine" class="form-text">
                Digite a desenvolvedora do jogo
              </span>
            </div>
          </div>
          <div>
            <div class="col-auto">
              <label for="inputLancamento" class="col-form-label"
                >Data de Lançamento</label
              >
            </div>
            <div class="col-auto">
              <input
                type="date"
                class="form-control"
                id="inputLancamento"
                aria-describedby="inputLancamentoHelp"
                v-model="$store.state.item.data_lancamento"
                required
              />
            </div>
            <div class="col-auto">
              <span id="controleHelpLine" class="form-text">
                Insira a data de laçamento do jogo
              </span>
            </div>
          </div>
          <div>
            <div class="col-auto">
              <label for="inputDescricao" class="col-form-label"
                >Descrição do jogo</label
              >
            </div>
            <div class="col-auto">
              <textarea
                class="form-control"
                aria-label="With textarea"
                v-model="$store.state.item.descricao"
                required
              ></textarea>
            </div>
            <div class="col-auto">
              <span id="controleHelpLine" class="form-text">
                Insira a data de laçamento do jogo
              </span>
            </div>
          </div>
          <div>
            <div class="col-auto">
              <label for="inputImagem" class="col-form-label">Imagem</label>
            </div>
            <div class="col-auto">
              <input
                type="file"
                id="inputImagem"
                class="form-control"
                aria-describedby="nameHelpLine"
                @change="carregarImagem($event)"
                required
              />
            </div>
            <div class="col-auto">
              <span id="nameHelpLine" class="form-text">
                Imagem do console (*.png)
              </span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            Fechar
          </button>
          <button type="button" class="btn btn-success" @click="editarGame()">
            Salvar
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Exclusão -->
  <div
    class="modal fade"
    id="excluirConsole"
    tabindex="-1"
    aria-labelledby="excluirConsoleLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="excluirGameLabel">Excluir Jogo</h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <p>
            Deseja realmente excluir dados do jogo
            <strong> {{ $store.state.item.nome }}</strong
            >?
          </p>
          <span class="text-muted"
            ><strong>Atenção:</strong> Ao confirmar, não será possivel recuperar
            os dados deletados.</span
          >
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            Cancelar
          </button>
          <button type="button" class="btn btn-danger" @click="excluirGame()">
            Confirmar
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      urlBase: "http://127.0.0.1:8000/api/games",
      urlPaginacao: "",
      urlFiltro: "",
      console_id: "",
      nome: "",
      descricao: "",
      desenvolvedora: "",
      data_lancamento: "",
      imagemGame: [],
      games: {
        data: [],
      },
      consoles: {
        data: [],
      },
      busca: {
        console_id: "",
        nome: "",
        descricao: "",
        desenvolvedora: "",
        data_lancamento: "",
      },
    };
  },
  methods: {
    carregarImagem(e) {
      this.imagemGame = e.target.files;
    },
    salvarGame() {
      // definindo valores dos atributos com formdata
      let form = new FormData();
      form.append("console_id", this.console_id);
      form.append("nome", this.nome);
      form.append("descricao", this.descricao);
      form.append("desenvolvedora", this.desenvolvedora);
      form.append("data_lancamento", this.data_lancamento);
      form.append("imagem", this.imagemGame[0]);

      // cabeçalhos da requisição
      let cfg = {
        headres: {
          "Content-Type": "multipart/form-data",
          Accept: "application/json",
        },
      };

      // enviando atributos para a requisição com axios via post para que seja salvo no backend
      axios
        .post(this.urlBase, form, cfg)
        .then((response) => {
          Swal.fire({
            text: response.data.msg,
            icon: "success",
          });
          this.carregarGames();
        })
        .catch((errors) => {
          swal.fire({
            icon: "error",
            title: "Oops...",
            text: errors.response.data.message,
          });
        });
    },
    carregarGames() {
      let url = this.urlBase + "?" + this.urlPaginacao + this.urlFiltro;
      axios
        .get(url)
        .then((response) => {
          this.games = response.data;
        })
        .catch((errors) => {
          console.log(errors);
        });
    },
    editarGame() {
      let form = new FormData();
      form.append("_method", "patch");
      form.append("console_id", this.$store.state.item.console_id);
      form.append("nome", this.$store.state.item.nome);
      form.append("descricao", this.$store.state.item.descricao);
      form.append("desenvolvedora", this.$store.state.item.desenvolvedora);
      form.append("data_lancamento", this.$store.state.item.data_lancamento);
      if (this.imagemGame[0]) {
        form.append("imagem", this.imagemGame[0]);
      }
      let url = this.urlBase + "/" + this.$store.state.item.id;
      let cfg = {
        headers: {
          "Content-Type": "multipart/form-data",
          Accept: "application/json",
        },
      };
      axios
        .post(url, form, cfg)
        .then((response) => {
          Swal.fire({
            text: response.data.msg,
            icon: "success",
          });
          atualizarImagem.value = "";
          this.carregarGames();
        })
        .catch((errors) => {
          swal.fire({
            icon: "error",
            title: "Oops...",
            text: errors.response.data.message,
          });
        });
    },
    excluirGame() {
      let url = this.urlBase + "/" + this.$store.state.item.id;
      // criando uma instância de forData e passando o metodo para delete
      let form = new FormData();
      form.append("_method", "delete");

      axios
        .post(url, form)
        .then((response) => {
          Swal.fire({
            text: response.data.msg,
            icon: "success",
          });
          this.carregarGames();
        })
        .catch((errors) => {
          swal.fire({
            icon: "error",
            title: "Oops...",
            text: errors.response.data.message,
          });
        });
    },
    setStore(obj, dados) {
      let idObjeto = obj.id;
      // fazer um foreach em dados
      dados.forEach((chave, valor) => {
        if (chave.id == idObjeto) {
          let data = chave;
          this.$store.state.item = data;
        }
      });
    },
    paginacao(li) {
      if (li.url) {
        this.urlPaginacao = li.url.split("?")[1];
        this.carregarGames(); // requisitando novamente os dados para nossa API com base na URL atualizada
      }
    },
    carregarConsoles() {
      let url = "http://127.0.0.1:8000/api/console?all";
      axios
        .get(url)
        .then((response) => {
          this.consoles = response;
        })
        .catch((errors) => {
          console.log(errors);
        });
    },
  },
  mounted() {
    this.carregarGames();
    this.carregarConsoles();
  },
};
</script>