<template>
  <div>
    <main>
      <section class="py-5 text-center container">
        <div class="row py-lg-5">
          <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">Consoles</h1>
            <p class="lead text-body-secondary">
              Aqui você pode gerenciar todos os consoles, como inserir um novo e
              editar.
            </p>
            <p>
              <button
                class="btn btn-primary my-2 m-1"
                data-bs-toggle="modal"
                data-bs-target="#inserirConsole"
              >
                Inserir Console
              </button>
              <a href="/games" class="btn btn-secondary my-2 m-1"
                >Ver Games cadastrados</a
              >
            </p>
          </div>
        </div>
      </section>

      <div class="album py-5 bg-body-tertiary">
        <div class="container">
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <div
              v-for="(obj, chave) in this.consoles.data"
              :key="chave"
              class="col"
            >
              <div class="card shadow-sm">
                <img
                  :src="'/storage/' + obj.imagem"
                  class="card-img-top"
                  style="width: 411px; height: 411px"
                />
                <div class="card-body">
                  <h5 class="card-text">
                    <strong>{{ obj.marca }} {{ obj.nome }}</strong> com
                    {{ obj.controles }} controle(s) e armazenamento de
                    {{ obj.armazenamento }}GB
                  </h5>
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <div class="btn-group">
                      <button
                        type="button"
                        class="btn btn-sm btn-outline-info m-1"
                        data-bs-toggle="modal"
                        data-bs-target="#vizualizarConsole"
                        @click="setStore(obj, this.consoles.data)"
                      >
                        Vizualizar
                      </button>
                      <button
                        type="button"
                        class="btn btn-sm btn-outline-warning m-1"
                        data-bs-toggle="modal"
                        data-bs-target="#editarConsole"
                        @click="setStore(obj, this.consoles.data)"
                      >
                        Editar
                      </button>
                      <button
                        type="button"
                        class="btn btn-sm btn-outline-danger m-1"
                        data-bs-toggle="modal"
                        data-bs-target="#excluirConsole"
                        @click="setStore(obj, this.consoles.data)"
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
            v-for="(li, key) in consoles.links"
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
    id="inserirConsole"
    tabindex="-1"
    aria-labelledby="inserirConsoleLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="inserirConsoleLabel">
            Inserir novo console
          </h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div>
            <div class="col-auto">
              <label for="inputName" class="col-form-label">Nome</label>
            </div>
            <div class="col-auto">
              <input
                type="text"
                id="inputName"
                class="form-control"
                aria-describedby="nameHelpLine"
                placeholder="Ex: Playstation 5"
                v-model="nome"
              />
            </div>
            <div class="col-auto">
              <span id="nameHelpLine" class="form-text">
                Digite o nome do Console
              </span>
            </div>
          </div>
          <div>
            <div class="col-auto">
              <label for="inputMarca" class="col-form-label">Marca</label>
            </div>
            <div class="col-auto">
              <input
                type="text"
                id="inputMarca"
                class="form-control"
                aria-describedby="marcaHelpLine"
                placeholder="Ex: Sony"
                v-model="marca"
              />
            </div>
            <div class="col-auto">
              <span id="marcaHelpLine" class="form-text">
                Digite a marca do console
              </span>
            </div>
          </div>
          <div>
            <div class="col-auto">
              <label for="inputControles" class="col-form-label"
                >Quantidade de Controles</label
              >
            </div>
            <div class="col-auto">
              <input
                type="text"
                id="inputControles"
                class="form-control"
                aria-describedby="controleHelpLine"
                placeholder="Ex: 2"
                v-model="controles"
              />
            </div>
            <div class="col-auto">
              <span id="controleHelpLine" class="form-text">
                Digite a quantidades de controle
              </span>
            </div>
          </div>
          <div>
            <div class="col-auto">
              <label for="inputArmazenamento" class="col-form-label"
                >Armazenamento</label
              >
            </div>
            <div class="col-auto">
              <input
                type="text"
                id="inputArmazenamento"
                class="form-control"
                aria-describedby="armazenamentoHelpLine"
                placeholder="Ex: 512"
                v-model="armazenamento"
              />
            </div>
            <div class="col-auto">
              <span id="armazenamentoHelpLine" class="form-text">
                Digite o tamanho de aramzenamento
              </span>
            </div>
          </div>
          <div>
            <div class="col-auto">
              <label for="inputMidia" class="col-form-label"
                >Midia suportada</label
              >
            </div>
            <div class="col-auto">
              <input
                type="text"
                id="inputMidia"
                class="form-control"
                aria-describedby="midiaHelpLine"
                placeholder="Ex: Midia Física"
                v-model="midia"
              />
            </div>
            <div class="col-auto">
              <span id="midiaHelpLine" class="form-text">
                Digite o tipo de midia do console.
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
          <button
            type="button"
            class="btn btn-success"
            @click="salvarConsole()"
          >
            Salvar
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Vizualizar -->
  <div
    class="modal fade"
    id="vizualizarConsole"
    tabindex="-1"
    aria-labelledby="vizualizarConsoleLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="vizualizarConsoleLabel">
            Dados do Console
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
            <div class="imgConsole">
              <img
                :src="'storage/' + $store.state.item.imagem"
                alt="Imagem do console"
                v-if="$store.state.item.imagem"
                style="width: 15rem; margin: 0 7rem 0 7rem"
              />
            </div>
            <div class="card-body">
              <h3>
                Console
                <strong
                  >{{ $store.state.item.marca }}
                  {{ $store.state.item.nome }}</strong
                >
              </h3>
              <ul>
                <li>
                  Armazenamento:
                  <strong>{{ $store.state.item.armazenamento }}GB</strong>
                </li>
                <li>
                  Controles: <strong>{{ $store.state.item.controles }}</strong>
                </li>
                <li>
                  Midia aceitavel:
                  <strong>{{ $store.state.item.tipo_midia }}</strong>
                </li>
              </ul>
              <h4 class="mt-3" v-if="$store.state.item.games != ''">
                Jogos relacionados:
              </h4>
              <div
                v-for="(item, chave) in $store.state.item.games"
                :key="chave"
                :value="item"
              >
                <ul class="list-group-horizontal">
                  <li id="listRelacaoGames" style="font-size: large">
                    {{ item.nome }}
                  </li>
                </ul>
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
    id="editarConsole"
    tabindex="-1"
    aria-labelledby="editarConsoleLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editarConsoleLabel">
            Editar dados do console
          </h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div>
            <div class="col-auto">
              <label for="inputName" class="col-form-label">Nome</label>
            </div>
            <div class="col-auto">
              <input
                type="text"
                id="inputName"
                class="form-control"
                aria-describedby="nameHelpLine"
                placeholder="Ex: Playstation 5"
                v-model="$store.state.item.nome"
              />
            </div>
            <div class="col-auto">
              <span id="nameHelpLine" class="form-text">
                Digite o nome do Console
              </span>
            </div>
          </div>
          <div>
            <div class="col-auto">
              <label for="inputMarca" class="col-form-label">Marca</label>
            </div>
            <div class="col-auto">
              <input
                type="text"
                id="inputMarca"
                class="form-control"
                aria-describedby="marcaHelpLine"
                placeholder="Ex: Sony"
                v-model="$store.state.item.marca"
              />
            </div>
            <div class="col-auto">
              <span id="marcaHelpLine" class="form-text">
                Digite a marca do console
              </span>
            </div>
          </div>
          <div>
            <div class="col-auto">
              <label for="inputControles" class="col-form-label"
                >Quantidade de Controles</label
              >
            </div>
            <div class="col-auto">
              <input
                type="text"
                id="inputControles"
                class="form-control"
                aria-describedby="controleHelpLine"
                placeholder="Ex: 2"
                v-model="$store.state.item.controles"
              />
            </div>
            <div class="col-auto">
              <span id="controleHelpLine" class="form-text">
                Digite a quantidades de controle
              </span>
            </div>
          </div>
          <div>
            <div class="col-auto">
              <label for="inputArmazenamento" class="col-form-label"
                >Armazenamento</label
              >
            </div>
            <div class="col-auto">
              <input
                type="text"
                id="inputArmazenamento"
                class="form-control"
                aria-describedby="armazenamentoHelpLine"
                placeholder="Ex: 512"
                v-model="$store.state.item.armazenamento"
              />
            </div>
            <div class="col-auto">
              <span id="armazenamentoHelpLine" class="form-text">
                Digite o tamanho de aramzenamento
              </span>
            </div>
          </div>
          <div>
            <div class="col-auto">
              <label for="inputMidia" class="col-form-label"
                >Midia suportada</label
              >
            </div>
            <div class="col-auto">
              <input
                type="text"
                id="inputMidia"
                class="form-control"
                aria-describedby="midiaHelpLine"
                placeholder="Ex: Midia Física"
                v-model="$store.state.item.tipo_midia"
              />
            </div>
            <div class="col-auto">
              <span id="midiaHelpLine" class="form-text">
                Digite o tipo de midia do console.
              </span>
            </div>
          </div>
          <div>
            <div class="col-auto">
              <label for="atualizarImagem" class="col-form-label">Imagem</label>
            </div>
            <div class="col-auto">
              <input
                type="file"
                id="atualizarImagem"
                class="form-control"
                aria-describedby="nameHelpLine"
                @change="carregarImagem($event)"
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
          <button
            type="button"
            class="btn btn-success"
            @click="editarConsole()"
          >
            Salvar Edição
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
          <h1 class="modal-title fs-5" id="excluirConsoleLabel">
            Excluir Console
          </h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <p>
            Deseja realmente excluir dados do console
            <strong
              >{{ $store.state.item.marca }}
              {{ $store.state.item.nome }}</strong
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
          <button
            type="button"
            class="btn btn-danger"
            @click="excluirConsole()"
          >
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
      urlBase: "http://127.0.0.1:8000/api/console",
      urlPaginacao: "",
      urlFiltro: "",
      nome: "",
      marca: "",
      controles: "",
      armazenamento: "",
      midia: "",
      imagemConsole: [],
      consoles: {
        data: [],
      },
      busca: {
        id: "",
        nome: "",
        marca: "",
        controles: "",
        armazenamento: "",
        midia: "",
      },
    };
  },
  methods: {
    carregarImagem(e) {
      this.imagemConsole = e.target.files;
    },
    salvarConsole() {
      // definindo valores dos atributos com formdata
      let form = new FormData();
      form.append("nome", this.nome);
      form.append("marca", this.marca);
      form.append("controles", this.controles);
      form.append("armazenamento", this.armazenamento);
      form.append("tipo_midia", this.midia);
      form.append("imagem", this.imagemConsole[0]);

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
          this.carregarConsoles();
        })
        .catch((errors) => {
          swal.fire({
            icon: "error",
            title: "Oops...",
            text: errors.response.data.message,
          });
          console.log(errors);
        });
    },
    carregarConsoles() {
      let url = this.urlBase + "?" + this.urlPaginacao + this.urlFiltro;
      axios
        .get(url)
        .then((response) => {
          this.consoles = response.data;
        })
        .catch((errors) => {
          console.log(errors);
        });
    },
    editarConsole() {
      let form = new FormData();
      form.append("_method", "patch");
      form.append("nome", this.$store.state.item.nome);
      form.append("marca", this.$store.state.item.marca);
      form.append("controles", this.$store.state.item.controles);
      form.append("armazenamento", this.$store.state.item.armazenamento);
      form.append("tipo_midia", this.$store.state.item.tipo_midia);
      if (this.imagemConsole[0]) {
        form.append("imagem", this.imagemConsole[0]);
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
          this.carregarConsoles();
        })
        .catch((errors) => {
          swal.fire({
            icon: "error",
            title: "Oops...",
            text: errors.response.data.message,
          });
        });
    },
    excluirConsole() {
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
          this.carregarConsoles();
        })
        .catch((errors) => {
          swal.fire({
            icon: "error",
            title: "Oops...",
            text: errors.response.data.msg,
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
        this.carregarConsoles(); // requisitando novamente os dados para nossa API com base na URL atualizada
      }
    },
  },
  mounted() {
    this.carregarConsoles();
  },
};
</script>